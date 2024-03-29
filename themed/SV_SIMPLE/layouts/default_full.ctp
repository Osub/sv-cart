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
 * $Id: default_full.ctp 4808 2009-10-09 10:05:22Z huangbo $
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

?>


<script type="text/javascript">
	var time_out_relogin_js = "<?php echo $SCLanguages['time_out_relogin'];?>";
	var page_confirm = "<?php echo $SCLanguages['confirm'];?>";
	var root_all = "<?php echo $root_all;?>";
	var webroot_dir = "<?php echo $cart_webroot;?>";
	var user_webroot = "<?php echo $user_webroot;?>";
	var cart_webroot = "<?php echo $cart_webroot;?>";
	var server_host = "<?php echo $server_host;?>";
	var themePath = "<?php echo $this->themeWeb;?>";
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

<?php echo $minify->css(array($this->themeWeb.'css/layout',$this->themeWeb.'css/'.$lang_css,$this->themeWeb.'css/'.$style_css));?>
<?php echo $minify->js(array(/*'/js/yui/yahoo-dom-event.js','/js/yui/container_core-min.js','/js/yui/element-beta-min.js','/js/yui/connection-min.js','/js/yui/json-min.js','/js/yui/yahoo-min.js',*/$this->themeWeb.'js/common.js'));?>
</head>
<body class="svcart-skin-g00" id="svcart-com">
<?//php echo $this->element('dragl', array('cache'=>'+0 hour'));?>

<?php echo $this->element('header', array('cache'=>'+0 hour','languages'=>(isset($languages))?$languages:array(),'navigations_top'=>(isset($navigations['T']))?$navigations['T']:array()));?>

	

<div class="content clearfix">
	<?php echo $content_for_layout; ?>
</div>


<?php echo $this->element('footer', array('cache'=>'+0 hour','categories_tree'=>(isset($categories_tree))?$categories_tree:array(),'brands'=>(isset($brands))?$brands:array(),'navigations_footer'=>(isset($navigations['F']))?$navigations['F']:array()));?>

<?php echo $cakeDebug; ?>
	
<!--对话框-->
<input type="hidden" value="" id="img_src_text_number">
<input type="hidden" value="" id="assign_dir">
<div id="layer_dialog"  style="display:none;background:#fff;">
<div id="loginout" >
	<h1><b></b></h1>
	<div id="buyshop_box">
		<p class="login-alettr">
		<?php echo $html->image("msg.gif",array('align'=>'absmiddle','class'=>'sub_icon'));?>
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
	<p><?php echo $html->image("loginout-bottom.gif");?></p>
</div>
</div>
<!--End 对话框-->		
	
</body>
</html>
