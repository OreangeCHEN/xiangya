<?php

namespace app\api\model;

use think\Model;

class BannerItem extends BaseModel
{
    //
    protected $hidden=['delete_time','id','img_id','banner_id','type','key_word'];
    //任何接口都不需要的字段
    protected $autoWriteTimestamp = true;
    public function img(){
        return $this->belongsTo('Image','img_id','id');
        //关联表名，外键，主键
    }
}
