<?php
namespace app\xcx\model;
use think\Db;
use think\Model;

class Matem extends Model
{

    public function readData($where,$order,$limit,$page,$field){
        $result = Db::table('tk_roommates')
            ->where($where)
            ->limit(($page)*$limit,$limit)
            ->order($order)
            ->field($field)
            ->select();
        if($result){
            $msg = new Loops();
            foreach ($result as $k => $v){
                $result[$k]['live_date'] = $v['live_date']== '0000-00-00' ? '随时入住' : $v['live_date'];;
                $result[$k]['avatar'] = $msg->getUserAvatar($v['user_id']);
                $result[$k]['nickname'] = $msg->getUserNick($v['user_id']);
            }
        }
        return $result ? $result :  null;
    }


    public function addMate($data){
        $data['dsn'] = $this->getMateDsn();
        $addHouse = Db::table('tk_roommates')->insertGetId($data);
        //写入一条轮播消息
        $mateInfo = Db::table('tk_roommates')->where(['id' =>$addHouse])->field('user_id')->find();
        $msg = new Loops();
        $userNick = $msg->getUserNick($mateInfo['user_id']);
        $str = $userNick.'正在找室友';
        $msg->insertMsg($str);
        return $addHouse ? $addHouse :  0;
    }

    public function editMate($data){
        $id = $data['id'];
        unset($data['id']);
        $update = Db::table('tk_roommates')
            ->where(['id' => $id])
            ->update($data);
        return $update ? $id : 0;
    }


    public function getMate($id,$uid){
        $house = Db::table('tk_roommates')
            ->where(['id' => $id])
            ->find();
        $msg = new Loops();
        if($house['user_id']){
            $house['real_name'] = $msg->getUserNick($house['user_id']);
            $house['avaurl'] = $msg->getUserAvatar($house['user_id']);
        }
        if($uid){
            //写入一条浏览记录
            $view = new Views();
            $view->addView($uid,$id,2);
        }
        return $house ? $house : null;
    }

    //生成找室友编码
    public function getMateDsn()
    {
        $dsn = 'M';
        $max =$this->getMax();
        $s = '';
        for ($i = 1; $i < 10 - strlen($max); $i++) {
            $s .= '0';
        }
        $max++;
        $dsn .= $s.$max;
        return $dsn;
    }

    public function getMax(){
        $max = Db::table('tk_roommates')->order('id desc')->find();
        return $max['id'] ? $max['id'] : 0;
    }
}