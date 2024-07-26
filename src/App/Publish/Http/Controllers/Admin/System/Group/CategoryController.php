<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-28 08:06:57
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-26 19:18:06
 * @FilePath: \app\Http\Controllers\Admin\System\Group\CategoryController.php
 */

namespace App\Http\Controllers\Admin\System\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Rules\Public\CheckArray;
use App\Rules\Public\CheckString;
use App\Rules\Public\ChineseCodeNumberLine;
use App\Rules\Public\Numeric;
use App\Rules\Public\Required;
use App\Rules\Public\CheckBetween;
use App\Rules\Public\CheckUnique;
use App\Rules\Public\LetterNumberUnderLine;

use App\Rules\Admin\Common\TreeDeep;

use App\Facade\Admin\System\Group\AdminCategoryFacade;

class CategoryController extends Controller
{

     /**
     * 获取树形地址
     *
     * @return void
     */
    public function getTreeCategory()
    {
        $user = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($user)->allows('admin-role'))
        {
             $result = AdminCategoryFacade::getTreeCategory();
        }

        return  $result;
    }

     /**
     * 添加顶级/下级文章分类
     *
     * @param Request $request
     * @return void
     */
    public function addCategory(Request $request)
    {
        $user = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($user)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'parent_id'=>['bail',new Required,new Numeric],
                    'deep' => ['bail',new Required,new TreeDeep],
                    'sort' => ['bail',new Required,new Numeric],
                    'rate' => ['bail',new Required,new Numeric],
                    'category_name'=>['bail',new Required,new CheckString,new CheckBetween(2,30),new ChineseCodeNumberLine],
                    'category_code'=>['bail',new Required,new CheckString,new CheckBetween(2,30),new LetterNumberUnderLine, new CheckUnique('category','category_code')],
                    'remark_info'=>['bail','nullable',new CheckString,new CheckBetween(0,30),new ChineseCodeNumberLine],
                    'category_picture_id'=>['bail','nullable',new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            $result =AdminCategoryFacade::addCategory(f($validated),$user);
        }

        return $result;
    }

    /**
     * 修改文章分类
     *
     * @param Request $request
     * @return void
     */
    public function updateCategory(Request $request)
    {
        $user = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        $id = checkId($request->input('id'));

        if(Gate::forUser($user)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'parent_id'=>['bail',new Required,new Numeric],
                    'deep' => ['bail',new Required,new TreeDeep],
                    'sort' => ['bail',new Required,new Numeric],
                    'rate' => ['bail',new Required,new Numeric],
                    'category_name'=>['bail',new Required,new CheckString,new CheckBetween(2,30),new ChineseCodeNumberLine],
                    'category_code'=>['bail',new Required,new CheckString,new CheckBetween(2,30),new LetterNumberUnderLine, new CheckUnique('category','category_code',$id)],
                    'remark_info'=>['bail','nullable',new CheckString,new CheckBetween(0,30),new ChineseCodeNumberLine],
                    'category_picture_id'=>['bail','nullable',new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminCategoryFacade::updateCategory(f($validated),$user);
        }
        return $result;
    }

    /**
     * 树形控件移动
     *
     * @param Request $request
     * @return void
     */
    public function moveCategory(Request $request)
    {
        $user = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if (Gate::forUser($user)->allows('super-role')) {

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

            $result = AdminCategoryFacade::moveCategory($validated, $user);
        }

        return $result;
    }

    /**
     * 删除文章分类
     *
     * @param Request $request
     * @return void
     */
    public function deleteCategory(Request $request)
    {
        $user = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($user)->allows('admin-role'))
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

            //p($validated);die;

            $result = AdminCategoryFacade::deleteCategory(f($validated),$user);

        }

        return $result;
    }
}
