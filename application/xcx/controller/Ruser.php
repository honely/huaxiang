<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/4/18
 * Time: 14:02
 */
namespace app\xcx\controller;
use app\xcx\model\Loops;
use app\xcx\model\Msgs;
use app\xcx\model\Rolem;
use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

class Ruser extends Controller{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $adminName=session('adminName');
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
    public function details(){
        $cus_id=intval($_GET['id']);
        //获取客户信息；
        $cusInfo=Db::table('tk_ruser')->where(['id' => $cus_id])->find();
        $this->assign('cus',$cusInfo);
        return $this->fetch();
    }

    public function index(){
        $weChat = session('ad_wechat');
        $weChat = $weChat== null ? 0: $weChat;
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        //会话
        $addable = in_array('274',$power_list,true);
        //角色
        $editable = in_array('275',$power_list,true);
        $this->assign('addable',$addable);
        $this->assign('editable',$editable);
        $this->assign('wechat',$weChat);
        return $this->fetch();
    }


    public function userData(){
        $where ='1 = 1 ';
        $keywords = trim($this->request->param('keywords'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( id like '%".$keywords."%' or nickname like '%".$keywords."%')";
        }
        $count=Db::table('tk_ruser')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',50,'intval');
        $example=Db::table('tk_ruser')->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('cdate desc')
            ->select();
        if($example){
            foreach ($example as $k => $v){
                $example[$k]['roleId'] = $v['role_id'] == 0 ? '否': '是';
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $example;
        $res['count'] = $count;
        return json($res);
    }


    //通用缩略图上传接口
    public function upload()
    {
        if($this->request->isPost()){
            $res['code']=1;
            $res['msg'] = 'Upload SuccessFully！';
            $file = $this->request->file('file');
            $config = [
                'size' => 1024*1024*30
            ];
            $size = $file->validate($config);
            if($size){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/amsg');
                //halt( $info);
                if($info){
                    $res['name'] = $info->getFilename();
                    $res['filepath'] = 'uploads/amsg/'.$info->getSaveName();
                }else{
                    $res['code'] = 0;
                    $res['msg'] = 'Upload Failed！'.$file->getError();
                }
            }else{
                $res['code'] = 0;
                $res['msg'] = '10M maximum Size！';
            }
            return $res;
        }
    }

}