<?php
/**
 * Created by PhpStorm.
 * User: Dangmengmeng
 * Date: 2019/12/23
 * Time: 14:34
 */
namespace app\api\controller;
use phpmailer\PHPMailer;
use think\Controller;
use think\Loader;

class Mailer extends  Controller
{

    public function mailto($id,$type,$contents){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        Loader::import('phpmailer.phpmailer');//加载extend中的自定义类
        $mailer = 'customerservices@welho.me';
        //$mailer = '1149054548@qq.com';
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
        $mail->Subject = "新举报提醒";// 邮件标题
        $mail->Body = "有一条新的".$type."信息,帖子id:".$id."，帖子内容:".$contents."，请尽快处理！";
        if(!$mail->send()){
            return json(['code'=>0,'msg'=>'发送失败！请联系管理员']);
        }else{
            return json(['code'=>1,'msg'=>'发送成功！']);
        }
    }

    public function mailtos(){
        Loader::import('phpmailer.phpmailer');//加载extend中的自定义类
        //$mailer = 'customerservices@welho.me';
        $mailer = '1149054548@qq.com';
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
        $mail->Subject = "新举报提醒";// 邮件标题
        $mail->Body = "有一条新的请尽快处理！";
        if(!$mail->send()){
            return json(['code'=>0,'msg'=>'发送失败！请联系管理员']);
        }else{
            return json(['code'=>1,'msg'=>'发送成功！']);
        }
    }



    //用户咨询发邮件给公司联系方式
    public function mailCorp($corpName,$corpMail,$userNick,$userPhone,$userWechat,$type,$content){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        Loader::import('phpmailer.phpmailer');//加载extend中的自定义类
        //$mailer = 'customerservices@welho.me';
        $mailer = '1149054548@qq.com';
        $mail = new PHPMailer();
        $toemail = $corpMail;//收件人
        $mail->isSMTP();// 使用SMTP服务
        $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
        $mail->Host = "mail.welho.me";// 发送方的SMTP服务器地址
        $mail->SMTPAuth = true;// 是否使用身份验证
        $mail->Username = "customerservices@welho.me";
        $mail->Password = "hxxb0401!!";
        $mail->SMTPSecure = "ssl";// 使用ssl协议方式
        $mail->Port = 465;
        $mail->IsHTML(true);
        $mail->setFrom("customerservices@welho.me","花香小宝");
        $mail->addAddress($toemail,'Wang');
        $mail->addReplyTo($mailer,"Reply");
        $mail->Subject = "New Enquiry from Welhome/新用户咨询来自小宝租房";// 邮件标题
        $mail->Body = "Dear ".$corpName."，
<br/><br/>
This email is automatically generated. As this email is an automated notification we are unable to receive replies. Do not respond to this email address.
<br/><br/>
        From :".$userNick."
<br/><br/>
Tel: ".$userPhone."
<br/><br/>
Wechat：".$userWechat."<br/><br/>
Enquiry Type: ".$type."<br/><br/>

Message:".$content;
        if(!$mail->send()){
            return false;
        }else{
            return true;
        }
    }

}