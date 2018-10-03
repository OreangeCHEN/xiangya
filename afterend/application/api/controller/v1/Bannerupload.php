<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/28
 * Time: 22:09
 */

namespace app\api\controller\v1;

use app\api\model\BannerItem;
use app\api\model\Image;
use app\api\validate\ArticleMustBeNotNull;
use think\Controller;
use think\Request;
use app\api\controller\Article;
use app\admin\controller\Main;
;

class Bannerupload extends Controller
{
    public function _initialize()
    {
        //在调用此控制器方法前先使用初始化方法判断
        if(!session('name')){
            return $this->error('您没有登陆',url('admin/login/index'));
        }
    }

    public function edit(){
        echo $this->fetch("../application/admin/view/main/header.html");

        echo $this->fetch('../application/admin/view/main/banneredit.html');
        echo $this->fetch("../application/admin/view/main/footer.html");
    }


    public function upload()
    {


        $conclusion=[
            'id'=>input('post.type'),
            'author'=>input('post.author'),
            'article'=>input('post.article'),
            'title'=>input('post.title')
        ];
        if ($conclusion['article']=="<p><br></p>"){
            return "<script>alert('请输入文章内容');window.location.replace('/api/v1.Bannerupload/edit')</script>";
        }

       // BannerItem::update($conclusion);
        $file = request()->file('pic');
        if ($file) {
            $info = $file->validate(['ext'=>'jpg,png,jpeg'])->rule('sha1')->move(ROOT_PATH . 'public' . DS . 'banner_uploads');
            if ($info) {
                $img= "http://139.199.211.244/banner_uploads/".$info->getSaveName();
                /*$img ="http://123.207.252.76/banner_uploads/".$info->getPathname();*/
            } else {
                echo $file->getError();
            }
        }else{
            echo "请上传Banner图片";
        }
        $pic=[
            'id'=>$conclusion['id'],
            'url'=>$img
        ];
         BannerItem::update($conclusion);
         Image::update($pic);

        return "<script>alert('更新成功');window.location.replace('/api/Article')</script>";



//        return "<script>alert('更新成功');</script>".$this->fetch('login');
    }
}