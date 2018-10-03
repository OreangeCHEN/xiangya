<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/4
 * Time: 21:02
 */

namespace app\admin\controller;
use app\api\controller\Article;
use think\Controller;
use think\Request;

class Main extends Controller
{
        public function __construct(Request $request){
            parent::__construct();
            //echo $this->fetch("header");

            $tmp = controller('api/Article','controller');
            $tmp->index();

            if ($request->action() == "edit")
                $tmp->edit(input('post.id'));
            if ($request->action() == "create")
                $tmp->create();

            //echo $this->fetch($request->action());
            //echo $this->fetch("footer");
            exit(0);
        }
}