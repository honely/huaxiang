<?php


namespace app\xcx\model;


use think\Db;
use think\Model;

class Rolem extends Model
{

    public function getPowerList($roleIds){
        $roleArr = explode(',',$roleIds);
        $roleNames = '';
        for ($i = 0;$i < count($roleArr);$i++){
            $roleName = $this->getRole($roleArr[$i]);
            $roleNames.= $roleName.',';
        }
        $powers = rtrim($roleNames,',');
        $power_list = array_unique(explode(',',trim($powers,',')));
        return $power_list;
    }

    public function getPowerListByAdminId($adminId){
        //获取按钮权限
        $userData = Db::table("super_admin")
            ->alias('admin')
            ->where(['admin.ad_id' => $adminId])
            ->find();
        $roleArr = explode(',',$userData['ad_role']);
        $roleNames = '';
        for ($i = 0;$i < count($roleArr);$i++){
            $roleName = $this->getRole($roleArr[$i]);
            $roleNames.= $roleName.',';
        }
        $powers = rtrim($roleNames,',');
        $power_list = array_unique(explode(',',trim($powers,',')));
        return $power_list;
    }

    public function getRole($roleid){
        $roleInfo = Db::table('super_role')
            ->where(['r_id' => $roleid])
            ->field('r_power')
            ->find();
        return $roleInfo['r_power'];
    }

}