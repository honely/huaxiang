<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:90:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\admin\role.html";i:1592898544;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
    #pages .layui-laypage-prev {
        padding: 0 12px;
    }
    #pages .layui-laypage-next{
        padding: 0 12px;
    }
    #pages .layui-laypage a{
        border:none;
    }
    #pages .layui-laypage-curr{
        padding: 0 11px;
        height: 24px;
        line-height: 24px;
    }
    #pages .layui-laypage input{
        padding: 0 11px;
        height: 26px;
        line-height: 26px;
    }
    #pages .layui-laypage input, .layui-laypage button{
        padding: 0 11px;
        height: 26px;
        line-height: 26px;
    }
    #pages .layui-laypage select{
        height: 18px;
    }
</style>
<div style="margin: 20px;">
<span class="layui-breadcrumb" lay-separator=">">
    <a>员工管理</a>
    <a><cite>角色列表</cite></a>
</span>
    <div style="float:right;">
        <?php if($addable == true): ?>
        <button class="layui-btn layui-btn-primary layui-btn-sm"  onclick="addAdmin()"><i class="layui-icon"></i>新增角色</button>
        <?php endif; ?>
    </div>
</div>
<hr/>
<div class="layui-tab">
    <table lay-skin="line" class="layui-table" lay-filter="parse-table-demo" style="padding: 10px;text-align: left;border: 1px;solid-color: #28282c">
                    <thead>
                    <tr>
                        <td style="padding-left: 30px;">编号</td>
                        <td>角色名称</td>
                        <td>人数统计（人）</td>
                        <td  style="text-align: right;padding-right: 50px;">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($role == null): ?>
                    <tr><td colspan="4">暂无内容</td></tr>
                    <?php endif; if(is_array($role) || $role instanceof \think\Collection || $role instanceof \think\Paginator): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$na): $mod = ($i % 2 );++$i;?>
                    <tr>
                        <td style="padding-left: 30px;"><?php echo $na['r_bid']; ?></td>
                        <td><?php echo $na['r_name']; ?></td>
                        <td><?php echo $na['countNum']; ?></td>
                        <td style="text-align: right;padding-right: 30px;">
                            <?php if($editable == true): ?>
                            <button class="layui-btn layui-btn-xs" onclick="editRole(<?php echo $na['r_id']; ?>)"><i class="layui-icon">&#xe642;</i>编辑</button>
                            <?php endif; if($delable == true): ?>
                            <button class="layui-btn layui-btn-disabled layui-btn-xs" onclick="delRole(<?php echo $na['r_id']; ?>)"><i class="layui-icon">&#xe640;</i>删除</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
    <div id="pages" style="text-align: left;padding: 7px;"></div>
</div>
<script>
    layui.use(['form','laypage','layer'], function(){
        var form = layui.form,
            laypage = layui.laypage,
            layer = layui.layer;
        laypage.render({
            elem: 'pages'
            ,count: <?php echo $count; ?>
            ,limit: <?php echo $limit; ?>
            ,curr: <?php echo $page; ?>
            ,limits: [50]
            ,prev:'<i class="layui-icon">&#xe603;</i>'
            ,next:'<i class="layui-icon">&#xe602;</i>'
            ,layout: ['prev', 'page', 'next', 'skip','count',  'limit']
            ,jump: function(obj,frist){
                if(!frist){
                    window.location.href="<?=url('admin/role')?>?page="+obj.curr+"&limit="+obj.limit;
                }
            }
        });
        //监听指定开关
        form.on('switch(switchTest)', function(data){
            layer.msg('开关checked：'+ (this.checked ? 'true' : 'false'), {
                offset: '6px'
            });
            layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
        });
    });
    //删除管理员
    function delRole() {
        layer.msg('默认角色禁止删除',{
            time: 2000
        });
//        layer.confirm('确定删除这个角色？删除后不可恢复！', {
//            btn : [ '确定', '取消' ]
//        }, function() {
//            layer.msg('您已删除此角色', {icon: 1});
//            window.location.href='<?=url("admin/delrole")?>?r_id='+ r_id ;
//        },function(){
//            layer.msg('您已取消该操作！',{
//                time: 2000
//            });
//        });
    }
</script>
<script type="text/javascript">
    function addAdmin(){
        window.location.href='<?=url('admin/addRole')?>';
    }
    function editRole(r_id){
        // if(r_id == 1){
        //     layer.msg('超级管理员禁止修改',{
        //         time: 2000
        //     });
        // }else{
            window.location.href='<?=url("admin/editrole")?>?r_id='+ r_id ;
        // }
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