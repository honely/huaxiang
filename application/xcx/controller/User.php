<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/4/18
 * Time: 14:02
 */
namespace app\xcx\controller;
use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

class User extends Controller{
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
    public function details(){
        $cus_id=intval($_GET['id']);
        //获取客户信息；
        $cusInfo=Db::table('tk_user')->where(['id' => $cus_id])->find();
        //收藏记录
        $collect=Db::table('xcx_collect')
            ->where(['cl_user_id' => $cus_id])
            ->order('cl_addtime desc')
            ->select();
        //浏览记录
        $view=Db::table('xcx_view_history')
            ->where(['vh_userid' => $cus_id])
            ->select();
        //发布房源
        $house = Db::table('tk_houses')
            ->where(['user_id' => $cus_id])
            ->select();
        //发布找室友
        $mate = Db::table('tk_roommates')
            ->where(['user_id' => $cus_id])
            ->select();
        //搜索记录
        $querys = Db::table('xcx_search_keywords')
            ->where(['sk_userid' => $cus_id])
            ->select();
//        dump($cusInfo);
//        dump($house);
//        dump($collect);
//        dump($view);
//        dump($mate);
//        dump($querys);exit;
        $this->assign('house',$house);
        $this->assign('collect',$collect);
        $this->assign('view',$view);
        $this->assign('mate',$mate);
        $this->assign('querys',$querys);
        $this->assign('cus',$cusInfo);
        return $this->fetch();
    }

    //彻底删除某一用户
    public function absdelete(){
        $cus_id=intval($_GET['cus_id']);
        $abs=Db::table('super_customer')
            ->where(['cus_id' => $cus_id ,'cus_isdelete' => '2'])
            ->delete();
        if($abs){
            $this->success('删除成功','back');
        }else{
            $this->error('删除失败','back');
        }
    }



    public function index(){
        return $this->fetch();
    }


    public function userData(){
        $where ='1 = 1 ';
        $keywords = trim($this->request->param('keywords'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( id like '%".$keywords."%' or nickname like '%".$keywords."%')";
        }
        $count=Db::table('tk_user')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $example=Db::table('tk_user')->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('cdate desc')
            ->select();
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $example;
        $res['count'] = $count;
        return json($res);
    }
}