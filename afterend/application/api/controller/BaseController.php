<?php
/**
 * Created by PhpStorm.
 * User: YEYECHEN
 * Date: 2018/8/3
 * Time: 0:51
 */


namespace app\api\controller;




use app\api\service\Token as TokenService;
use think\Controller;

class BaseController extends Controller
{

    protected function checkSession(){
        if(!session('name')){
            return $this->error('您没有登陆',url('admin/login/index'));
        }
    }

}