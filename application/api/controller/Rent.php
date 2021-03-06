<?php


namespace app\api\controller;


use app\xcx\model\Loops;
use think\Controller;
use app\xcx\model\Views;
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
            $res['id'] = $id;
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
        //写入一条浏览记录
        $col = new Views();
        $col->addView($uid,$id,3);
        if($mate){
            $msg = new Loops();
            $mate['nickname'] = $msg->getUserNick($mate['userid']);
            $mate['avaurl'] = $msg->getUserAvatar($mate['userid']);
            $mate['is_colt'] = $this->getColt($mate['id'],$uid);
            $mate['is_like'] = $this->getLikes($mate['id'],$uid);
            $comment = Db::table('tk_comment')
                    ->where(['type' => 2,'repy' => 1,'status' =>1,'tid' => $id])
                    //->orderRaw()
                    ->order('cid desc')
                    ->limit(2)
                    ->select();
            if($comment){
                $loop = new Loops();
                foreach ($comment as $k => $v){
                    $comment[$k]['nickname'] = $loop->getUserNick($v['userid']);
                    $comment[$k]['avatar'] = $loop->getUserAvatar($v['userid']);
                    $comment[$k]['replys'] = $this->getReplay($v['cid']);
                }
            }
            $commc = Db::table('tk_comment')->where(['type' => 2,'repy' => 1,'status' =>1,'tid' => $id])->count('cid');
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $mate;
            $res['comment'] = $comment;
            $res['countc'] = $commc;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        return json($res);
    }


    public function getCollects($uid){
        $collects = Db::table('xcx_collect')
            ->where(['cl_user_id' => $uid,'cl_type' => 3])
            ->field('cl_house_id')
            ->select();
        $collect =  array_column($collects,'cl_house_id');
        return $collect;
    }

    public function getLike($uid){
        $collects = Db::table('xcx_likes')
            ->where(['uid' => $uid,'type' => 3])
            ->field('tid')
            ->select();
        $collect =  array_column($collects,'tid');
        return $collect;
    }

    public function getColt($id,$uid){
        $collects = Db::table('xcx_collect')
            ->where(['cl_user_id' => $uid,'cl_type' => 3])
            ->field('cl_house_id')
            ->select();
        $collect =  array_column($collects,'cl_house_id');
        $colt = in_array($id,$collect,true);
        return $colt ? 1 : 0;
    }
    public function getLikes($id,$uid){
        $collects = Db::table('xcx_likes')
            ->where(['uid' => $uid,'type' => 2])
            ->field('tid')
            ->select();
        $collect =  array_column($collects,'tid');
        $colt = in_array($id,$collect,true);
        return $colt ? 1 : 0;
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
        $where = "status = 1 ";
        $keys = trim($this->request->param('keys'));
        if(isset($keys) && !empty($keys) && $keys){
            $where.=" and ( title like '%".$keys."%' or descs like '%".$keys."%' )";
            if($uid){
                $this->addQueryLog($uid,$keys,3);
            }
        }
        //类型
        $type = trim($this->request->param('type'));
        if(isset($type) && !empty($type) && $type){
            $where.=" and type = '".$type."'";
        }
         //城市
        $city = trim($this->request->param('city'));
        if(isset($city) && !empty($city) && $city){
            $where.=" and city = '".$city."'";
        }
        //性别
        $sex = trim($this->request->param('sex'));
        if(isset($sex) && !empty($sex) && $sex){
            $where.=" and sex = ".$sex;
        }
        //入住时间最大值 最小值 mintime  结束    maxtime  左边加5天
        $mintime = trim($this->request->param('mintime'));
        $maxtime = trim($this->request->param('minaxtime'));
        if((isset($mintime) && !empty($mintime) && $mintime) && !$maxtime){
            $mintime = date('Y-m-d',strtotime($mintime));
            $where.=" and livedate >= '".$mintime."' ";
        }

        if((isset($maxtime) && !empty($maxtime) && $maxtime) && !$mintime){
            $maxtime = date('Y-m-d',strtotime($maxtime));
            $where.=" and livedate  <= '".$maxtime."' ";
        }
        if($mintime && $maxtime){
            $mintime = date('Y-m-d',strtotime($mintime));
            $maxtime = date('Y-m-d',strtotime($maxtime));
            $where.= " and livedate >= '".$mintime."' and livedate  <= '".$maxtime."' ";
        }
        $page = trim($this->request->param('page','0','intval'));
        $limit = 12;
        $order = "mdate desc";
        $result = Db::table('tk_forent')
            ->where($where)
            ->limit(($page)*$limit,$limit)
            ->field('id,title,type,userid,mdate,likes,sex,cdate')
            ->order($order)
            ->select();
        if($result){
            $msg = new Loops();
            //是否收藏
            $collects = $this->getCollects($uid);
            //dump($collects);
            $likes = $this->getLike($uid);
            foreach ($result as $k => $v){
                $colt = in_array($v['id'],$collects,true);
                $result[$k]['is_colt'] = $colt ? 1 : 0;
                $like = in_array($v['id'],$likes,true);
                $result[$k]['is_like'] = $like ? 1 : 0;
                $result[$k]['mdate'] = date('Y-m-d',strtotime($v['mdate']));
                $result[$k]['avatar'] = $msg->getUserAvatar($v['userid']);
                $result[$k]['nickname'] = $msg->getUserNick($v['userid']);
                $result[$k]['sex'] = $v['sex'] == 1 ? '男' : '女';
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $result;
            $res['where'] = $where;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $result;
         $res['where'] = $where;
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



    public function myrent(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = intval(trim($this->request->param('uid')));
        $type = trim($this->request->param('type','拼租'));
        if(!$uid){
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        $limit = trim($this->request->param('limit','10'));
        $page = trim($this->request->param('page','0'));
        $where = "status <=2 and userid = ".$uid." and type = '".$type."' ";
        $order = 'mdate desc';
        $result = Db::table('tk_forent')
            ->where($where)
            ->limit(($page)*$limit,$limit)
            ->order($order)
            ->select();
        if($result){
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


    public function rentpost(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id = trim($this->request->param('id'));
        $uid = trim($this->request->param('uid'));
        if(!$id){
            $res['code'] = 2;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        // tags  title地区 户型 租期  图像 昵称 类型
        $house = Db::table('tk_forent')
            ->where(['id' => $id,'status' =>1])
            ->field('id,title,userid,city,area,room,mytags,type,leaseterm,status,livedate')
            ->find();
        if (is_null($house)) {
            $res['code'] = 0;
            $res['msg'] = '该记录已经不存在了';
            return json($res);
        }
        if($house['status'] != 1){
            $res['code'] = 0;
            $res['msg'] = '该记录已被外星人劫持！';
            return json($res);
        }
        if($house){
            $loop = new Loops();
            $house['nickname'] =  $loop->getUserNick($house['userid']);
            $house['avatar'] =  $loop->getUserAvatar($house['userid']);
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $house;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '读取失败！';
        return json($res);
    }


    //求租拼租删除
    public function del(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id = trim($this->request->param('id'));
        if (!@$id) {
            $res['code'] = 0;
            $res['msg'] = 'id不能为空！';
            return json($res);
        }
        $one = Db::table('tk_forent')
            ->where(['id' => $id])->field('id')->find();
        if(!$one){
            $res['code'] = 0;
            $res['msg'] = '记录不存在！';
            return json($res);
        }
        $del = Db::table('tk_forent')
            ->where(['id' => $id])
            ->update(['status' => 3]);
        if($del){
            $res['code'] = 1;
            $res['msg'] = '删除成功！';
            return json($res);
        }else{
            $res['code'] = 0;
            $res['msg'] = '删除失败！';
            return json($res);
        }

    }


    /***
     * 求租拼租上线下
     * 1.帖子id
     * 2.status = 1 上线  ； = 2 下线
     */
    public function onstatus(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id = trim($this->request->param('id'));
        $status = trim($this->request->param('status'));
        if (!@$id || !@$status) {
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $one = Db::table('tk_forent')
            ->where(['id' => $id])->field('id')->find();
        if(!$one){
            $res['code'] = 0;
            $res['msg'] = '记录不存在！';
            return json($res);
        }
        $del = Db::table('tk_forent')
            ->where(['id' => $id])
            ->update(['status' => $status]);
        if($del){
            $res['code'] = 1;
            $res['msg'] = '操作成功！';
            return json($res);
        }else{
            $res['code'] = 0;
            $res['msg'] = '操作失败！';
            return json($res);
        }
    }


}