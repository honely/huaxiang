<?php
namespace app\xcx\controller;
use app\xcx\model\Rolem;
use think\Controller;
use think\Db;
use think\Request;

class Question extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $adminName=session('adminId');
        if(empty($adminName)){
            $this->error('请先登录！','login/login');
        }
        if(isset($_SESSION['expiretime'])) {
            if($_SESSION['expiretime'] < time()) {
                unset($_SESSION['expiretime']);
                $this->error('您的登录身份已过期，请重新登录！','login/login');
                exit(0);
            } else {
                $_SESSION['expiretime'] = time() + 1800; // 刷新时间戳
            }
        }
    }


    public function rent1(){
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $addable = in_array('268',$power_list,true);
        $editable = in_array('269',$power_list,true);
        $delable = in_array('270',$power_list,true);
        $this->assign('addable',$addable);
        $this->assign('editable',$editable);
        $this->assign('delable',$delable);
        return $this->fetch();
    }


    public function loard1(){
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $addable = in_array('271',$power_list,true);
        $editable = in_array('272',$power_list,true);
        $delable = in_array('273',$power_list,true);
        $this->assign('addable',$addable);
        $this->assign('editable',$editable);
        $this->assign('delable',$delable);
        return $this->fetch();
    }

    public function about(){
        return $this->fetch();
    }
    public function agreement(){
        return $this->fetch();
    }

    public function rentData(){
        $where =' 1 = 1';
        $keywords = trim($this->request->param('keywords'));
        $type = trim($this->request->param('type'));
        if(isset($type) && !empty($type)){
            $where.=" and type = '".$type."'";
        }
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( title like '%".$keywords."%' or dsn like '%".$keywords."%' )";
        }
        $count=Db::table('tk_questions')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $design=Db::table('tk_questions')
            ->limit(($page-1)*$limit,$limit)
            ->order('id desc')
            ->where($where)
            ->select();
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        return json($res);
    }


    public function review1(){
        $id = trim($this->request->param('id'));
        if($_POST){
            $data = $_POST;
            $data['mdate'] =  date('Y-m-d H:i:s');
            unset($data['id']);
            $update = Db::table('tk_questions')->where(['id' => $id])->update($data);
            if($update){
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }else{
            $content = Db::table('tk_questions')->where(['id' => $id])->find();
            $this->assign('content',$content);
            return $this->fetch();
        }
    }


    public function del(){
        $cl_id = intval(trim($this->request->param('id')));
        $del = Db::table('tk_questions')
            ->where(['id' => $cl_id])->delete();
        if($del){
            $this->success('删除成功！');
        }else{
            $this->error('删除失败!');
        }
    }

    public function add(){
        $type = trim($this->request->param('type'));
        if($_POST){
            $data = $_POST;
            $data['type'] = $type;
            $data['cdate'] = date('Y-m-d H:i:s');
            $data['mdate'] =  date('Y-m-d H:i:s');
            $add = Db::table('tk_questions')->insertGetId($data);
            $url = $type == '租房'  ? 'rent1' : 'loard1';
            if($add){
                $this->success('添加成功！',$url);
            }else{
                $this->error('添加失败!',$url);
            }
        }else{
            $this->assign('type',$type);
            return $this->fetch();
        }
    }

    public function edit(){
        $id = intval(trim($this->request->param('id')));
        $type = trim($this->request->param('type'));
        if($_POST){
            $data = $_POST;
            $data['cdate'] = date('Y-m-d H:i:s');
            $data['mdate'] =  date('Y-m-d H:i:s');
            $add = Db::table('tk_questions')->where(['id' =>$id])->update($data);
            $url = $type == '关于我们'  ? 'about' : 'agreement';
            if($add){
                $this->success('修改成功！',$url);
            }else{
                $this->error('修改失败!',$url);
            }
        }else{
            $content = Db::table('tk_questions')->where(['id' => $id])->find();
            $this->assign('content',$content);
            $this->assign('type',$type);
            return $this->fetch();
        }
    }

}