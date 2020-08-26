<?php


namespace app\api\controller;


use app\xcx\model\Loops;
use think\Controller;
use think\Db;
use think\Log;

class Rent extends Controller
{
    public function addRent(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $data = $this->request->post();
        if(!$data){
            $res['code'] = 0;
            $res['msg'] = '缺少提交参数！';
            return json($res);
        }
        $data['cdate'] = date('Y-m-d H:i:s');
        $data['mdate'] = date('Y-m-d H:i:s');
        $id = Db::table('tk_forent')->insertGetId($data);
        if($id){
            $res['code'] = 1;
            $res['msg'] = '写入成功！';
            $res['id'] = $id;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '写入失败！';
        return json($res);
    }


    public function editRent(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $data = $this->request->post();
        if(!$data){
            $res['code'] = 0;
            $res['msg'] = '缺少提交参数！';
            return json($res);
        }
        if($data && $data['id'] <= 0){
            $res['code'] = 0;
            $res['msg'] = '缺少ID参数！';
            return json($res);
        }
        $data['mdate'] = date('Y-m-d H:i:s');
        $id = $data['id'];
        unset($data['id']);
        $edit = Db::table('tk_forent')->where(['id' => $id])->update($data);
        if($edit){
            $res['code'] = 1;
            $res['msg'] = '修改成功！';
            $res['id'] = $edit;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '修改失败！';
        return json($res);
    }
    public function rentDetail(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id = trim($this->request->param('id'));
        $uid = trim($this->request->param('uid',0));
        if(!$id){
            $res['code'] = 2;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $mate = Db::table('tk_forent')
            ->where(['id' => $id])->find();
        if($mate){
            $msg = new Loops();
            $house['nickname'] = $msg->getUserNick($mate['userid']);
            $house['avaurl'] = $msg->getUserAvatar($mate['userid']);
            $comment = Db::table('tk_comment')
                ->where(['type' => 2,'repy' => 1,'status' =>1,'tid' => $id])
                ->order('cid desc')
                ->limit(20)
                ->select();
            if($comment){
                foreach ($comment as $k => $v){
                    $comment[$k]['nickname'] = $msg->getUserNick($v['userid']);
                    $comment[$k]['avatar'] = $msg->getUserAvatar($v['userid']);
                    $comment[$k]['replys'] = $this->getReplay($v['cid']);
                }
            }
            $mate['comment'] = $comment;
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $mate;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
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
                $comment[$k]['replys'] = $this->getReplay($v['cid']);
            }
        }
        return $comment;
    }
    /**
     * 求租拼租列表查询接口
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        //城市
        $uid = trim($this->request->param('uid',0));
        //区域里面  热门  学校  所有区
        //热门区域
        $where = "1 = 1 ";
        $keys = trim($this->request->param('keys'));
        if(isset($keys) && !empty($keys) && $keys){
            $where.=" and ( title like '%".$keys."%' or desc like '%".$keys."%' )";
            if($uid){
                $this->addQueryLog($uid,$keys,3);
            }
        }
        //类型
        $type = trim($this->request->param('type'));
        if(isset($type) && !empty($type) && $type){
            $where.=" and type = '".$type."'";
        }
        //性别
        $sex = trim($this->request->param('sex'));
        if(isset($sex) && !empty($sex) && $sex){
            $where.=" and sex = ".$sex;
        }
        //入住时间最大值 最小值 mintime  结束    maxtime  左边加5天
        $mintime = trim($this->request->param('mintime'));
        $maxtime = trim($this->request->param('maxtime'));
        if((isset($mintime) && !empty($mintime) && $mintime) && !$maxtime){
            $where.=" and livedate >= '".$mintime."' ";
        }

        if((isset($maxtime) && !empty($maxtime) && $maxtime) && !$mintime){
            $where.=" and livedate  <= '".$maxtime."'";
        }
        if($mintime && $maxtime){
            $where.= " and ((livedate >= '".$mintime."' and livedate  <= '".$maxtime."')";
        }
        $page = trim($this->request->param('page','0','intval'));
        $limit = 12;
        $order = "cdate desc";
        $result = Db::table('tk_forent')
            ->where($where)
            ->limit(($page)*$limit,$limit)
            ->order($order)
            ->select();
        if($result){
            $msg = new Loops();
            foreach ($result as $k => $v){
                $result[$k]['avatar'] = $msg->getUserAvatar($v['userid']);
                $result[$k]['nickname'] = $msg->getUserNick($v['userid']);
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $result;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $result;
        return json($res);
    }

    //用户行为分析
    public function addQueryLog($uid,$key,$type){
        $data['sk_keywords'] = $key;
        $data['sk_userid'] = $uid;
        $data['sk_type'] = $type;
        $data['sk_addtime'] = date('Y-m-d H:i:s');
        $resault = Db::table('xcx_search_keywords')->insertGetId($data);
        return $resault;
    }

}