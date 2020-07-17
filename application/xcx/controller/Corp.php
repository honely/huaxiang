<?php

namespace app\xcx\controller;


use app\xcx\model\Rolem;
use think\Controller;
use think\Db;

class Corp extends Controller
{
    public function index(){
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $editable = in_array('260',$power_list,true);
        $delable = in_array('261',$power_list,true);
        $this->assign('editable',$editable);
        $this->assign('delable',$delable);
        return $this->fetch();
    }

    public function corpData(){
        $where ='1 = 1 ';
        $count=Db::table('xcx_corp')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',50,'intval');
        $example=Db::table('xcx_corp')->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('cp_addtime desc')
            ->select();
        if($example){
            foreach ($example as $k => $v){
                $example[$k]['cp_add_admin'] = $this->getAdminName($v['cp_add_admin']);
                $example[$k]['cp_count'] = $this->getCountStaff($v['cp_id']);
            }

        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $example;
        $res['count'] = $count;
        return json($res);
    }

    public function getCountStaff($cpid){
        $count = Db::table('super_admin')
            ->where(['ad_id' => $cpid])
            ->count('ad_id');
        return $count;
    }

    public function getAdminName($adId){
        $adimin = Db::table('super_admin')
            ->where(['ad_id' => $adId])
            ->field('ad_bid')
            ->find();
        return $adimin ? $adimin['ad_bid'] : '---';
    }

    public function my(){
        return $this->fetch();
    }

    public function add(){
        $adminId=intval(session('adminId'));
        if($_POST){
            $data['cp_name']=$_POST['cp_name'];
            $data['cp_identity']=$_POST['cp_identity'];
            $data['cp_logo']=$_POST['cp_logo'];
            $data['cp_email']=$_POST['cp_email'];
            $data['cp_address']=$_POST['cp_address'];
            $data['cp_email']=$_POST['cp_email'];
            $data['cp_desc']=$_POST['cp_desc'];
            $data['cp_tel']=$_POST['cp_tel'];
            $data['cp_opentime']=$_POST['cp_opentime'];
            $data['cp_weixin']= $_POST['cp_weixin'];
            $data['cp_addtime']= date('Y-m-d H:i:s');
            $data['cp_udate']= date('Y-m-d H:i:s');
            $data['cp_fuzeren']='';
            $data['cp_able']=1;
            $data['cp_add_admin'] = $adminId;
            $addBan=Db::table('xcx_corp')->insert($data);
            if($addBan){
                $this->success('添加成功！','index');
            }else{
                $this->error('添加失败!','index');
            }
        }else{
            return $this->fetch();
        }
    }

    public function edit(){
        $adminId=intval(session('adminId'));
        $ba_id=$_GET['cp_id'];
        if($_POST){
            $data['cp_name']=$_POST['cp_name'];
            $data['cp_identity']=$_POST['cp_identity'];
            $data['cp_logo']=$_POST['cp_logo'];
            $data['cp_email']=$_POST['cp_email'];
            $data['cp_address']=$_POST['cp_address'];
            $data['cp_email']=$_POST['cp_email'];
            $data['cp_desc']=$_POST['cp_desc'];
            $data['cp_tel']=$_POST['cp_tel'];
            $data['cp_opentime']=$_POST['cp_opentime'];
            $data['cp_weixin']= $_POST['cp_weixin'];
            $data['cp_udate']= date('Y-m-d H:i:s');
            $data['cp_fuzeren']='';
            $data['cp_able']=1;
            $data['cp_add_admin'] = $adminId;
            $update=Db::table('xcx_corp')->where(['cp_id'=> $ba_id])->update($data);
            if($update){
                $this->success('修改成功！','index');
            }else{
                $this->error('您未做任何修改！','index');
            }
        }else{
            $banInfo=Db::table('xcx_corp')
                ->where(['cp_id'=> $ba_id])
                ->find();
            $this->assign('corp',$banInfo);
            return $this->fetch();
        }
    }


    public function del(){
        $ba_id=intval(trim($_GET['cp_id']));
        $delBan=Db::table('xcx_corp')->where(['cp_id'=> $ba_id])->delete();
        if($delBan){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！','index');
        }
    }


    public function upload()
    {
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/corp');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/corp/".$path_date."/".$path_filename;
            // 成功上传后 返回上传信息
            return json(array('state'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
        }else{
            // 上传失败返回错误信息
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }


    public function detail(){
        $ba_id=$_GET['cp_id'];
        $banInfo=Db::table('xcx_corp')
            ->where(['cp_id'=> $ba_id])
            ->find();
        $this->assign('corp',$banInfo);
        return $this->fetch();
    }
}