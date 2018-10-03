<?php
/**
 * Created by PhpStorm.
 * User: YEYECHEN
 * Date: 2018/7/28
 * Time: 23:13
 */

namespace app\api\controller\v1;
use app\api\validate\IDMustBePostiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannnerMissException;

class Banner
{
    public function getBanner($id){


            //检查参数
            (new IDMustBePostiveInt())->gocheck();
            //获取banner
            $banner = BannerModel::getBannerByID($id);
            //异常的抛出
            if (!$banner) {
                throw new BannnerMissException();
            }
            return json($banner);

    }

}




//999未知错误或者是不希望用户知道的错误
//30000请求的主题不存在
//404找不到
//10001通用参数失败
//返回的banner的是一个模型的对象
//$banner->hidden(['update_time','delete_time']);
//$banner->visible(['id','update_time']);