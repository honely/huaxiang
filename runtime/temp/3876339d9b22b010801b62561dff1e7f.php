<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:91:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\inspect\add.html";i:1603248567;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
                            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                                <legend>选择你的公司的看房员</legend>
                            </fieldset>
                            <div class="layui-row layui-col-space5">
                                <div class="layui-col-md4">
                                    <div class="grid-demo grid-demo-bg1">
                                        <div class="layui-form-item">
                                            <label class="layui-form-label"><span style="color: red;">*</span>选择公司</label>
                                            <div class="layui-input-inline">
                                                <select name="hp_corp" lay-verify="required" lay-filter="aihao">
                                                    <option value="">请选择选择公司</option>
                                                    <?php if(is_array($corp) || $corp instanceof \think\Collection || $corp instanceof \think\Paginator): $i = 0; $__LIST__ = $corp;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$role): $mod = ($i % 2 );++$i;?>
                                                    <option value="<?php echo $role['cp_id']; ?>"><?php echo $role['cp_name']; ?></option>
                                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-col-md4">
                                    <div class="grid-demo">
                                        <div class="layui-form-item">
                                            <label class="layui-form-label"><span style="color: red;">*</span>选择看房员</label>
                                            <div class="layui-input-inline">
                                                <select name="hp_inspector" lay-verify="required" id="b_order">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-col-md4">
                                    <div class="grid-demo grid-demo-bg1">
                                        <div class="layui-form-item" pane>
                                            <label class="layui-form-label"><span style="color: red;">*</span>看房性质</label>
                                            <div class="layui-input-block">
                                                <input type="radio" name="hp_type"  value="1" title="公开看房" checked>
                                                <input type="radio" name="hp_type" value="2" title="私人看房">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                                <legend>房源列表</legend>
                            </fieldset>
                            <div class="layui-form" id="test">
                                <table class="layui-table">
                                    <colgroup>
                                        <col width="200">
                                        <col>
                                    </colgroup>
                                    <thead>
                                    </thead>
                                    <tbody id="houseTable">
                                    </tbody>
                                </table>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" lay-submit lay-filter="saveInfo">添加</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    layui.use(['form', 'jquery','upload'], function(){
        var form = layui.form
            ,$ = layui.jquery;
        form.on('select(aihao)', function(data){
            var cid=data.value;
            console.log(cid);
            $.ajax({
                type: 'POST',
                url: "<?=url('inspect/getAdmin')?>?cid="+cid,
                data: {cid:cid},
                dataType:  'json',
                success: function(data){
                    var admin=data.data;
                    var house=data.houses;
                    $("#b_order").html("<option value=''></option>");
                    $.each(admin, function(i, val) {
                        var option1 = $("<option>").val(val.ad_id).text(val.ad_realname);
                        $("#b_order").append(option1);
                        form.render('select');
                    });
                    $("#b_order").get(0).selectedIndex=0;
                    $("#houseTable").empty();
                    if(house.length > 0){
                        $.each(house, function(i, val) {
                            var html = "<tr>\n" +
                                "        <td><input name='hp_hid["+val.id+"]' type='checkbox' lay-skin=\"primary\" /></td>\n" +
                                "        <td>"+val.address+"</td>\n" +
                                "      </tr>";
                            $("#houseTable").append(html);
                            form.render('checkbox');
                        });
                    }else{
                        var html ="<span>暂无数据</span>";
                        $("#houseTable").append(html);
                    }

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