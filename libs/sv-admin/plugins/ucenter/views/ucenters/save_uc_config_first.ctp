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
<?php echo $form->create('ucenters',array('action'=>'/save_uc_config_first/','name'=>'theForm'));?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<br />
<div class="home_main" id="guides_1">
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	<?=$html->image('tab_left.gif',array('class'=>'left'))?>
	<?=$html->image('tab_right.gif',array('class'=>'right'))?>
	会员数据导入到 UCenter</h1></div>
	<div class="box">
	<div class="shop_config menus_configs guides" style="width:500px;">
	<br />
	

	<dl><dt>会员合并方式</dt>
	<dd>
		<input type="radio" name="merge" value="1" checked />将与UC用户名和密码相同的用户强制为同一用户
		<br />
		<input type="radio" name="merge" value="2" />将与UC用户名和密码相同的用户不导入UC用户
	</dd></dl>
	<p id="ECS_NOTICE"></p>
	</div>
	</div>
	<p class="submit_btn"><input type="button" value="开始导入" onclick="import_start(this)" /></p>
	</div>
</div>
<? echo $form->end();?>
<script type="text/javascript">
function import_start(obj)
{
  	var frm = document.forms['theForm'];
  	var merge = -1;
  	for (var i=0; i<frm.elements['merge'].length; i++)
  	{
    	if (frm.elements['merge'][i].checked)
    	{
      		merge = frm.elements['merge'][i].value;
    	}
  	}

  	var notice = document.getElementById('ECS_NOTICE');
  	notice.innerHTML = "正在导入用户到UCenter中...";
  	YAHOO.example.container.wait.show();
  //	obj.disabled 	= 	true;
    var postData	=	'start=0&merge=' + merge;
	var sUrl		=	webroot_dir+"ucenter/ucenters/import_user/";
	var request 	= 	YAHOO.util.Connect.asyncRequest('POST', sUrl, checkResponse_callback,postData);
}
var checkResponse_Success = function(o){
	
	try{   
		var result = YAHOO.lang.JSON.parse(o.responseText);   
	}catch (e){   
		alert("Invalid data");  
		alert(o.responseText); 
		YAHOO.example.container.wait.hide();
	}
	
  	if (result.error > 0)
  	{
    	alert(result.message);
  	}
  	
  	if (result.error == 0)
  	{
    	var notice = document.getElementById('ECS_NOTICE');
    	notice.innerHTML = result.message;
    	window.setTimeout(function ()
    	{
        	location.href='complete';
    	}, 1000);
  	}
}

var checkResponse_Failure = function(o){
	alert("error");
	YAHOO.example.container.wait.hide();
}
var checkResponse_callback ={
	success:checkResponse_Success,
	failure:checkResponse_Failure,
	timeout : 30000,
	argument: {}
};






function checkResponse(result)
{

}
</script>
