<?php


namespace app\api\controller;


use think\Controller;
use think\Db;
use think\Exception;

class Trmaterial extends Controller
{

    /**
     * 获取自己的材料列表
     */
    public function mylist()
    {
        $uid = trim($this->request->param('uid'));
        $data = Db::table('tk_rmaterial')
            ->field('a.id,b.name,a.url')
            ->alias('a')
            ->join('tk_rmaterial_type b','a.type_id = b.id','left')
            ->where(['a.user_id' => $uid])
            ->order('a.updatetime', 'desc')
            ->select();
        if (empty($data)) {
            $res['code'] = 0;
            $res['msg'] = '数据为空';
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '获取成功';
        $res['data'] = $data;
        return json($res);
    }

    /**
     * 获取材料列表
     */
    public function getlist()
    {
        $data = Db::table('tk_rmaterial_type')
            ->field('id,name,score,type')
            ->select();

        $res['code'] = 1;
        $res['msg'] = '获取成功';
        $res['data'] = $data;
        return json($res);
    }

    /**
     * 添加我的材料
     */
    public function add()
    {

        if ($this->request->isPost()) {
            $uid = $this->request->request('uid');
            $type_id = $this->request->request('type_id');
            $Material = Db::table('tk_rmaterial_type')
                ->where(['id' => $type_id])
                ->find();
            if (empty($Material)) {
                $res['code'] = 0;
                $res['msg'] = 'Wrong material type !';
                return json($res);
            }
            if(!$this->request->file('file')){
                $res['code'] = 0;
                $res['msg'] = '请选择材料文件 !';
                return json($res);
            }
            $file = $this->request->file('file');
            $info = $file->move(ROOT_PATH . 'public' . DS . '/upload/xcx/' . $Material['file_dir']);
            if (!$info) {
                $res['code'] = 0;
                $res['msg'] = '上传失败！';
                return $res;
            }
            $file_url = '/upload/xcx/' . $Material['file_dir'] . '/' . $info->getSaveName();
            $data = [
                'user_id' => $uid,
                'type_id' => $type_id,
                'url' => $file_url,
                'createtime' => time(),
                'updatetime' => time(),
            ];

            try {
                $myMaterial = Db::table('tk_rmaterial')
                    ->where(['user_id' => $uid, 'type_id' => $type_id])
                    ->find();
                if (empty($myMaterial)) {
                    Db::name('tk_rmaterial')->insertGetId($data);
                } else {
                    Db::name('tk_rmaterial')->where('id', $myMaterial['id'])->update($data);
                }

                $res['code'] = 1;
                $res['msg'] = '上传成功';
                $res['data']['material'] = Db::table('tk_rmaterial')
                    ->alias('a')
                    ->join('tk_rmaterial_type b', 'a.type_id = b.id', 'left')
                    ->where(['user_id' => $uid])
                    ->sum('b.score');

                return json($res);
            } catch (Exception $e) {
                Db::rollback();
                $res['code'] = 0;
                $res['msg'] = '上传失败！';
                return $res;
            }
        }
    }
}