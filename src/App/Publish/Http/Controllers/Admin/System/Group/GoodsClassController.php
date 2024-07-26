<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-26 10:41:09
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-26 19:04:08
 * @FilePath: \app\Http\Controllers\Admin\System\Group\GoodsClassController.php
 */

namespace App\Http\Controllers\Admin\System\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Rules\Public\Required;
use App\Rules\Public\Numeric;
use App\Rules\Public\CheckString;
use App\Rules\Public\CheckBetween;
use App\Rules\Public\CheckArray;
use App\Rules\Public\FormatTime;
use App\Rules\Public\CheckUnique;
use App\Rules\Public\ChineseCodeNumberLine;

use App\Rules\Admin\Common\TreeDeep;

use App\Facade\Admin\System\Group\AdminGoodsClassFacade;

class GoodsClassController extends Controller
{
	 /**
     * 获取产品分类
     *
     * @return void
     */
    public function getTreeGoodsClass()
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        //p('here');die;

        if(Gate::forUser($admin)->allows('admin-role'))
        {
             $result = AdminGoodsClassFacade::getTreeGoodsClass();
        }

        return $result;
    }

     /**
     * 添加产品分类
     *
     * @param Request $request
     * @return void
     */
    public function addGoodsClass(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'parent_id'=>['bail',new Required,new Numeric],
                    'deep' => ['bail',new Required,new TreeDeep],
                    'sort' => ['bail',new Required,new Numeric],
                    'rate' => ['bail',new Required,new Numeric],
                    'goods_class_name'=>['bail',new Required,new CheckString,new CheckBetween(2,30)],
                    'goods_class_code'=>['bail',new Required,new CheckString,new CheckBetween(2,30),new CheckUnique('goods_class','goods_class_code')],
                    'is_certificate'=>['bail',new Required],
                    'certificate_number'=>['bail',new Required],
                    'remark_info'=>['bail','nullable',new CheckString,new CheckBetween(0,30),new ChineseCodeNumberLine],
                    'goods_class_picture_id'=>['bail','nullable',new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result = AdminGoodsClassFacade::addGoodsClass(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 更新产品分类
     *
     * @param Request $request
     * @return void
     */
    public function updateGoodsClass(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        $id = checkId($request->input('id'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'parent_id'=>['bail',new Required,new Numeric],
                    'deep' => ['bail',new Required,new TreeDeep],
                    'sort' => ['bail',new Required,new Numeric],
                    'rate' => ['bail',new Required,new Numeric],
                    'goos_class_name'=>['bail',new Required,new CheckString,new CheckBetween(2,30)],
                    'goos_class_code'=>['bail',new Required,new CheckString,new CheckBetween(2,30), new CheckUnique('goos_class','goos_class_code',$id)],
                    'is_certificate'=>['bail',new Required],
                    'certificate_number'=>['bail',new Required],
                    'remark_info'=>['bail','nullable',new CheckString,new CheckBetween(0,30)],
                    'goods_class_picture_id'=>['bail','nullable',new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminGoodsClassFacade::updateGoodsClass(f($validated),$admin);
        }
        return $result;
    }

    /**
     * 树形控件移动
     *
     * @param Request $request
     * @return void
     */
    public function moveGoodsClass(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if (Gate::forUser($admin)->allows('super-role')) {

            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'parent_id'=>['bail',new Required,new Numeric],
                    'dropType' => ['bail',new Required,new TreeDeep],
                    'sort' => ['bail',new Required,new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminGoodsClassFacade::moveGoodsClass(f($validated), $admin);
        }

        return $result;
    }

    /**
     * 删除产品分类
     *
     * @param Request $request
     * @return void
     */
    public function deleteGoodsClass(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('super-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'is_delete'=>['bail',new Required,new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminGoodsClassFacade::deleteGoodsClass($validated,$admin);
        }

        return $result;
    }
}
