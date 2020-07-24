<?php
namespace app\xcx\controller;
use app\xcx\model\Rolem;
use think\Controller;
use think\Db;
use think\Request;

class Tags extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $adminName=session('adminName');
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


    public function house(){
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $addable = in_array('262',$power_list,true);
        $editable = in_array('263',$power_list,true);
        $delable = in_array('264',$power_list,true);
        $this->assign('addable',$addable);
        $this->assign('editable',$editable);
        $this->assign('delable',$delable);
        return $this->fetch();
    }

    public function mate(){
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $addable = in_array('265',$power_list,true);
        $editable = in_array('266',$power_list,true);
        $delable = in_array('267',$power_list,true);
        $this->assign('addable',$addable);
        $this->assign('editable',$editable);
        $this->assign('delable',$delable);
        return $this->fetch();
    }

    public function tagData(){
        $where =' 1 = 1';
        $keywords = trim($this->request->param('keywords'));
        $type = trim($this->request->param('type'));
        if(isset($type) && !empty($type)){
            $where.=" and type = '".$type."'";
        }
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( title like '%".$keywords."%' or dsn like '%".$keywords."%' )";
        }
        $count=Db::table('xcx_tags')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',50,'intval');
        $design=Db::table('xcx_tags')
            ->limit(($page-1)*$limit,$limit)
            ->order('torder asc,id desc')
            ->where($where)
            ->select();
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        return json($res);
    }


    public function add(){
        $type = trim($this->request->param('type'));
        if($_POST){
            $data = $_POST;
            $data['type'] = $type;
            $add = Db::table('xcx_tags')->insertGetId($data);
            $url = $type == 1  ? 'house' : 'mate';
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
        $url = $type == 1  ? '房源标签' : '找室友标签';
        if($_POST){
            $data = $_POST;
            $add = Db::table('xcx_tags')->where(['id' =>$id])->update($data);
            $url = $type == 1  ? 'house' : 'mate';
            if($add){
                $this->success('修改成功！',$url);
            }else{
                $this->error('修改失败!',$url);
            }
        }else{
            $content = Db::table('xcx_tags')->where(['id' => $id])->find();
            $this->assign('content',$content);
            $this->assign('type',$type);
            $this->assign('url',$url);
            return $this->fetch();
        }
    }


    public function del(){
        $cl_id = intval(trim($this->request->param('id')));
        $del = Db::table('xcx_tags')
            ->where(['id' => $cl_id])->delete();
        if($del){
            $this->success('删除成功！');
        }else{
            $this->error('删除失败!');
        }
    }

}