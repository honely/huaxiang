<?php


namespace app\api\controller;


use phpmailer\receiver;
use think\Controller;

class Mailre extends Controller
{
    public function gettotal(){
        $mailServer="mail.welho.me";

        $mailLink="{{$mailServer}:143}INBOX" ; //imagp连接地址：不同主机地址不同

        $mailUser = 'mengmeng.dang@welho.me'; //邮箱用户名

        $mailPass = 'dmm1586,1.q'; //邮箱密码

        $mbox = imap_open($mailLink,$mailUser,$mailPass);

        $totalrows = imap_num_msg($mbox);

        echo "总信件条数：{$totalrows}";
    }

    public function getMails(){
        $userName = "customerservices@welho.me";
        $pass = "hxxb0401!!";
        //$userName = 'mengmeng.dang@welho.me';
        //$pass = 'dmm1586,1.q';
        $mbox = imap_open("{mail.welho.me/imap/ssl/novalidate-cert}INBOX", $userName, $pass);
        $emails = imap_search($mbox, 'ALL');
        if ($emails) {
            $output = '';
            rsort($emails);
            foreach ($emails as $email_number) {
                $overview = imap_fetch_overview($mbox, $email_number, 0);
                $structure = imap_fetchstructure($mbox, $email_number);
                var_dump($structure->parts);
                if (isset($structure->parts) && is_array($structure->parts) && isset($structure->parts[1])) {
                    $part = $structure->parts[1];
                    $message = imap_fetchbody($mbox, $email_number, 2);

                    if ($part->encoding == 3) {
                        $message = imap_base64($message);
                    } else if ($part->encoding == 1) {
                        $message = imap_8bit($message);
                    } else {
                        $message = imap_qprint($message);
                    }
                }

                $output .= '<div class="toggle' . ($overview[0]->seen ? 'read' : 'unread') . '">';
                $output .= '<span class="from">From: ' . utf8_decode(imap_utf8($overview[0]->from)) . '</span>';
                $output .= '<span class="date">on ' . utf8_decode(imap_utf8($overview[0]->date)) . '</span>';
                $output .= '<br /><span class="subject">Subject(' . $part->encoding . '): ' . utf8_decode(imap_utf8($overview[0]->subject)) . '</span> ';
                $output .= 'aaaaaaa</div>';

                $output .= '<div class="body">' . $message . '</div><hr />';
            }

            echo $output;
        }
    }

    /**
     * mail Received()读取收件箱邮件
     *
     * @param
     * @access public
     * @return result
     */
    public function mailReceived()
    {
        $obj = new receiver();
        //Connect to the Mail Box
        $res=$obj->connect();         //If connection fails give error message and exit
//        if (!$res)
//        {
//            return array("msg"=>"Error: Connecting to mail server");
//        }
        // Get Total Number of Unread Email in mail box
        $tot=$obj->getTotalMails(); //Total Mails in Inbox Return integer value

        if(0 == $tot) { //如果信件数为0,显示信息
            return array("msg"=>"No Message for ".$this->mailAccount);
        }
        else
        {
            $res=array("msg"=>"Total Mails:: $tot<br>");

            for($i=$tot;$i>0;$i--)
            {
                $head=$obj->getHeaders($i);  // Get Header Info Return Array Of Headers **Array Keys are (subject,to,toOth,toNameOth,from,fromName)

                //处理邮件附件
                $files=$obj->GetAttach($i,$this->savePath); // 获取邮件附件，返回的邮件附件信息数组

                $imageList=array();
                foreach($files as $k => $file)
                {
                    //type=1为附件,0为邮件内容图片
                    if($file['type'] == 0)
                    {
                        $imageList[$file['title']]=$file['pathname'];
                    }
                }
                $body = $obj->getBody($i,$this->webPath,$imageList);

                $res['mail'][]=array('head'=>$head,'body'=>$body,"attachList"=>$files);
// 				$obj->deleteMails($i); // Delete Mail from Mail box
//         		$obj->move_mails($i,"taskMail");
            }
            $obj->close_mailbox();   //Close Mail Box
            return $res;
        }
    }

    /**
     * creatBox
     *
     * @access public
     * @return void
     */
    public function creatBox($boxName)
    {
        // Creating a object of reciveMail Class
        $obj= new receiver($this->mailAccount,$this->mailPasswd,$this->mailAddress,$this->mailServer,$this->serverType,$this->port,false);
        $obj->creat_mailbox($boxName);
    }

    /**
     * Set save path.
     *
     * @access public
     * @return void
     */
    public function setSavePath()
    {
        $savePath = "./upload/" . date('Ym/', $this->now);
        if(!file_exists($savePath))
        {
            @mkdir($savePath, 0777, true);
            touch($savePath . 'index.html');
        }
        $this->savePath = dirname($savePath) . '/';
    }

    public function getEmails(){
        $res = $this->mailReceived();
        dump($res);
    }
}