<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Index extends Controller{
    public function index(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
        $where = $keywords ? " art_title like '%".$keywords."%'" :' 1 =1';
        $discount = Db::table('wechat_article')->where(['art_type' => 1])->select();
        $recommend = Db::table('wechat_article')
            ->where(['art_type' => 2])
            ->where($where)
            ->select();
        $rent = Db::table('wechat_article')
            ->where($where)
            ->where(['art_type' => 3])->select();
        $life = Db::table('wechat_article')
            ->where($where)
            ->where(['art_type' => 4])->select();
        $cusInfo = [
            'discount' => $discount,
            'rec' => $recommend,
            'rent' => $rent,
            'keywords' => $keywords,
            'discount' => $discount,
            'life' => $life,
            'where' => $where,
        ];
        $res['code'] = 1;
        $res['msg'] = "获取成功！";
        $res['data'] = $cusInfo;
        return json($res);
    }


    /***
     *Names:客户预约方法
     * @return \think\response\Json
     *Created by Dang Mengmeng at 2019/11/20 11:18
     */
    public function addnew(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $phone = trim($this->request->param('phone'));
        $data['fu_phone'] = $phone;
        $data['fu_addtime'] = time();
        $addNew = Db::table('crm_form_user')->insert($data);
        if($addNew){
            $res['code'] =1;
            $res['msg'] ='提交成功！';
            return json($res);
        }else{
            $res['code'] =2;
            $res['msg'] ='提交失败';
            return json($res);
        }
    }

    public function hello(){
        $asd = Db::connect('db2')->table('tk_ad')->where(['id' => 17])->find();
        dump($asd);
    }
}