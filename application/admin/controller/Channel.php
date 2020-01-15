<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/11/9
 * Time: 15:35
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;

class Channel extends Controller{
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


    public function index(){
        $channel=Db::table('super_house_rent_channel')
            ->order('hrc_isable,hrc_addtime desc')
            ->select();
        $this->assign('channel',$channel);
        return $this->fetch();
    }



    public function add(){
        if($_POST){
            $data['hrc_title']=trim($_POST['hrc_title']);
            $data['hrc_img']=trim($_POST['hrc_img']);
            $data['hrc_isable']=intval(trim($_POST['hrc_isable']));
            $data['hrc_addtime']=time();
            $data['hrc_admin'] = session('adminId');
            $add=Db::table('super_house_rent_channel')->insert($data);
            if($add){
                $this->success('添加成功！','channel/index');
            }else{
                $this->success('添加失败！','channel/add');
            }
        }else{
            return $this->fetch();
        }
    }


    public function edit(){
        $hrc_id=$_GET['hrc_id'];
        if($_POST){
            $data['hrc_title']=trim($_POST['hrc_title']);
            $data['hrc_img']=trim($_POST['hrc_img']);
            $data['hrc_isable']=intval(trim($_POST['hrc_isable']));
            $data['hrc_addtime']=time();
            $data['hrc_admin'] = session('adminId');
            $update=Db::table('super_house_rent_channel')
                ->where(['hrc_id' => $hrc_id])
                ->update($data);
            if($update){
                $this->success('修改成功！','channel/index');
            }else{
                $this->success('您未做任何修改！','channel/index');
            }
        }else{
            $channel=Db::table('super_house_rent_channel')
                ->where(['hrc_id' => $hrc_id])
                ->find();
            $this->assign('conf',$channel);
            return $this->fetch();
        }
    }

    public function del(){
        $hrc_id=intval(trim($_GET['hrc_id']));
        $del=Db::table('super_house_rent_channel')
            ->where(['hrc_id' => $hrc_id])
            ->delete();
        if($del){
            $this->success('删除成功！','channel/index');
        }else{
            $this->success('删除失败！','channel/index');
        }
    }



    public function upload(){
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/channel');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/channel/".$path_date."/".$path_filename;
            return json(array('state'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
        }else{
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }
}