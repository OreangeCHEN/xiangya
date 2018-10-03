<?php
/**
 * Created by PhpStorm.
 * User: YEYECHEN
 * Date: 2018/7/29
 * Time: 11:38
 */

namespace app\api\validate;
use think\Validate;


class IDMustBePostiveInt extends BaseValidate
{
    protected $rule=[
        'id'=>'require|isPositiveInteger'
        ];

    protected $message=[
        'id'=>'id必须是正整数'
    ];

}