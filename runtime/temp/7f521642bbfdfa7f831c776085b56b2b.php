<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:95:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\inspect\addrent.html";i:1603451112;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
            <!--基本信息-->
            <div class="layui-tab-item layui-show">
                <div style="margin: 10px">
                    <div style="padding: 15px;">
                        <form class="layui-form" action="<?=url('inspect/insertdata')?>" method="post">
                            <div class="layui-form-item">
                                <label class="layui-form-label">地址</label>
                                <div class="layui-input-block">
                                    <input type="text" readonly class="layui-input" value="<?php echo $address; ?>"/>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-inline">
                                    <label class="layui-form-label">手机号</label>
                                    <div class="layui-input-inline">
                                        <select name="u_phone" id="u_phone" lay-verify="required" lay-search="" lay-filter="u_phone">
                                            <option value="">请输入选择手机号</option>
                                            <?php if(is_array($users) || $users instanceof \think\Collection || $users instanceof \think\Paginator): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$role): $mod = ($i % 2 );++$i;?>
                                            <option value="<?php echo $role['u_id']; ?>"><?php echo $role['u_phone']; ?></option>
                                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">姓名</label>
                                <div class="layui-input-block">
                                    <input type="text" class="layui-input"  name="pu_username" id="pu_username"/>
                                    <input type="hidden" class="layui-input"  name="pu_uid" id="pu_uid"/>
                                    <input type="hidden" class="layui-input"  name="pu_phone" id="pu_phone"/>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">电子邮件</label>
                                <div class="layui-input-block">
                                    <input type="text" class="layui-input"  name="pu_email" id="pu_email"/>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <span class="layui-btn" onclick="closeAlls()">提交</span>
                                </div>
                            </div>
                        </form>
                    </div>
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
                                    <td><?php echo $vo['pu_username']; ?></td>
                                    <td><?php echo $vo['pu_phone']; ?></td>
                                    <td><?php echo $vo['pu_email']; ?></td>
                                    <td>
                                        <span data-id="<?php echo $vo['pu_id']; ?>" class="layui-btn layui-btn-warm layui-btn-xs" onclick="delRenter(<?php echo $vo['pu_id']; ?>)">删除</span>
                                    </td>
                                </tr>
                                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function delRenter(puid) {
        $.ajax({
            type: 'post',
            url: "<?=url('inspect/delrent')?>?id="+puid,
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
    function closeAlls(){
        var pu_username = $('#pu_username').val();
        var pu_email = $('#pu_email').val();
        var pu_uid = $('#pu_uid').val();
        $.ajax({
            type: 'post',
            url: "<?=url('inspect/addrent')?>?id=<?php echo $id; ?>",
            data:{'pu_username':pu_username,'pu_hid':pu_username,'pu_email':pu_email,'pu_uid':pu_uid,'id':<?php echo $id; ?>,'hp_hid':<?php echo $hp_hid; ?>},
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