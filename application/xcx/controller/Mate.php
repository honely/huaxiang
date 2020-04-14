<?php


namespace app\xcx\controller;


use think\Controller;
use think\Db;

class Mate extends Controller
{
    public function index(){
        return $this->fetch();
    }

    public function indexData(){
        $where =' 1 = 1';
        $keywords = trim($this->request->param('keywords'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( title like '%".$keywords."%' or dsn like '%".$keywords."%' )";
        }
        $count=Db::table('tk_roommates')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $design=Db::table('tk_roommates')
            ->limit(($page-1)*$limit,$limit)
            ->order('id desc')
            ->where($where)
            ->select();
        if($design){
            //statuss
            foreach($design as $k => $v){
                $design[$k]['statuss'] = $v['status'] == 1 ? '已发布' :'草稿箱';
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        return json($res);
    }



    public function del(){
        $id = $this->request->param('id',22,'intval');
        $del = Db::table('tk_roommates')
            ->where(['id' => $id])
            ->delete();
        if($del){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！','index');
        }
    }


    //更改是否显示的状态
    public function status(){
        $ba_id = intval(trim($_GET['id']));
        $change = intval(trim($_GET['change']));
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '上线';
                $data['status'] = '1';
            }else{
                $msg = '下线';
                $data['status'] = '2';
            }
            $changeStatus = Db::table('tk_roommates')->where(['id' => $ba_id])->update($data);
            if($changeStatus){
                $res['code'] = 1;
                $res['msg'] = $msg.'成功！';
            }else{
                $res['code'] = 0;
                $res['msg'] = $msg.'失败！';
            }
        }else{
            $res['code'] = 0;
            $res['msg'] = '这是个意外！';
        }
        return $res;
    }

    /***
     * @param $id int  房源id
     * @return bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function greaterTop($id){
        $houseCity = Db::table('tk_roommates')
            ->where(['id' => $id])
            ->field('city')
            ->find();
        $count =Db::table('tk_roommates')
            ->where(['city' => $houseCity['city'],'top' => '是'])
            ->count();
        return $count >=5 ? false : true;
    }
    public function greaterTj($id){
        $houseCity = Db::table('tk_roommates')
            ->where(['id' => $id])
            ->field('city')
            ->find();
        $count =Db::table('tk_roommates')
            ->where(['city' => $houseCity['city'],'tj' => '是'])
            ->count();
        return $count >=10 ? false : true;
    }

}