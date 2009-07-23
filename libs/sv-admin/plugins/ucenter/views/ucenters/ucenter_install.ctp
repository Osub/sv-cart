<?php
/*****************************************************************************
 * SV-Cart 商店设置向导
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1393 2009-05-15 07:40:52Z zhengli $
*****************************************************************************/
?>
<?php echo $form->create('ucenters',array('action'=>'/save_uc_config_first/','id'=>'theform'));?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<br />
<div class="home_main" id="guides_1">
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	<?=$html->image('tab_left.gif',array('class'=>'left'))?>
	<?=$html->image('tab_right.gif',array('class'=>'right'))?>
	设置会员数据整合插件</h1></div>
	<div class="box">
	<div class="shop_config menus_configs guides" style="width:500px;">
	<br />
	
	<dl><dt style="width:140px;">UCenter 的 URL: </dt>
	<dd><input type="text" name="uc_url" id="uc_url" style="width:200px;border:1px solid #649776"  /></dd></dl>
	<dl style="display:none"><dt style="width:140px;">UCenter 的 IP: </dt>
	<dd><input type="text" name="uc_ip" id="uc_ip" style="width:200px;border:1px solid #649776"  /></dd></dl>
	<dl><dt style="width:140px;">UCenter 创始人密码: </dt>
	<dd><input type="text" name="uc_pass" id="uc_pass" style="width:200px;border:1px solid #649776" /><span id="ucfounderpwnotice" style="color:#FF0000"></span></dd></dl>
	<input type="hidden" name="code" id="code" value="ucenter">
	<input type="hidden" name="ucconfig" id="ucconfig" value="" />

	</div>
	</div>
	<p class="submit_btn"><input type="button" value="确定" onclick="save_uc_config()" /><input type="reset" value="重置"  /></p>
	</div>
</div>
<? echo $form->end();?>
<script type="text/javascript">
function save_uc_config()
{
    var uc_url 	= 	GetId("uc_url");
    var uc_ip 	= 	GetId("uc_ip");
    var uc_pass = 	GetId("uc_pass");
    var code 	= 	GetId("code");
    YAHOO.example.container.wait.show();
    var postData=	"ucapi=" + uc_url.value + "&" + "ucip=" + uc_ip.value + "&" + "ucfounderpw=" + uc_pass.value + "&" + "code=" + code.value;
	var sUrl	=	webroot_dir+"ucenter/ucenters/setup_ucenter/";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, setup_ucenter_callback,postData);
    
}
var setup_ucenter_Success = function(o){
	try{   
		var result = YAHOO.lang.JSON.parse(o.responseText);   
	}catch (e){   
		alert("Invalid data");  
		alert(o.responseText); 
		YAHOO.example.container.wait.hide();
	} 
    if (result.error !== 0)
    {
        if (result.error == 2)
        {
            GetId("uc_ip").style.display = '';
        }
        GetId("ucfounderpwnotice").innerHTML= result.message;
        YAHOO.example.container.wait.hide();
    }
    else
    {
        GetId("ucconfig").value = result.message;
        GetId("theform").submit();
    }

}
var setup_ucenter_Failure = function(o){
	alert("error");
	YAHOO.example.container.wait.hide();
}
var setup_ucenter_callback ={
	success:setup_ucenter_Success,
	failure:setup_ucenter_Failure,
	timeout : 30000,
	argument: {}
};

</script>