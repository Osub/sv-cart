<?php
/*****************************************************************************
 * SV-Cart 模板管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 943 2009-04-23 10:38:44Z huangbo $
*****************************************************************************/
?>
<div class="content" >
<?=$this->element('ur_here',array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<div class="home_main" id="all_tmp" >



<!--Product Photos-->
	<div class="order_stat properies"  >
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  当前模板</h1></div>
	  
	  <div class="box themes_backup" >
	  <p class="picture">
	<?=@$html->image("/../../{$curr_template['screenshot']}",array('height'=>'190'))?>
	</p>
		<ul class="bak_haddle">
		<li><?php if(isset($curr_template['name']))echo $curr_template['name'];?> &nbsp;<?php if(isset($curr_template['version']))echo $curr_template['version'];?></li>		
		<li><?php if(isset($curr_template['author']))echo $html->link($curr_template['author'],$curr_template['author_uri'],'',false,false);?></li>
		<li><?php if(isset($curr_template['desc']))echo $curr_template['desc']?></li> 		
		</ul>
	  </div>
	</div>
	
	
	<div class="order_stat properies" >
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  可用模板</h1></div>
	  <div class="box themes_box">
	    <?if(isset($available_templates) && sizeof($available_templates)>0){?>
	    <?php foreach($available_templates as $k=>$themed){?>
	  <div class="themes_show">
	  <p class="name"><?php if(isset($themed['name']))echo $html->link($themed['name'],$themed['uri'],'',false,false)."&nbsp;&nbsp;&nbsp;&nbsp;".$html->link("卸载","javascript:;",array("onclick"=>"deletethemed('{$themed['code']}')"),false,false)."&nbsp;&nbsp;&nbsp;&nbsp;"; if(isset($themed['flag'])&& $themed['flag']=="1")echo "是否可用： ".$html->link($html->image('yes.gif'),"javascript:;",array("onclick"=>"currencythemed('{$themed['code']}','no')"),false,false)."&nbsp;&nbsp;&nbsp;&nbsp;".$html->link("默认","javascript:;",array("onclick"=>"use_theme('{$themed['code']}')"),false,false); if(isset($themed['flag'])&& $themed['flag']=="" )echo "是否可用： ".$html->link($html->image('no.gif'),"javascript:;",array("onclick"=>"currencythemed('{$themed['code']}','yes')"),false,false);?> </p>
	  
	  
	  
	  <p class="picture"><?php if(isset($themed['screenshot'])&& $themed['flag']=="1"){echo $html->link($html->image('/../'.$themed['screenshot'],array("width"=>"190")),"javascript:;",array("onclick"=>"use_theme('{$themed['code']}')"),false,false); }else if(isset($themed['screenshot'])){echo "<img src='../$themed[screenshot]' width='190' alt='' />";}?></p>
	  <p><?php if(isset($themed['desc']))echo $themed['desc'];?></p> 
	</div>
		<?php }}?>

	  </div>
	</div>
	
<!--Product Photos End-->
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  可选模板</h1></div>
	  <div class="box themes_box">
	    <?if(isset($install_templates) && sizeof($install_templates)>0){?>
	    <?php foreach($install_templates as $k=>$themed){?>
	  <div class="themes_show">
	  <p class="name"><?php if(isset($themed['name']))echo $html->link($themed['name'],$themed['uri'],'',false,false); echo "&nbsp;&nbsp;&nbsp;&nbsp;";echo $html->link("安装","javascript:;",array("onclick"=>"installthemed('{$themed['code']}')"),false,false);?> </p>
	  <p class="picture"><?php if(isset($themed['screenshot'])){echo "<img src='../$themed[screenshot]' width='190' alt='' />";}?></p>
	  <p><?php if(isset($themed['desc']))echo $themed['desc'];?></p> 
	</div>
		<?php }}?>
	  </div>
	</div>

</div>
<!--Main Start End-->
</div>
<script type="text/javascript" >
	function tmp_show(){
		var sUrl = webroot_dir+"themes/tmp_show/?status=1";
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, tmp_show_callback);

	}
	var tmp_show_Success = function(o){
		document.getElementById("all_tmp").innerHTML=o.responseText;
		YAHOO.example.container.wait.hide();
	}	
	
	var tmp_show_Failure = function(o){
		alert("error");
		YAHOO.example.container.wait.hide();
	}
	var tmp_show_callback ={
		success:tmp_show_Success,
		failure:tmp_show_Failure,
		timeout : 30000,
		argument: {}
	};
	
	function use_theme(a){
		YAHOO.example.container.wait.show(); 
		var sUrl = webroot_dir+"themes/usethemed/?status=1";
		var postData = "code="+a;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, ajax_use_callback,postData);

	}
	var ajax_use_Success = function(o){
		tmp_show();
		YAHOO.example.container.wait.hide();
	}	
	
	var ajax_use_Failure = function(o){
		alert("error");
		YAHOO.example.container.wait.hide();
	}
	var ajax_use_callback ={
		success:ajax_use_Success,
		failure:ajax_use_Failure,
		timeout : 30000,
		argument: {}
	};

	function installthemed(a){
		YAHOO.example.container.wait.show(); 
		var sUrl = webroot_dir+"themes/installthemed/?status=1";
		var postData = "code="+a;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, ajax_install_callback,postData);

	}
	var ajax_install_Success = function(o){
		tmp_show();
		YAHOO.example.container.wait.hide();
	}	
	
	var ajax_install_Failure = function(o){
		alert("error");
		YAHOO.example.container.wait.hide();
	}
	var ajax_install_callback ={
		success:ajax_install_Success,
		failure:ajax_install_Failure,
		timeout : 30000,
		argument: {}
	};

	function deletethemed(a){
		YAHOO.example.container.wait.show(); 
		var sUrl = webroot_dir+"themes/deletethemed/?status=1";
		var postData = "code="+a;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, ajax_deletethemed_callback,postData);

	}
	var ajax_deletethemed_Success = function(o){
		tmp_show();
		YAHOO.example.container.wait.hide();
	}	
	
	var ajax_deletethemed_Failure = function(o){
		alert("error");
		YAHOO.example.container.wait.hide();
	}
	var ajax_deletethemed_callback ={
		success:ajax_deletethemed_Success,
		failure:ajax_deletethemed_Failure,
		timeout : 30000,
		argument: {}
	};
	
	function currencythemed(a,b){
		YAHOO.example.container.wait.show(); 
		var sUrl = webroot_dir+"themes/currencythemed/?status=1";
		var postData = "code="+a+"&flag="+b;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, ajax_currencythemed_callback,postData);

	}
	var ajax_currencythemed_Success = function(o){
		
		tmp_show();
		YAHOO.example.container.wait.hide();
	}	
	
	var ajax_currencythemed_Failure = function(o){
		alert("error");
		YAHOO.example.container.wait.hide();
	}
	var ajax_currencythemed_callback ={
		success:ajax_currencythemed_Success,
		failure:ajax_currencythemed_Failure,
		timeout : 30000,
		argument: {}
	};	
	
</script>