<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use think\Db;

class Article extends BaseController
{
    protected $beforeActionList=[
        'checkSession'=>['only'=>'index,create,edit']
    ];


    public function index()
    {
        $array = Db::table('Article')->order('id')->select();
//        dump($list);
//        die;
        $list=[];
        foreach ($array as $data){
            switch ($data['kind']){
                case 'rdxw' :$data['kind']='热点新闻';break;
                case 'fybj' :$data['kind']='妇婴保健';break;
                case 'jbfz' :$data['kind']='疾病防治';break;
                case 'ysbj' :$data['kind']='饮食保健';break;
                case 'xljk' :$data['kind']='心理健康';break;
            }
            array_push($list,$data);
        }
        $this->assign('data',$list);

        echo $this->fetch("../application/admin/view/main/header.html");
        echo $this->fetch('../application/admin/view/main/index.html');
        echo $this->fetch("../application/admin/view/main/footer2.html");
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        echo $this->fetch("../application/admin/view/main/header.html");
        echo $this->fetch('../application/admin/view/main/create.html');
        echo $this->fetch("../application/admin/view/main/footer2.html");
        return ;
    }

    public function insert()
    {
        $data=[
            'title' => input('post.title'),
            'author'=>input('post.author'),
            'author_url' => input('post.author_url'),
            'article'=>input('post.article'),
            'summary'=>input('post.summary'),
            'kind'=>input('post.kind')
        ];
        $data['time'] = date('Y-m-d H:i:s');

        $tmp = request()->file('image');
        if ($tmp)
        {
            $pic = $tmp->validate(['ext'=>'jpg,png,jpeg'])->move(ROOT_PATH . 'public' . DS . 'cover_image');
            if ($pic)
                $data['image'] ="http://139.199.211.244/cover_image/".$pic->getSaveName();
            else
                echo '图片不合法';
        }
        else
            return "<script>alert('请上传图片');window.location.replace('/api/Article/create')</script>";

        if (!$data['title'])
            return "<script>alert('请输入文章标题');window.location.replace('/api/Article/create')</script>";
        else if (!$data['author'])
            return "<script>alert('请输入文章作者');window.location.replace('/api/Article/create')</script>";
        else if (!$data['summary'])
            return "<script>alert('请输入文章摘要');window.location.replace('/api/Article/create')</script>";
        else if ($data['article']=="<p><br></p>")
              return "<script>alert('请输入文章内容');window.location.replace('/api/Article/create')</script>";
        else
        {
            if (!$data['author_url'])
                $data['author_url'] = '#';
            $ret = Db::table('Article')->insert($data);

            if ($ret)
                return "<script>alert('添加成功');window.location.replace('/api/Article')</script>";
            else
                return "<script>alert('Un-Oh，遇到未知原因，编辑失败，请重试');window.location.replace('/api/Article')</script>";

        }
    }
    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read_by_id($id)
    {
        $data = Db::table('Article')->where('id',$id)->select();
        if ($data)
            $status = '读取成功';
        else
            $status = '读取失败';
        $tmp['status'] = $status;
        $tmp['data'] = $data[0];
        return json_encode($tmp);
    }

    public function read_by_kind($kind,$page)
    {
        $data = Db::table('Article')->where('kind',$kind)->order('time')->page($page,5)->select();
        if ($data)
            $status = '读取成功';
        else
            $status = '读取失败';
        $tmp['status'] = $status;
        $tmp['data'] = $data;
        return json_encode($tmp);
    }

    /**
     * 显示指定的资源
     *
     * @param
     * @return \think\Response
     */
    public function read_all()
    {
        $data = Db::table('Article')->order('id')->select();
        if ($data)
            $status = '读取成功';
        else
            $status = '读取失败';
        $tmp['status'] = $status;
        $tmp['data'] = $data;
        return json_encode($tmp);
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $tmp = Db::table('Article')->where('id',$id)->select();
        $data = $tmp[0];
        switch ($data['kind']){
            case 'rdxw' :$data['kind']='热点新闻';break;
            case 'fybj' :$data['kind']='妇婴保健';break;
            case 'jbfz' :$data['kind']='疾病防治';break;
            case 'ysbj' :$data['kind']='饮食保健';break;
            case 'xljk' :$data['kind']='心理健康';break;
        }
        $this->assign('data',$data);


        echo $this->fetch("../application/admin/view/main/header.html");
        echo $this->fetch('../application/admin/view/main/edit.html');
        echo $this->fetch("../application/admin/view/main/footer2.html");

    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update()
    {
        $data = input('post.');
        $id = input('post.id');

        $tmp = request()->file('image');

        if ($tmp)
        {
            $pic = $tmp->validate(['ext'=>'jpg,png,jpeg'])->move(ROOT_PATH . 'public' . DS . 'cover_image');
            if ($pic)
            {
                $data['image'] ="http://139.199.211.244/cover_image/".$pic->getSaveName();
                Db::table('Article')->where('id',$id)->update([
                    'image' => $data['image'],
                ]);
            }
            else
                echo '图片不合法';
        }
        $data['time'] = date('Y-m-d H:i:s');

        switch ($data['kind']){
            case '热点新闻' :$data['kind']='rdxw';break;
            case '妇婴保健' :$data['kind']='fybj';break;
            case '疾病防治' :$data['kind']='jbfz';break;
            case '饮食保健' :$data['kind']='ysbj';break;
            case '心理健康' :$data['kind']='xljk';break;
        }

        if (!$data['title'])
            return "<script>alert('请输入文章标题');window.location.replace('/api/Article')</script>";
        if (!$data['author'])
            return "<script>alert('请输入文章作者');window.location.replace('/api/Article')</script>";
         if (!$data['summary'])
            return "<script>alert('请输入文章摘要');window.location.replace('/api/Article')</script>";
        if  ($data['article']=="<p><br></p>")
            return "<script>alert('请输入文章内容');window.location.replace('/api/Article')</script>";

        $judge = Db::table('Article')->where('id',$id)->update([
            'title' => $data['title'],
            'author' => $data['author'],
            'kind' => $data['kind'],
            'author_url' => $data['author_url'],
            'summary' => $data['summary'],
            'article' => $data['article'],
            'time' => $data['time'],
        ]);

        if ($judge)
//            $this->success('编辑成功','/api/Article');
            return "<script>alert('编辑成功');window.location.replace('/api/Article')</script>";
        else
            return "<script>alert('Un-Oh，遇到未知原因，更新失败，请重试');window.location.replace('/api/Article')</script>";

        /*if ($judge)
            return self::index()."<script>alert('编辑成功');</script>";
        else
            return self::index()."<script>alert('Un-Oh，遇到未知原因，更新失败，请重试');</script>";*/
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $judge = Db::table('Article')->where('id',$id)->delete();

        if ($judge)
            return "<script>alert('删除成功');window.location.replace('/api/Article')</script>";
        else
            return "<script>alert('Un-Oh，遇到未知原因，删除失败，请重试'');window.location.replace('/api/Article')</script>";

    }
}
