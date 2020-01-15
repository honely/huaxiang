<?php
/**
 * Created by PhpStorm.
 * User: Dangmengmeng
 * Date: 2019/12/11
 * Time: 10:22
 */


namespace app\home\controller;


use think\Controller;
use think\Db;

class My extends Controller
{

    /***
     * Notes：个人中心
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Author: Created by Dang Mengmeng At 2019/12/11 10:25
     */
    public function index(){
        $u_id = trim($this->request->param('u_id','0','intval'));
        $userInfo = Db::table('web_user')
            ->where(['u_id' => $u_id])
            ->field('u_id,u_nickname,u_avatar')
            ->find();
        $this->assign('user',$userInfo);
        $this->assign('u_id',$u_id);
        return $this->fetch();
    }
}