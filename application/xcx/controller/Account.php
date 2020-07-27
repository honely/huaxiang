<?php


namespace app\xcx\controller;


use app\xcx\model\Languages;
use app\xcx\model\Msgs;
use phpmailer\PHPMailer;
use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

class Account extends Controller
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
        $adminId=session('adminId');
        $lang = new Languages();
        $enLang = $lang->getLanguages();
        $this->assign('lable',$enLang);
        $this->assign('admin_id',$adminId);
        return $this->fetch();
    }

    public function personal(){
        $ad_id =session('adminId');
        $ad_role = intval(session('ad_role'));
        $adminInfo=Db::table('super_admin')
            ->where(['ad_id' => $ad_id])
            ->find();
        $lang = new Languages();
        $enLang = $lang->getLanguages();
        $this->assign('lable',$enLang);
        $allrole = [
            [
                'ad_id' => '1',
                'ad_role' => '超级管理员',
                'erole' => $enLang['superadmin'],
                'is_checked' => false
            ],
            [
                'ad_id' => '43',
                'ad_role' => '企业负责人',
                'erole' => $enLang['director'],
                'is_checked' => false
            ],
            [
                'ad_id' => '44',
                'ad_role' => '企业员工',
                'erole' => $enLang['staff'],
                'is_checked' => false
            ],
            [
                'ad_id' => '45',
                'ad_role' => '运营负责人',
                'erole' => $enLang['operator'],
                'is_checked' => false
            ],
            [
                'ad_id' => '46',
                'ad_role' => '客服',
                'erole' => $enLang['employee'],
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
        $where = '1 = 1';
        $roleInfo=Db::table('super_role')
            ->field('r_id,r_name')
            ->where($where)
            ->select();
        $adminUser = Db::table('tk_user')
            ->where(['role_id' => 1])
            ->field('id,nickname,tel')
            ->select();
        $this->assign('lable',$enLang);
        $this->assign('allrole',$allrole);
        $this->assign('user',$adminUser);
        $this->assign('role',$roleInfo);
        $this->assign('admin',$adminInfo);
        return $this->fetch();
    }

    public function edit(){
        $ad_id =session('adminId');
        if($_POST){
            $data['ad_realname'] = $_POST['ad_realname'];
            $data['ad_sex'] = $_POST['ad_sex'];
            $data['ad_bid'] = $_POST['ad_bid'];
            $data['ad_corp'] = $_POST['ad_corp'];
            $data['ad_weixin'] = $_POST['ad_weixin'];
            $data['ad_job'] = $_POST['ad_job'];
            $data['ad_img'] = $_POST['ad_img'];
            $data['ad_desc'] = $_POST['ad_desc'];
            if(isset($_POST['ad_role']) && $_POST['ad_role']){
                $bill = $_POST['ad_role'];
                $bills = '';
                foreach($bill as $key => $val){
                    $bills .= $key.',';
                }
                $data['ad_role'] = rtrim($bills,',');
            }
            $edit=Db::table('super_admin')->where(['ad_id' => $ad_id])->update($data);
            if($edit){
                $this->success('修改成功！','personal');
            }else{
                $this->error('您未做任何修改！','personal');
            }
        }else{
            $adminInfo=Db::table('super_admin')
                ->where(['ad_id' => $ad_id])
                ->find();
            $lang = new Languages();
            $enLang = $lang->getLanguages();
            $this->assign('lable',$enLang);
            $allrole = [
                [
                    'ad_id' => '1',
                    'ad_role' => '超级管理员',
                    'erole' => $enLang['superadmin'],
                    'is_checked' => false
                ],
                [
                    'ad_id' => '43',
                    'ad_role' => '企业负责人',
                    'erole' => $enLang['director'],
                    'is_checked' => false
                ],
                [
                    'ad_id' => '44',
                    'ad_role' => '企业员工',
                    'erole' => $enLang['staff'],
                    'is_checked' => false
                ],
                [
                    'ad_id' => '45',
                    'ad_role' => '运营负责人',
                    'erole' => $enLang['operator'],
                    'is_checked' => false
                ],
                [
                    'ad_id' => '46',
                    'ad_role' => '客服',
                    'erole' => $enLang['employee'],
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
            $where = '1 = 1';
            $roleInfo=Db::table('super_role')
                ->field('r_id,r_name')
                ->where($where)
                ->select();
            $adminUser = Db::table('tk_user')
                ->where(['role_id' => 1])
                ->field('id,nickname,tel')
                ->select();
            $this->assign('allrole',$allrole);
            $this->assign('user',$adminUser);
            $this->assign('role',$roleInfo);
            $this->assign('admin',$adminInfo);
            return $this->fetch();
        }
    }


    public function email(){
        $lang = new Languages();
        $enLang = $lang->getLanguages();
        $this->assign('lable',$enLang);
        return $this->fetch();

    }

    /***
     * 发送短信验证码
     * @return \think\response\Json
     */
    public function sendMsg(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $phone = trim($this->request->param('phone'));
        //判断手机号是否正确
        $phoneTrim = trim($phone,'+');
        $frist = substr($phoneTrim,0,1);
        $headTwo = substr($phoneTrim, 0, 2);
        //判断手机号是否正确
        //判断是否为澳洲手机号
        $code = mt_rand(999, 9999);
        //$pattern = '/^1[3456789]{1}\d{9}$/';
        if($frist == 1 || $headTwo == '86'){
            Loader::import('aliyunSdk/api_demo/SmsDemo',EXTEND_PATH);
            $sems = new \SmsDemo();
            $sem1=$sems->sendSms1($phone,$code);
            $array=$this->object2array($sem1);
            $data['code'] = $code;
            $data['phone'] = $phone;
            if($array['Code'] == 'OK'){
                return  json(['code' => '1','msg' => '短信发送成功！','data' =>$code]);
            }else{
                return  json(['code' => '0','msg' => '短信发送失败！']);
            }
        }else{
            $msg = new Msgs();
            $res = $msg->sendAus($code,$phone);
            if($res == 200){
                return  json(['code' => '1','msg' => '短信发送成功！','data' =>$code]);
            }else{
                return json(['code'=>0,'msg'=>'发送失败！请联系管理员']);
            }
        }
    }

    //把对象转换成数组的方法；
    public function object2array($object) {
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                $array[$key] = $value;
            }
        }
        else {
            $array = $object;
        }
        return $array;
    }

    public function changePhone(){
        $ad_id =session('adminId');
        $ad_phone = trim($this->request->param('ad_phone'));
        $code = trim($this->request->param('code'));
        $ucode = trim($this->request->param('ucode'));
        if($code != $ucode){
            $this->error('验证码错误!');
        }
        $update = Db::table('super_admin')
            ->where(['ad_id' => $ad_id])
            ->update(['ad_phone' => $ad_phone]);
        if($update){
            $this->success('绑定成功！');
        }else{
            $this->error('绑定失败！');
        }
    }

    public function changemail(){
        $ad_id =session('adminId');
        $ad_phone = trim($this->request->param('ad_email'));
        $code = trim($this->request->param('code'));
        $ucode = trim($this->request->param('ucode'));
        if($code != $ucode){
            $this->error('验证码错误!');
        }
        $update = Db::table('super_admin')
            ->where(['ad_id' => $ad_id])
            ->update(['ad_email' => $ad_phone]);
        if($update){
            $this->success('绑定成功！');
        }else{
            $this->error('绑定失败!');
        }
    }


    public function mailto(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        Loader::import('phpmailer.phpmailer');//加载extend中的自定义类
        $mailer = trim($this->request->param('email'));
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
        $mail->Subject = "【EMAIL VERIFICATION】WELHOME AGENT PLATFORM//【邮箱验证】小宝经纪人平台";// 邮件标题
        $code = mt_rand(999, 9999);
        $mail->isHTML(true);
        $mail->Body = "Dear Agent,
<br/>
<br/>
You're update your email address on the Welhome Agent Platform.

<br/>
<br/>
Verification code:".$code."
<br/>
<br/>
Expire in 3 mins

<br/>
<br/>

This is an automatic email, please do not reply. ".$code."，请尽快处理！";
        $data['mail'] = $mailer;
        $data['code'] = $code;
        if(!$mail->send()){
            return json(['code'=>0,'msg'=>'发送失败！请联系管理员']);
        }else{
            return json(['code'=>1,'msg'=>'发送成功！','data' => $data]);
        }
    }

    public function phone(){
        $lang = new Languages();
        $enLang = $lang->getLanguages();
        $this->assign('lable',$enLang);
        return $this->fetch();

    }
}