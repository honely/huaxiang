<?php


namespace app\xcx\controller;

use app\xcx\model\Loops;
use think\Controller;
use think\Db;
use think\Request;

class Forent extends Controller
{

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
    public function index(){
        $adminId = session('adminId');
        return $this->fetch();
    }

    public function indexData(){
        $where =' status <= 2';
        $keywords = trim($this->request->param('keywords'));
        $type = trim($this->request->param('type'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( title like '%".$keywords."%')";
        }
        if(isset($type) && !empty($type) && $type){
            $where.=" and type = '".$type."'";
        }
        $count=Db::table('tk_forent')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',50,'intval');
        $order = 'cdate desc';
        $design=Db::table('tk_forent')
            ->limit(($page-1)*$limit,$limit)
            ->order($order)
            ->where($where)
            ->select();
        if($design){
            $loop = new Loops();
            foreach($design as $k => $v){
                $design[$k]['statuss'] = $v['status'] == 1 ? '已发布' :'草稿箱';
                $design[$k]['user_id'] = $loop->getUserNick($v['userid']);
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        return json($res);
    }



    public function del(){
        $id = $this->request->param('id',22,'intval');
        $del = Db::table('tk_forent')
            ->where(['id' => $id])
            ->delete();
        if($del){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！','index');
        }
    }


    //更改是否显示的状态
    public function status(){
        $ba_id = intval(trim($_GET['id']));
        $change = intval(trim($_GET['change']));
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '上线';
                $data['status'] = '1';
            }else{
                $msg = '下线';
                $data['status'] = '2';
            }
            $changeStatus = Db::table('tk_forent')->where(['id' => $ba_id])->update($data);
            if($changeStatus){
                $res['code'] = 1;
                $res['msg'] = $msg.'成功！';
            }else{
                $res['code'] = 0;
                $res['msg'] = $msg.'失败！';
            }
        }else{
            $res['code'] = 0;
            $res['msg'] = '这是个意外！';
        }
        return $res;
    }


    public function details(){
        $id = $this->request->param('id',22,'intval');
        $house = Db::table('tk_forent')
            ->where(['id' => $id])
            ->find();
        $msg = new Loops();
        if($house['userid']){
            $house['real_name'] = $msg->getUserNick($house['userid']);
            $house['avaurl'] = $msg->getUserAvatar($house['userid']);
        }
        $this->assign('house',$house);
        return $this->fetch();
    }


}