<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-28 08:06:57
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-26 21:01:36
 * @FilePath: \app\Http\Controllers\Admin\System\Group\LabelController.php
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

use App\Facade\Admin\System\Group\AdminLabelFacade;

class LabelController extends Controller
{
   /**
     * 获取树形地址
     *
     * @return void
     */
    public function getTreeLabel()
    {
        $user = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($user)->allows('admin-role'))
        {
             $result = AdminLabelFacade::getTreeLabel();
        }

        return  $result;
    }

     /**
     * 添加顶级/下级标签
     *
     * @param Request $request
     * @return void
     */
    public function addLabel(Request $request)
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
                    'label_name'=>['bail',new Required,new CheckString],
                    'label_code'=>['bail','nullable',new CheckString],
                    'remark_info'=>['bail','nullable',new CheckString],
                    'label_picture_id'=>['bail','nullable',new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            $result =AdminLabelFacade::addLabel(f($validated),$user);
        }

        return $result;
    }

    /**
     * 更新标签
     *
     * @param Request $request
     * @return void
     */
    public function updateLabel(Request $request)
    {
        $user = Auth::guard('admin_token')->user();

        $result = code(config('admin_code.AdminAuthError'));

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
                    'label_name'=>['bail',new Required,new CheckString,],
                    'label_code'=>['bail','nullable',new CheckString],
                    'remark_info'=>['bail','nullable',new CheckString],
                    'label_picture_id'=>['bail','nullable',new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminLabelFacade::updateLabel(f($validated),$user);
        }
        return $result;
    }

    /**
     * 树形控件移动
     *
     * @param Request $request
     * @return void
     */
    public function moveLabel(Request $request)
    {
        $user = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if (Gate::forUser($user)->allows('super-role'))
        {

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

            $result = AdminLabelFacade::moveLabel(f($validated), $user);
        }

        return $result;
    }

    /**
     * 删除标签
     *
     * @param Request $request
     * @return void
     */
    public function deleteLabel(Request $request)
    {
        $user = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($user)->allows('admin-role'))
        {
           $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'is_delete'=>['bail',new Required,new Numeric],
                ],
                []
            );

            $validated = $validator->validated();
            //p($validated);die;
            $result = AdminLabelFacade::deleteLabel(f($validated),$user);

        }

        return $result;
    }
}
