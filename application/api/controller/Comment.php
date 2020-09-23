<?php


namespace app\api\controller;


use app\xcx\model\Subscp;
use think\Controller;
use app\xcx\model\Loops;
use think\Db;
use think\Log;

class Comment extends Controller
{


    /***
     * 发布评论
     */
    public function addcom(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $tid = $this->request->post('tid');
        $type = $this->request->post('type');
        $userid = $this->request->post('userid');
        $conts = $this->request->post('conts');
        if(!$tid || !$type || !$userid){
            $res['code'] = 0;
            $res['msg'] = '缺少提交参数！';
            return json($res);
        }
        if(!$conts){
            $res['code'] = 0;
            $res['msg'] = '评论内容不为空！';
            return json($res);
        }
        $data = $this->request->post();
        $data['addtime'] = date('Y-m-d H:i:s');
        $data['repy'] = 1;
        $insert = Db::table('tk_comment')->insertGetId($data);
        if($insert){
            //评论成功后推送消息给发帖人
            $this->sendSupc($insert,$userid);
            $res['code'] = 1;
            $res['msg'] = '评论成功！';
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '评论失败！';
        return json($res);
    }

    public function sendSupc($insert,$userid){
        $data['ss_msg_id'] = $insert;
        $data['ss_status'] = 1;
        $data['ss_user_id'] = $userid;
        $data['ss_send_time'] = date('Y-m-d H:i:s');
        $data['ss_send_date'] = date('Y-m-d');
        $data['ss_remarks'] = '1.评论订阅消息预发送；';
        $logId = Db::table('xcx_sub_msg')->insertGetId($data);
        $res = Db::table('tk_comment')->where(['cid' => $insert])->find();
        $infos = $this->getInfos($res['tid'],$res['type']);
        //发帖者拒绝推送消息
        if($infos['user_info']['able_sub'] != 1){
            Db::table('xcx_sub_msg')
                ->where(['ss_id' => $logId])
                ->update([
                    'ss_status' => 3,
                    'ss_remarks' => $data['ss_remarks'].'2.发送失败：用户未订阅',
                ]);
        }else{
            $topTitle = $infos['title'];
            $uOpen = $infos['user_info']['openid'];
            $addTime = $res['addtime'];
            $loop = new Loops();
            $commer = $loop->getUserNick($userid);
            $content = $res['conts'];
            $scp = new Subscp();
            $sendSub = $scp->sendComment($topTitle,$uOpen,$addTime,$commer,$content,$res['tid'],$res['type']);
            $res = json_decode($sendSub, true);
            if($res['errcode'] == 0){
                //发送成功
                Db::table('xcx_sub_msg')
                    ->where(['ss_id' => $logId])
                    ->update([
                        'ss_status' => 2,
                        'ss_remarks' => $data['ss_remarks'].'2.发送成功：已发送订阅消息到用户手机。',
                    ]);
            }else{
                //发送失败
                Db::table('xcx_sub_msg')
                    ->where(['ss_id' => $logId])
                    ->update([
                        'ss_status' => 3,
                        'ss_remarks' => $data['ss_remarks'].''.$uOpen.'2.发送失败：微信服务端未发送成功。',
                    ]);
            }
        }
    }


    public function getInfos($tid,$type){
        if($type ==1){
            //房源
            $infos = Db::table('tk_houses')
                ->where(['id' => $tid])
                ->field('title,user_id')
                ->find();
            $infos['user_info'] = $this->getRevStatus($infos['user_id']);
        }else{
            //求租拼租
            $infos = Db::table('tk_forent')
                ->where(['id' => $tid])
                ->field('title,userid')
                ->find();
            $infos['user_info'] = $this->getRevStatus($infos['userid']);
        }
        return $infos;
    }

    public function getRevStatus($revid){
        $sender = Db::table('tk_user')
            ->where(['id' => $revid])
            ->field('able_sub,openid,nickname')
            ->find();
        return $sender ? $sender :false;

    }


    /***
     * 发布评论的回复
     */
    public function addReply(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $repyid = $this->request->post('repyid');
        $userid = $this->request->post('userid');
        $conts = $this->request->post('conts');
        if(!$repyid || !$userid){
            $res['code'] = 0;
            $res['msg'] = '缺少提交参数！';
            return json($res);
        }
        if(!$conts){
            $res['code'] = 0;
            $res['msg'] = '评论内容不为空！';
            return json($res);
        }
        $data = $this->request->post();
        $data['addtime'] = date('Y-m-d H:i:s');
        $data['repy'] = 2;
        $insert = Db::table('tk_comment')->insertGetId($data);
        if($insert){
            //回复成功，推送回复提醒消息
            Log::write('留言回复comment：','info');
            $this->sendReplays($insert,$userid);
            $res['code'] = 1;
            $res['msg'] = '回复成功！';
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '回复失败！';
        return json($res);
    }

    public function sendReplays($insert,$userid){
        $data['ss_msg_id'] = $insert;
        $data['ss_status'] = 1;
        $data['ss_user_id'] = $userid;
        $data['ss_send_time'] = date('Y-m-d H:i:s');
        $data['ss_send_date'] = date('Y-m-d');
        $data['ss_remarks'] = '1.留言回复订阅消息预发送；';
        $logId = Db::table('xcx_sub_msg')->insertGetId($data);
        //根据回复的id获取帖子的id
        $info  = $this->getTopicInfosByReplayid($insert);
        $infos = $this->getInfos($info['tid'],$info['type']);
        $userids = $this->getRevStatus($info['userid']);
        //发帖者拒绝推送消息
        if($userids['able_sub'] != 1){
            Db::table('xcx_sub_msg')
                ->where(['ss_id' => $logId])
                ->update([
                    'ss_status' => 3,
                    'ss_remarks' => $data['ss_remarks'].'2.发送失败：用户未订阅',
                ]);
        }else{
            $topTitle = $infos['title'];
            $uOpen = $userids['openid'];
            $scp = new Subscp();
            $loop = new Loops();
            $replayer = $loop->getUserNick($userid);
            $sendSub = $scp->sendReply($topTitle,$uOpen,$replayer,$info['tid'],$info['type']);
            $res = json_decode($sendSub, true);
            if($res['errcode'] == 0){
                //发送成功
                Db::table('xcx_sub_msg')
                    ->where(['ss_id' => $logId])
                    ->update([
                        'ss_status' => 2,
                        'ss_remarks' => $data['ss_remarks'].'2.发送成功：已发送订阅消息到用户手机。',
                    ]);
            }else{
                //发送失败
                Db::table('xcx_sub_msg')
                    ->where(['ss_id' => $logId])
                    ->update([
                        'ss_status' => 3,
                        'ss_remarks' => $data['ss_remarks'].'2.发送失败：微信服务端未发送成功。',
                    ]);
            }
        }
    }



    public function getTopicInfosByReplayid($cid){
        $res = Db::table('tk_comment')
            ->where(['cid' =>$cid])
            ->field('tid,type,repy,repyid,userid')
            ->find();
        $topid = [];
        if($res['repy'] == 1){
            //帖子id
            $topid['tid'] = $res['tid'];
            $topid['type'] = $res['type'];
            $topid['userid'] = $res['userid'];
        }else{
            $topinfo = Db::table('tk_comment')
                ->where(['cid' =>$res['repyid']])
                ->field('tid,type,userid')
                ->find();
            $topid['tid'] = $topinfo['tid'];
            $topid['type'] = $topinfo['type'];
            $topid['userid'] = $topinfo['userid'];
        }
        return $topid;
    }

    public function comList(){
        $id = trim($this->request->param('id'));
        $type = trim($this->request->param('type'));
        $page = trim($this->request->param('page',0));
        $limit = trim($this->request->param('limit',5));

        $comment = Db::table('tk_comment')
            ->where(['tid' => $id,'type' =>$type])
            ->limit(($page)*$limit,$limit)
            ->order('addtime desc')
            ->select();
        $count = Db::table('tk_comment')->Where(['tid' => $id,'type' =>$type])->count('cid');
        if($comment){
            $loop = new Loops();
            foreach ($comment as $k => $v){
                $comment[$k]['nickname'] = $loop->getUserNick($v['userid']);
                $comment[$k]['avatar'] = $loop->getUserAvatar($v['userid']);
                $comment[$k]['replys'] = $this->getReplay($v['cid']);
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $comment;
            $res['count'] = $count;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = "数据为空";
        return json($res);
    }

    public function getReplay($cid){
        $comment = Db::table('tk_comment')
            ->where(['repy' => 2,'status' =>1,'repyid' => $cid])
            ->limit(20)
            ->order('cid desc')
            ->select();
        if($comment){
            $loop = new Loops();
            foreach ($comment as $k => $v){
                $comment[$k]['nickname'] = $loop->getUserNick($v['userid']);
                $comment[$k]['avatar'] = $loop->getUserAvatar($v['userid']);
                //$comment[$k]['replys'] = $this->getReplay($v['cid']);
            }
        }
        return $comment;
    }
}