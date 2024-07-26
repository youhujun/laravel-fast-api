<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-01 11:07:42
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-06 20:56:51
 * @FilePath: \app\Service\Facade\Public\Excel\PublicExcelFacadeService.php
 */

namespace App\Service\Facade\Public\Excel;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriteXlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReadXlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style;

use App\Exceptions\Common\CommonException;

/**
 * @see \App\Facade\Public\Excel\PublicExcelFacade
 */
class PublicExcelFacadeService
{
   public function test()
   {
       echo "PublicExcelFacadeService test";
   }

   /********写表格**** */
   //数据列长度
   protected $cloumnLength = 0;

   //数据行数量
   protected $rowLength = 0;

   //开始的列
   protected $firstCloumn;

   //结束的列
   protected $lastCloumn;
   //*******************读表格*************** */

   //初始化表格对象
   public  $spreadsheet;

   //工作表数量 number
   public  $sheetNumber;

   //工作表名称
   public  $sheetName = [];

   //当前工作表
   public $worksheet;

   //工作表总行数
   public  $rowTotal;

   //工作表总列数
   public $cloumnTotal;

   /*******************************************写表格****************************************** */
   /*******************************************写表格****************************************** */
   /*******************************************写表格****************************************** */
   /*******************************************写表格****************************************** */

   //获取数据长度
   protected function  getDataCloumnLength($data)
   {
        $this->cloumnLength = count($data[0]);

        return $this->cloumnLength;
   }

   //获取数据行数
   protected function getDataRowLength($data)
   {
       //因为要算上 cloumn 列名
       $this->rowLength = count($data) + 1;

       return  $this->rowLength;
   }

   //设置表格列宽 以及为字符串显示
   protected function setCloumWidth($spreadsheet)
   {

        for($i=1; $i <= $this->cloumnLength; $i++)
        {
            $cloumn = Coordinate::stringFromColumnIndex($i);

            //设置列宽
            $spreadsheet->getActiveSheet()->getColumnDimension($cloumn)->setAutoSize(true);
            //设置文本格式
            $spreadsheet->getActiveSheet()->getStyle($cloumn)->getNumberFormat()->setFormatCode(Style\NumberFormat::FORMAT_TEXT);

        }
   }

   /**
    * 设置表格开始和结束列
    *
    * @param [type] $index 开始列的下标
    * @param [type] $data  生成excel表得数据 根据数据长度得出列长度
    * @return void
    */
   protected function setExcelCloumn($index,$data)
   {
        $this->getDataCloumnLength($data);

        $cloumn = Coordinate::stringFromColumnIndex($this->cloumnLength);

        $this->lastCloumn = $cloumn;

        $this->firstCloumn = Coordinate::stringFromColumnIndex($index);
   }

    /**
     * 导出excel表格数据
     *
     * @param array $cloumn [
          ['一年级','二年级','三年级']
      ];
     * @param array $data [
        [10,20,30],
        [10,null,30],
        [10,20,30],
      ];
     * @param string $title "test"
     * @param string $save 是否保存  0 不曹村 1保存 默认不保存
     * @return void
     */
   public function exportExcelData($cloumn = [[]],$data = [[]],$title = 'test',$save = 0)
   {
        if(!isset($cloumn) || !isset($data) )
        {
        throw new CommonException('ExportExcelInItError');
        }
        if(count($cloumn) < 1 || count($data) < 1)
        {
        throw new CommonException('ExportExcelInItError');
        }
        if(count($cloumn[0]) == 0 || count($data) == 0)
        {
        throw new CommonException('ExportExcelInItError');
        }

         $spreadsheet = new Spreadsheet();
         //设置活动单元表
         $spreadsheet->setActiveSheetIndex(0);

         $this->setExcelCloumn(1,$data);

         //合并单元格 作为标题
         $spreadsheet->getActiveSheet()->mergeCells($this->firstCloumn.'1:'. $this->lastCloumn.'1');

          // 设置单元格格式 可以省略
          //标题样式
          $styleArrayTitle = [
            'font' => [ 'bold' => true, 'size' => 22 ],
            'alignment' => [
                    'horizontal' => Style\Alignment::HORIZONTAL_CENTER,
                ],
            'borders' => [
                'diagonalDirection' => Style\Borders::DIAGONAL_BOTH,
                'allBorders' => [
                    'borderStyle' => Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FACC2E',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
          ];
          //栏目样式
          $styleArrayCloumn = [
            'font' => [ 'bold' => true, 'size' => 14 ],
            'alignment' => [
                    'horizontal' => Style\Alignment::HORIZONTAL_CENTER,
                ],
            'borders' => [
                    'top' => [
                        'borderStyle' => Style\Border::BORDER_THIN,
                    ],
                ],
            'fill' => [
                'fillType' => Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => '2ECCFA',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
          ];

          //$spreadsheet->getActiveSheet()->getStyle('A1:B1')->applyFromArray($styleArray);
          //$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
          //设置标题样式
          $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArrayTitle);
          //设置栏目样式
          $spreadsheet->getActiveSheet()->getStyle( $this->firstCloumn.'2:'.$this->lastCloumn.'2')->applyFromArray($styleArrayCloumn);
          //$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(50);
          //$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(25);
          //$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
          $spreadsheet->getActiveSheet()->getCell('A1')->setValue($title);
          $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
          $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
          //设置
          $this->setCloumWidth($spreadsheet);

          $allData = \array_merge($cloumn,$data);
          //也可以通过表名
          //$spreadsheet->setActiveSheetIndexByName('DataSheet');
          //参数意义 分别是数据 null类型不设置 最左侧从那个单元格开始
          $spreadsheet->getActiveSheet()->fromArray($allData,null,'A2');

          //Setting a spreadsheet's metadata 设置表元数据 一般没用
          /* $spreadsheet->getProperties()
           ->setCreator("王琛晔")    //作者
           ->setLastModifiedBy("游鹄君") //最后修改者
           ->setTitle("测试表")  //标题
           ->setSubject("小测试表") //副标题
           ->setDescription("哈哈哈哈")  //描述
           ->setKeywords("噗噗") //关键字
           ->setCategory("1级"); //分类  */
          $writer = new WriteXlsx($spreadsheet); //这种最好
          //$writer = IOFactory::createWriter($spreadsheet, 'Xls');
          if($save)
          {
             $writer->save(\storage_path("app/public/excel/{$title}.xlsx"));
          }
          else
          {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');//告诉浏览器输出07Excel文件
            //header('Content-Type:application/vnd.ms-excel');//告诉浏览器将要输出Excel03版本文件
            header("Content-Disposition: attachment;filename={$title}.xlsx");//告诉浏览器输出浏览器名称
            header('Cache-Control: max-age=0');//禁止缓存
            $writer->save('php://output');
          }
   }

   /*******************************************读表格****************************************** */
   /*******************************************读表格****************************************** */
   /*******************************************读表格****************************************** */
   /*******************************************读表格****************************************** */

   public function testExcel()
   {

        //读取
        //$this->initReadExcel(\storage_path('app/public/excel/test.xlsx'));
        //$this->getWorkSheet();
        //$this->setWorkSheet();
        //$data = $this->getDataByColumn();
        //$data = $this->getDataByRow();
        //$data = $this->getRowData(2);
        //$data = $this->getColumnData(3);

      //导出
/*      $cloumn = [
          ['一年级','二年级','三年级']
      ];

       $data =  [
        [10,20,30],
        [10,null,30],
        [10,20,30],
      ];

      $title =  "test";
      $this->exportExcelData($cloumn, $data,$title,1); */
   }

    /**
    * Undocumented 读取表格初始化
    *
    * @param [type] $fileUrl 文件地址
    * @return 表格对象
    */
   public  function initReadExcel($fileUrl)
   {
       //更改使用内存限制
       set_time_limit(0);
       ini_set("memory_limit",-1);

       //自动方式 慢
       $reader = IOFactory::createReaderForFile($fileUrl);
       $this->spreadsheet = $reader->load( $fileUrl);
       $this->getExcelNumberName();
   }
    /**
    * Undocumented 获取工作表的数量和每个工作表的名称
    *
    * @param [type] $spreadsheet
    * @return void
    */
   protected function getExcelNumberName()
   {
        //获取工作表数量 只有自动方式不报错
        $this->sheetNumber = $this->spreadsheet ->getSheetCount();

        //获取工作表名称, 只有自动方式不报错
        $this->sheetName =  $this->spreadsheet ->getSheetNames();
   }

    /**
    * Undocumented function 获取单张工作表的所有行数和列数
    *
    * @param [type] $worksheet
    * @return void
    */
   public function getRowColumnNumber()
   {
        $this->rowTotal = $this->worksheet->getHighestRow();
        // 总列数 字母表示,需要转换成数字
        $colsString = $this->worksheet->getHighestColumn();

        $this->cloumnTotal = Coordinate::columnIndexFromString($colsString);
   }

    /**
    * 设置当前工作表
    *
    * @param integer $index
    * @return void
    */
   public function setWorkSheet($index = null)
   {
       if(empty($index) || !is_numeric($index))
       {
           $index = 0;
       }
       //指定当前工作表
       $this->spreadsheet->setActiveSheetIndex((int)$index);

       $this->worksheet =  $this->spreadsheet->getActiveSheet();

       $this->getRowColumnNumber();
   }

   /**
    * 获取当前工作表
    *
    * @param [type] $index
    * @return void
    */
   public function getWorkSheet($key = null)
   {
       if(empty($key))
       {
           $key = 0;
       }
       else
       {
           //只获取第一个参数
           $key = func_get_arg(0);
       }

       //如果是字符串表示通过名称 并且名称在工作表中
       if(\is_string($key) && \in_array($key,$this->sheetName))
       {
           //根据工作表名称来获取数据
           $this->worksheet = $this->spreadsheet->getSheetByName($key);
           //$this->worksheet = $this->spreadsheet->getSheetByName($this->sheetName[0]);
       }
       else
       {
            //否则验证
            if(\is_int($key))
            {
                //根据索引来选择处理的表
                $this->worksheet = $this->spreadsheet->getSheet($key);
            }
       }

       $this->getRowColumnNumber();
   }




    /**
    * Undocumented function  获取一行的数据 (这一行的所有列)
    *
    * @param [type] $worksheet
    * @return void
    */
   public function getRowData($rowIndex = 1)
   {
       $data = [];

       if(!empty($rowIndex) && \is_int($rowIndex) && $rowIndex > 0)
       {
         for ($i=1; $i <=$this->cloumnTotal ; $i++)
         {
            $value = $this->worksheet->getCell([$i, $rowIndex])->getFormattedValue();

            $data[] = $value;
         }
       }

       return $data;
   }

    /**
    * Undocumented function  获取一列的数据 (这一列所有的行)
    *
    * @param [type] $worksheet
    * @param [type] $column
    * @return void
    */
   public function getColumnData($columnIndex)
   {
       $data = [];

       if(!empty($columnIndex) && \is_int($columnIndex) && $columnIndex > 0)
       {
         for ($i=1; $i <= $this->rowTotal ; $i++)
         {
            $value = $this->worksheet->getCell([$columnIndex, $i])->getFormattedValue();
            $data[] = $value;
         }
       }

       return $data;

   }

   /**
    * Undocumented 通过表名按照行来获取一张表的数据
    *
    * @param [object] $worksheet 工作表队像
    * @return [array] $row  返回列和行组成的二位数组
    */
   public function getDataByRow()
   {
         //声明行和列的数组
         $row = [];

         for ($i=1; $i <= $this->rowTotal; $i++)
         {
            $col = [];

            for ($j=1; $j <= $this->cloumnTotal; $j++)
            {
                $value = $this->worksheet->getCell([$j, $i])->getFormattedValue();

                if(!empty($value))
                {
                    $col[$j-1] = $value;
                }
            }

            if(count($col)>0)
            {
              $row[$i-1] = $col;
            }
         }
         unset($this->worksheet);
         ob_flush();
         flush();
         return $row;
   }

   /**
    * Undocumented 通过表名按照列来获取一张表的数据
    *
    * @param [object] $worksheet 工作表队像
    * @return [array] $rol  返回行和列组成的二位数组
    */
   public function getDataByColumn()
   {
        //声明列和行
        $col = [];

        for ($i=1; $i <= $this->cloumnTotal; $i++)
        {
           $row = [];
           for ($j=1; $j <= $this->rowTotal; $j++)
           {
               $value = $this->worksheet->getCell([$i, $j])->getFormattedValue();

               if(!empty($value))
               {
                   $row[$j-1] = $value;
               }
           }

           if(count($row)>0)
           {
             $col[$i-1] = $row;
           }
        }
        unset($this->worksheet);
        ob_flush();
        flush();

        return $col;
   }
}
