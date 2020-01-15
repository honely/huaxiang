<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/9/19
 * Time: 15:51
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;

class Learn extends Controller{

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $adminName=session('adminId');
        if(empty($adminName)){
            $this->error('请先登录！','login/login');
        }
        if(isset($_SESSION['expiretime'])) {
            if($_SESSION['expiretime'] < time()) {
                unset($_SESSION['expiretime']);
                $this->error('您的登录身份已过期，请重新登录！','login/login');
                exit(0);
            } else {
                $_SESSION['expiretime'] = time() + 1800; // 刷新时间戳
            }
        }
    }

    /*
     * 培训管理
     * */
    public function index(){
        return $this->fetch();
    }

    /*
     * 课程管理数据
     * */
    public function indexData(){
        $where = " 1 = 1";
        $count=Db::table('super_lession')
            ->join('super_admin','super_admin.ad_id = super_lession.ls_admin')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $coupon=Db::table('super_lession')
            ->join('super_admin','super_admin.ad_id = super_lession.ls_admin')
            ->limit(($page-1)*$limit,$limit)
            ->where($where)
            ->order('ls_order desc')
            ->select();
        foreach ($coupon as $k =>$v){
            $coupon[$k]['ls_addtime'] = date('Y-m-d H:i:s',$v['ls_addtime']);
        }
        $res['code'] = 0;
        $res['data'] = $coupon;
        $res['count'] = $count;
        return json($res);
    }




    /*
     * 添加课程
     * */
    public function addLession(){
        $adminId=session('adminId');
        if($_POST){
            $data=$_POST;
            $data['ls_admin'] =$adminId;
            $data['ls_addtime'] =time();
            $data['ls_updatetime'] =time();
            $add=Db::table('super_lession')->insert($data);
            if($add){
                $this->success('发布课程成功！','index');
            }else{
                $this->error('发布课程失败！','index');
            }
        }else{
            return $this->fetch();
        }
    }



    /*
     *
     * editlession
     * */
    public function editlession(){
        $ls_id=intval(trim($_GET['ls_id']));
        $adminId=intval(session('adminId'));
        if($_POST){
            $data=$_POST;
            $data['ls_updatetime']=time();
            $data['ls_admin'] = $adminId;
            $update=Db::table('super_lession')->where(['ls_id'=> $ls_id])->update($data);
            if($update){
                $this->success('修改成功！','index');
            }else{
                $this->error('您未做任何修改！','index');
            }
        }else{
            $lessonInfo=Db::table('super_lession')
                ->where(['ls_id'=> $ls_id])
                ->find();
            $this->assign('lesson',$lessonInfo);
            return $this->fetch();
        }
    }






    /*
     * reOrder
     * */
    public function reOrder(){
        $ls_id=intval(trim($_POST['ls_id']));
        $ls_order=intval(trim($_POST['value']));
        if(!empty($ls_order)){
            $reOrder=Db::table('super_lession')->where(['ls_id' => $ls_id])->update(['ls_order' => $ls_order]);
            if($reOrder){
                $this->success('修改排序成功！');
            }else{
                $this->error('修改排序失败！');
            }
        }else{
            $this->error('请输入一个整数数字！');
        }
    }



    /*
     * reOrder
     * */
    public function subreOrder(){
        $lc_id=intval(trim($_POST['lc_id']));
        $lc_order=intval(trim($_POST['value']));
        if(!empty($lc_order)){
            $reOrder=Db::table('super_chapter')->where(['lc_id' => $lc_id])->update(['lc_order' => $lc_order]);
            if($reOrder){
                $this->success('修改排序成功！');
            }else{
                $this->error('修改排序失败！');
            }
        }else{
            $this->error('请输入一个整数数字！');
        }
    }


    /*
     *dellesson
     * */
    public function dellesson(){
        $ls_id=intval(trim($_GET['ls_id']));
        $del=Db::table('super_lession')->where(['ls_id' => $ls_id])->delete();
        if($del){
            $this->success('删除课程成功','index');
        }else{
            $this->error('删除课程失败','index');
        }
    }


    /*
     * 课程章节内容
     * */
    public function sublesson(){
        $ls_id=intval(trim($_GET['ls_id']));
        $ls_title=Db::table('super_lession')->where(['ls_id' => $ls_id])->column('ls_title');
        $this->assign('ls_title',$ls_title[0]);
        $this->assign('ls_id',$ls_id);
        return $this->fetch();
    }


    public function chapterData(){
        $where = " 1 = 1";
        $ls_id= intval(trim($this->request->param('ls_id')));
        $count=Db::table('super_chapter')
            ->join('super_admin','super_chapter.lc_admin = super_admin.ad_id')
            ->where(['lc_ls_id' => $ls_id])
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $subLesson=Db::table('super_chapter')
            ->join('super_admin','super_chapter.lc_admin = super_admin.ad_id')
            ->where(['lc_ls_id' => $ls_id])
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('lc_order desc')
            ->field('super_admin.ad_realname,super_chapter.*')
            ->select();
        foreach ($subLesson as $k =>$v){
            $subLesson[$k]['lc_addtime'] = date('Y-m-d H:i:s',$v['lc_addtime']);
        }
        $res['code'] = 0;
        $res['data'] = $subLesson;
        $res['count'] = $count;
        return json($res);
    }

    /*
     * addsubles
     * */
    public function addsubles(){
        $adminId=intval(session('adminId'));
        $ls_id=intval(trim($_GET['ls_id']));
        if($_POST){
            $data=$_POST;
            $data['lc_ls_id'] =$ls_id;
            $data['lc_admin'] =$adminId;
            $data['lc_addtime'] =time();
            $data['lc_updatetime'] =time();
            $add=Db::table('super_chapter')->insert($data);
            if($add){
                $this->success('发布成功！');
            }else{
                $this->error('发布失败！');
            }
        }else{
            $ls_title=Db::table('super_lession')->where(['ls_id' => $ls_id])->column('ls_title');
            $this->assign('ls_title',$ls_title[0]);
            $this->assign('ls_id',$ls_id);
            return $this->fetch();
        }
    }

    /*
     * status
     * */
    public function status(){
        $ls_id = $_GET['ls_id'];
        $change = $_GET['change'];
        if($ls_id && isset($change)){
            if($change){
                $msg = '显示';
                $data['ls_isable'] = 1;
            }else{
                $msg = '隐藏';
                $data['ls_isable'] = 2;
            }
            $changeStatus = Db::table('super_lession')->where(['ls_id' => $ls_id])->update($data);
            if($changeStatus){
                $res['code'] = 1;
                $res['msg'] = $msg.'成功！';
            }else{
                $res['code'] = 0;
                $res['msg'] =$msg.'失败！';
            }
        }else{
            $res['code'] = 0;
            $res['msg'] = '这是个意外！';
        }
        return $res;
    }

    /*
     * status
     * */
    public function substatus(){
        $lc_id = $_GET['lc_id'];
        $change = $_GET['change'];
        if($lc_id && isset($change)){
            if($change){
                $msg = '显示';
                $data['lc_isable'] = 1;
            }else{
                $msg = '隐藏';
                $data['lc_isable'] = 2;
            }
            $changeStatus = Db::table('super_chapter')->where(['lc_id' => $lc_id])->update($data);
            if($changeStatus){
                $res['code'] = 1;
                $res['msg'] = $msg.'成功！';
            }else{
                $res['code'] = 0;
                $res['msg'] =$msg.'失败！';
            }
        }else{
            $res['code'] = 0;
            $res['msg'] = '这是个意外！';
        }
        return $res;
    }



    /*
     * editsubles
     * */
    public function editsubles(){
        $lc_id=intval(trim($_GET['lc_id']));
        $adminId=intval(session('adminId'));
        if($_POST){
            $data=$_POST;
            $data['lc_updatetime']=time();
            $data['lc_admin'] = $adminId;
            $update=Db::table('super_chapter')->where(['lc_id'=> $lc_id])->update($data);
            if($update){
                $this->success('修改成功！');
            }else{
                $this->error('您未做任何修改！');
            }
        }else{
            $chapterInfo=Db::table('super_chapter')
                ->where(['lc_id'=> $lc_id])
                ->find();
            $ls_id=$chapterInfo['lc_ls_id'];
            $ls_title=Db::table('super_lession')->where(['ls_id' => $ls_id])->column('ls_title');
            $this->assign('ls_title',$ls_title[0]);
            $this->assign('ls_id',$ls_id);
            $this->assign('chapter',$chapterInfo);
            return $this->fetch();
        }
    }


    /*
     * delchapter
     * */
    public function delchapter(){
        $lc_id=intval(trim($_GET['lc_id']));
        $del=Db::table('super_chapter')->where(['lc_id' => $lc_id])->delete();
        if($del){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }




    /*
     * 题库管理
     * */
    public function exam(){
        return $this->fetch();
    }

    //文章图片上传
    public function upload(){
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/article');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/learn/".$path_date."/".$path_filename;
            // 成功上传后 返回上传信息
            return json(array('state'=>1,'path'=>$path,'msg'=> '文件上传成功！'));
        }else{
            // 上传失败返回错误信息
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }




}