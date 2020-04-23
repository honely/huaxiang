<?php
namespace app\xcx\model;
use app\api\controller\Mailer;
use think\Db;
use think\Model;
class Reports extends Model
{
    public function addReport($uId,$mid,$content,$type,$userName,$title){
        $types = $type == 1 ? '找室友举报' : '房源举报';
        $data['user_id'] = $uId;
        $data['p_id'] = $mid;
        $data['user_name'] = $userName;
        $data['content'] = $content;
        $data['type'] = $types;
        $data['title'] = $title;
        $data['status'] = 0;
        $data['cdate'] = date('Y-m-d H:i:s');
        $addHouse = Db::table('tk_report')->insertGetId($data);
        //举报完成发送邮件
        //根据mid和帖子类型 查询帖子的编号
        $bid = $this->getBid($type,$mid);
        $mailer = new Mailer();
        $mailer->mailto($bid,$types,$content);
        return $addHouse ? $addHouse :  0;
    }

    public function getBid($type,$mid){
        if($type == 1){
            $Bid = Db::table('tk_roommates')->where(['id' => $mid])->field('dsn')->find();
        }else{
            $Bid = Db::table('tk_houses')->where(['id' => $mid])->field('dsn')->find();
        }
        return $Bid['dsn'];
    }

}