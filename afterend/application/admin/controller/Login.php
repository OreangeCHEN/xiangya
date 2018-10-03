<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/7
 * Time: 11:39
 */

namespace app\admin\controller;

use app\api\controller\Article;
use think\Controller;
use think\Request;
use think\Session;


class Login extends Controller
{

    public function index(){
        echo $this->fetch('login');
    }
    public function check(){
        if (Request::instance()->isPost()) { //判断是否是是否为 POST 请求
            $data = input('post.');
//
            $username = $data['name'];
            $password = $data['password'];
            if ($username=='admin' &&$password=== 'admin') {
//                登录成功写入session

                Session::set('name', 'admin');
                Session::set('password', 'admin');
              return  "<script>window.location.replace('/api/Article/index')</script>";
//                return $this->success('登陆成功','/api/Article/index');
            } else {
                echo "<script>alert('用户名或密码错误');window.location.replace('index')</script>";
                return;
            }
        } else {
            echo "<script>alert('请正确访问');window.location.replace('index')</script>";
            return;
        }

    }
    public function logout(){
        session(null);//退出清空session
        $url='admin/login/index';
      echo $this->fetch('login');
//        return $this->success('退出成功',url('admin/login/index'));//跳转到登录页面
    }

}