<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:97:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\inspect\emailrent.html";i:1603712709;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
<!DOCTYPE html>
<html style="height: 100%">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <title>小宝经纪人平台</title>
    <link rel="stylesheet" href="../../../layui/src/css/layui.css">
    <script src="../../../static/jquery-1.10.2.min.js"></script>
    <script src="../../../layui/src/layui.js"></script>
	<style>
		.layui-body{
			left:0!important
		}
	</style>
</head>
<body class="layui-layout-body" style="height: 100%">

<div class="layui-body">
    <div class="layui-tab">
        <div class="layui-tab-content">
            <div style="padding: 15px;">
                <form class="layui-form" id="emailForm">
                    <div style="margin: 10px">
                        <fieldset class="layui-elem-field layui-field-title">
                            <legend>看房参与者</legend>
                        </fieldset>
                        <div class="layui-form" id="test">
                            <table class="layui-table">
                                <thead>
                                </thead>
                                <tbody>
                                <?php if($renter != null): if(is_array($renter) || $renter instanceof \think\Collection || $renter instanceof \think\Paginator): $i = 0; $__LIST__ = $renter;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <tr>
                                    <td><input name="pu_user[<?php echo $vo['pu_email']; ?>]" type='checkbox' lay-skin="primary" /></td>
                                    <td><?php echo $vo['pu_username']; ?></td>
                                    <td><?php echo $vo['pu_phone']; ?></td>
                                    <td><?php echo $vo['pu_email']; ?></td>
                                </tr>
                                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">邮件主题</label>
                        <div class="layui-input-block">
                            <input type="text" class="layui-input" name="emailsubject" id="pu_username" placeholder="请输入邮件主题" />
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">正文</label>
                        <div class="layui-input-block">
                            <textarea name="emailcontent" placeholder="请输入邮件内容" class="layui-textarea"></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <span class="layui-btn" onclick="closeAlls()">发送</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function closeAlls(){
        $.ajax({
            type: 'post',
            url: "<?=url('inspect/emailrenter')?>",
            data:$("#emailForm").serialize(),
            dataType:  'json',
            success: function(data){
                layer.msg(data.msg,{
                    time: 2000
                },function () {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    parent.location.reload();
                });
            }
        });
    }
    layui.use(['form', 'jquery','upload'], function(){
        var form = layui.form
            ,$ = layui.jquery;
        form.on('select(u_phone)', function(data){
            var cid=data.value;
            console.log(cid);
            $.ajax({
                type: 'POST',
                url: "<?=url('inspect/getUser')?>?id="+cid,
                data: {cid:cid},
                dataType:  'json',
                success: function(data){
                    console.log(data);
                    var user = data.data;
                    $('#pu_username').val(user.u_name);
                    $('#pu_email').val(user.u_email);
                    $('#pu_uid').val(user.u_id);
                }
            });
        });
        //自定义验证规则
        form.verify({
            title: function(value){
                if(value.length < 2){
                    return '至少得2个字符啊';
                }
            }
            ,imgReg:function (value) {
                if(value.length <= 0){
                    return '请上传图片';
                }
            }
        });
    });
</script>
</div>
<script>
    //JavaScript代码区域
    layui.use('element', function(){
        var element = layui.element;

    });
</script>
</body>
</html>