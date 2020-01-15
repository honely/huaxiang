<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Ziyuan extends Controller
{

    public function index(){
        return $this->fetch();
    }

    public function indexData(){
        $count=Db::table('super_setinfo')
            ->where(['s_type' => 2])
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',15,'intval');
        $pcBan=Db::table('super_setinfo')
            ->where(['s_type' => 2])
            ->limit(($page-1)*$limit,$limit)
            ->select();
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $pcBan;
        $res['count'] = $count;
        return json($res);
    }


    public function edit(){
        $s_id= $this->request->param('s_id');
        $ban = Db::table('super_setinfo')->where(['s_id' => $s_id])->find();
        $this->assign('ban',$ban);
        return $this->fetch();
    }

    //banner图片上传
    public function upload(){
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/docs');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/docs/".$path_date."/".$path_filename;
            // 成功上传后 返回上传信息
            return json(array('state'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
        }else{
            // 上传失败返回错误信息
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }
}