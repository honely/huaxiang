<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:92:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\user\details.html";i:1595984305;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="../../../layui/src/css/layui.css">
    <script src="../../../static/jquery-1.10.2.min.js"></script>
    <script src="../../../layui/src/layui.js"></script>
</head>
<form class="layui-form" action="" id="cusInfo" method="post">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>用户信息</legend>
    </fieldset>
    <div class="layui-form-item" style="margin:50px">
        <div class="layui-form-item">
        <div class="layui-form-mid layui-word-aux">id: <?php echo $cus['id']; ?></div>
        </div>
        <div class="layui-form-item">
        <div class="layui-form-mid layui-word-aux">昵称: <?php echo $cus['nickname']; ?></div>
        </div>
        <div class="layui-form-item">
        <div class="layui-form-mid layui-word-aux">图像:
            <img style="width: 60px;height: 60px;" src="<?php echo $cus['avaurl']; ?>" alt="<?php echo $cus['nickname']; ?>">
        </div>
        </div>
        <div class="layui-form-item">
        <div class="layui-form-mid layui-word-aux">性别:<?php echo $cus['sex']; ?></div>
        </div>
        <div class="layui-form-item">
            <div class="layui-form-mid layui-word-aux">微信:<?php echo $cus['wchat']; ?></div>
        </div>
      <div class="layui-form-item">
            <div class="layui-form-mid layui-word-aux">电话:<?php echo $cus['tel']; ?></div>
        </div>
        <div class="layui-form-item">
        <div class="layui-form-mid layui-word-aux">生日:<?php echo $cus['birth']; ?></div>
        </div>
        <div class="layui-form-item">
        <div class="layui-form-mid layui-word-aux">邮箱:<?php echo $cus['email']; ?></div>
        </div>
        <div class="layui-form-item">
        <div class="layui-form-mid layui-word-aux">注册日期：<?php echo $cus['cdate']; ?></div>
        </div>
        <div class="layui-form-item">
        <div class="layui-form-mid layui-word-aux">上次登录：<?php echo $cus['mdate']; ?></div>
        </div>
    </div>
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>用户行为分析</legend>
    </fieldset>
    <div class="layui-form-item" style="margin: 50px">
        <?php if($collect != null): ?>
        <div class="layui-inline">
            <label class="layui-form-label">用户收藏</label>
            <table class="layui-table" lay-size="sm">
                <tr>
                    <th>id</th>
                    <th>房源/找室友编号</th>
                    <th>收藏类型</th>
                    <th>收藏时间</th>
<!--                    <th>操作</th>-->
                </tr>
                <?php if(is_array($collect) || $collect instanceof \think\Collection || $collect instanceof \think\Paginator): $i = 0; $__LIST__ = $collect;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <tr>
                        <td><?php echo $vo['cl_id']; ?></td>
                        <td><?php echo $vo['cl_house_id']; ?></td>
                        <td><?php echo $vo['cl_type']=='1'?'房源' : '找室友'; ?></td>
                        <td><?php echo $vo['cl_addtime']; ?></td>
<!--                        <td>-->
<!--                            <span class="layui-btn layui-btn-xs">详情</span>-->
<!--                        </td>-->
                    </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
        </div>
        <?php endif; if($view != null): ?>
        <div class="layui-inline">
            <label class="layui-form-label">用户浏览</label>
            <table class="layui-table" lay-size="sm">
                <tr>
                    <th>id</th>
                    <th>房源/找室友编号</th>
                    <th>浏览类型</th>
                    <th>浏览时间</th>
<!--                    <th>操作</th>-->
                </tr>
                <?php if(is_array($view) || $view instanceof \think\Collection || $view instanceof \think\Paginator): $i = 0; $__LIST__ = $view;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $vo['vh_id']; ?></td>
                    <td><?php echo $vo['vh_house_id']; ?></td>
                    <td><?php echo $vo['vh_type']=='1'?'房源' : '找室友'; ?></td>
                    <td><?php echo $vo['vh_add_time']; ?></td>
<!--                    <td>-->
<!--                        <span class="layui-btn layui-btn-xs">详情</span>-->
<!--                    </td>-->
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
        </div>
        <?php endif; if($querys != null): ?>
        <div class="layui-inline">
            <label class="layui-form-label">用户搜索</label>
            <table class="layui-table" lay-size="sm">
                <tr>
                    <th>id</th>
                    <th>搜索关键词</th>
                    <th>搜索类型</th>
                    <th>搜索时间</th>
                </tr>
                <?php if(is_array($querys) || $querys instanceof \think\Collection || $querys instanceof \think\Paginator): $i = 0; $__LIST__ = $querys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $vo['sk_id']; ?></td>
                    <td><?php echo $vo['sk_keywords']; ?></td>
                    <td><?php echo $vo['sk_type']=='1'?'房源' : '找室友'; ?></td>
                    <td><?php echo $vo['sk_addtime']; ?></td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
</form>
</html>
<script>
    layui.use(['form', 'laydate','layer', 'jquery'], function(){
        var form = layui.form
            ,laydate = layui.laydate
            ,layer=layui.layer
            ,$ = layui.jquery;

        //日期
        laydate.render({
            elem: '#date'
        });
        //自定义验证规则
        form.verify({
            title: function(value){
                if(value.length < 2){
                    return '标题至少得2个字符啊';
                }
            }
            ,pass: [/(.+){6,12}$/, '密码必须6到12位']
            ,content: function(value){
                layedit.sync(editIndex);
            }
        });
        form.on('select(cus_provid)', function(data){
            var p_id=data.value;
            $.ajax({
                type: 'POST',
                url: "<?=url('user/getCityName')?>?p_id="+p_id,
                data: {p_id:p_id},
                dataType:  'json',
                success: function(data){
                    var code=data.data;
                    $("#cityName").html("<option value=''>请选择市</option>");
                    $.each(code, function(i, val) {
                        var option1 = $("<option>").val(val.c_id).text(val.c_name);
                        $("#cityName").append(option1);
                        form.render('select');
                    });
                    $("#cityName").get(0).selectedIndex=0;
                }
            });
        });
        //ajax提交表单数据
        form.on('submit(editCus)', function(data){
            $.ajax({
                'type':"post",
                'url':"<?=url('user/editUser')?>?cus_id=",
                'data':$("#cusInfo").serialize(),
                'success':function (result) {
                   if(result.code == '1'){
                       var index=parent.layer.getFrameIndex(window.name);
                       parent.layer.close(index);
                       window.parent.location.reload();
                   }
                },
                'error':function (error) {
                    console.log(error);
                }
            })
        });
    });
</script>