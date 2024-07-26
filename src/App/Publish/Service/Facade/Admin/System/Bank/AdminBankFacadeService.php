<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-31 23:31:19
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-01 12:16:56
 * @FilePath: \app\Service\Facade\Admin\System\Bank\AdminBankFacadeService.php
 */

namespace App\Service\Facade\Admin\System\Bank;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

use  App\Service\Facade\Trait\QueryService;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;

use App\Models\System\Bank\Bank;

use App\Http\Resources\System\BankResource;
use App\Http\Resources\System\BankCollection;


use App\Facade\Public\Excel\PublicExcelFacade;

/**
 * @see \App\Facade\Admin\System\Bank\AdminBankFacade
 */
class AdminBankFacadeService
{
   public function test()
   {
       echo "AdminBankFacadeService test";
   }

   use QueryService;

   protected static $sort = [
      1 => ['created_time','asc'],
      2 => ['created_time','desc'],
    ];

   protected static $searchItem = [
        'bank_name',
        'bank_code'
    ];

   protected static $storage_public_path = DIRECTORY_SEPARATOR.'app'. DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR;


    /**
    * 批量导入数据
    *
    * @param UploadFileLog $uploadFileLog
    * @return void
    */
   public function importData($path)
   {
       $result = 0;

       $exists = Storage::disk('public')->exists($path);

       if($exists)
       {
            PublicExcelFacade::initReadExcel(storage_path(self::$storage_public_path.$path));

            PublicExcelFacade::setWorkSheet(0);

            $excelData = PublicExcelFacade::getDataByRow();

            array_shift($excelData);

            $insertData = [];

            foreach ($excelData as $key => $value)
            {
                $insertData[] =
                [
                    'bank_name'=> $value[0],
                    'bank_code'=> empty($value[1])?null:$value[1],
                    'is_default' => empty($value[2])?0:$value[2],
                    'sort' => empty($value[3])?100:$value[3]
                ];
            }

            $result = Bank::insert($insertData);

       }

       return $result;
   }

    /**
     * 导出表格数据
     *
     * @param [type] $bankList
     * @return void
     */
    protected function exportData($bankList)
    {
        $cloumn = [['银行民称','银行编码','是否常用','添加时间']];

        $data = [];

        foreach ($bankList as $key => $value)
        {
           $list = [];

           $list[] = $value->bank_name;
           $list[] = $value->bank_code;
           $list[] = $value->is_dfault == 1?'是':'否';
           $list[] = $value->created_at;

           $data[] =  $list;
        }

        $title = "银行信息表";

        PublicExcelFacade::exportExcelData($cloumn, $data,$title,1);

        return $title;

    }

    /**
     * 获取默认的用户选项
     *
     * @return void
     */
    public function defaultBank()
    {

        $result = code(config('admin_code.GetDefaultBankError'));

        $this->where[] = ['is_default','=',1];

        $query= Bank::where($this->where);

        $query->orderBy(self::$sort[2][0],self::$sort[2][1]);

        $data =  $query->get();

        $result = new BankCollection($data,['code'=>0,'msg'=>'获取默认银行列表成功!']);

        return $result;
    }

    /**
     * 查找用户
     *
     * @param [type] $find
     * @return void
     */
    public function findBank($validated)
    {
        $result = code(config('admin_code.FindBankError'));

        $find = $validated['find'];

        $where[] = ['bank_name','like',"%{$find}%"];
        $orWhere[] = ['bank_code','like',"%{$find}%"];

        $query = Bank::where($where)->orWhere($orWhere);

        $query->orderBy(self::$sort[2][0],self::$sort[2][1]);

        $data =  $query->get();

        $result = new BankCollection($data,['code'=>0,'msg'=>'查找银行列表成功!']);

        return $result;
    }


    /**
     * 查询
     *
     * @param [type] $validated
     * @return void
     */
    public function getBank($validated)
    {
       $result = code(config('admin_code.GetBankError'));

       $this->setQueryOptions($validated);

       $query =Bank::query();

       if(isset($validated['findSelectIndex']))
       {
            if(isset($validated['find']) && !empty($validated['find']))
            {
               $this->where[] = [self::$searchItem[$validated['findSelectIndex']],'like',"%{$validated['find']}%"];

               $query =Bank::where($this->where);
            }
       }

        if(isset($validated['timeRange']) && \count($validated['timeRange']) > 0)
        {
             $this->whereBetween[] = [\strtotime($validated['timeRange'][0])];
             $this->whereBetween[] = [\strtotime($validated['timeRange'][1])];

             $query->whereBetween('created_time',$this->whereBetween);
        }

        $query->orderBy('id','asc');

        if(isset($validated['sortType']))
        {
            $sortType = $validated['sortType'];

            $query->orderBy(self::$sort[$sortType][0],self::$sort[$sortType][1]);
        }

        $download = null;

        //判断是否需要导出数据
        if(isset($validated['isExport']) && $validated['isExport'] == 1)
        {
            if(isset($validated['exportType']))
            {
                $bankList = null;

                $title = '';
                //本页数据
                if($validated['exportType'] == 1)
                {
                    $bankList = $query->offset(($this->page - 1) * $this->perPage)->limit($this->perPage)->get();

                    $title = $this->exportData($bankList);
                }

                if($validated['exportType'] == 2)
                {
                    $bankList = $query->get();

                    $title = $this->exportData($bankList);
                }

                $exists = Storage::disk('public')->exists("excel/{$title}.xlsx");

                if($exists)
                {
                    //return response()->download(public_path("storage/excel/{$title}.xlsx"));

                   $download = asset("storage/excel/{$title}.xlsx");
                }
            }
        }

        $bankList = $query->paginate($this->perPage,$this->columns,$this->pageName,$this->page);

        if(\optional($bankList))
        {
             $result = new BankCollection($bankList,['code'=>0,'msg'=>'获取银行列表成功!'],$download);

        }

        return  $result;
    }

    /**
     * 添加
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function addBank($validated,$admin)
    {
        $result = code(config('admin_code.AddBankError'));

        $bank = new Bank;

        foreach ( $validated as $key => $value)
        {
            if(\is_null($value))
            {
                $value = "";
            }
            $bank->$key = $value;
        }

        $bank->created_at = time();
        $bank->created_time = time();
        $bankResult = $bank->save();

        if(!$bankResult)
        {
            throw new CommonException('AddBankError');
        }

        CommonEvent::dispatch($admin,$validated,'AddBank');

        $result = code(['code'=>0,'msg'=>'添加银行成功!']);

        return $result;
    }


    /**
     * 更新
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function updateBank($validated,$admin)
    {
        $result = code(config('admin_code.UpdateBankError'));

        $bank = Bank::find($validated['id']);

        if(!$bank)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $where = [];

        $updateData = [];

        $where[] = ['revision','=',$bank ->revision];

        foreach ( $validated as $key => $value)
        {
            if($key === 'id')
            {
                $where[] = ['id','=',$value];
                continue;
            }

            if(\is_null($value))
            {
                $value = "";
            }

            $updateData[$key] = $value;
        }

        $updateData['revision'] = $bank ->revision + 1;

        $updateData['updated_time'] = time();

        $updateData['updated_at']  = date('Y-m-d H:i:s',time());

        //更新管理员
        $bankResult = Bank::where($where)->update($updateData);

        if(!$bankResult)
        {
            throw new CommonException('UpdateBankError');
        }

        CommonEvent::dispatch($admin,$validated,'UpdateBank');

        $result = code(['code'=>0,'msg'=>'更新银行成功!']);


        return $result;
    }

    /**
     * 删除
     *
     * @param [type] $id
     * @param [type] $admin
     * @return void
     */
    public function deleteBank($validated,$admin)
    {
        $result = code(config('admin_code.DeleteBankError'));

        $id = $validated['id'];

        $bank = Bank::find($id);

         if(!$bank)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $bank->deleted_time = time();

        $bank->deleted_at = date('Y-m-d H:i:s',time());

        $bankResult =  $bank->save();

        if(!$bankResult )
        {
            throw new CommonException('DeleteBankError');
        }

        CommonEvent::dispatch($admin,$id,'DeleteBank');

        $result = code(['code'=>0,'msg'=>'删除银行成功!']);

        return $result;
    }

    /**
     * 批量删除用户
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function multipleDeleteBank($validated,$admin)
    {
        $result = code(config('admin_code.MultipleDeleteBankError'));

        if(isset($validated['selectId']) && count($validated['selectId']))
        {
            $deleteResult = Bank::whereIn('id',$validated['selectId'])->delete();

            if(!$deleteResult)
            {
                throw new CommonException('MultipleDeleteBankError');
            }

            CommonEvent::dispatch($admin,$validated,'MultipleDeleteBank');

            $result = code(['code'=>0,'msg'=>'批量删除银行成功!']);
        }

        return $result;
    }
}
