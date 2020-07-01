<?php
namespace app\api\controller;
use app\xcx\model\Matem;
use think\Controller;
use think\Db;

class Mate extends Controller
{
    public function addMate(){
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
        $housem = new Matem();
        $id = $housem->addMate($data);
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


    public function editMate(){
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
        $mateM = new Matem();
        $edit = $mateM->editMate($data);
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
    public function mateDetail(){
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
        $mateM = new Matem();
        $mate = $mateM->getMate($id,$uid);
        if($mate){
            $mate['live_date'] = $mate['live_date']== '0000-00-00' ? '随时入住' : $mate['live_date'];
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $mate;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        return json($res);
    }


    /**
     * 找室友列表查询接口
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
        $uid = trim($this->request->param('uid'));
        $city = trim($this->request->param('city','墨尔本'));
        //区域里面  热门  学校  所有区
        //热门区域
        $where = "status = 1 and city = '".$city."'";
        $area = trim($this->request->param('area'));
        if(isset($area) && !empty($area) && $area){
            $where.=" and area = '".$area."'";
        }
        $keys = trim($this->request->param('keys'));
        if(isset($keys) && !empty($keys) && $keys){
            $where.=" and ( title like '%".$keys."%' or dsn like '%".$keys."%'  or school like '%".$keys."%' or city like '%".$keys."%')";
            if($uid){
                $this->addQueryLog($uid,$keys,2);
            }
        }
        //学校
        $school = trim($this->request->param('school'));
        if(isset($school) && !empty($school) && $school){
            $where.=" and school = '".$school."'";
        }
        //年龄age
        $age = trim($this->request->param('age'));
        if(isset($age) && !empty($age) && $age){
            $where.=" and ager = '".$age."'";
        }
        //性别
        $sex = trim($this->request->param('sex'));
        if(isset($sex) && !empty($sex) && $sex){
//            if($sex == '不限'){
//                $sexr = '男女不限';
//            }else{
//                $sexr = '限'.$sex;
//            }
            $where.=" and sex = '".$sex."'";
        }
        //宠物
        //楼宇设施
        $order = 'mdate desc';
        $field = 'id,title,ager,sex,school,habit,user_id,mdate,live_date,price';
        $page = trim($this->request->param('page','0','intval'));
        $mateM = new Matem();
        $mate= $mateM->readData($where,$order,'12',$page,$field);
        $this->addQueryContent($uid,$where,2);
        if($mate){
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $mate;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $mate;
        return json($res);
    }


    public function my(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = intval(trim($this->request->param('uid')));
        $limit = trim($this->request->param('limit','10'));
        $page = trim($this->request->param('page','0','intval'));
        if(!$uid){
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        $where = "(status >=1 and user_id = '".$uid."')";
        $order = 'publish_date desc';
          $field = 'id,title,area,images,price,school,ager,sex,status,habit,user_id,live_date,mdate,price';
        $housem = new Matem();
        $house = $housem->readData($where,$order,$limit,$page,$field);
        if($house){
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $house;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $house;
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

    //用户行为分析
    public function addQueryContent($uid,$content,$type){
        $data['sk_userid'] = $uid;
        $data['sk_type'] = $type;
        $data['sk_content'] = $content;
        $data['sk_addtime'] = date('Y-m-d H:i:s');
        $resault = Db::table('xcx_search_keywords')->insertGetId($data);
        return $resault;
    }

}