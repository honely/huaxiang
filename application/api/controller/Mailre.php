<?php


namespace app\api\controller;


use phpmailer\receiver;
use phpmailer\Imap;
use think\Controller;
use PhpImap\Exceptions\ConnectionException;
use PhpImap\Mailbox;
use Exception;

class Mailre extends Controller
{
    //https://github.com/barbushin/php-imap
    public function demo() {
        $mailbox = new Mailbox(
            '{mail.welho.me/imap/ssl/novalidate-cert}INBOX',
            'mengmeng.dang@welho.me',
            'dmm1586,1.q',
            __DIR__,
            'UTF-8'
        );
        try {
            $mail_ids = $mailbox->searchMailbox('UNSEEN');
        } catch (ConnectionException $ex) {
            die('IMAP connection failed: '.$ex->getMessage());
        } catch (Exception $ex) {
            die('An error occured: '.$ex->getMessage());
        }
    
        foreach ($mail_ids as $mail_id) {
            echo "+------ P A R S I N G ------+\n";
            $email = $mailbox->getMail($mail_id, false);
            echo 'from-name: '.(string) (isset($email->fromName) ? $email->fromName : $email->fromAddress)."\n";
            echo 'from-email: '.(string) $email->fromAddress."\n";
            echo 'to: '.(string) $email->toString."\n";
            echo 'subject: '.(string) $email->subject."\n";
            echo 'message_id: '.(string) $email->messageId."\n";
            echo 'mail has attachments? ';
            if ($email->hasAttachments()) {
                echo "Yes\n";
            } else {
                echo "No\n";
            }
            if (!empty($email->getAttachments())) {
                echo \count($email->getAttachments())." attachements\n";
            }
            if ($email->textHtml) {
                echo "Message HTML:\n".$email->textHtml;
            } else {
                echo "Message Plain:\n".$email->textPlain;
            }
            if (!empty($email->autoSubmitted)) {
                // Mark email as "read" / "seen"
                $mailbox->markMailAsRead($mail_id);
                echo "+------ IGNORING: Auto-Reply ------+\n";
            }
            if (!empty($email->precedence)) {
                // Mark email as "read" / "seen"
                $mailbox->markMailAsRead($mail_id);
                echo "+------ IGNORING: Non-Delivery Report/Receipt ------+\n";
            }
        }
        $mailbox->disconnect();
    }

    public function test() {
        $imap=new Imap("{mail.welho.me/imap/ssl/novalidate-cert}INBOX",30,30);
        $imap->capability();
        $imap->id(array(
            'name'          => 'SinaMail OtherMail Client',
            'version'       => '1',
            'os'            => 'SinaMail OtherMail',
            'os-version'    => '1.0',
        ));
        $imap->login("mengmeng.dang@welho.me","dmm1586,1.q");
        $folders=$imap->getList('', '*');
        var_dump($folders);
        $status = $imap->select('SENT');
        var_dump($status);
        $ls = $imap->fetch(array(), array('uid', 'internaldate', 'rfc822.size'));
        
        
        
        
        foreach($ls as $k=>$i){
            $info=$imap->fetch(array($k), array('rfc822'));
        }
    }
    
    public function gettotal(){
        $mailServer="mail.welho.me";

        $mailLink="{mail.welho.me/imap/ssl/novalidate-cert}INBOX" ; //imagp连接地址：不同主机地址不同

        $mailUser = 'mengmeng.dang@welho.me'; //邮箱用户名

        $mailPass = 'dmm1586,1.q'; //邮箱密码
        $mailUser = "customerservices@welho.me";
        $mailPass = "hxxb0401!!";
        $mbox = imap_open($mailLink,$mailUser,$mailPass);

        $totalrows = imap_num_msg($mbox);

        echo "总信件条数：{$totalrows}";
    }

    public function getMails(){
        $userName = "customerservices@welho.me";
        $pass = "hxxb0401!!";
        // $userName = 'mengmeng.dang@welho.me';
        // $pass = 'dmm1586,1.q';
        $mbox = imap_open("{mail.welho.me/imap/ssl/novalidate-cert}INBOX", $userName, $pass);
        $emails = imap_search($mbox, 'ALL');
        if ($emails) {
            $output = '';
            rsort($emails);
            foreach ($emails as $email_number) {
                $overview = imap_fetch_overview($mbox, $email_number, 0);
                $structure = imap_fetchstructure($mbox, $email_number);
                if(!isset($structure->parts)) {
                   $data = imap_fetchbody($mbox, $email_number, 1);
                }
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
                    $output .= '<div class="toggle' . ($overview[0]->seen ? 'read' : 'unread') . '">';
                    $output .= '<span class="from">From: ' . utf8_decode(imap_utf8($overview[0]->from)) . '</span>';
                    $output .= '<span class="date">on ' . utf8_decode(imap_utf8($overview[0]->date)) . '</span>';
                    $output .= '<br /><span class="subject">Subject(' . $part->encoding . '): ' . utf8_decode(imap_utf8($overview[0]->subject)) . '</span> ';
                    $output .= 'aaaaaaa</div>';

                    $output .= '<div class="body">' . $message . '</div><hr />';
                }
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
         $savePath = "./upload/" . date('Ym/', time());

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
                $files=$obj->GetAttach($i,$savePath); // 获取邮件附件，返回的邮件附件信息数组

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