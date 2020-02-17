<?php
namespace app\api\controller;
use app\xcx\model\Matem;
use think\Controller;

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
        //待审核3
        $data['status'] = '0';
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
        if(!$id){
            $res['code'] = 2;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $mateM = new Matem();
        $mate = $mateM->getMate($id);
        if($mate){
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $mate;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '读取失败！';
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
        $city = trim($this->request->param('city','墨尔本'));
        //区域里面  热门  学校  所有区
        //热门区域
        $where = "city = '".$city."'";
        $area = trim($this->request->param('area'));
        if(isset($area) && !empty($area) && $area){
            $where.=" and area = '".$area."'";
        }
        //学校
        $school = trim($this->request->param('school'));
        if(isset($school) && !empty($school) && $school){
            $where.=" and school = '".$school."'";
        }
        //年龄age
        $age = trim($this->request->param('age'));
        if(isset($age) && !empty($age) && $age){
            $where.=" and age = '".$age."'";
        }
        //性别
        $sex = trim($this->request->param('sex'));
        if(isset($sex) && !empty($sex) && $sex){
            $where.=" and sex = '".$sex."'";
        }
        //宠物
        //楼宇设施
        $order = 'publish_date desc';
        $field = 'id,title,ager,school,habit';
        $mateM = new Matem();
        $mate= $mateM->readData($where,$order,'12','0',$field);
        if($mate){
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $mate;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '读取失败！';
        $res['data'] = $mate;
        return json($res);
    }


}