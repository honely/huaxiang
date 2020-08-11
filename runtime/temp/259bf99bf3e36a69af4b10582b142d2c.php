<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:90:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\corp\admin.html";i:1596610968;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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

<style>
    .layui-form-onswitch i {
        left: 78px;
        background-color: #fff;
    }
    .layui-form-switch {
        width: 90px;
    }
    .layui-form-switch em {
        width: 70px;
    }
</style>
<div style="margin: 20px;">
    <span class="layui-breadcrumb" lay-separator=">">
        <a><?php echo $lable['gongsiguanli']; ?></a>
        <a><cite><?php echo $lable['yuangongguanli']; ?></cite></a>
    </span>
    <div style="float:right;">
        <?php if($addable == true): ?>
        <button class="layui-btn layui-btn-primary layui-btn-sm"  onclick="addAdmin()"><i class="layui-icon"></i><?php echo $lable['tianjiayuangong']; ?></button>
        <?php endif; ?>
    </div>
</div>
<hr/>
<section class="panel panel-padding" style="padding-top: 10px;padding-left: 10px;">
    <form class="layui-form layui-form-pane1">
        <div class="layui-form-item  demoTable">
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <input type="text" name="keywords" id="keywords"  placeholder="<?php echo $lable['nameorid']; ?>" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <span class="layui-btn" data-type="reload"><?php echo $lable['search']; ?></span>
                    <a href="<?=url('corp/admin')?>" class="layui-btn layui-btn-warm"><?php echo $lable['fresh']; ?></a>
                </div>
            </div>
        </div>
    </form>
</section>
<section class="panel panel-padding">
    <table lay-skin="line" class="layui-table" lay-filter="demo" lay-data="{height: 'full-120', cellMinWidth:80, url:'/xcx/corp/adminData/', limit:50,limits:[50] ,id: 'testReload',page:true}" >
            <thead>
            <tr>
                <th lay-data="{field:'ad_id'}">ID</th>
                <th lay-data="{field:'ad_realname'}"><?php echo $lable['yuangongxm']; ?></th>
                <th lay-data="{field:'ad_roles'}"><?php echo $lable['juese']; ?></th>
                <th lay-data="{field:'ad_email'}"><?php echo $lable['youxiang']; ?></th>
                <th lay-data="{field:'adWechat'}"><?php echo $lable['conwechat']; ?></th>
                <th lay-data="{field:'ad_phone'}"><?php echo $lable['phone']; ?></th>
                <th lay-data="{field:'ad_corp'}"><?php echo $lable['company']; ?></th>
                <th lay-data="{field:'ad_job'}"><?php echo $lable['position']; ?></th>
                <?php if($offable == true): ?>
                <th lay-data="{field:'ad_isable',width:145,templet: '#switchTpl', unresize: true}"><?php echo $lable['status']; ?></th>
                <?php endif; ?>
                <th lay-data="{field:'ad_createtime'}"><?php echo $lable['addtime']; ?></th>
                <th lay-data="{align:'center',width:320, toolbar: '#barDemo'}"><?php echo $lable['caozuo']; ?></th>
            </tr>
            </thead>
        </table>
</section>

<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="details"><?php echo $lable['detail']; ?></a>
    <?php if($editable == true): ?>
    {{#  if(d.ad_role == 44){ }}
    <a class="layui-btn layui-btn-xs" lay-event="edit"><?php echo $lable['edit']; ?></a>
    {{#  } }}
    <?php endif; if($connectable == true): ?>
    {{#  if(d.ad_role == 44){ }}
    <a class="layui-btn layui-btn-xs" lay-event="connect"><?php echo $lable['connect']; ?></a>
    {{#  } }}
    <?php endif; if($delable == true): ?>
    {{#  if(d.ad_role == 44){ }}
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><?php echo $lable['delete']; ?></a>
    {{#  } }}
    <?php endif; ?>
</script>
<script type="text/html" id="switchTpl">
    <input type="checkbox" name="sex" lay-skin="switch" value="{{d.ad_id}}" lay-text="<?php echo $lable['zaizhi']; ?>|<?php echo $lable['lizhi']; ?>" lay-filter="sexDemo" {{ d.ad_isable == 1 ? 'checked' : '' }}>
</script>
<script>
    layui.use(['table','laydate','form'], function(){
        var table = layui.table
            ,form = layui.form;
        table.on('tool(demo)', function(obj){
            var data = obj.data;
            var ad_id = data.ad_id;
            if(obj.event === 'edit'){
                window.location.href='<?=url("corp/edita")?>?ad_id='+ ad_id ;
            }else if(obj.event === 'details'){
                layer.open({
                    type: 2,
                    title: '<?php echo $lable['detail']; ?>',
                    shadeClose: true,
                    shade: false,
                    maxmin: true,
                    area: ['80%', '80%'],
                    content: "<?=url('corp/detaila')?>?ad_id="+ad_id
                });
            }else if(obj.event === 'connect'){
                layer.open({
                    type: 2,
                    title: '绑定用户',
                    shadeClose: true,
                    shade: false,
                    maxmin: true,
                    area: ['80%', '80%'],
                    content: "<?=url('admin/fenpei')?>?ad_id="+ad_id
                });
            }else if(obj.event === 'dels'){
                layer.msg('超级管理员禁止删除！',{
                    time: 2000
                });
            }else if(obj.event === 'dels'){
                layer.msg('超级管理员禁止删除！',{
                    time: 2000
                });
            } else if(obj.event === 'del'){
                var ad_id = data.ad_id;
                layer.confirm('<?php echo $lable['deleteConfirm']; ?>！', {
                    btn : [ '<?php echo $lable['sure']; ?>', '<?php echo $lable['cancel']; ?>']//按钮
                }, function() {
                    $.ajax({
                        'type':"get",
                        'url':"<?=url('admin/del')?>",
                        'data':{ad_id:ad_id},
                        'success':function (result) {
                            if(result.code < 1){
                                layer.msg(result.msg);
                            }else {
                                layer.msg(result.msg);
                                layer.open({
                                    title: '<?php echo $lable['deleteSuc']; ?>'
                                    ,content: result.msg
                                    ,yes: function(index){
                                        layer.close(index);
                                        window.location.href='<?=url("corp/admin")?>';
                                    }
                                    ,cancel:function (index) {
                                        layer.close(index);
                                        window.location.href='<?=url("corp/admin")?>';
                                    }
                                });
                            }
                        },
                        'error':function () {
                            console.log('error');
                        }
                    })
                },function(){
                    layer.msg('<?php echo $lable['quxiaocaozuo']; ?>！',{
                        time: 2000
                    });
                });
            }
        });
        //监听是否开启操作
        form.on('switch(sexDemo)', function(obj){
            var id = this.value;
            //如果选中状态是true,后台数据将要改为显示
            var change = obj.elem.checked;
            if(change){
                change = 1;
            }else{
                change = 0;
            }
            $.ajax({
                type: 'POST',
                url: "<?=url('admin/status')?>?ad_id="+id+ "&change="+change,
                dataType:  'json',
                success: function(data){
                    console.log(data);
                    layer.msg(data.msg);
                }
            });
        });

        var $ = layui.$, active = {
            reload: function(){
                var keywords = $('#keywords').val();
                var ad_role = $('#ad_role').val();
                //执行重载
                table.reload('testReload', {
                    url: '/xcx/admin/adminData/'
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,where: {
                        keywords: keywords,
                        ad_role: ad_role
                    },
                    success:function (data) {
                        console.log(data);
                    }
                });
            }

        };
        $('.demoTable .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
    function sysQuery(ad_isable){
        var keywords = $('#keywords').val();
        var ad_role = $('#ad_role').val();
        //执行重载
        layui.use(['table','jquery'], function(){
            var table = layui.table;
            table.reload('testReload', {
                url: '/xcx/admin/adminData/'
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    keywords: keywords,
                    ad_isable: ad_isable,
                    ad_role: ad_role
                },
                success:function (data) {
                    console.log(data);
                }
            });
            $.ajax({
                type:'post',
                url:'/xcx/admin/admin',
                data:{'keywords':keywords,'ad_role':ad_role},
                success:function (data) {
                    console.log(data);
                    $('.all').html(data.all);
                    $('.display').html(data.display);
                    $('.none').html(data.none);
                },
                error:function (data) {
                    console.log(data)
                }
            })
        })
    }
</script>
<script type="text/javascript">
    function addAdmin(){
        window.location.href="<?=url('corp/adda')?>";
    }
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