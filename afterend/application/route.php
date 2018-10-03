<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::get("api/:version/banner/:id",'api/:version.Banner/getBanner'); //获取banner图片


//Route::get("xykqyxy/:version/Banneredit","api/:version._bannerupload/edit");















//Route::rule('hello','index/index/test',"POST",['https'=>false]);

//路由表达式，路由地址，请求类型：GET POST DELETE PUT *(任意类型）is BAD,路由参数（数组）
//既支持get又支持post：写两个rule
//把rule换成get/post/any也可以有相同的效果


/*return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];*/