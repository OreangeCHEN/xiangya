<?php
/**
 * Created by PhpStorm.
 * User: YEYECHEN
 * Date: 2018/7/30
 * Time: 0:09
 */

namespace app\api\model;
use think\Db;
use think\Exception;
use think\Model;



class Banner extends BaseModel
{

    protected $hidden=['delete_time','update_time','description'];
    //关联
    public function items(){
        return $this->hasMany('BannerItem','banner_id','id');
        //关联模型的模型名字，外键，当前模型的主键
    }

    //get
    public static function getBannerByID($id){
        $banner=self::with(['items','items.img'])->find($id);
        return $banner;
    }
}


//1.原生语句
//2.构造器查询
//3.模型和关联模型
//查询构造器，原因：方便，给了一种统一的操作数据库的方法


//$result=Db::query('select * from banner_item where banner_id=?',[$id]);
//return $result;
//select找全部find找第一个
// $result=Db::table('banner_item')->where('banner_id','=',$id)->select();  update delete insert find验证器方法（得到query对象）+查询方法
//链式方调用select的时候会清除前面所有的链式操作
//字段名，表达式，查询条件
//表达式，数组法，闭包：   数组法不够灵活而且存在一定的隐患  闭包是最为灵活的


/* $result=Db::table('banner_item')
          ->where('banner_id','=',$id)
          ->select();*/
/* $result=Db::table('banner_item')
     ->where(function ($query) use($id){
         $query->where('banner_id','=',$id);
     })
     ->select();*/