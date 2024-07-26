<?php

namespace App\Rules\Public;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

use Illuminate\Support\Facades\DB;

class CheckUnique implements Rule
{
    protected $message;

    //表名
    protected $table;

    //字段
    protected $field;

    //忽略的id
    protected $ignoreId;


    public function __construct($table,$field,$ignoreId = 0)
    {
        $this->table = $table;

        $this->field = $field;

        $this->ignoreId = $ignoreId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $result = true;

        //分析 如果有忽略id 就是更新检查 没有则是添加
        $query = DB::table($this->table)->where($this->field,$value);

        if($this->ignoreId)
        {
            $dataNumber = $query->get()->count();

            if($dataNumber > 1)
            {
                 $result = false;
            }

            if($dataNumber == 1)
            {
                $queryData = $query->first();

                if($queryData->id != $this->ignoreId)
                {
                    $result = false;
                }
            }
        }
        else
        {
            //添加检查
            $dataNumber = $query->get()->count();

            if($dataNumber)
            {
                $result = false;
            }

        }

        if(!$result)
        {
            $this->message = '数据唯一性校验失败!';
            throw new RuleException('RuleCheckUniqueError',$attribute);
        }

        return $result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        //return 'The validation error message.';
        return  $this->message;
    }
}
