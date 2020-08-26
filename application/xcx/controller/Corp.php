<?php

namespace app\xcx\controller;


use app\xcx\model\Languages;
use app\xcx\model\Loops;
use app\xcx\model\Rolem;
use phpmailer\PHPMailer;
use think\Controller;
use think\Db;
use think\Loader;

class Corp extends Controller
{
    public function index(){
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $addable = in_array('290',$power_list,true);
        $editable = in_array('291',$power_list,true);
        $delable = in_array('293',$power_list,true);
        $lang = new Languages();
        $enLab = $lang->getLanguages();
        $this->assign('lable',$enLab);
        $this->assign('addable',$addable);
        $this->assign('editable',$editable);
        $this->assign('delable',$delable);
        return $this->fetch();
    }

    public function corpData(){
        $where ='1 = 1 ';
        $count=Db::table('xcx_corp')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',50,'intval');
        $example=Db::table('xcx_corp')->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('cp_addtime desc')
            ->select();
        if($example){
            foreach ($example as $k => $v){
                $example[$k]['cp_add_admin'] = $this->getAdminName($v['cp_add_admin']);
                $example[$k]['cp_count'] = $this->getCountStaff($v['cp_id']);
            }

        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $example;
        $res['count'] = $count;
        return json($res);
    }

    public function myData(){
        $cropId = session('ad_corp');
        $where='cp_able = 1 and cp_id  in ('.$cropId.')';
        $count=Db::table('xcx_corp')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',50,'intval');
        $example=Db::table('xcx_corp')->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('cp_addtime desc')
            ->select();
        if($example){
            foreach ($example as $k => $v){
                $example[$k]['cp_add_admin'] = $this->getAdminName($v['cp_add_admin']);
                $example[$k]['cp_count'] = $this->getCountStaff($v['cp_id']);
            }

        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $example;
        $res['count'] = $count;
        return json($res);
    }

    public function getCountStaff($cpid){
        $where='ad_corp  in ('.$cpid.')';
        $count = Db::table('super_admin')
            ->where($where)
            ->count('ad_id');
        return $count;
    }

    public function getAdminName($adId){
        $adimin = Db::table('super_admin')
            ->where(['ad_id' => $adId])
            ->field('ad_bid')
            ->find();
        return $adimin ? $adimin['ad_bid'] : '---';
    }

    public function my(){
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $addable = in_array('288',$power_list,true);
        $editable = in_array('289',$power_list,true);
        $lang = new Languages();
        $enLab = $lang->getLanguages();
        $this->assign('lable',$enLab);
        $this->assign('addable',$addable);
        $this->assign('editable',$editable);
        return $this->fetch();
    }

    public function add(){
        $adminId=intval(session('adminId'));
        if($_POST){
            $data['cp_name']=$_POST['cp_name'];
            $data['cp_identity']=$_POST['cp_identity'];
            $data['cp_logo']=$_POST['cp_logo'];
            $data['backimg']=$_POST['backimg'];
            $data['minilogo']=$_POST['minilogo'];
            $data['colour']=$_POST['colour'];
            $data['cp_address']=$_POST['cp_address'];
            $data['cp_email']=$_POST['cp_email'];
            $data['cp_desc']=$_POST['cp_desc'];
            $data['cp_tel']=$_POST['cp_tel'];
            $data['cp_addtime']= date('Y-m-d H:i:s');
            $data['cp_udate']= date('Y-m-d H:i:s');
            $data['cp_fuzeren']='';
            $data['cp_able']=1;
            $data['cp_add_admin'] = $adminId;
            $addBan=Db::table('xcx_corp')->insert($data);
            if($addBan){
                $this->success('添加成功！','index');
            }else{
                $this->error('添加失败!','index');
            }
        }else{
            $lang = new Languages();
            $enLab = $lang->getLanguages();
            $this->assign('lable',$enLab);
            return $this->fetch();
        }
    }

    public function edit(){
        $type = trim($this->request->param('type',1));
        $url = $type == 1 ? 'index' : 'my';
        $adminId=intval(session('adminId'));
        $ba_id=$_GET['cp_id'];
        if($_POST){
            $data['cp_name']=$_POST['cp_name'];
            $data['cp_identity']=$_POST['cp_identity'];
            $data['cp_logo']=$_POST['cp_logo'];
            $data['backimg']=$_POST['backimg'];
            $data['minilogo']=$_POST['minilogo'];
            $data['colour']=$_POST['colour'];
            $data['cp_address']=$_POST['cp_address'];
            $data['cp_email']=$_POST['cp_email'];
            $data['cp_desc']=$_POST['cp_desc'];
            $data['cp_tel']=$_POST['cp_tel'];
            $data['cp_udate']= date('Y-m-d H:i:s');
            $data['cp_fuzeren']='';
            $data['cp_able']=1;
            $data['cp_add_admin'] = $adminId;
            $update=Db::table('xcx_corp')->where(['cp_id'=> $ba_id])->update($data);
            if($update){
                $this->success('修改成功！',$url);
            }else{
                $this->error('您未做任何修改！',$url);
            }
        }else{
            $title = $type == 1 ? '公司列表' : '我的公司';
            $banInfo=Db::table('xcx_corp')
                ->where(['cp_id'=> $ba_id])
                ->find();
            $lang = new Languages();
            $enLab = $lang->getLanguages();
            $this->assign('lable',$enLab);
            $this->assign('type',$type);
            $this->assign('title',$title);
            $this->assign('corp',$banInfo);
            return $this->fetch();
        }
    }


    public function del(){
        $ba_id=intval(trim($_GET['cp_id']));
        $delBan=Db::table('xcx_corp')->where(['cp_id'=> $ba_id])->delete();
        if($delBan){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！','index');
        }
    }


    public function upload()
    {
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/corp');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/corp/".$path_date."/".$path_filename;
            // 成功上传后 返回上传信息
            return json(array('state'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
        }else{
            // 上传失败返回错误信息
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }


    public function detail(){
        $ba_id=$_GET['cp_id'];
        $banInfo=Db::table('xcx_corp')
            ->where(['cp_id'=> $ba_id])
            ->find();
        $lang = new Languages();
        $enLab = $lang->getLanguages();
        $this->assign('lable',$enLab);
        $this->assign('corp',$banInfo);
        return $this->fetch();
    }


    public function admin(){
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $addable = in_array('287',$power_list,true);
        $editable = in_array('288',$power_list,true);
        $delable = in_array('239',$power_list,true);
        $offable = in_array('286',$power_list,true);
        $connectable = in_array('285',$power_list,true);
        $lang = new Languages();
        $enLab = $lang->getLanguages();
        $this->assign('lable',$enLab);
        $this->assign('addable',$addable);
        $this->assign('editable',$editable);
        $this->assign('delable',$delable);
        $this->assign('offable',$offable);
        $this->assign('connectable',$connectable);
        return $this->fetch();
    }

    //管理员
    public function adminData(){
        $cropId = session('ad_corp');
        $where=" ad_corp  in (".$cropId.") and ( ad_role = 43 or ad_role = 44 )";
        $keywords = trim($this->request->param('keywords'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ad_realname like '%".$keywords."%' ";
        }
        $count=Db::table('super_admin')
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


    public function getRoleName($roleIds){
        $roleArr = explode(',',$roleIds);
        $roleNames = '';
        for ($i = 0;$i < count($roleArr);$i++){
            $roleName = $this->getRole($roleArr[$i]);
            $roleNames.= $roleName.',';
        }
        return rtrim($roleNames,',');
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


    public function getRole($roleid){
        $roleInfo = Db::table('super_role')
            ->where(['r_id' => $roleid])
            ->field('r_name,r_admin')
            ->find();
        $lang = new Languages();
        $enLab = $lang->getLang();
        return $enLab == 'Cn' ? $roleInfo['r_name'] : $roleInfo['r_admin'];
    }


    public function adda(){
        $cp_id = $this->request->param('cp_id',0,'intval');
        if($_POST){
            $data['ad_realname'] = $_POST['ad_realname'];
            $data['ad_sex'] = $_POST['ad_sex'];
            $data['ad_phone'] = str_replace(' ', '', $_POST['ad_phone']);
            $data['ad_email'] = $_POST['ad_email'];
            $isRepeat=Db::table('super_admin')
                ->where(['ad_email' => $data['ad_email']])
                ->find();
            if($isRepeat){
                $this->error('此邮箱已注册！','add');
            }
            $data['ad_isable'] = 2;
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
            $data['ad_role'] = $_POST['ad_role'];
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
                $this->success('添加成功，请查收账户激活邮件','my');
            }else{
                $this->error('添加管理员失败','my');
            }
        }else{
            $cropId = session('ad_corp');
            $where='cp_able = 1 and cp_id  in ('.$cropId.')';
            $crop = Db::table('xcx_corp')
                ->where($where)
                ->field('cp_id,cp_name')
                ->select();
            $cpname = Db::table('xcx_corp')
                ->where(['cp_id' => $cp_id])
                ->field('cp_name')
                ->find();
            $cpname = $cpname['cp_name'];
            $lang = new Languages();
            $enLab = $lang->getLanguages();
            $this->assign('lable',$enLab);
            $this->assign('crop',$crop);
            $this->assign('crop',$crop);
            $this->assign('cpname',$cpname);
            $this->assign('cp_id',$cp_id);
            return $this->fetch();
        }
    }

    public function edita(){
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
                $this->success('修改管理员成功！','admin');
            }else{
                $this->error('您未做任何修改！','admin');
            }
        }else{
            $lang = new Languages();
            $adminInfo=Db::table('super_admin')
                ->where(['ad_id' => $ad_id])
                ->find();
            $enLab = $lang->getLanguages();
            $allrole = [
                [
                    'ad_id' => '44',
                    'ad_role' => $enLab['staff'],
                    'is_checked' => false
                ]
            ];

            $cropId = session('ad_corp');
            $where='cp_able = 1 and cp_id  in ('.$cropId.')';
            $houseBill = explode(',',$adminInfo['ad_role']);
            foreach ($allrole as $key => &$val) {
                if(in_array($val['ad_id'], $houseBill)) {
                    $val['is_checked'] = true;
                }
            }unset($val);
            $houseInfo['sub'] = $houseBill;
            $all_tags = Db::table('xcx_corp')
                ->where($where)
                ->field('cp_id,cp_name')
                ->select();
            $crops= explode(',',$adminInfo['ad_corp']);
            foreach ($all_tags as $key => &$val) {
                $all_tags[$key]['is_checked'] = false;
                if(in_array($val['cp_id'], $crops)) {
                    $val['is_checked'] = true;
                }
            }unset($val);
            $this->assign('lable',$enLab);
            $this->assign('crop',$all_tags);
            $this->assign('allrole',$allrole);
            $this->assign('admin',$adminInfo);
            return $this->fetch();
        }
    }


    public function detaila(){
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
        $lang = new Languages();
        $enLab = $lang->getLanguages();
        $this->assign('lable',$enLab);
        $this->assign('role',$roleInfo);
        $this->assign('admin',$adminInfo);
        return $this->fetch();
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
}