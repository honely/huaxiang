<?php


namespace app\api\controller;


use think\Controller;
use think\Db;

class Apply extends Controller
{

    /***
     * 申请看房
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function add(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid')));
        $name = trim($this->request->param('name'));
        $phone = trim($this->request->param('phone'));
        $email = trim($this->request->param('email'));
        $start_date = trim($this->request->param('start_date'));
        $book_times = trim($this->request->param('book_times'));
        $hid = trim($this->request->param('hid'));
        $type = trim($this->request->param('type'));
        $is_save = trim($this->request->param('is_save'));
        $hp_id = trim($this->request->param('hp_id'));
        if (!$uId || !$name || !$phone || !$email || !$hid) {
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        if($is_save == 1){
            $updateUser = Db::table('tk_user')
                ->where(['id' => $uId])
                ->update([
                    'tel' => $phone,
                    'real_name' => $name,
                    'email' => $email,
                ]);
        }
        if($type == 1){
            //在事先安排好的看房安排里登基一个租客
            //查询是否已经登记租客
            $isReg = Db::table('tk_planrenter')
                ->where(['pu_hp_id' => $hp_id,'pu_uid' => $uId])
                ->find();
            if($isReg){
                $res['code'] = 0;
                $res['msg'] = '你已经预约了此次看房时间！';
                return json($res);
            }
            $datas['pu_hp_id'] = $hp_id;
            $datas['pu_uid'] = $uId;
            $datas['pu_addtime'] = date('Y-m-d H:i:s');
            $datas['pu_hid'] = $hid;
            $datas['pu_phone'] = $phone;
            $datas['pu_username'] = $name;
            $datas['pu_email'] = $email;
            $insert  = Db::table('tk_planrenter')->insertGetId($datas);
            if($insert){
                $res['code'] = 1;
                $res['msg'] = '预约成功！';
                $res['data'] = $insert;
                return json($res);
            }
            $res['code'] = 0;
            $res['msg'] = '预约失败！';
            return json($res);
        }else{
            $intData['u_email'] = $email;
            $intData['u_uid'] = $uId;
            $intData['u_phone'] = $phone;
            $intData['u_name'] = $name;
            $intData['u_Inquery_time'] = date('Y-m-d H:i:s');
            $intData['u_book_time'] = $start_date;
            $intData['u_book_times'] = $book_times;
            $intData['u_hid'] = $hid;
            $intData['u_type'] = $type;
            $intData['u_source'] = 1;
            $insert  = Db::table('tk_userinfo')->insertGetId($intData);
            if($insert){
                $res['code'] = 1;
                $res['msg'] = '预约成功！';
                $res['data'] = '$insert！';
                return json($res);
            }
            $res['code'] = 0;
            $res['msg'] = '预约失败！';
            return json($res);
        }

    }



    public function guide(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $keywords = trim($this->request->param('keywords'));
        $where = " type = '申请指南'";
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( title like '%".$keywords."%' or content like '%".$keywords."%' )";
        }
        $design=Db::table('tk_questions')
            ->limit(($page-1)*$limit,$limit)
            ->order('id desc')
            ->where($where)
            ->field('id,title,images')
            ->select();
        if($design){
            foreach ($design as $k => $v){
                $design[$k]['images'] =  "https://".$_SERVER['SERVER_NAME']."/".$v['images'];
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $design;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '数据为空！';
        $res['data'] = $design;
        return json($res);
    }

    public function guidetail(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id= $this->request->param('id',0,'intval');
        if(!$id){
            $res['code'] = 0;
            $res['msg'] = '参数为空！';
            return json($res);
        }
        $design = Db::table('tk_questions')->where(['id' => $id])->find();
        if($design){
            $design['images'] =  "https://".$_SERVER['SERVER_NAME']."/".$design['images'];
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $design;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '读取失败！';
        $res['data'] = $design;
        return json($res);
    }

     public function getInspect(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id= $this->request->param('hid');
        $hp_id= $this->request->param('hp_id',0);
        $date = date('Y-m-d H:i:s');
        $order = $hp_id ? ' field(hp_id,'.$hp_id.') desc' : ' hp_plandate desc ';
        $sql = "SELECT `hp_id`,`hp_plandate`,`hp_lastime` FROM `tk_houseplan` WHERE  `hp_hid` = ".$id." AND `hp_status` = 1  AND `hp_type` = 1  AND (  hp_endtime > '".$date."' ) ORDER BY ".$order;
         $design = Db::query($sql);
        if($design){
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $design;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '读取失败！';
        $res['data'] = $design;
        return json($res);
    }


    public function myagree(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id= $this->request->param('uid');
        $type= $this->request->param('type',1);
        $page= $this->request->param('page',0,'intval');
        $limit=$this->request->param('limit',10,'intval');
        if($type == 1){
            $where = "hp_status < 3 ";
        }else{
            $where = "hp_status = 3 ";
        }
        $booking = Db::table('tk_planrenter')
            ->where(['pu_uid' =>$id])
            ->where($where)
            ->join('tk_houses','tk_planrenter.pu_hid = tk_houses.id')
            ->join('tk_houseplan','tk_planrenter.pu_hp_id = tk_houseplan.hp_id')
            ->order('pu_addtime desc')
            ->limit($page*$limit,$limit)
            ->field('tk_houseplan.hp_plandate,tk_houseplan.hp_lastime,tk_houses.tags,tk_houses.price,tk_houses.cover,tk_houses.title,tk_houses.address,tk_houses.street,tk_houseplan.hp_hid')
            ->select();
        if($booking){
            foreach ($booking as $k => $v){
                $booking[$k]['cover'] = "https://".$_SERVER['SERVER_NAME']."/".$v['cover'];
                $booking[$k]['address'] = $v['street']? $v['street']."/".$v['address'] : $v['address'];
                $booking[$k]['hp_plandate'] = date('Y.m.d',strtotime($v['hp_plandate']));
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $booking;
            $res['type'] = $type;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '读取成功,数据为空！';
        $res['data'] = $booking;
        $res['type'] = $type;
        return json($res);
    }
    
    
    
   public function updateHousePlanStatus(){

        //进行中
         //设置时区问题
        date_default_timezone_set("Australia/Melbourne");
        $planss = Db::table('tk_houseplan')
            ->where("hp_endtime > '".date('Y-m-d H:i:s')."' and hp_startime <  '".date('Y-m-d H:i:s')."'")
            ->field('hp_id,hp_status')
            ->select();
        if($planss){
            foreach ($planss as $k => $v){
                Db::table('tk_houseplan')
                    ->where(['hp_id' => $v['hp_id']])
                    ->update(['hp_status' => 2]);
            }
        }

        //已结束
        $plans = Db::table('tk_houseplan')
            ->where("hp_endtime < '".date('Y-m-d H:i:s')."'")
            ->field('hp_id,hp_status')
            ->select();
        if($plans){
            foreach ($plans as $k => $v){
                Db::table('tk_houseplan')
                    ->where(['hp_id' => $v['hp_id']])
                    ->update(['hp_status' => 3]);
            }
        }
    }
}