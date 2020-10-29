<?php


namespace app\xcx\controller;


use think\Controller;
use think\Db;

class Apply extends Controller
{

    public function guide(){
        return $this->fetch();
    }

    public function add(){
        if($_POST){
            $data['title']=$_POST['title'];
            $data['content']=$_POST['content'];
            $data['images']=$_POST['images'];
            $data['type']='申请指南';
            $data['cdate']=date('Y-m-d H:i:s');
            $data['mdate']=date('Y-m-d H:i:s');
            $addBan=Db::table('tk_questions')->insert($data);
            if($addBan){
                $this->success('添加成功！','guide');
            }else{
                $this->error('添加失败!','guide');
            }
        }else{
            return $this->fetch();
        }
    }


    public function upload()
    {
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/apply');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/apply/".$path_date."/".$path_filename;
            // 成功上传后 返回上传信息
            return json(array('state'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
        }else{
            // 上传失败返回错误信息
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }

    public function edit(){
        $ba_id=$_GET['id'];
        if($_POST){
            $data['title']=$_POST['title'];
            $data['content']=$_POST['content'];
            $data['images']=$_POST['images'];
            $data['mdate']=date('Y-m-d H:i:s');
            $update=Db::table('tk_questions')->where(['id'=> $ba_id])->update($data);
            if($update){
                $this->success('修改成功！','guide');
            }else{
                $this->error('您未做任何修改！','guide');
            }
        }else{
            $banInfo=Db::table('tk_questions')
                ->where(['id'=> $ba_id])
                ->find();
            $this->assign('apply',$banInfo);
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
}