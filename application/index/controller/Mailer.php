<?php
/**
 * Created by PhpStorm.
 * User: Dangmengmeng
 * Date: 2019/12/23
 * Time: 14:34
 */
namespace app\index\controller;
use phpmailer\PHPMailer;
use think\Controller;
use think\Loader;

class Mailer extends  Controller
{

    public function mailto(){
        Loader::import('phpmailer.phpmailer');//加载extend中的自定义类
        $mail = new PHPMailer();
        $toemail = '1149054548@qq.com';//收件人
        $mail->isSMTP();// 使用SMTP服务
        $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
        $mail->Host = "smtp.163.com";// 发送方的SMTP服务器地址
        $mail->SMTPAuth = true;// 是否使用身份验证
        $mail->Username = "17691074991@163.com";
        $mail->Password = "welhome1234";
        $mail->SMTPSecure = "ssl";// 使用ssl协议方式
        $mail->Port = 465;// 163邮箱的ssl协议方式端口号是465/994

        $mail->setFrom("17691074991@163.com","花香小宝");// 设置发件人信息，如邮件格式说明中的发件人，这里会显示为Mailer(xxxx@163.com），Mailer是当做名字显示
        $mail->addAddress($toemail,'Wang');// 设置收件人信息，如邮件格式说明中的收件人，这里会显示为Liang(yyyy@163.com)
        $mail->addReplyTo("1149054548@qq.com","Reply");

        $mail->Subject = "花香小宝邮箱验证";// 邮件标题

        $num = rand(100000,999999);

        $mail->Body = "你的验证码是".$num;
        if(!$mail->send()){
            echo "Mailer Error: " . $mail->ErrorInfo;
        }else{
            echo 1;  //成功
        }
    }
}