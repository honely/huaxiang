<?php


namespace app\api\controller;


use app\xcx\model\Housem;
use think\Controller;
use think\Db;

class Corp extends Controller
{

    /***
     * 个人主页
     */
    public function personal(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id = trim($this->request->param('aid'));
        if(!$id){
            $res['code'] = 2;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $admin['personal'] = Db::table('super_admin')->where(['ad_id' => $id])->find();
        if($admin['personal']){
            unset($admin['ad_password']);
            //个人在租
            $where = ['pm' => $id];
            $fields = "id,house_type,toilet,car,house_room,area,price,images";
            $hous = new Housem();
            $admin['house'] = $hous->readData($where,'id desc',5,0,$fields);
            $admin['count'] =5;
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $admin;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        return json($res);
    }

    /***
     * 公司主页
     */
    public function comps(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id = trim($this->request->param('cid'));
        if(!$id){
            $res['code'] = 2;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $admin['corp'] = Db::table('xcx_corp')->where(['cp_id' => $id])->find();
        if($admin){
            //我的团队
            $admin['team'] = Db::table('super_admin')
                ->where(['ad_corp' => $id])
                ->field('ad_id,ad_realname,ad_img')
                ->select();
            //全部房产总数
            $fields = "id,house_type,toilet,car,house_room,area,price,images";
            $where = ['corp' => $id];
            $hous = new Housem();
            $admin['house'] = $hous->readData($where,'id desc',5,0,$fields);
            $admin['count'] =5;
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $admin;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        return json($res);
    }


    public function contact(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $cid = trim($this->request->param('cid'));
        $uid = trim($this->request->param('uid'));
        $name = trim($this->request->param('name'));
        $phone = trim($this->request->param('phone'));
        $wechat = trim($this->request->param('wechat'));
        $save = trim($this->request->param('is_save'));
        $type = trim($this->request->param('type'));
        $content = trim($this->request->param('content'));
        if(!$cid || !$name || !$phone || !$wechat || !$type || !$content || !$uid){
            $res['code'] = 2;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        //数据入
        $insert = Db::table('xcx_contactcorp')
            ->insertGetId([
                'cid' => $cid,
                'name' => $name,
                'phone' => $phone,
                'wechat' => $wechat,
                'save' => $save,
                'type' => $type,
                'content' => $content,
                'addtime' => date('Y-m-d H:i:s'),
                'status' => 3,
            ]);
        if($save == 1){
            Db::table('tk_user')->where(['id' => $uid])->update(['tel' => $phone,'wchat' => $wechat]);
        }
        $corp = Db::table('xcx_corp')
            ->where(['cp_id' => $cid])
            ->field('cp_name,cp_email')
            ->find();
        $type = $this->forType($type);
        $mailer = new Mailer();
        $res = $mailer->mailCorp($corp['cp_name'],$corp['cp_email'],$name,$phone,$wechat,$type,$content);
        if(!$res){
            Db::table('xcx_contactcorp')->where(['id' => $insert])->update(['status' =>2]);
            return json(['code'=>0,'msg'=>'发送失败！请联系管理员']);
        }else{
            Db::table('xcx_contactcorp')->where(['id' => $insert])->update(['status' =>1]);
            return json(['code'=>1,'msg'=>'发送成功！']);
        }
    }

    public function forType($type){
        switch ($type){
//        Inspection/ Available Date/ Application/ Length of lease
            case 1:
                $room = 'Inspection';
                break;
            case 2:
                $room = 'Length of lease';
                break;
            case 3:
                $room = 'Available Date';
                break;
            case 4:
                $room = 'Application';
                break;
            default:
                $room ='Others';
        }
        return $room;
    }

}