<?php
namespace app\home\controller;
use think\Controller;
use think\Db;

class User extends Controller
{

    public function addPhone(){
        $id = trim($this->request->param('id'));
        $phone = trim($this->request->param('phone'));
        $isPhone = Db::table('web_user')
            ->where(['u_id' => $id,'u_phone' => $phone])
            ->find();
        if($isPhone){
            $code = 0;
            $msg = '手机号已绑定';
        }else{
            $addPhone = Db::table('web_user')
                ->where(['u_id' => $id])
                ->update(['u_phone' => $phone]);
            if($addPhone){
                $code = 1;
                $msg = '手机号绑定成功！';
            }else{
                $code = 2;
                $msg = '手机号绑定失败！';
            }
        }

        $res['code'] = $code;
        $res['msg'] = $msg;
        return json($res);
    }
}