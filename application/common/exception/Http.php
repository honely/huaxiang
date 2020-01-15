<?php
namespace app\common\exception;
use think\exception\Handle;
class Http extends Handle
{

    public function render(\Exception $e){
        if(config('app_debug')){
            //如果开启debug则正常报错
            return parent::render($e);
        }else{
            //重定向页面
            header("Location:".url('index/common/index'));
        }
    }

}