<?php
/**
 * Created by PhpStorm.
 * User: YEYECHEN
 * Date: 2018/7/29
 * Time: 12:32
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Exception;
use think\Validate;
use think\Request;

class BaseValidate extends Validate
{
    protected function isNotEmpty($value,$rule='',$data='',$field=''){

        if(empty($value)){
            return false;
        }else{
            return true;
        }
    }
    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getDataByRule($arrays){//接受一个arrays数组包含所有客户端传过来的参数变量
        if (array_key_exists('user_id', $arrays) | array_key_exists('uid', $arrays)) {
            // 不允许包含user_id或者uid，防止恶意覆盖user_id外键
            throw new ParameterException([
                'msg' => '参数中包含有非法的参数名user_id或者uid'
            ]);
        }
        $newArray = [];
        foreach ($this->rule as $key => $value) {//遍历我们的rule数组，获取指定变量
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }





    protected function isPositiveInteger($value,$rule='',$data='',$field=''){

        if(is_numeric($value)&&is_int($value+0)&&($value+0)>0){
            return true;
        }else{

            return false;
        }

    }
    public function gocheck(){
        //获取参数
        //对参数作校验
        $request=Request::instance();
        $params=$request->param();
        $result=$this->batch()->check($params);
        if(!$result){


            throw new Exception("参数不可以为空");
//            $error=$this->error;
//            throw new Exception($error);
        }else{
            return true;
        }

    }

}