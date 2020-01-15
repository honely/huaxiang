<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Rec extends Controller
{

    public function user(){
        if($_POST){
            $data = $_POST;
            if(!$data['fu_phone'] || !$data['fu_user_name'] || !$data['fu_user_wechat']){
                $this->error('请填写完成再提交！');
            }
            $data['type'] = 2;
            $data['fu_addtime'] = time();
            $insert = Db::table('crm_form_user')->insert($data);
            if($insert){
                $this->success('提交成功');
            }else{
                $this->error('提交失败');
            }
        }else{
            return $this->fetch();
        }

    }
}