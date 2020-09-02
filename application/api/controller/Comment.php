<?php


namespace app\api\controller;


use think\Controller;
use app\xcx\model\Loops;
use think\Db;

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
            $res['code'] = 1;
            $res['msg'] = '评论成功！';
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '评论失败！';
        return json($res);
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
            $res['code'] = 1;
            $res['msg'] = '回复成功！';
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '回复失败！';
        return json($res);
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