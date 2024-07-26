<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-06 19:25:04
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-07 22:12:28
 * @FilePath: \app\Http\Controllers\Admin\Develop\DevelopController.php
 */

namespace App\Http\Controllers\Admin\Develop;

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

use App\Rules\Admin\Login\Password;

use App\Facade\Admin\Develop\DeveloperFacade;


class DevelopController extends Controller
{

    /**
     * 添加
     *
     * @param Request $request
     * @return void
     */
    public function addDeveloper(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

           $result = code(\config('code.apiAuthError'));

            $validator = Validator::make(
                $request->all(),
                [
                    'username'=>['bail','nullable',new Required,new CheckString,new CheckBetween(1,20),new CheckUnique('users','account_name')],
                    'password'=>['bail','nullable',new Required,new CheckString,new CheckBetween(6,10),new Password]
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result =  DeveloperFacade::addDeveloper($admin,f($validated));
        }

        return $result;
    }


}
