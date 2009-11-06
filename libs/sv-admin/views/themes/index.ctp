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
 * $Id: index.ctp 5209 2009-10-20 08:40:13Z huangbo $
*****************************************************************************/
?>
<div class="content" >
<?php echo $this->element('ur_here',array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<div class="home_main" id="all_tmp" >



<!--Product Photos-->
	<div class="order_stat properies"  >
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  当前模板</h1></div>
	  
	  <div class="box themes_backup" >
	  <p class="picture">
	  	 <?
	  	  $curr_template_img = $curr_template['screenshot'];
	  	  if(isset($curr_template['template_style']) && $curr_template['template_style'] != ""){
				$style = explode("_",$curr_template['screenshot']);
				$s_type =  explode(".",$style[(sizeof($style)-1)]);
				$s_type[0] = $curr_template['template_style'];
				$style[(sizeof($style)-1)] = implode(".",$s_type);
				$curr_template_img = implode("_",$style);	  	  		
	  	  }
	  	  ?>
	  	 
		<?php echo @$html->image($server_host.$root_all.$curr_template_img,array('height'=>'190','id'=>'theme_img'))?>
	</p>
		<ul class="bak_haddle">
		<li><?php if(isset($curr_template['name']))echo $curr_template['name'];?> &nbsp;<?php if(isset($curr_template['version']))echo $curr_template['version'];?></li>		
		<li><?php if(isset($curr_template['author']))echo $html->link($curr_template['author'],$curr_template['author_uri'],'',false,false);?></li>
		<li><?php if(isset($curr_template['desc']))echo $curr_template['desc']?></li> 	
		<li>
	
		<?if(isset($curr_template['style']) && sizeof($curr_template['style'])>0){?>
			<div style="display:none">
				<?if(isset($curr_template['template_style']) && $curr_template['template_style'] == ""){?>
					<?php echo $html->image("green_over.gif")?>
				<?}else{?>
					<? if(isset($curr_template['template_style']) && $curr_template['template_style'] != ""){
				  	  		$arr = explode(".",$curr_template['screenshot']);
				  	  		$arr[2].="";
				  	  		$this_template_img = implode(".",$arr);?>					
				  	  			<span onMouseOver="javascript:onSOver('theme_img','<?=$server_host.$this_template_img?>');" onMouseOut="onSOut('theme_img','<?=$server_host.$curr_template_img?>');"><a href="javascript:select_style('');"><?php echo $html->image("green.gif")?></a></span>
					<?
				  	  }?>						
						
				<?}?>
					</div>
			<?foreach($curr_template['style'] as $key=>$val){?>
				
				<?if($val != ""){?>
				<?if(isset($curr_template['template_style']) && $curr_template['template_style'] == $val){?>
					<?=$html->image($val.'_over.gif',array("title"=>$val));?>
				<?}else{?>
					<?	  	if(isset($curr_template['template_style']) ){
				$style = explode("_",$curr_template['screenshot']);
				$s_type =  explode(".",$style[2]);
				$s_type[0] = $val;
				$style[2] = implode(".",$s_type);						
				  	  		$this_template_img = implode("_",$style);					

				  	  	?>	
				  	  	<span onMouseOver="javascript:onSOver('theme_img','<?=$server_host.$this_template_img?>');" onMouseOut="onSOut('theme_img','<?=$server_host.$curr_template_img?>');"><a href="javascript:select_style('<?php echo $curr_template['name'];?>','<?=$val?>');"><?=$html->image($val.'.gif',array("title"=>$val));?></a></span>
<?	
				  	  }?>
						
				<?}?><?}?>
				&nbsp;
			<?}?>
		<?}?>
		</li>
		</ul>
	  </div>
	</div>
	<script>
			function onSOver(theme_img,img){

				document.getElementById(theme_img).src = img
			}
			function onSOut(theme_img,img){
				document.getElementById(theme_img).src = img
			}	
	</script>
<ul class="tab">
	<li class="hover" id="tabs1" onclick="overtab('tabs',1,3)"><span>可用模板</span></li>
	<li class="normal" id="tabs2" onclick="overtab('tabs',2,3)"><span>可选模板</span></li>
	<li class="normal" id="tabs3" onclick="overtab('tabs',3,3)"><span>收费模板</span></li>
</ul>
<!--可用模板-->
<div id="con_tabs_1" class="display">
	<div class="order_stat properies">
	  <div class="box themes_box">
	    <?php if(isset($available_templates) && sizeof($available_templates)>0){?>
	    <?php foreach($available_templates as $k=>$themed){?>

	  <div class="themes_show">
	  <p class="name"><?php if(isset($themed['name']))echo $html->link($themed['name'],$themed['uri'],'',false,false)."&nbsp;&nbsp;&nbsp;&nbsp;".$html->link("卸载","javascript:;",array("onclick"=>"deletethemed('{$themed['code']}')"),false,false)."&nbsp;&nbsp;&nbsp;&nbsp;"; if(isset($themed['flag'])&& $themed['flag']=="1")echo "是否可用： ".$html->link($html->image('yes.gif'),"javascript:;",array("onclick"=>"currencythemed('{$themed['code']}','no')"),false,false)."&nbsp;&nbsp;&nbsp;&nbsp;".$html->link("默认","javascript:;",array("onclick"=>"use_theme('{$themed['code']}')"),false,false); if(isset($themed['flag'])&& $themed['flag']=="" )echo "是否可用： ".$html->link($html->image('no.gif'),"javascript:;",array("onclick"=>"currencythemed('{$themed['code']}','yes')"),false,false);?> </p>
	  
	  
	  
	  <p class="picture"><?php if(isset($themed['screenshot'])&& $themed['flag']=="1"){echo $html->link($html->image($server_host.$root_all.$themed['screenshot'],array("width"=>"190","id"=>"{$themed['name']}")),"javascript:;",array("onclick"=>"use_theme('{$themed['code']}')"),false,false); }else if(isset($themed['screenshot'])){echo "<img src='../$themed[screenshot]' width='190' alt='' />";}?></p>
	  <p><?php if(isset($themed['desc']))echo $themed['desc'];?></p> 
	  <p><?if(isset($themed['style']) && sizeof($themed['style'])>0){?>
			<?foreach($themed['style'] as $key=>$val){?>
			<?	  
				$style = explode("_",$themed['screenshot']);
				$s_type =  explode(".",$style[2]);
				$s_type[0] = $val;
				$style[2] = implode(".",$s_type);						
				$this_template_img = implode("_",$style);					
			?><span onMouseOver="javascript:onSOver('<?php echo $themed['name'];?>','<?=$server_host.$this_template_img?>');" onMouseOut="onSOut('<?php echo $themed['name'];?>','<?=$server_host.$this_template_img?>');"><a href="javascript:select_style('<?php echo $themed['name'];?>','<?=$val?>');"><?=$html->image($val.'.gif',array("title"=>$val));?></a></span>
			&nbsp;
			<?}?>
		<?}?>
	  
	  </p> 
	</div>
		<?php }}?>
	  </div>
	</div>
	</div>
		  
<!--可选模板-->
<div id="con_tabs_2" class="none">
	<div class="order_stat properies">
	  <div class="box themes_box">
	    <?php if(isset($install_templates) && sizeof($install_templates)>0){?>
	    <?php foreach($install_templates as $k=>$themed){?>
	  <div class="themes_show">
	  <p class="name"><?php if(isset($themed['name']))echo $html->link($themed['name'],$themed['uri'],'',false,false); echo "&nbsp;&nbsp;&nbsp;&nbsp;";echo $html->link("安装","javascript:;",array("onclick"=>"installthemed('{$themed['code']}')"),false,false);?> </p>
	  <p class="picture"><?php if(isset($themed['screenshot'])){?> <?=$html->image($server_host.$root_all.$this->themeWeb.$themed['screenshot'],array("width"=>"190"))?> <?}?></p>
	  <p><?php if(isset($themed['desc']))echo $themed['desc'];?></p> 
	</div>
		<?php }}?>
	  </div>
	</div>
</div>
<!--收费模板-->
<div id="con_tabs_3" class="none">
	<div id="rss_load" class="order_stat properies">
	  
	</div>
</div>
<!--收费模板 End-->
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
				window.location.reload();

		YAHOO.example.container.wait.hide();
		
	}	
	
	var tmp_show_Failure = function(o){
	//	//alert("error");
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
	//	//alert("error");
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
		//alert("error");
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
		//alert("error");
		YAHOO.example.container.wait.hide();
	}
	var ajax_deletethemed_callback ={
		success:ajax_deletethemed_Success,
		failure:ajax_deletethemed_Failure,
		timeout : 30000,
		argument: {}
	};
	
	function select_style(theme_name,template_style){
		YAHOO.example.container.wait.show(); 
		var sUrl = webroot_dir+"themes/select_style/"+theme_name;
		var postData = "template_style="+template_style;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, select_style_callback,postData);
	}
	
	var select_style_Success = function(o){
		YAHOO.example.container.wait.hide();
		window.location.reload();
	}	
	
	var select_style_Failure = function(o){
		//alert("error");
		YAHOO.example.container.wait.hide();
	}
	var select_style_callback ={
		success:select_style_Success,
		failure:select_style_Failure,
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
		////alert("error");
		YAHOO.example.container.wait.hide();
	}
	var ajax_currencythemed_callback ={
		success:ajax_currencythemed_Success,
		failure:ajax_currencythemed_Failure,
		timeout : 30000,
		argument: {}
	};	
	function rss_load(){
		var urlimg = webroot_dir+"themes/rss_str/";
		YAHOO.util.Connect.asyncRequest('POST', urlimg, rss_load_callback);
	}
	var rss_load_img_Success = function(oResponse){
		//alert(oResponse);
		//var oResults = eval("(" + oResponse.responseText + ")");
		//alert(oResults);
		var rss_load = document.getElementById('rss_load'); 
		rss_load.innerHTML = oResponse.responseText;
		//alert(oResponse.responseText);
	}

	var rss_load_img_Failure = function(o){
		//alert("异步请求失败");
	}

	var rss_load_callback ={
		success:rss_load_img_Success,
		failure:rss_load_img_Failure,
		timeout : 3000000,
		argument: {}
	};		
	rss_load();

</script>