<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-03-11 10:53:49
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-08-22 15:53:49
 */

namespace App\Service\Facade\Trait;

use Illuminate\Support\Facades\Log;

Trait QueryService
{

    //where 查询条件
    public $where = [];
    //orWhere查询条件
    public $orWhere = [];

    //范围查询条件
    public $whereBetween = [];

    //关联查询条件
    public $withWhere = [];
    //关联查询判断条件
    public $orWithWhere = [];

    //分页
    public $perPage=10;
    public $page=1;
    public $pageName = 'page';

    //查询内容
    public $columns = ['*'];

    /**
     * 处理分页选项
     *
     * @param [type] $validated
     * @return void
     */
    protected function setQueryOptions($validated)
    {
        $this->setPaginate($validated);
    }

    /**
     * 设置分页
     *
     * @param [type] $validated
     * @return void
     */
    protected function setPaginate($validated)
    {
       if(isset($validated['pageSize']) && !empty($validated['pageSize']))
       {
            $this->perPage = $validated['pageSize'];
       }

       if(isset($validated['currentPage']) && !empty($validated['currentPage']))
       {
            $this->page = $validated['currentPage'];
       }
    }

    /**
     * 处理 orWhere选项
     *
     * @param [type] $query
     * @param [type] $orWhere
     *  $orWhere[] = ['id',2];
        $orWhere[] = ['id',3];
     * @return void
     */
    protected function setOrWhere($query,$orWhere)
    {
        for ($i= 0; $i < count($orWhere); $i++)
        {
            $query->orWhere($orWhere[$i][0],$orWhere[$i][1]);
        }

        return $query;
    }

}
