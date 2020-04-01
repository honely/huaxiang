<?php


namespace app\xcx\controller;


use app\extend\Imgcompress;
use think\Controller;
use think\Request;

/**
 * 分享请保持网址。尊重别人劳动成果。谢谢。
 * 图片压缩类：通过缩放来压缩。如果要保持源图比例，把参数$percent保持为1即可。
 * 即使原比例压缩，也可大幅度缩小。数码相机4M图片。也可以缩为700KB左右。如果缩小比例，则体积会更小。
 * 结果：可保存、可直接显示。
 */
class Imgcomp extends Controller
{
    public function index() {
        import('Imgcompress', EXTEND_PATH);
        if($this->request->isPost()){
            $res['code'] = 1;
            $res['msg'] = '上传成功！';
            $file = $this->request->file('file');
            $info = $file->move(ROOT_PATH . 'public' . DS . '/upload/xcx');
            if($info){
                $res['name'] = $info->getFilename();
                $res['file'] = '/upload/xcx/'.$info->getSaveName();
                $source = ROOT_PATH . 'public' . DS . '/upload/xcx/' . $info->getSaveName();
                $dst_img = ROOT_PATH . 'public' . DS . '/uploads/xcx/test.png';
                $percent = 1;
                $image = (new Imgcompress($source, $percent))->compressImg($dst_img);
            }
        }
    }

}
