<?php


namespace app\xcx\controller;


use app\api\controller\Mailer;
use app\xcx\model\Languages;
use app\xcx\model\Loops;
use think\Controller;
use think\Db;
use think\Request;

class Inspect extends Controller
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

    public function apply(){
        $lang = new Languages();
        $enLab = $lang->getLanguages();
        $this->assign('lable',$enLab);
        return $this->fetch();
    }


    public function add(){
        $cropId = session('ad_corp');
        $where='cp_able = 1 and cp_id  in ('.$cropId.')';
        $example=Db::table('xcx_corp')->where($where)
            ->limit(20)
            ->order('cp_addtime desc')
            ->field('cp_id,cp_name')
            ->select();
        $this->assign('corp',$example);
        return $this->fetch();
    }

    public function insertdata(){
        $data['hp_corp'] = $_POST['hp_corp'];
        $data['hp_type'] = $_POST['hp_type'];
        $data['hp_inspector'] = $_POST['hp_inspector'];
        $data['hp_cdate'] = date('Y-m-d H:i:s');
        $data['hp_mdate'] = date('Y-m-d H:i:s');
        if(isset($_POST['hp_hid']) && $_POST['hp_hid']){
            $bill = $_POST['hp_hid'];
            foreach($bill as $key => $val){
                $data['hp_hid'] = $key;
                $insert = Db::table('tk_houseplan')->insert($data);
            }
        }
        $this->success('添加成功！','index');
    }

    public function getAdmin(){
        //根据公司id去获取公司下面所有的员工
        $cid = trim($this->request->param('cid'));
        $where=" ad_corp  in (".$cid.")";
        $admin=Db::table('super_admin')
            ->where($where)
            ->limit(50)
            ->order('ad_id desc')
            ->field('ad_id,ad_realname')
            ->select();
        $house = Db::table('tk_houses')
            ->where(['status' => 1,'is_del' => 1,'corp' => $cid])
            ->field('id,address,street,title')
            ->select();
        foreach($house as $k => $v){
            $house[$k]['address'] = $v['street'] ? $v['street'].'/'.$v['address'] : $v['address'] ;
        }
        if($admin){
            return  json(['code' => '1','data' => $admin,'houses' => $house]);
        }else{
            return  json(['code' => '1','data' => $admin,'houses' => $house]);
        }
    }


    public function index(){
        return $this->fetch();
    }

    public function indexData(){
        $count=Db::table('tk_houseplan')
            ->count('hp_id');
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',50,'intval');
        $order = 'hp_cdate desc';
        $design=Db::table('tk_houseplan')
            ->join('tk_houses','tk_houseplan.hp_hid = tk_houses.id')
            ->join('super_admin','tk_houseplan.hp_inspector = super_admin.ad_id')
            ->limit(($page-1)*$limit,$limit)
            ->order($order)
            ->field('tk_houses.address,tk_houseplan.*,super_admin.ad_realname')
            ->select();
        if($design){
            foreach ($design as $k => $v){
                $design[$k]['hp_status'] = $this->getStatus($v['hp_status']);
                $design[$k]['is_rent'] = $this->getRenter($v['hp_id']);
                $design[$k]['hp_type'] = $v['hp_type'] == 1 ? '公开看房' : '私人看房';
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        return json($res);
    }
    
    public function getRenter($hpid){
        $count = Db::table('tk_planrenter')->where(['pu_hp_id' => $hpid])->count('pu_id');
        return $count;
    }

    public function getStatus($status){
        switch ($status)
        {
            //1，未开始；2，进行中；3。已完成；4已取消'
            case 1:
                $type = '未开始';
                break;
            case 2:
                $type = '进行中';
                break;
            case 3:
                $type = '已完成';
                break;
            case 4:
                $type = '已取消';
                break;
            default:
                $type = '---';
        }
        return $type;
    }


    /***
     * 添加时间后生成一条新的看房记录
     * @return mixed
     */
    public function addtime(){
        $id= $this->request->param('id');
        if($_POST){
            $plan = Db::table('tk_houseplan')->where(['hp_id' => $id])->find();
            $startime = $_POST['hp_plandate'].' '.$_POST['startime'];
            $endtime = date('Y-m-d H:i:s',strtotime($_POST['hp_plandate'].' '.$_POST['startime'])+($_POST['hp_chixutime']*60));
            $lastime = date('H:i',strtotime($startime)).'~'.date('H:i',strtotime($endtime));
            if(!$plan['hp_plandate']){
                $update = Db::table('tk_houseplan')
                    ->where(['hp_id' => $id])
                    ->update([
                        'hp_plandate' => $_POST['hp_plandate'],
                        'hp_startime' => $startime,
                        'hp_endtime' => $endtime,
                        'hp_lastime' => $lastime,
                        'hp_chixutime' => $_POST['hp_chixutime'],
                        'hp_maxnum' => $_POST['hp_maxnum'],
                        'hp_mdate' => date('Y-m-d H:i:s'),
                    ]);
            }else{
                $insert = Db::table('tk_houseplan')->insert([
                    'hp_hid' => $plan['hp_hid'],
                    'hp_inspector' => $plan['hp_inspector'],
                    'hp_corp' => $plan['hp_corp'],
                    'hp_type' => $plan['hp_type'],
                    'hp_cdate' => date('Y-m-d H:i:s'),
                    'hp_mdate' => date('Y-m-d H:i:s'),
                    'hp_plandate' => $_POST['hp_plandate'],
                    'hp_startime' => $startime,
                    'hp_endtime' => $endtime,
                    'hp_lastime' => $lastime,
                    'hp_chixutime' => $_POST['hp_chixutime'],
                    'hp_maxnum' => $_POST['hp_maxnum'],
                ]);
            }
            $this->success('添加时间成功！','inspect/index');
        }else{
            $this->assign('id',$id);
            return $this->fetch();
        }
    }


    //登记租客
    public function addrent(){
        $id= $this->request->param('id');
        if($_POST){
            $data['pu_hp_id'] = $id;
            $data['pu_uid'] = $_POST['pu_uid'];
            $data['pu_hid'] = $_POST['hp_hid'];
            $data['pu_addtime'] = date('Y-m-d H:i:s');
            $data['pu_username'] = $_POST['pu_username'];
            $data['pu_phone'] = $_POST['pu_phone'];
            $data['pu_email'] = $_POST['pu_email'];
            $insert = Db::table('tk_planrenter')->insert($data);
            if($insert){
                $this->success('添加租客成功！','inspect/index');
            }else{
                $this->success('添加租客成功！','inspect/index');
            }
        }else{
            $update = Db::table('tk_houseplan')
                ->where(['hp_id' => $id])->find();
            $houses = Db::table('tk_houses')
                ->where(['id' => $update['hp_hid']])
                ->field('id,address,street')
                ->find();
            $address = $houses['street'] ? $houses['street'].'/'.$houses['address'] : $houses['address'];
            $this->assign('address',$address);
            $users = Db::table('tk_userinfo')
                ->where(['u_hid' => $houses['id']])
                ->field('u_id,u_phone')
                ->select();
            $renter = Db::table('tk_planrenter')
                ->where(['pu_hp_id' => $id])
                ->order('pu_id desc')
                ->select();
            $this->assign('renter',$renter);
            $this->assign('users',$users);
            $this->assign('id',$id);
            $this->assign('hp_hid',$update['hp_hid']);
            return $this->fetch();
        }

    }

    public function getUser(){
        $id= $this->request->param('id');
        $user = Db::table('tk_userinfo')
            ->where(['u_id' => $id])
            ->field('u_email,u_id,u_name,u_phone,u_hid,u_uid')
            ->find();
        if($user){
            return  json(['code' => '1','data' => $user]);
        }else{
            return  json(['code' => '1','data' => $user]);
        }
    }

    public function delrent(){
        $id= $this->request->param('id');
        $user = Db::table('tk_planrenter')
            ->where(['pu_id' => $id])->delete();
        if($user){
            return  json(['code' => '1','msg' => '删除成功']);
        }else{
            return  json(['code' => '0','msg' => '删除失败！']);
        }
    }
    public function cancel(){
        $id= $this->request->param('id');
        $user = Db::table('tk_houseplan')
            ->where(['hp_id' => $id])
            ->update(['hp_status' => 4]);
        if($user){
            return  json(['code' => '1','msg' => '取消成功']);
        }else{
            return  json(['code' => '0','msg' => '取消失败！']);
        }
    }


    public function applyData(){
        $count=Db::table('tk_userinfo')
            ->count('u_id');
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',50,'intval');
        $example=Db::table('tk_userinfo')
            ->limit(($page-1)*$limit,$limit)
            ->order('u_Inquery_time desc')
            ->select();
        $loop = new Loops();
        if($example){
            foreach ($example as $k => $v){
                $example[$k]['u_source'] = $this->getSource($v['u_source']);
                $example[$k]['address'] = $this->gethouseAddress($v['u_hid']);
                $example[$k]['u_uid'] = $loop->getUserNick($v['u_uid']);
            }

        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $example;
        $res['count'] = $count;
        return json($res);
    }
    
    public function gethouseAddress($hid){
        $houses = Db::table('tk_houses')->where(['id'=>$hid])->field('address,street')->find();
        $address = $houses['street'] ? $houses['street'].'/'.$houses['address'] : $houses['address'];
        return $address;
    }


    public function getSource($status){
        switch ($status)
        {
            //`数据来源：1.看房预约；2站内信；3公司主页；4个人主页',
            case 1:
                $type = '看房预约';
                break;
            case 2:
                $type = '站内信';
                break;
            case 3:
                $type = '公司主页';
                break;
            case 4:
                $type = '个人主页';
                break;
            default:
                $type = '---';
        }
        return $type;
    }


    /**
     * 联系租客
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function emailrent(){
        $id= $this->request->param('id');
        $renter = Db::table('tk_planrenter')
            ->where(['pu_hp_id' => $id])
            ->order('pu_id desc')
            ->select();
        $this->assign('id',$id);
        $this->assign('renter',$renter);
        return $this->fetch();
    }

    public function emailrenter(){
        $subject = $this->request->param('emailsubject');
        $content = $this->request->param('emailcontent');
        $bill = $this->request->param();
        $billarr = $bill['pu_user'];
        $mailer = new Mailer();
        foreach($billarr as $key => $val){
            $mailer->mailtorenter($key,$subject,$content);
        }
        $this->success('发送成功！','inspect/index');
    }
    
    //联系客户
    public function emailuser(){
        $id= $this->request->param('id');
        $renter = Db::table('tk_userinfo')
            ->where(['u_id' => $id])
            ->find();
        $this->assign('user',$renter);
        return $this->fetch();
    }
    
    
     public function senduser(){
        $subject = $this->request->param('emailsubject');
        $content = $this->request->param('emailcontent');
        $user = $this->request->param('email');
        $mailer = new Mailer();
        $mailer->mailtorenter($user,$subject,$content);
        $this->success('发送成功！','inspect/index');
    }
}