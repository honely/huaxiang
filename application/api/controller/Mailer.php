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
use think\Log;

class Mailer extends Controller
{

    public function mailto($id, $type, $contents)
    {
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
        $mail->setFrom("customerservices@welho.me", "花香小宝");
        $mail->addAddress($toemail, 'Wang');
        $mail->addReplyTo($mailer, "Reply");
        $mail->Subject = "新举报提醒";// 邮件标题
        $mail->Body = "有一条新的" . $type . "信息,帖子id:" . $id . "，帖子内容:" . $contents . "，请尽快处理！";
        if (!$mail->send()) {
            return json(['code' => 0, 'msg' => '发送失败！请联系管理员']);
        } else {
            return json(['code' => 1, 'msg' => '发送成功！']);
        }
    }

    public function mailtos()
    {
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
        $mail->setFrom("customerservices@welho.me", "花香小宝");
        $mail->addAddress($toemail, 'Wang');
        $mail->addReplyTo($mailer, "Reply");
        $mail->Subject = "新举报提醒";// 邮件标题
        $mail->Body = "有一条新的请尽快处理！";
        if (!$mail->send()) {
            return json(['code' => 0, 'msg' => '发送失败！请联系管理员']);
        } else {
            return json(['code' => 1, 'msg' => '发送成功！']);
        }
    }


    //用户咨询发邮件给公司联系方式
    public function mailCorp($corpName, $corpMail, $userNick, $userPhone, $userWechat, $type, $content)
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        Loader::import('phpmailer.phpmailer');//加载extend中的自定义类
        $mailer = 'customerservices@welho.me';
        //$mailer = '1149054548@qq.com';
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
        $mail->setFrom("customerservices@welho.me", "花香小宝");
        $mail->addAddress($toemail, 'Wang');
        $mail->addReplyTo($mailer, "Reply");
        $mail->Subject = "New Enquiry from Welhome/新用户咨询来自小宝租房";// 邮件标题
        $mail->Body = "Dear " . $corpName . "，
            <br/><br/>
            This email is automatically generated. As this email is an automated notification we are unable to receive replies. Do not respond to this email address.
            <br/><br/>
                    From :" . $userNick . "
            <br/><br/>
            Tel: " . $userPhone . "
            <br/><br/>
            Wechat：" . $userWechat . "<br/><br/>
            Enquiry Type: " . $type . "<br/><br/>
            
            Message:" . $content;
        if (!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * 邮件发送
     * @param string $toMail 接收邮件者邮箱
     * @param string $toName 接收邮件者名称
     * @param string $mpid 会话id
     * @param string $uId 接收邮件者用户id
     * @param string $formName 发送人昵称
     * @param string $subject 邮件主题
     * @param string $body 邮件内容
     * @return boolean
     */
    public function sendEmail($toMail = 'ufogbow@163.com', $toName = '张三', $mpid = '46', $uId = '78', $formName = '李四', $subject = '测试邮件', $body = '你好')
    {
        Loader::import('phpmailer.phpmailer');//加载extend中的自定义类
        $mail = new PHPMailer();
        //服务器配置
        $mail->CharSet = "UTF-8";                     //设定邮件编码
        $mail->SMTPDebug = 0;                        // 调试模式输出
        $mail->isSMTP();                             // 使用SMTP
        $mail->Host = 'mail.welho.me';                // SMTP服务器
        $mail->SMTPAuth = true;                      // 允许 SMTP 认证
        $mail->Username = 'testmessage@welho.me';                // SMTP 用户名  即邮箱的用户名
        $mail->Password = 'test.message';             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
        $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
        $mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持
       
        // 利用会话id使用邮箱
        $mail->SetFrom('testmessage+' . $mpid . 'D' . $uId . '@welho.me', $formName);  //发件人

        $mail->Subject = $subject;
        $mail->MsgHTML($body);
        $mail->AddAddress($toMail, $toName);
        Log::write('邮件转发Mailer：$toMail=' . $toMail . '$toName' . $toName, 'info');
        if (!$mail->send()) {
            return json(['code' => 0, 'msg' => '发送失败！请联系管理员']);
        } else {
            return json(['code' => 1, 'msg' => '发送成功！']);
        }
    }
    
    /**
     * 邮件发送
     * @param string $type 咨询类型
     * @param string $toMail 接收邮件者邮箱
     * @param string $toName 接收邮件者名称
     * @param string $mpid 会话id
     * @param string $uId 接收邮件者用户id
     * @param string $formName 发送人昵称
     * @param string $phone 发送人电话
     * @param string $address 房源地址
     * @param string $content 消息内容
     * @return boolean
     */
    public function mailPm($type = '入住时间', $toMail = '1149054548@qq.com', $toName = '接收邮件者名称', $mpid = '46', $uId = '78', $formName = '发送人昵称', $phone = '15210030318', $address = '房源地址', $content = '消息内容')
    {
        Log::write('邮件转发MailerPm：$toMail=' . $toMail . '$toName' . $toName, 'info');
        // 拼接html页面
        $url = "https://".$_SERVER['SERVER_NAME'];
        $nowTime = date('Y/m/d H:i');
        $fp = fopen('./public/email.html', "r"); //只读打开模板
        $body = fread($fp, filesize('./public/email.html'));//读取模板中内容
        $body = str_replace("{type}", $type, $body);//咨询类型
        $body = str_replace("{nowTime}", $nowTime, $body);//发送时间
        $body = str_replace("{url}", $url, $body);//站内回复地址
        $body = str_replace("{formName}", $formName, $body);//发送人昵称
        $body = str_replace("{phone}", $phone, $body);//发送人电话
        $body = str_replace("{address}", $address, $body);//房源地址
        $body = str_replace("{content}", $content, $body);//消息内容
        fclose($fp);
        
        Loader::import('phpmailer.phpmailer');//加载extend中的自定义类
        $mail = new PHPMailer();
        //服务器配置
        $mail->CharSet = "UTF-8";                     //设定邮件编码
        $mail->SMTPDebug = 0;                        // 调试模式输出
        $mail->isSMTP();                             // 使用SMTP
        $mail->Host = 'mail.welho.me';                // SMTP服务器
        $mail->SMTPAuth = true;                      // 允许 SMTP 认证
        $mail->Username = 'testmessage@welho.me';                // SMTP 用户名  即邮箱的用户名
        $mail->Password = 'test.message';             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
        $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
        $mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持

        // 利用会话id使用邮箱
        $mail->SetFrom('testmessage+' . $mpid . 'D' . $uId . '@welho.me', $formName);  //发件人

        $subject = 'New enquiry from '.$formName.' for '.$address.' via Welhome';
        $mail->Subject = $subject;

        $mail->MsgHTML($body);

        $mail->AddAddress($toMail, $toName);
        Log::write('邮件转发MailerPm：$toMail=' . $toMail . '$toName' . $toName, 'info');
        if (!$mail->send()) {
             Log::write('失败MailerPm：', 'info');
            return json(['code' => 0, 'msg' => '发送失败！请联系管理员']);
        } else {
            Log::write('成功MailerPm：', 'info');
            return json(['code' => 1, 'msg' => '发送成功！']);
        }
    }
    

    // 获取邮件内容
    public function getEmail()
    {
        $email = $_POST['email'];

        $lines = explode("\n", $email);
        Log::write('邮件获取getEmail：$lines=', 'info');
        $splittingheaders = true;
        $result = [];
        $result['headers'] = '';
        $result['message'] = '';
        for ($i = 0; $i < count($lines); $i++) {
            if ($splittingheaders) {
                // this is a header
                $result['headers'] .= $lines[$i] . "\n";

                // look out for special headers
                if (preg_match("/^Subject: (.*)/", $lines[$i], $matches)) {
                    $result['subject'] = $matches[1];
                }
                if (preg_match("/^From: (.*)/", $lines[$i], $matches)) {
                    $result['from'] = $matches[1];
                }
                if (preg_match("/^To: (.*)/", $lines[$i], $matches)) {
                    $result['to'] = $matches[1];
                }
            } else {
                // not a header, but message
                $result['message'] .= $lines[$i] . "\n";
            }

            if (trim($lines[$i]) == "") {
                // empty line, header section has ended
                $splittingheaders = false;
            }
        }

        // 获取消息
        preg_match_all("/Encoding: (.*?)\n([\s\S]*?)\n------=/i", $result['message'], $matchMsg);
        $message = [];
        foreach ($matchMsg[1] as $k => $encoding) {
            if (trim($encoding) == 'base64') {
                $message[$k] = imap_base64($matchMsg[2][$k]);
            } else if (trim($encoding) == '8bit') {
                $message[$k] = imap_8bit($matchMsg[2][$k]);
            } else {
                $message[$k] = imap_qprint($matchMsg[2][$k]);
            }
        }
        //$content = empty($message[0]) ? $message[1] : $message[0];
        $content = $message[1];

        preg_match_all("/charset=(.*?)\n/", $result['message'], $charset);
        $charset = $charset[1][1];
        $charset = trim($charset);
        $charset = trim($charset, '"');
        if ($charset != "UTF-8" && $charset != "UTF8") {
            $content = iconv($charset, "UTF-8", $content);
        }

        if(preg_match("/([\s\S]*?)</i", $content, $match)){
            $content = $match[1];
        }

        // 获取会话id以及用户id
        //preg_match("/<testmessage\+(.*?)@welho.me>/", $result['to'], $matchMid);
        preg_match("/<testmessage\+(.*?)D(.*?)@welho.me>/", $result['to'], $matchMid);
        $mpid = $matchMid[1];
        $uId = $matchMid[2];
        Log::write('邮件获取Mailer：$mpid=' . $mpid . '$uId' . $uId. '$content' . $content, 'info');
        $Msg = new Msg();
        $Msg->forwardToMsg($mpid, $uId, $content);
    }

}