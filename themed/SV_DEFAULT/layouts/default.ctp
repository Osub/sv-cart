<?php 
/*****************************************************************************
 * SV-Cart 模板
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: default.ctp 3225 2009-07-22 10:59:01Z huangbo $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?>
<meta name="Author" content="上海实玮网络科技有限公司" />
<meta name="description" content="<?php if(isset($meta_description)){echo $meta_description;} ?>" />
<meta name="keywords" content="<?php if(isset($meta_keywords)){echo $meta_keywords;} ?>" />
<title><?php echo $title_for_layout; ?> - Powered by Seevia</title>
<?php echo $html->meta('icon');

$lang_css = isset($_SESSION['Config']['locale']) ? $_SESSION['Config']['locale']:'chi';
$style_css = (isset($template_style) && $template_style != "")?"style_".$template_style:"style";
$style_js = (isset($template_style) && $template_style != "")?"/".$template_style:"/green";


?>


<script type="text/javascript">
	var time_out_relogin_js = "<?php echo $SCLanguages['time_out_relogin'];?>";
	var style_js = "<?php echo $style_js;?>";
	var wait_message = "<?php echo $SCLanguages['wait_for_operation'];?>";
	var timeout_please_try_again = "<?php echo $SCLanguages['timeout_please_try_again'];?>";
	var page_confirm = "<?php echo $SCLanguages['confirm'];?>";
	var root_all = "<?php echo $root_all;?>";
	var webroot_dir = "<?php echo $cart_webroot;?>";
	var admin_webroot = "<?php echo $admin_webroot;?>";
	var user_webroot = "<?php echo $user_webroot;?>";
	var cart_webroot = "<?php echo $cart_webroot;?>";
	var server_host = "<?php echo $server_host;?>";
	var themePath = "<?php echo $this->themeWeb;?>";
	var order_code_is_null = "<?php echo $SCLanguages['order_code'].$SCLanguages['can_not_empty'];?>";
	var news_letter_is_null = "<?php echo $SCLanguages['email'].$SCLanguages['can_not_empty'];?>";
	var news_letter_is_error = "<?php echo $SCLanguages['void'].$SCLanguages['email'];?>";
	
// 这里把JS用到的所有语言都赋值到这里
<?php if(isset($js_languages) && sizeof($js_languages)>0){?>
<?php foreach($js_languages as $k=>$v){?>
var <?php echo $k;?> = "<?php echo $v;?>";
<?php }?>
<?php }?>
<?php if(isset($search_autocomplete_image) && sizeof($search_autocomplete_image)>0){?>
<?php foreach($search_autocomplete_image as $k=>$v){?>
var <?php echo $k;?> = "<?php echo $v;?>";
<?php }?>
<?php }?>
</script>
<?php echo $minify->css(array($this->themeWeb.'css/layout',$this->themeWeb.'css/component',$this->themeWeb.'css/login',$this->themeWeb.'css/menu',$this->themeWeb.'css/containers',$this->themeWeb.'css/autocomplete',$this->themeWeb.'css/'.$style_css,$this->themeWeb.'css/'.$lang_css));?>
<?php echo $minify->js(array('/js/yui/yahoo-dom-event.js','/js/yui/container_core-min.js','/js/yui/menu-min.js','/js/yui/element-beta-min.js','/js/yui/animation-min.js','/js/yui/connection-min.js','/js/yui/container-min.js','/js/yui/json-min.js',$this->themeWeb.'js/common.js','/js/swfobject.js'));?>
</head>
<body class="svcart-skin-g00" id="svcart-com">
<?php echo $this->element('dragl', array('cache'=>'+0 hour'));?>
<div id="header">
	<?php if(isset($languages)){?>
	<?php echo $this->element('header',array('cache'=>'+0 hour','languages'=>(isset($languages))?$languages:array(),'navigations_top'=>(isset($navigations['T']))?$navigations['T']:array()));?>
	<?php }else{?>
	<div id="logo"><?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'logo.gif':'logo.gif',array("alt"=>"SV-Cart","height"=>"192","width"=>"58")),"/","",false,false);?></div>
	<?php }?>
</div>
	<div id="container">
		<div id="content" >
			<div id="Left">
				<?php if(isset($category_type)){?>
				<?php if($category_type == 'A'){?>
					<?php //pr($articles_tree);?>
				<?php echo $this->element('category_A', array('cache'=>array('time'=> "+24 hour",'key'=>'category_A'.$template_style),'categories_tree'=>$articles_tree));?>
				<?php }else{?>
				<?php echo $this->element('category', array('cache'=>array('time'=> "+24 hour",'key'=>'category'.$template_style),'categories_tree'=>$categories_tree));?>
				<?php }}else{?>
				<?php echo $this->element('category', array('cache'=>array('time'=> "+24 hour",'key'=>'category'.$template_style),'categories_tree'=>(isset($categories_tree))?$categories_tree:array()));?>
				<?php }?>
				<?php if(isset($brands) && is_array($brands) && count($brands)){?>
				<?php echo $this->element('brand', array('cache'=>array('time'=> "+24 hour",'key'=>'brand'.$template_style),'brands'=>$brands));?>
				<?php }?>
				<?php if(isset($top_products) && sizeof($top_products)){?>
				<?php echo $this->element('top', array('cache'=>array('time'=> "+24 hour",'key'=>'top'.$template_style)));?>
				<?php }?>
				<?php echo $this->element('order', array('cache'=>array('time'=> "+24 hour",'key'=>'order'.$template_style)));?>
				<?php if(isset($vote_lists) && sizeof($vote_lists)){?>
				<?php echo $this->element('vote', array('cache'=>'+0 hour'));?>
				<?php }?>					
				<?php echo $this->element('newsletter', array('cache'=>array('time'=> "+24 hour",'key'=>'newsletter'.$template_style)));?>
				<?php if(isset($navigations['H'])){?>
				<?php echo $this->element('help', array('cache'=>array('time'=> "+24 hour",'key'=>'help'.$template_style),'navigations_help'=>$navigations['H']));?>
				<?php echo $this->element('links', array('cache'=>array('time'=> "+24 hour",'key'=>'links'.$template_style),'navigations_help'=>$navigations['H']));?>
				<?php }?>
				<?php echo $this->element('history', array('cache'=>'+0 hour'));?>
			</div>
			<?php if($this->name == "CakeError"){?>
				<?php echo $content_for_layout; ?>
			<?php }else{?>
			<div id="Right">
			<?php if ($session->check('Message.flash')){$session->flash();// this line displays our flash messages echo $content_for_layout; ?> 
			<?php }else{?>
			<?php echo $content_for_layout;?>
			<?php }?>
			</div>
			<?php }?>
		</div>
	</div>
	<div id="footer">
		<?php if(isset($categories_tree) && isset($brands)){?>
		<?php echo $this->element('footer', array('cache'=>'+0 hour','categories_tree'=>$categories_tree,'brands'=>$brands,'navigations_footer'=>(isset($navigations['B']))?$navigations['B']:array()));?>
		<?php }?>
		</div>
	<?php echo $cakeDebug;?>
			<!--对话框-->
<input type="hidden" value="" id="img_src_text_number">
<input type="hidden" value="" id="assign_dir">
<div id="layer_dialog"  style="display:none;background:#fff;">
<div id="loginout" >
	<h1><b></b></h1>
	<div id="buyshop_box">
		<p class="login-alettr">
		<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."msg.gif":"msg.gif",array('align'=>'absmiddle','class'=>'sub_icon'));?>
		<b>
		<span id="dialog_content"></span>
		</b>
		</p>
		<br /><input type="hidden" id="confirm">

		<p class="buy_btn mar" ><span id="button_replace">
		<a href='javascript:layer_dialog_obj.hide();'><?php echo $SCLanguages['cancel']?></a>
		<a href='javascript:confirm_record();'><?php echo $SCLanguages['confirm']?></a>
		</span></p>
	</div>
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."loginout-bottom.gif":"loginout-bottom.gif");?></p>
</div>
</div>
<!--End 对话框-->	
<!-- gears对话框 -->
<div id="layer_gears"  style="display:none;background:#fff;">
<div id="loginout" >
	<h1><b><?=$SCLanguages['google_gears']?></b></h1>
	<div id="buyshop_box">
		<p class="login-alettr">
		<b>
		<span id="dialog_content">
			<font id="no_gears" style="display:none;">
			<?=$SCLanguages['not_yet_been_installed']?><?=$SCLanguages['google_gears']?>
			</font>
			<font id="error_gears" style="display:none;">
			<?=$SCLanguages['google_gears']?><?=$SCLanguages['run_error_may_reinstall']?>
			</font>		
			<font id="msg_gears" style="display:none;">
			<?=$SCLanguages['speed_up_for_website']?><?=$SCLanguages['successfully']?>
			</font>					
		</span>
		</b>
		</p>
		<br />
			
		<p class="buy_btn mar" ><span id="button_replace">
		<font id="no_gears_a" style="display:none;">
		<a class="cursor" onclick="window.location = 'http://gears.google.com/?action=install';" ><?=$SCLanguages['install_now']?> <?=$SCLanguages['google_gears']?></a>
		</font>
		<font id="error_gears_a" style="display:none;">
		<a class="cursor" onclick="window.location = 'http://gears.google.com/?action=install';"><?=$SCLanguages['reinstall']?> <?=$SCLanguages['google_gears']?></a>
		</font>
		<a href='javascript:layer_gears_obj.hide();'><?php echo $SCLanguages['cancel']?></a>
		</span></p>
	</div>
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."loginout-bottom.gif":"loginout-bottom.gif");?></p>
</div>
</div>
<!--End gears对话框-->	
</body>
</html>