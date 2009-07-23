<?php 
/*****************************************************************************
 * SV-Cart 头文件
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: header.ctp 3276 2009-07-23 09:14:17Z huangbo $
*****************************************************************************/
?>
<div id="logo"><?php echo $html->link($html->image((!empty($SVConfigs['shop_logo']))?$SVConfigs['shop_logo']:"logo.gif",array("alt"=>"SV-Cart","width"=>"192","height"=>"58")),$server_host.$cart_webroot,"",false,false);?></div>
<div class="header_right">
<!-- gears -->
<?=$javascript->link('gears_init');?>
<script>
var STORE_NAME = 'SV_Cart_Store_User'
var localServer;
var filesToCapture = [
	<?if(isset($gears_file) && sizeof($gears_file)>0){?><?foreach($gears_file as $k=>$v){?>"<? echo $v;?>"<?if((sizeof($gears_file)-1) != $k){?>,<?}?><?}?><?}?>
];
</script>

<div class="tools">
	<div class="member color_5">
	<span id="user_info">
	<?php if(isset($_SESSION['User']['User']['id'])){ ?>
	<?php echo $SCLanguages['welcome'];?><b>&nbsp;<?php echo $html->link($_SESSION['User']['User']['name'],'/',array("title"=>$SCLanguages['user_center'],"class"=>"name color_f9"));?></b>
		<font>|</font>
	<?php echo $html->link($SCLanguages['log_out'],"javascript:logout();",array("class"=>"color_4"));?>
		<?php }else{ ?>
	<a class="cursor color_4" id="login"><?php echo $SCLanguages['login'];?></a><?php if($SVConfigs['enable_registration_closed'] == 0){?>
		<font>|</font><?php echo $html->link($SCLanguages['register'],"/register/",array("class"=>"color_4"),"",false,false);?>
	<?php }?><?php }?></span><?//php echo $html->link($SCLanguages['cart'],$server_host.$cart_webroot."carts/",array("class"=>"color_4","title"=>sprintf($SCLanguages['cart_total_product'],isset($header_cart['quantity'])?$header_cart['quantity']:0).$svshow->price_format(isset($header_cart['total'])?$header_cart['total']:0,$SVConfigs['price_format'])),"",false,false);?>
	<?php if(is_array($languages) && sizeof($languages)>1){?>
	<a class="cursor color_4" id="locales"><?php echo $SCLanguages['switch_languages'];?></a>
	<?php }?>
		<?if(isset($SVConfigs['gears_setting']) && $SVConfigs['gears_setting'] == 1){?>
		<script>show_gears();</script>
		<?}?>
	</div>
	
<div id="search">
<?php echo $form->create('Product', array('action' => 'Search' ,'onsubmit'=>"return YAHOO.example.ACJson.validateForm();"));?> 
<input id="ysearchinput" type="text" name="keywords" class="enter_text" /><input type="hidden" name="type" value="S" /><span><a href="javascript:ad_search()"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'search_go_btn.png':'search_go_btn.png',array("alt"=>"GO","class"=>"go","title"=>"搜索"))?></a></span><a id="adv_search" class="cursor color_53"><?php echo $SCLanguages['advanced_search'];?></a>
<?php echo $form->end();?>
<p class="color_53 cart"><?php echo $html->link(sprintf($SCLanguages['cart_total_product'],isset($header_cart['quantity'])?"<strong>".$header_cart['quantity']."</strong>":"<strong>0</strong>")."<strong>".$svshow->price_format(isset($header_cart['total'])?$header_cart['total']:0,$SVConfigs['price_format'])."</strong>",$server_host.$cart_webroot."carts/",array("class"=>"color_4","title"=>sprintf($SCLanguages['cart_total_product'],isset($header_cart['quantity'])?$header_cart['quantity']:0).$svshow->price_format(isset($header_cart['total'])?$header_cart['total']:0,$SVConfigs['price_format'])),"",false,false);?>	
</p>
</div>
<div class="header_navs color_5"><?php if(isset($navigations_top) && sizeof($navigations_top)>0){
foreach($navigations_top as $k=> $navigation){?>
<?php if($k !=0){?>|<?php }?><span class="nav"><?php if($navigation['NavigationI18n']['url']!="" && $navigation['NavigationI18n']['name'] !="") echo $html->link($navigation['NavigationI18n']['name'],$server_host.substr($cart_webroot,0,-1).$navigation['NavigationI18n']['url'],array("class"=>"color_f9","target" =>$navigation['Navigation']['target']));
	else echo $html->link("Seevia","http://www.seevia.cn",array("class"=>"color_f9"));?></span><?php }}?>
</div>

</div>

</div>