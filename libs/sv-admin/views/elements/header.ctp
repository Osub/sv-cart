<?php
/*****************************************************************************
 * SV-Cart 头部
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: header.ctp 1852 2009-05-27 11:04:35Z huangbo $
*****************************************************************************/
?>
<div id="header">
	<div class="tools">
	<?=$html->image('tools_left.gif',array('class'=>'left'))?>
	<?=$html->image('tools_right.gif',array('class'=>'right'))?>
	<p class="logo"><?=$html->image('logo.gif')?></p>
	<p class="toolsbar"><span><b><?if(isset($Operator_Name)){echo $Operator_Name;}else{ echo $operatorLogin['Operator']['name'];}?></b></span><span>您上一次登录时间: <?if(isset($Operator_Longin_Date)){ echo $Operator_Longin_Date;}else{echo $operatorLogin['Operator']['last_login_time'];}?></span><span>您的IP地址：<?if(isset($Operator_Ip)){ echo $Operator_Ip;}else{ echo $operatorLogin['Operator']['last_login_ip'];}?></span>|<span><?=$html->link("SV-Cart首页","/../",array("target"=>"_blank"),false,false);?></span>|<span><?=$html->link("管理首页","/",'',false,false);?></span>|<span><?=$html->link("SV-Cart官网","http://www.seevia.cn",array("target"=>"_blank"),false,false);?></span>|<span><?=$html->link("修改登陆密码","javascript:;",array("onclick"=>"amend_password()"),false,false);?></span>|<span><?=$html->link($html->image('icon01.gif',array('align'=>'absmiddle','style'=>"margin:-2px 2px 0 0;*margin:0 2px 0 0;")).'退出',"/log_out",'',false,false)?></span></p>
	</div>
<!--menu start-->

<div id="topmenu" class="svcarmenubar svcartmenubarnav" style='width:100%;'>
<div class="bd">
	<ul class="first-of-type main_nav">
	<?php 
	$Operator_menu=$this->requestAction("commons/operator_menus/");
	if(isset($Operator_menu)&& sizeof($Operator_menu)>0){
				 foreach($Operator_menu as $key=>$v){
				 $id="id=\"Operator_menu_$key\"";
				  ?>
<li class="svcartmenubaritem first-of-type">
    <? if(isset($v['Operator_menu'])&& !empty($v['Operator_menu'])){?>
	<a class="svcartmenubaritemlabel"><?=$v['Operator_menu']['name']?></a>
	<?php //echo $html->link("{$v['Operator_menu']['name']}","",array("class"=>"svcartmenubaritemlabel"),false,false);?>
	<?}?>
	<div <?php echo $id;?> class="svcartmenu">
         <?php if(isset($v['SubMenu'])&&  !empty($v['SubMenu'])){?>
          <div class="bd">
             <ul>
        <?if(isset($v['SubMenu']) && sizeof($v['SubMenu'])>0){?>
        <?php foreach($v['SubMenu'] as $k=>$val){?>
        <li class="svcartmenuitem">
        <?php echo $html->link("{$val['Operator_menu']['name']}","{$val['Operator_menu']['link']}",array("class"=>"svcartmenuitemlabel"),false,false);?> 

        </li>
         <?php }?>
         <?}?>
      </ul>
      </div>
         <p style='margin-top:0;'><?=$html->image('menu_bottom.gif')?></p>
     <?php }?>
         
     </div>
	</li>
<?php }}?>
	</ul>
</div>
</div>
<!--menu End-->	
</div>
<!--对话框-->
<div id="amend_password" style="display:none">	
<div id="loginout" >
	<h1><b>修改当前管理员密码</b></h1>
	
	<div class="order_stat athe_infos tongxun" >
	<div id="pwd_text">
	<div id="buyshop_box">
		<p class="login-alettr" style="border:0;padding-bottom:15px;">管理员:<b><?if(isset($Operator_Name)){echo $Operator_Name;}else{ echo $operatorLogin['Operator']['name'];}?></b></p>
		 <dl><dt><b class="green_2">旧密码:</b></dt><dd><input class="text_input" type="password" id="old_pwd" /></dd></dl>
		 <dl><dt><b class="green_2">新密码:</b></dt><dd><input class="text_input" type="password" id="new_pwd" /></dd></dl>
		 <dl><dt><b class="green_2">确认密码:</b></dt><dd><input class="text_input" type="password" id="new_pwd_confirm" /></dd></dl>
		 <dl><dt><b class="green_2"></b></dt><dd><span id="pwd_information"></span></dd></dl>

 		<br />
		<p class="buy_btn mar"><?=$html->link("关闭","javascript:password_big_panel.hide();");?>
		<?=$html->link("确定","javascript:;",array("onclick"=>"confirm_password();"));?></p>
	</div></div>
		<div id="pwd_confirm" style="display:none">
		<div id="buyshop_box">
		<p class="login-alettr" style="border:0;padding-bottom:15px;"><b>密码修改成功!</b></p>
		<br />
		<p class="buy_btn" style="padding-right:170px;"><?=$html->link("确定","javascript:password_big_panel.hide();");?></p>
		</div></div>
		
	<p><?=$html->image("loginout-bottom.png");?></p>
	</div>
</div>	
</div>
<script type="text/javascript">
	//修改密码确认
	function confirm_password(){
		var old_pwd = document.getElementById('old_pwd');
		var new_pwd = document.getElementById('new_pwd');
		var new_pwd_confirm = document.getElementById('new_pwd_confirm');
		
		var pwd_information = document.getElementById('pwd_information');
		if(new_pwd.value!=new_pwd_confirm.value&&new_pwd_confirm.value!=""){
			pwd_information.innerHTML = "两次密码输入不一样";
			return false;
		}else{
			pwd_information.innerHTML = "";
		}
		if(old_pwd.value!=""&&new_pwd.value==""){
			pwd_information.innerHTML = "新密码不能为空";
			return false;
		}
		if(old_pwd.value!=""&&new_pwd_confirm.value==""){
			pwd_information.innerHTML = "新密码不能为空";
			return false;
		}
		
		var sUrl = webroot_dir+"operators/ajax_amend_now_pwd/"+old_pwd.value+"/"+new_pwd.value;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, confirm_password_callback);
		

	}

	var confirm_password_Success = function(o){
		var new_pwd = document.getElementById('new_pwd');
		var new_pwd_confirm = document.getElementById('new_pwd_confirm');
		var pwd_information = document.getElementById('pwd_information');
		var old_pwd = document.getElementById('old_pwd');
		if(o.responseText==0){
			old_pwd.value="";
			new_pwd.value="";
			new_pwd_confirm.value="";
			pwd_information.innerHTML = "密码输入错误!"
			
		}else{
			pwd_information.innerHTML = "";
			old_pwd.value="";
			new_pwd.value="";
			new_pwd_confirm.value="";
			document.getElementById('pwd_confirm').style.display = "block";
			document.getElementById('pwd_text').style.display = "none";
		}
	}
	
	var confirm_password_Failure = function(o){
		//alert("error");
	}

	var confirm_password_callback ={
		success:confirm_password_Success,
		failure:confirm_password_Failure,
		timeout : 10000,
		argument: {}
	};
	//修改密码对话框
	function amend_password(){
		document.getElementById('amend_password').style.display = "block";
		document.getElementById('pwd_text').style.display = "block";
		document.getElementById('pwd_confirm').style.display = "none";
		password_big_panel.show();
	}
	//遮罩层JS
	function initPage_password(){
		tabView = new YAHOO.widget.TabView('contextPane'); 
        password_big_panel = new YAHOO.widget.Panel("amend_password", 
							{
								visible:false,
								draggable:false,
								modal:true,
								style:"margin 0 auto",
								fixedcenter: true
							} 
						); 
		password_big_panel.render();
	}
	initPage_password();
</script>