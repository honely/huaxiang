<?php


namespace app\api\controller;


use think\Controller;
use think\Db;

class Top extends Controller
{
    /***
     * 房源用户置顶
     * uid 用户id
     * hid 房源id
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function userTop(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid')));
        $hid = intval(trim($this->request->param('hid')));
        if(!$uId || !$hid){
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $date = date('Y-m-d');
        $isTopable = $this->topCount($uId,$date);
        if(!$isTopable){
            $res['code'] = 0;
            $res['msg'] = '您今日的置顶次数已用光！';
            return json($res);
        }
        //写入一条置顶记录；
        $log['tp_hid'] = $hid;
        $log['tp_uid'] = $uId;
        $log['tp_type'] = 1;
        $log['tp_aid'] = 0;
        $log['tp_date'] = $date;
        $log['tp_top_time'] = date('Y-m-d H:i:s');
        $insert = Db::table('xcx_house_top')->insertGetId($log);
        //更新房源发布时间
        $updateHouseCtime = Db::table('tk_houses')
            ->where(['id' => $hid])
            ->update(['cdate' => date('Y-m-d H:i:s')]);
        if($insert && $updateHouseCtime){
            $res['code'] = 1;
            $res['msg'] = '置顶成功！';
            $res['count'] = $isTopable-1;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '置顶失败！';
        return json($res);
    }


    //求租拼租置顶
    public function renTop(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid')));
        $hid = intval(trim($this->request->param('hid')));
        if(!$uId || !$hid){
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $date = date('Y-m-d');
        $isTopable = $this->topCount($uId,$date);
        if(!$isTopable){
            $res['code'] = 0;
            $res['msg'] = '您今日的置顶次数已用光！';
            return json($res);
        }
        //写入一条置顶记录；
        $log['tp_hid'] = $hid;
        $log['tp_uid'] = $uId;
        $log['tp_aid'] = 0;
        $log['tp_type'] = 2;
        $log['tp_date'] = $date;
        $log['tp_top_time'] = date('Y-m-d H:i:s');
        $insert = Db::table('xcx_house_top')->insertGetId($log);
        //更新房源发布时间
        $updateHouseCtime = Db::table('tk_forent')
            ->where(['id' => $hid])
            ->update(['mdate' => date('Y-m-d H:i:s')]);
        if($insert && $updateHouseCtime){
            $res['code'] = 1;
            $res['msg'] = '置顶成功！';
            $res['count'] = $isTopable-1;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '置顶失败！';
        return json($res);
    }

    public function topCount($uId,$date){
        $topInfo = Db::table('xcx_house_top')
            ->where(['tp_uid' => $uId,'tp_date' =>$date])
            ->count('tp_id');
        $count = 10-$topInfo;
        return $count;
    }


    //更新livedate0000-00-00
    public function updateLiveDate(){
        Db::table('tk_houses')
            ->where("live_date <= '".date('Y-m-d')."'")
            ->update(['live_date' => '0000-00-00']);
    }

}