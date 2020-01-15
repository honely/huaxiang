<?php
namespace app\home\controller;
use think\Controller;
use think\Db;

class House extends Controller
{

    /***
     *Names:房源添加或修改方法
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     *Created by Dang Mengmeng at 2019/11/22 17:58
     */
    public function editHouse(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $data = $_POST;
        $id = $this->request->param('id','0','intval');
        if($id > 0){
            //修改
            $data['mdate'] = date('Y-m-d H:i:s');
            $update = Db::table('tk_houses')->where(['id' => $id])->update($data);
            if($update){
                $mail = new Mailer();
                $mails =  $mail->mailto();
                return json(['code' => 1,'msg'=>'修改成功','id' => $id]);
            }else{
                return json(['code' => 0,'msg'=>'修改失败']);
            }
        }else{
            //添加
            $dsn = $this->getHouseDsn();
            $data['dsn'] = $dsn;
            $data['cdate'] = date('Y-m-d H:i:s');
            $data['mdate'] = date('Y-m-d H:i:s');
            $insert = Db::table('tk_houses')->insertGetId($data);
            if($insert){
                $mail = new Mailer();
                $mails =  $mail->mailto();
                return json(['code' => 1,'msg'=>'添加成功','id' => $insert]);
            }else{
                return json(['code' => 0,'msg'=>'添加失败']);
            }
        }
    }


    /***
     * 房源编号生成；小程序端生成的房源编号是A开头，找室友的帖子是B开头
     * @return string
     * @throws \think\Exception
     * Created by Dangmengmeng At 2020/1/2 10:35
     */
    public function getHouseDsn()
    {
        // 找室友编号开始为B
        $dsn = 'C';
        $max = Db::connect('db2')->table('tk_houses')->max('id');
        $s = '';
        for ($i = 1; $i < 10 - strlen($max); $i++) {
            $s .= '0';
        }
        $max++;
        $dsn .= $s.$max;
        return $dsn;
    }

    /***
     *Names:我的房源方法
     * $page 页码
     * $status  发布状态 1：已发布；2：下线；3待审核；4。审核不通过；5草稿箱
     * $userId  用户id
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/11/22 17:42
     */
    public function myHouse(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $page = $this->request->param('page','1','intval');
        $userId = $this->request->param('userId','1','intval');
        $limit = $this->request->param('limit','10','intval');
        $houses = Db::table('tk_houses')
            ->where(['user_id' => $userId])
            ->where('status != 2')
            ->limit(($page-1)*$limit,$limit)
            ->select();
        $count = Db::table('tk_houses')
            ->where(['user_id' => $userId])
            ->where('status != 2')
            ->field('id')
            ->count();
        if($houses){
            foreach ($houses as $k => $v){
                $houses[$k]['status'] = $this->houseStatus($v['status']);
            }
            return json(['code' => 1,'msg'=>'读取成功','count' => $count,'data' => $houses]);
        }else{
            return json(['code' => 0,'msg'=>'读取失败','data' => null]);
        }
    }


    /***
     * 发布状态 1：已发布；2：下线；3待审核；4。审核不通过；5草稿箱
     * @param $status
     * @return string
     * dangmengmeng 2019年12月5日10:34:15
     */
    public function houseStatus($status){
        switch ($status)
        {
            case 1:
                $type = '已发布';
                break;
            case 2:
                $type = '下线';
                break;
            case 3:
                $type = '待审核';
                break;
            case 4:
                $type = '审核被拒';
                break;
            case 5:
                $type = '草稿箱';
                break;
            default:
                $type = '---';
        }
        return $type;
    }

    /***
     *Names:房源详情
     * $id  房源id
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/11/22 17:44
     */
    public function houseDetail(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id = $this->request->param('id','1','intval');
        $house = Db::table('tk_houses')->where(['id' => $id])->find();
        if($house){
            return json(['code' => 1,'msg'=>'读取成功','data' => $house]);
        }else{
            return json(['code' => 0,'msg'=>'读取失败','data' => null]);
        }
    }


    /***
     * 网站端房源图片上传，通用这个一个接口
     * @return \think\response\Json
     * Dangmengmeng 2019年12月5日09:42:24
     */
    public function upload()
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $path_date=date("Ym",time());
        if($this->request->isPost()){
            $file = $this->request->file('file');
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/house/'.$path_date.'/');
            if($info){
                $path = 'uploads/house/'.$path_date.'/'.$info->getSaveName();
                return json(array('state'=>1,'filepath'=>$path,'msg'=> '图片上传成功！'));
            }else{
                return json(array('state'=>0,'filepath'=>'','msg'=> '图片上传失败！'));
            }
        }
    }
}
