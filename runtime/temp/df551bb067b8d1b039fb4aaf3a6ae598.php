<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:88:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\corp\add.html";i:1598852961;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
    .one-pan{
        position: relative;
    }
    .one{
        position: absolute;
        left:300px;
        top:0;
    }
</style>
<div class="layui-body">
    <div style="margin: 20px;">
    <span class="layui-breadcrumb" lay-separator=">">
        <a><?php echo $lable['gongsiguanli']; ?></a>
        <a href="<?=url('corp/index')?>"><?php echo $lable['gongsiliebiao']; ?></a>
        <a><cite><?php echo $lable['tianjia']; ?></cite></a>
    </span>
        <div style="float:right;">
            <a href="<?=url('corp/index')?>" class="layui-btn layui-btn-primary layui-btn-sm">
                <i class="layui-icon layui-icon-return"></i>
                <?php echo $lable['back']; ?></a>
        </div>
    </div>
    <hr/>
    <div class="layui-tab">
        <div class="layui-tab-content">
            <!--基本信息-->
            <div class="layui-tab-item layui-show">
                <div style="margin: 10px">
                    <div style="padding: 15px;">
                        <form class="layui-form" action="<?=url('corp/add')?>" method="post">
                            <div class="layui-form-item">
                                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['gongsimingcheng']; ?></label>
                                <div class="layui-input-block">
                                    <input type="text" name="cp_name" lay-verify="required|title" placeholder="<?php echo $lable['pleaseInput']; ?>" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><span style="color: red;">*</span>ABN</label>
                                <div class="layui-input-block">
                                    <input type="text" name="cp_identity" lay-verify="required|title" placeholder="<?php echo $lable['pleaseInput']; ?>" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['address']; ?></label>
                                <div class="layui-input-inline" id="input" style="width: 550px;">
                                    <input type="text" id="end" autocomplete="off" class="layui-input" placeholder="<?php echo $lable['houseAddP']; ?>">
                                    <input type="text" name="cp_address" id="address" style="display: none" readonly class="layui-input" lay-verify="required|addresss"  placeholder="目的地取值">
                                    <input type="hidden" name="x" id="x" lay-verify="addres" autocomplete="off" class="layui-input" >
                                    <input type="hidden" name="y" id="y" lay-verify="addres" autocomplete="off" class="layui-input" >
                                </div>
                                <div class="layui-input-inline" style="width: 550px;">
                                    <span id="resetAdd" class="layui-btn">重置地址</span>
                                </div>
                                <div class="layui-form-mid layui-word-aux" style="margin-left: 110px;color: red !important;"><?php echo $lable['selectAddNot']; ?></div>
                            </div>
                            <div class="layui-form-item one-pan">
                                <label class="layui-form-label"><span style="color: red;">*</span>Logo</label>
                                <div class="layui-upload-drag" id="uploadLogo" style="display:inline-block;">
                                    <image id="logoPre">
                                        <input type="hidden" lay-verify="imgReg" name="cp_logo" id="cp_logo" value=""/>
                                    </image>
                                    <div id="display">
                                        <i class="layui-icon"></i>
                                        <p><?php echo $lable['shangchuan']; ?></p>
                                    </div>
                                </div>
                                <div class="one">
                                    <div class="layui-form-mid layui-word-aux" style="margin-left: 39px; "><?php echo $lable['tupianRemark']; ?></div>
                                </div>
                            </div>
                             <div class="layui-form-item one-pan">
                                <label class="layui-form-label"><span style="color: red;">*</span>miniLogo</label>
                                <div class="layui-upload-drag" id="uploadLogom" style="display:inline-block;">
                                    <image id="logoPrem">
                                        <input type="hidden" lay-verify="imgReg" name="minilogo" id="minilogo" value=""/>
                                    </image>
                                    <div id="display">
                                        <i class="layui-icon"></i>
                                        <p><?php echo $lable['shangchuan']; ?></p>
                                    </div>
                                </div>
                                <div class="one">
                                    <div class="layui-form-mid layui-word-aux" style="margin-left: 39px; "><?php echo $lable['tupianRemark']; ?></div>
                                </div>
                            </div>
                            <div class="layui-form-item one-pan">
                                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['beijingtu']; ?></label>
                                <div class="layui-upload-drag" id="uploadImg" style="display:inline-block;">
                                    <image id="imgPre">
                                        <input type="hidden" lay-verify="imgReg" name="backimg" id="backimg" value=""/>
                                    </image>
                                    <div id="displays">
                                        <i class="layui-icon"></i>
                                        <p><?php echo $lable['shangchuan']; ?></p>
                                    </div>
                                </div>
                                <div class="one">
                                    <div class="layui-form-mid layui-word-aux" style="margin-left: 39px; "><?php echo $lable['tupianRemark']; ?></div>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['qianduancolor']; ?></label>
                                <div class="layui-input-block">
                                    <input type="radio" name="colour" value="1" title="<?php echo $lable['qianse']; ?>" checked>
                                    <input type="radio" name="colour" value="2" title="<?php echo $lable['shense']; ?>">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['youxiang']; ?></label>
                                <div class="layui-input-block">
                                    <input type="text" name="cp_email" lay-verify="required|title" placeholder="<?php echo $lable['pleaseInput']; ?>" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['dianhua']; ?></label>
                                <div class="layui-input-block">
                                    <input type="text" name="cp_tel" lay-verify="required|title" placeholder="<?php echo $lable['pleaseInput']; ?>" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item layui-form-text">
                                <label class="layui-form-label"><?php echo $lable['desc']; ?></label>
                                <div class="layui-input-block">
                                    <textarea placeholder="<?php echo $lable['pleaseInput']; ?>" maxlength="500" name="cp_desc" class="layui-textarea"></textarea>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" lay-submit lay-filter="saveInfo"><?php echo $lable['fabu']; ?></button>
                                    <a class="layui-btn layui-btn-primary" href="<?=url('corp/index')?>"><?php echo $lable['back']; ?></a>
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
    $('#resetAdd').click(function () {
        //清空经纬度的赋值
        $('#end').show();
        $('#address').hide();
        $('#x').val('');
        $('#y').val('');
    });
    layui.link('/layui/src/autocomplete/autocomplete.css');
    layui.config({
        base: '/layui/src/autocomplete/'
        , version: false,
        debug: false,
    });
    layui.use(['form', 'jquery','upload','autocomplete','element'], function(){
        var form = layui.form
            ,upload = layui.upload
            ,autocomplete = layui.autocomplete
            ,element = layui.element
            ,$ = layui.jquery;
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
        autocomplete.render({
            elem: $('#end'),
            response: {code: 'code', data: 'suggestions'},
            template_val: '{{d.label}}',
            template_txt: '{{d.label}}',
            onselect: function (resp) {
                console.log(resp);
                var address = resp.label;
                $('#address').val(address);
                $('#end').hide();
                $('#address').show();
                locationAD(address);
            }
        });
        let APP_ID_HERE = "QuHxU6ypXzp37Dci84o8";
        let APP_CODE_HERE = "TDu_enlm0QIblRnIl33buw";
        function locationAD(query) {
            $.getJSON("https://geocoder.api.here.com/6.2/geocode.json?gen=9&searchtext=" + query + "&app_id=" + APP_ID_HERE + "&app_code=" + APP_CODE_HERE, function (data) {
                console.log(data);
                var lati = data["Response"]["View"][0]["Result"][0]["Location"]["DisplayPosition"]["Latitude"];
                var longi = data["Response"]["View"][0]["Result"][0]["Location"]["DisplayPosition"]["Longitude"];
                $('#x').val(lati);
                $('#y').val(longi);
            });

        }
        upload.render({
            elem: '#uploadLogo'
            ,url: '<?php echo url("xcx/corp/upload"); ?>'
            ,exts: 'PNG|JPG'
            ,size: '30000'
            ,done: function(res){
                layer.close(layer.msg());//关闭上传提示窗口
                if(res.status == 0) {
                    return layer.msg(res.message);
                }
                $('#uploadLogo').removeClass('layui-upload-drag');
                $('#logoPre').css('width','216px');
                $('#logoPre').css('height','150px');
                $('#logoPre').attr('src',"../../../"+res.path);
                console.log(res);
                $('#cp_logo').val('' +res.path + '');
            }
        }); 
         upload.render({
            elem: '#uploadLogom'
            ,url: '<?php echo url("xcx/corp/upload"); ?>'
            ,exts: 'PNG|JPG'
            ,size: '30000'
            ,done: function(res){
                layer.close(layer.msg());//关闭上传提示窗口
                if(res.status == 0) {
                    return layer.msg(res.message);
                }
                $('#uploadLogo').removeClass('layui-upload-drag');
                $('#logoPrem').css('width','216px');
                $('#logoPrem').css('height','150px');
                $('#logoPrem').attr('src',"../../../"+res.path);
                console.log(res);
                $('#minilogo').val('' +res.path + '');
            }
        }); 
        upload.render({
            elem: '#uploadImg'
            ,url: '<?php echo url("xcx/corp/upload"); ?>'
            ,exts: 'PNG|JPG'
            ,size: '30000'
            ,done: function(res){
                layer.close(layer.msg());//关闭上传提示窗口
                if(res.status == 0) {
                    return layer.msg(res.message);
                }
                $('#uploadImg').removeClass('layui-upload-drag');
                $('#imgPre').css('width','216px');
                $('#imgPre').css('height','150px');
                $('#imgPre').attr('src',"../../../"+res.path);
                console.log(res);
                $('#backimg').val('' +res.path + '');
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