<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/30
 * Time: 15:59
 */

namespace app\api\validate;


class ArticleMustBeNotNull extends BaseValidate
{
    protected $rule=[
        'title'=>'require' ,
        'content'=>'require',
        'author'=>'require',
        'id'=>'require|isPositiveInteger',
    ];
    protected $message=[
        'id'=>'id必须是正整数',
        'content'=>'文章内容不能为空',
        'author'=>'作者是谁？',
        'title'=>'请输入文章题目'
    ];
}