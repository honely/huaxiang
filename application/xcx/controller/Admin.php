<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/5/6
 * Time: 10:03
 */
namespace app\xcx\controller;
use app\xcx\model\Loops;
use app\xcx\model\Rolem;
use phpmailer\PHPMailer;
use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

class Admin extends Controller{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $adminName=session('adminName');
        if(empty($adminName)){
            $this->error('Please Login！','login/login');
        }
        if(isset($_SESSION['expiretime'])) {
            if($_SESSION['expiretime'] < time()) {
                unset($_SESSION['expiretime']);
                $this->error('Please Login！','login/login');
                exit(0);
            } else {
                $_SESSION['expiretime'] = time() + 1800; // 刷新时间戳
            }
        }
    }

    //管理员
    public function adminData(){
        $where=' 1 = 1 ';
        $keywords = trim($this->request->param('keywords'));
        $ad_role = trim($this->request->param('ad_role'));
        if(isset($ad_role) && !empty($ad_role)){
            $where.=" and  ad_role = ".$ad_role." ";
        }
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( ad_realname like '%".$keywords."%' or ad_bid like '%".$keywords."%' )";
        }
        $count=Db::table('super_admin')
            ->join('super_role','super_role.r_id = super_admin.ad_role')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',50,'intval');
        $admin=Db::table('super_admin')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('ad_id desc')
            ->select();
        $loop = new Loops();
        foreach($admin as $k => $v){
            $sex = $v['ad_sex']== 1 ? '男' :'女';
            $admin[$k]['adWechat'] = $loop->getUserNick($v['ad_wechat']);
            $admin[$k]['ad_roles'] = $this->getRoleName($v['ad_role']);
            $admin[$k]['ad_corp'] = $this->getCropName($v['ad_corp']);
            $admin[$k]['ad_createtime'] = date('Y-m-d H:i:s',$v['ad_createtime']);
            $admin[$k]['ad_realname'] = $v['ad_realname']."    ( ".$sex." )";
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $admin;
        $res['count'] = $count;
        $res['where'] = $where;
        return json($res);
    }


    public function getCropName($corpIds){
        $roleArr = explode(',',$corpIds);
        $roleNames = '';
        for ($i = 0;$i < count($roleArr);$i++){
            $roleName = $this->getCrop($roleArr[$i]);
            $roleNames.= $roleName.',';
        }
        return rtrim($roleNames,',');
    }



    public function getCrop($roleid){
        $roleInfo = Db::table('xcx_corp')
            ->where(['cp_id' => $roleid])
            ->field('cp_name')
            ->find();
        return $roleInfo['cp_name'];
    }


    public function getRoleName($roleIds){
        $roleArr = explode(',',$roleIds);
        $roleNames = '';
        for ($i = 0;$i < count($roleArr);$i++){
            $roleName = $this->getRole($roleArr[$i]);
            $roleNames.= $roleName.',';
        }
        return rtrim($roleNames,',');
    }

    public function getRole($roleid){
        $roleInfo = Db::table('super_role')
            ->where(['r_id' => $roleid])
            ->field('r_name')
            ->find();
        return $roleInfo['r_name'];
    }


    public function fenpei(){
        $adId = intval(trim($this->request->param('ad_id')));
        $adminWechat = Db::table('tk_user')->where(['role_id' => 1])->field('id,nickname,tel')->select();
        $this->assign('sale',$adminWechat);
        $this->assign('ad_id',$adId);
        return $this->fetch();
    }


    public function fenPro(){
        $ad_id = trim($this->request->param('ad_id','0','intval'));
        $ad_wechat = trim($this->request->param('ad_wechat','0','intval'));
        $update = Db::table('super_admin')
            ->where(['ad_id' => $ad_id])
            ->update(['ad_wechat' => $ad_wechat]);
        if($update){
            $this->success('Successfully！');
        }else{
            $this->error('Failed!');
        }
    }



    public function admin(){
        $ad_role=intval(session('ad_role'));
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $addable = in_array('247',$power_list,true);
        $editable = in_array('249',$power_list,true);
        $delable = in_array('251',$power_list,true);
        $offable = in_array('248',$power_list,true);
        $connectable = in_array('250',$power_list,true);
        $this->assign('addable',$addable);
        $this->assign('editable',$editable);
        $this->assign('delable',$delable);
        $this->assign('offable',$offable);
        $this->assign('connectable',$connectable);
        if($_POST){
            $where = ' 1 = 1 ';
            $keywords=trim($this->request->param('keywords'));
            $ad_role=intval(trim($this->request->param('ad_role')));

            if(isset($keywords) && !empty($keywords)){
                $where.=" and ( ad_realname like '%".$keywords."%' or ad_phone like '%".$keywords."%' or ad_email like '%".$keywords."%')";
            }
            if(isset($ad_role) && !empty($ad_role)){
                $where.=" and ad_role = ".$ad_role;
            }
            //已展示
            $data['display']=Db::table('super_admin')
                ->join('super_role','super_role.r_id = super_admin.ad_role')
                ->where($where)
                ->where(['ad_isable' => 1])
                ->count();
            //未展示
            $data['none']=Db::table('super_admin')
                ->join('super_role','super_role.r_id = super_admin.ad_role')
                ->where($where)
                ->where(['ad_isable' => 2])
                ->count();
            $data['all']=intval($data['display'])+intval($data['none']);
            return $data;
        }
        $wheres = ' 1 = 1 ';
        $roleInfo=Db::table('super_role')->where($wheres)->field('r_id,r_name')->select();
        $this->assign('roleInfo',$roleInfo);
        $this->assign('ad_role',$ad_role);
        return $this->fetch();
    }

    //更改是否显示的状态
    public function status(){
        $ba_id = $_GET['ad_id'];
        $change = $_GET['change'];
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = 'Show';
                $data['ad_isable'] = '1';
            }else{
                $msg = 'Hide';
                $data['ad_isable'] = '2';
            }
            $changeStatus = Db::table('super_admin')->where(['ad_id' => $ba_id])->update($data);
            if($changeStatus){
                $res['code'] = 1;
                $res['msg'] = $msg.'Successfully！';
            }else{
                $res['code'] = 0;
                $res['msg'] = $msg.'Failed！';
            }
        }else{
            $res['code'] = 0;
            $res['msg'] = '这是个意外！';
        }
        return $res;
    }



    //添加管理员
    public function add(){
        $ad_role = intval(session('ad_role'));
        if($_POST){
            $data['ad_realname'] = $_POST['ad_realname'];
            $data['ad_sex'] = $_POST['ad_sex'];
            $data['ad_phone'] = str_replace(' ', '', $_POST['ad_phone']);
            $data['ad_email'] = $_POST['ad_email'];
            $isRepeat=Db::table('super_admin')
                ->where(['ad_email' => $data['ad_email']])
                ->find();
            if($isRepeat){
                $this->error('Already Account！','admin');
            }
            $data['ad_isable'] = 2;
            if(isset($_POST['ad_role']) && $_POST['ad_role']){
                $bill = $_POST['ad_role'];
                $bills = '';
                foreach($bill as $key => $val){
                    $bills .= $key.',';
                }
                $data['ad_role'] = rtrim($bills,',');
            }
            if(isset($_POST['ad_corp']) && $_POST['ad_corp']){
                $bill = $_POST['ad_corp'];
                $bills = '';
                foreach($bill as $key => $val){
                    $bills .= $key.',';
                }
                $data['ad_corp'] = rtrim($bills,',');
            }
            $data['ad_createtime'] = time();
            $data['ad_admin'] = session('adminId');
            $data['ad_password'] = md5($_POST['ad_password']);
            $data['ad_job'] = $_POST['ad_job'];
            $data['ad_img'] = $_POST['ad_img'];
            $data['ad_desc'] = $_POST['ad_desc'];
            $add=Db::table('super_admin')->insertGetId($data);
            //如果后台添加的这个手机号和前端用户绑定的手机号相同则自动绑定
            $userPhone = Db::table('tk_user')->where(['tel' => $data['ad_phone']])->field('id,tel')->find();
            if($userPhone){
                Db::table('super_admin')->where(['ad_id' => $add])->update(['ad_wechat'=>$userPhone['tel']]);
            }
            if($add){
                $adminInfo = Db::table('super_admin')
                    ->where(['ad_id' => $add])
                    ->field('ad_email')
                    ->find();
                $this->sendEmail($adminInfo['ad_email']);
                //给平台用户发送一条账户邮箱激活链接
                $this->success('Please Check Your Email Account to active ','admin');
            }else{
                $this->error('Failed','admin');
            }
        }else{
            $where = '1 = 1';
            $roleInfo=Db::table('super_role')
                ->field('r_id,r_name')
                ->where($where)
                ->select();
            $adminUser = Db::table('tk_user')
                ->where(['role_id' => 1])
                ->field('id,nickname,tel')
                ->select();
            $crop = Db::table('xcx_corp')
                ->where(['cp_able' => 1])
                ->field('cp_id,cp_name')
                ->select();
            $this->assign('crop',$crop);
            $this->assign('user',$adminUser);
            $this->assign('role',$roleInfo);
            return $this->fetch();
        }
    }


  public function sendEmail($mailer){
        Loader::import('phpmailer.phpmailer');
        $mail = new PHPMailer();
        $toemail = $mailer;//收件人
        $mail->isSMTP();// 使用SMTP服务
        $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
        $mail->Host = "mail.welho.me";// 发送方的SMTP服务器地址
        $mail->SMTPAuth = true;// 是否使用身份验证
        $mail->Username = "customerservices@welho.me";
        $mail->Password = "hxxb0401!!";
        $mail->SMTPSecure = "ssl";// 使用ssl协议方式
        $mail->Port = 465;
        $mail->setFrom("customerservices@welho.me","花香小宝");
        $mail->addAddress($toemail,'Wang');
        $mail->addReplyTo($mailer,"Reply");
        $mail->Subject = "[Welhome]Congratulations, You have registered on Welhome Agent Platform!";// 邮件标题
        $mail->IsHTML(true);
        $mail->Body = "Welhome Aboard! Welhome Agent Platform (www.welho.me).
        <br/><br/>
The best Realestate wechat app in Australia, an professional property leasing platform dedicated for Realestate Agents.
 <br/><br/>
 You can 'Add listing', 'Manage Listing' and 'Chat' . If you find any problem or suggestion, please feel free to contact us!<br/><br/>
<b>Your Account:</b>".$mailer."
 <br/><br/>
<b>Default Password:</b> 123456
 <br/><br/>
Please follow the activation link: <a href='https://wx.huaxiangxiaobao.com/api/index/active?email=".$mailer."'>https://wx.huaxiangxiaobao.com/api/index/active?email=".$mailer."</a>
 <br/><br/><br/><br/><br/>
<img style='width: 204px;height: 86px;' src='https://wx.huaxiangxiaobao.com/public/ueditor/php/upload/image/20200417/1587119666198174.png'>
<br>
<b>Welhome Pty Ltd
<br>
ABN: 11 628 249 687</b>
<br>
<b style='color:rgb(237,125,49);font-weight:bold;'>A</b> 10-12 Woorayl St, Carnegie, VIC, 3163
<br>
<b style='color:rgb(237,125,49);font-weight:bold;'>W</b> https://huaxiangxiaobao.com/";
        if(!$mail->send()){
            return json(['code'=>0,'msg'=>'发送失败！请联系管理员']);
        }else{
            return json(['code'=>1,'msg'=>'发送成功！']);
        }
    }
    //修改管理员
    public function edit(){
        $ad_id=intval($_GET['ad_id']);
        if($_POST){
            $data['ad_realname'] = $_POST['ad_realname'];
            $data['ad_sex'] = $_POST['ad_sex'];
            $data['ad_phone'] = str_replace(' ', '', $_POST['ad_phone']);
            $data['ad_job'] = $_POST['ad_job'];
            $data['ad_img'] = $_POST['ad_img'];
            $data['ad_desc'] = $_POST['ad_desc'];
            $data['ad_email'] = $_POST['ad_email'];
            $isRepeat=Db::table('super_admin')
                ->where('ad_id','neq',$ad_id)
                ->where(['ad_email' => $data['ad_email']])
                ->find();
            if($isRepeat){
                $this->error('此邮箱已注册！','admin');
            }
            if(isset($_POST['ad_role']) && $_POST['ad_role']){
                $bill = $_POST['ad_role'];
                $bills = '';
                foreach($bill as $key => $val){
                    $bills .= $key.',';
                }
                $data['ad_role'] = rtrim($bills,',');
            }
            if(isset($_POST['ad_corp']) && $_POST['ad_corp']){
                $bill = $_POST['ad_corp'];
                $bills = '';
                foreach($bill as $key => $val){
                    $bills .= $key.',';
                }
                $data['ad_corp'] = rtrim($bills,',');
            }
            $edit=Db::table('super_admin')->where(['ad_id' => $ad_id])->update($data);
            if($edit){
                $this->success('Successfully！','admin');
            }else{
                $this->error('Failed！','admin');
            }
        }else{
            $ad_role = intval(session('ad_role'));
            $adminInfo=Db::table('super_admin')
                ->where(['ad_id' => $ad_id])
                ->find();
            $allrole = [
                [
                    'ad_id' => '1',
                    'ad_role' => '超级管理员',
                    'is_checked' => false
                ],
                [
                    'ad_id' => '43',
                    'ad_role' => '企业负责人',
                    'is_checked' => false
                ],
                [
                    'ad_id' => '44',
                    'ad_role' => '企业员工',
                    'is_checked' => false
                ],
                [
                    'ad_id' => '45',
                    'ad_role' => '运营负责人',
                    'is_checked' => false
                ],
                [
                    'ad_id' => '46',
                    'ad_role' => '客服',
                    'is_checked' => false
                ]
            ];
            $houseBill = explode(',',$adminInfo['ad_role']);
            foreach ($allrole as $key => &$val) {
                if(in_array($val['ad_id'], $houseBill)) {
                    $val['is_checked'] = true;
                }
            }unset($val);
            $houseInfo['sub'] = $houseBill;
            $all_tags = Db::table('xcx_corp')
                ->where(['cp_able' => 1])
                ->field('cp_id,cp_name')
                ->select();
            $crops= explode(',',$adminInfo['ad_corp']);
            foreach ($all_tags as $key => &$val) {
                $all_tags[$key]['is_checked'] = false;
                if(in_array($val['cp_id'], $crops)) {
                    $val['is_checked'] = true;
                }
            }unset($val);
            $this->assign('crop',$all_tags);
            $this->assign('allrole',$allrole);
            $this->assign('admin',$adminInfo);
            return $this->fetch();
        }
    }



    public function detail(){
        $ad_id=intval($_GET['ad_id']);
        $adminInfo=Db::table('super_admin')
            ->where(['ad_id' => $ad_id])
            ->find();
        if($adminInfo){
            $adminInfo['ad_roles'] = $this->getRoleName($adminInfo['ad_role']);
            $adminInfo['ad_corp'] = $this->getCropName($adminInfo['ad_corp']);
        }
        $where = '1 = 1';
        $roleInfo=Db::table('super_role')
            ->field('r_id,r_name')
            ->where($where)
            ->select();
        $this->assign('role',$roleInfo);
        $this->assign('admin',$adminInfo);
        return $this->fetch();
    }

    public function getAdminCorp($cpId){
        $corp = Db::table('xcx_corp')
            ->where(['cp_id' => $cpId])
            ->field('cp_name')
            ->find();
        return $corp ? $corp['cp_name'] : '未选择公司';
    }

    //检测电话号码
    public function checkPhone(){
        $ad_id=$_POST['ad_id'];
        $ad_phone=$_POST['ad_bid'];
        if($ad_id){
            $isRepeat=Db::table('super_admin')
                ->where('ad_id','neq',$ad_id)
                ->where(['ad_bid' => $ad_phone])
                ->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = 'Already Account！';
            }else{
                $res['code'] = 1;
                $res['msg'] = 'Available。';
            }
        }else{
            $isRepeat=Db::table('super_admin')->where(['ad_bid' => $ad_phone])->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = 'Already Account！';
            }else {
                $res['code'] = 1;
                $res['msg'] = 'Available。';
            }
        }
        return $res;
    }



    //检测邮箱
    public function checkEmail(){
        $ad_id=$_POST['ad_id'];
        $ad_email=$_POST['ad_email'];
        if($ad_id){
            $isRepeat=Db::table('super_admin')
                ->where('ad_id','neq',$ad_id)
                ->where(['ad_email' => $ad_email])
                ->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = 'Already Account！！';
            }else{
                $res['code'] = 1;
                $res['msg'] = 'Available。';
            }
        }else{
            $isRepeat=Db::table('super_admin')->where(['ad_email' => $ad_email])->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = 'Already Account！';
            }else {
                $res['code'] = 1;
                $res['msg'] = 'Available。';
            }
        }
        return $res;
    }








//通用缩略图上传接口
    public function upload()
    {
        if($this->request->isPost()){
            $res['code']=1;
            $res['msg'] = '上传成功！';
            $file = $this->request->file('file');
            $config = [
                'size' => 1024*1024*10
            ];
            $size = $file->validate($config);
            if($size){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/admin');
                //halt( $info);
                if($info){
                    $res['name'] = $info->getFilename();
                    $res['filepath'] = 'uploads/admin/'.$info->getSaveName();
                }else{
                    $res['code'] = 0;
                    $res['msg'] = 'Failed！'.$file->getError();
                }
            }else{
                $res['code'] = 0;
                $res['msg'] = '10M maximum Size！';
            }
            return $res;
        }
    }






    //删除管理员
    public function del(){
        $ad_id=intval($_GET['ad_id']);
        $del=Db::table('super_admin')->where(['ad_id' => $ad_id])->delete();
        if($del){
            $this->success('Successfully','admin');
        }else{
            $this->error('Failed','admin');
        }
    }

    //根据城市id获取
    public function getAreaName(){
        $c_id=intval($_GET['c_id']);
        $branch=Db::table('super_area')
            ->where(['area_c_id' => $c_id])
            ->field('area_id,area_name')
            ->select();
        if($branch){
            return  json(['code' => '1','data' => $branch]);
        }else{
            return  json(['code' => '0','data' => ['']]);
        }
    }

    //根据分站id获取该分站下的管理员；
    public function getAdminName(){
        $b_id=intval($_POST['b_id']);
        $admin=Db::table('super_admin')
            ->where(['ad_branch' => $b_id])
            ->field('ad_id,ad_realname')
            ->select();
        if($admin){
            return  json(['code' => '1','data' => $admin]);
        }else{
            return  json(['code' => '0','data' => ['']]);
        }
    }





    //角色配置
    public function role(){
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $addable = in_array('252',$power_list,true);
        $editable = in_array('253',$power_list,true);
        $delable = in_array('254',$power_list,true);
        $this->assign('addable',$addable);
        $this->assign('editable',$editable);
        $this->assign('delable',$delable);
        $count=Db::table('super_role')
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',50,'intval');
        $role=Db::table('super_role')
            ->limit(($page-1)*$limit,$limit)
            ->order('r_id desc')
            ->select();
        foreach($role as $k =>$v){
            $role[$k]['countNum']=Db::table('super_admin')->where(['ad_role' => $v['r_id']])->count();
        }
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('limit',$limit);
        $this->assign('role',$role);
        return $this->fetch();
    }



    public  function  addrole(){
        if($_POST){
        }else{
            //顶级菜单
            $menuList=Db::table('super_menu')
                ->where(['m_fid' => '0', 'm_type' => '1'])
                ->order('m_sort desc')
                ->select();
            foreach ($menuList as $k =>$v){
                //子菜单
                $menuList[$k]['child'] = Db::table('super_menu')
                    ->where(['m_fid' => $v['m_id'], 'm_type' => '1'])
                    ->order('m_sort desc')
                    ->select();
                //操作方法；
                foreach($menuList[$k]['child'] as $key =>$val){
                    $menuList[$k]['child'][$key]['children']= Db::table('super_menu')
                        ->where(['m_fid' => $val['m_id'], 'm_type' => '2'])
                        ->order('m_sort desc')
                        ->select();
                }
            }
            $this->assign('menuList',$menuList);
            return $this->fetch();
        }
    }



    //添加角色取到m_ids
    public function addmenuids(){
        $stime=strtotime(date('Y-m-d 00:00:00'));
        $etime=strtotime(date('Y-m-d 23:59:59'));
        //获取当日预约的数量
        $buNum=Db::table('super_role')->where('r_opeatime','between',[$stime,$etime])->count();
        //生成用户编号；
        $data['r_bid'] = date('Ymd').sprintf("%04d", $buNum+1);
        $data['r_power']=trim($_POST['ids'],',');
        $data['r_name']=trim($_POST['r_name']);
        $ids=explode(',',$data['r_power']);
        $data['r_power']=implode(',',array_unique($ids));
        $addRole=Db::table('super_role')->insert($data);
        if($addRole){
            $this->success('Successfully','role');
        }else{
            $this->error('Failed','role');
        }
    }


    //editRole
    public function editrole(){
        $r_id=intval($_GET['r_id']);
        if($_POST){
        }else{
            $roleInfo=Db::table('super_role')->where(['r_id' => $r_id])->find();
            $m_ids = "";
            if($roleInfo['r_power']){
                $m_ids = explode(',',trim($roleInfo['r_power'],','));
            }
            //顶级菜单
            $menuList=Db::table('super_menu')
                ->where(['m_fid' => '0', 'm_type' => '1'])
                ->order('m_sort desc')
                ->select();
            foreach ($menuList as $k =>$v){
                //子菜单
                $menuList[$k]['child'] = Db::table('super_menu')
                    ->where(['m_fid' => $v['m_id'], 'm_type' => '1'])
                    ->order('m_sort desc')
                    ->select();
                //操作方法；
                foreach($menuList[$k]['child'] as $key =>$val){
                    $menuList[$k]['child'][$key]['children']= Db::table('super_menu')
                        ->where(['m_fid' => $val['m_id'], 'm_type' => '2'])
                        ->order('m_sort desc')
                        ->select();
                }
            }
            $this->assign('menuList',$menuList);
            $this->assign('m_ids',$m_ids);
            $this->assign('roleInfo',$roleInfo);
            return $this->fetch();
        }
    }


    //editmenuids
    public function editmenuids(){
        $r_id=intval(trim($_POST['r_id']));
        $data['r_power']=trim($_POST['ids'],',');
        $data['r_name']=trim($_POST['r_name']);
        $ids=explode(',',$data['r_power']);
        $data['r_power']=implode(',',array_unique($ids));
        $edit=Db::table('super_role')->where(['r_id' => $r_id])->update($data);
        if($edit){
            $this->success('Successfully','role');
        }else{
            $this->error('Failed','role');
        }
    }

    //delrole
    public function delrole(){
        $r_id=intval($_GET['r_id']);
        $del=Db::table('super_role')->where(['r_id' => $r_id])->delete();
        if($del){
            $this->success('Successfully','role');
        }else{
            $this->error('Failed','role');
        }
    }




    //菜单列表
    public  function menu(){
        //父级id
        $m_fid = "0";
        if(isset($_GET['m_id'])){
            $m_fid=intval($_GET['m_id']);
        }
        //查看他是否为顶级菜单
        $isTopMenu=Db::table('super_menu')->where(['m_id' => $m_fid])->find();
        $istop=$isTopMenu['m_fid'];
        if($istop == 0 ){
            $where=" m_fid = ".$m_fid." and m_type = 1 ";
//            $where=" m_fid = ".$m_fid;
        }else{
            $where=" m_fid = ".$m_fid." and m_type = 2 ";
//            $where=" m_fid = ".$m_fid;
        }
        $count=Db::table('super_menu')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',50,'intval');
        $menuList=Db::table('super_menu')
            ->where($where)
//            ->fetchSql(true)
            ->order('m_sort desc')
            ->limit(($page-1)*$limit,$limit)
            ->select();
        foreach ($menuList as $k =>$v){
            $menuList[$k]['child'] = Db::table('super_menu')->where(['m_fid' => $v['m_id'], 'm_type' => '1'])->select();
            $menuList[$k]['m_type'] = $v['m_type'] == 1 ? "菜单" : "操作";
        }
        $this->assign('m_fid',$m_fid);
        $this->assign('menuList',$menuList);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('limit',$limit);
        return  $this->fetch();
    }


    //添加菜单
    public function addmenu(){
        if($_POST){
            $data['m_name']=$_POST['m_name'];
            $data['m_fid']=$_POST['m_fid'];
            $data['m_type']=$_POST['m_type'];
            $data['m_control']=$_POST['m_control'];
            $data['m_action']=$_POST['m_action'];
            $data['m_icon']=$_POST['m_icon'];
            $data['m_sort']=$_POST['m_sort'];
            $addMenu=Db::table('super_menu')->insert($data);
            if($addMenu){
                $this->success('Successfully！','menu');
            }else{
                $this->error('Failed！','menu');
            }
        }else{
            if(isset($_GET)){
                $m_fid=intval($_GET['m_fid']);
                if($m_fid){//非顶级菜单
                    $finfo=Db::table("super_menu")->where("m_id=".$m_fid)->find();
                    $this->assign('finfo',$finfo);
                }else{//顶部菜单
                    $this->assign('finfo',array("m_id"=>0,"m_fid"=>0,"m_name"=>'顶级菜单'));
                }
                return $this->fetch();
            }
        }
    }




    //修改菜单
    public function editmenu(){
        if(isset($_GET['m_id'])){
            $m_id=$_GET['m_id'];
            if($_POST){
                $data['m_name']=$_POST['m_name'];
                $data['m_fid']=$_POST['m_fid'];
                $data['m_type']=$_POST['m_type'];
                $data['m_control']=$_POST['m_control'];
                $data['m_action']=$_POST['m_action'];
                $data['m_icon']=$_POST['m_icon'];
                $data['m_sort']=$_POST['m_sort'];
                $editMenu=Db::table('super_menu')->where(['m_id' => $m_id])->update($data);
                if($editMenu){
                    $this->success('Successfully！','menu');
                }else{
                    $this->error('Failed！','menu');
                }
            }else{
                if(isset($_GET)){
                    $m_fid=intval($_GET['m_fid']);
                    if($m_fid){//非顶级菜单
                        $finfo=Db::table("super_menu")->where(['m_id' => $m_fid])->find();
                        $menuInfo=Db::table('super_menu')->where(['m_id' => $m_id])->find();
                        $this->assign('finfo',$finfo);
                        $this->assign('menu',$menuInfo);
                    }else{//顶部菜单
                        $menuInfo=Db::table('super_menu')->where(['m_id' => $m_id])->find();
                        $this->assign('finfo',array("m_id"=>0,"m_fid"=>0,"m_name"=>'顶级菜单'));
                        $this->assign('menu',$menuInfo);
                    }
                    return $this->fetch();
                }
            }
        }
    }


    //删除某个菜单
    public function delmenu(){
        $m_id=$_GET['m_id'];
        $isChild=Db::table('super_menu')->where(['m_fid' => $m_id])->find();
        if($isChild){
            $this->error('此菜单下有子菜单或操作，不能删除！','menu');
        }else{
            $del=Db::table('super_menu')->where(['m_id' => $m_id])->delete();
            if($del){
                $this->success('Successfully！','menu');
            }else{
                $this->error('Failed！','menu');
            }
        }
    }


    public function searchuser(){
        $phone = trim($this->request->param('phone'));
        $del=Db::table('tk_user')
            ->where(" tel like '%".$phone."%'")
            ->field('id,nickname,avaurl,tel')
            ->select();
        foreach ($del as $key => $v){
            $del[$key]['phone'] = substr_replace($v['tel'], '****', 3, 4);;
        }
        if($del){
            $this->success('Successfully！','',$del);
        }else{
            $this->error('Failed！');
        }
    }

}