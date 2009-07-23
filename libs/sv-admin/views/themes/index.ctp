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
 * $Id: index.ctp 3251 2009-07-23 03:39:24Z huangbo $
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
				$s_type =  explode(".",$style[2]);
				$s_type[0] = $curr_template['template_style'];
				$style[2] = implode(".",$s_type);
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
		<?//pr($curr_template);?>
		<?if(isset($curr_template['style']) && sizeof($curr_template['style'])>0){?>
			<div style="display:none">
				<?if(isset($curr_template['template_style']) && $curr_template['template_style'] == ""){?>
					<?php echo $html->image("green_over.gif")?>
				<?}else{?>
					<?	  	if(isset($curr_template['template_style']) && $curr_template['template_style'] != ""){
				  	  		$arr = explode(".",$curr_template['screenshot']);
				  	  		$arr[2].="";
				  	  		$this_template_img = implode(".",$arr);?>					
				  	  			<span onMouseOver="javascript:onSOver('<?=$server_host.$cart_webroot.$this_template_img?>');" onMouseOut="onSOut('<?=$server_host.$cart_webroot.$curr_template_img?>');"><a href="javascript:select_style('');"><?php echo $html->image("green.gif")?></a></span>
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
				  	  	<span onMouseOver="javascript:onSOver('<?=$server_host.$cart_webroot.$this_template_img?>');" onMouseOut="onSOut('<?=$server_host.$cart_webroot.$curr_template_img?>');"><a href="javascript:select_style('<?=$val?>');"><?=$html->image($val.'.gif',array("title"=>$val));?></a></span>
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
			function onSOver(img){
	//			alert(img);
				document.getElementById('theme_img').src = img
			}
			function onSOut(img){
				document.getElementById('theme_img').src = img
			}	
	</script>
	
	<div class="order_stat properies" >
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  可用模板</h1></div>
	  <div class="box themes_box">
	    <?php if(isset($available_templates) && sizeof($available_templates)>0){?>
	    <?php foreach($available_templates as $k=>$themed){?>

	  <div class="themes_show">
	  <p class="name"><?php if(isset($themed['name']))echo $html->link($themed['name'],$themed['uri'],'',false,false)."&nbsp;&nbsp;&nbsp;&nbsp;".$html->link("卸载","javascript:;",array("onclick"=>"deletethemed('{$themed['code']}')"),false,false)."&nbsp;&nbsp;&nbsp;&nbsp;"; if(isset($themed['flag'])&& $themed['flag']=="1")echo "是否可用： ".$html->link($html->image('yes.gif'),"javascript:;",array("onclick"=>"currencythemed('{$themed['code']}','no')"),false,false)."&nbsp;&nbsp;&nbsp;&nbsp;".$html->link("默认","javascript:;",array("onclick"=>"use_theme('{$themed['code']}')"),false,false); if(isset($themed['flag'])&& $themed['flag']=="" )echo "是否可用： ".$html->link($html->image('no.gif'),"javascript:;",array("onclick"=>"currencythemed('{$themed['code']}','yes')"),false,false);?> </p>
	  
	  
	  
	  <p class="picture"><?php if(isset($themed['screenshot'])&& $themed['flag']=="1"){echo $html->link($html->image($server_host.$root_all.$themed['screenshot'],array("width"=>"190")),"javascript:;",array("onclick"=>"use_theme('{$themed['code']}')"),false,false); }else if(isset($themed['screenshot'])){echo "<img src='../$themed[screenshot]' width='190' alt='' />";}?></p>
	  <p><?php if(isset($themed['desc']))echo $themed['desc'];?></p> 
	</div>
		<?php }}?>

	  </div>
	</div>
	
<!--Product Photos End-->
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  可选模板</h1></div>
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
	
	function select_style(template_style){
		YAHOO.example.container.wait.show(); 
		var sUrl = webroot_dir+"themes/select_style/";
		var postData = "template_style="+template_style;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, select_style_callback,postData);
	}
	
	var select_style_Success = function(o){
		YAHOO.example.container.wait.hide();
		window.location.reload();
	}	
	
	var select_style_Failure = function(o){
		alert("error");
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