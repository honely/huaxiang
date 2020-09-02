<?php


namespace app\api\controller;


use app\xcx\model\Housem;
use think\Controller;
use think\Db;
use think\Log;
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
        $page = trim($this->request->param('page',0));
        $limit = trim($this->request->param('limit',5));
        $city = trim($this->request->param('city',''));
        if(!$id){
            $res['code'] = 2;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $admin['personal'] = Db::table('super_admin')
        ->join('xcx_corp','super_admin.ad_corp = xcx_corp.cp_id')
        ->where(['ad_id' => $id])
        ->field('super_admin.*,xcx_corp.cp_address,xcx_corp.cp_name,xcx_corp.cp_name,xcx_corp.cp_desc,xcx_corp.cp_logo')
        ->find();
        if($admin['personal']){
            unset($admin['personal']['ad_password']);
            //个人在租
             //个人中介图像
            //个人中介图像
            $admin['personal']['ad_img'] = $this->getAdminImg($admin['personal']['ad_img']);
            if($city){
               $wheres = ['pm' => $id,'area' => $city,'status' =>1]; 
            }else{
              $wheres = ['pm' => $id,'status' => 1];  
            }
            $fields = "id,address,title,house_type,toilet,car,house_room,area,price,images";
            $hous = new Housem();
            $admin['house'] = $hous->readData($wheres,'id desc',$limit,$page,$fields);
            $admin['count'] =$hous->houseCot($wheres);
            $wherea = ['pm' =>$id,'status' => 1,'is_del' =>1];
            $areas = $this->getAreas($wherea);
            foreach($areas as $k => $v){
                $where = ['area' => $v['area'],'pm' =>$id,'status' =>1];
                $areas[$k]['name'] = $v['area'];
                $areas[$k]['count'] = $hous->houseCot($where);
            }
            $admin['areaCount'] = $areas;
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $admin;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        return json($res);
    }
    
    public function getAreas($where){
        $result = Db::table('tk_houses')
            ->where($where)
            ->group('area')
            ->field('id,area')
            ->order('area')
            ->select();
        return $result;
    }


 public function getAdminImg($adimg){
        $images = $adimg ? config('appurl').'/'.$adimg : 'https://wx.huaxiangxiaobao.com/static/logo.png';
        return $images;
    }


    /***
     * 公司主页
     */
    public function comps(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id = trim($this->request->param('cid'));
        $page = trim($this->request->param('page',0));
        $limit = trim($this->request->param('limit',5));
        $city = trim($this->request->param('city',''));
        Log::write('查看公司主页公司ID：'.$id,'info');
        Log::write('查看公司主页公司page：'.$page,'info');
        Log::write('查看公司主页公司$limit：'.$limit,'info');
        if(!$id){
            $res['code'] = 2;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $admin['corp'] = Db::table('xcx_corp')->where(['cp_id' => $id])->find();
        if (!$admin['corp']['area_img']) {
                $this->get_area_id($admin['corp']['cp_id'], $admin['corp']['x'], $admin['corp']['y']);
            }
        if($admin){
            $admin['corp'] = Db::table('xcx_corp')->where(['cp_id' => $id])->find();
            //我的团队
            $team= Db::table('super_admin')
                ->where(['ad_corp' => $id])
                ->field('ad_id,ad_realname,ad_img')
                ->select();
            if($team){
                foreach ($team as $k => $v){
                    $team[$k]['ad_img'] = $this->getAdminImg($v['ad_img']);
                }
            }
            $admin['team'] = $team;
            //全部房产总数
            $fields = "id,address,title,house_type,toilet,car,house_room,area,price,images";
             if($city){
               $where = ['corp' => $id,'area' => $city,'status' =>1]; 
            }else{
              $where = ['corp' => $id,'status' =>1];  
            }
            $hous = new Housem();
            $admin['house'] = $hous->readData($where,'id desc',$limit,$page,$fields);
            $admin['count'] =$hous->houseCot($where);
            $wherea = ['corp' =>$id,'status' => 1,'is_del' =>1];
            $areas = $this->getAreas($wherea);
            foreach($areas as $k => $v){
                $where = ['area' => $v['area'],'corp' =>$id,'status' =>1];
                $areas[$k]['name'] = $v['area'];
                $areas[$k]['count'] = $hous->houseCot($where);
            }
            $admin['areaCount'] = $areas;
            $admin['areaCount'] = $areas;
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $admin;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        return json($res);
    }
    
    
    
     public function get_area_id($id, $x, $y) {
       $url =  "https://image.maps.ls.hereapi.com/mia/1.6/mapview?c={$x}%2C{$y}&z=17&w=750&h=475&f=1&apiKey=WgZd-Ykul-3XNV5agUgW2vMohtzAlYEA64GIQvcrfaw";
        $res = file_get_contents($url);
        file_put_contents('uploads/corp/'.$id.'.png', $res);
        $data['id'] = $id;
        $img = 'https://wx.huaxiangxiaobao.com/uploads/corp/'.$id.'.png';
        Db::table('xcx_corp')->where(['cp_id' => $id])->update(['area_img' => $img]);
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
        $data = $this->request->param();
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
            Db::table('tk_user')->where(['id' => $uid])->update(['tel' => $phone,'wchat' => $wechat,'real_name' => $name]);
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