<?php 
/*****************************************************************************
 * SV-Cart flash模板
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: flash.ctp 4808 2009-10-09 10:05:22Z huangbo $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?>
<meta name="description" content="<?php if(isset($meta_description)){echo $meta_description;} ?>" />
<meta name="keywords" content="<?php if(isset($meta_keywords)){echo $meta_keywords;} ?>" />
<meta name="robots" content="noindex" />
<title><?php echo $title_for_layout; ?> - Powered by Seevia</title>
<?php if (Configure::read() == 0) { ?>
<meta http-equiv="Refresh" content="<?php echo $pause; ?>;url=<?php echo $url; ?>"/>
<?php } ?>		
<?php echo $html->meta('icon');
$lang_css = isset($_SESSION['Config']['locale']) ? $_SESSION['Config']['locale']:'chi';
$style_css = (isset($template_style) && $template_style != "")?"style_".$template_style:"style";
$style_js = (isset($template_style) && $template_style != "")?"/".$template_style:"/green";
?>

<script type="text/javascript">
	var style_js = "<?php echo $style_js;?>";
	var wait_message = "<?php echo $SCLanguages['wait_for_operation'];?>";
	var timeout_please_try_again = "<?php echo $SCLanguages['timeout_please_try_again'];?>";
	var page_confirm = "<?php echo $SCLanguages['confirm'];?>";
	var root_all = "<?php echo $root_all;?>";
	var webroot_dir = "<?php echo $user_webroot;?>";
	var user_webroot = "<?php echo $user_webroot;?>";
	var cart_webroot = "<?php echo $cart_webroot;?>";
	var server_host = "<?php echo $server_host;?>";
	var themePath = "<?php echo $this->themeWeb;?>";
	var order_code_is_null = "<?php echo $SCLanguages['order_code'].$SCLanguages['can_not_empty'];?>";
	var news_letter_is_null = "<?php echo $SCLanguages['email'].$SCLanguages['can_not_empty'];?>";
	var news_letter_is_error = "<?php echo $SCLanguages['void'].$SCLanguages['email'];?>";
	
</script>
<?php echo $minify->css(array($this->themeWeb.'css/layout',$this->themeWeb.'css/component',$this->themeWeb.'css/login',$this->themeWeb.'css/menu',$this->themeWeb.'css/containers',$this->themeWeb.'css/autocomplete',$this->themeWeb.'css/calendar',$this->themeWeb.'css/treeview',$this->themeWeb.'css/container',$this->themeWeb.'css/'.$style_css,$this->themeWeb.'css/'.$lang_css));?>
<?php echo $minify->js(array('/../js/yui/yahoo-dom-event.js','/../js/yui/container_core-min.js','/../js/yui/menu-min.js','/../js/yui/element-beta-min.js','/../js/yui/animation-min.js','/../js/yui/connection-min.js','/../js/yui/container-min.js','/../js/yui/json-min.js','/../js/yui/button-min.js','/../js/yui/calendar-min.js',$this->themeWeb.'js/regions.js',$this->themeWeb.'js/common.js'));?>

<script type="text/javascript">
//左列菜单
            YAHOO.util.Event.onContentReady("productsandservices", function () {
                var oMenu = new YAHOO.widget.Menu("productsandservices", { 
                                                        position: "static", 
                                                        hidedelay:  750, 
                                                        lazyload: true });
                oMenu.render();            
            });
</script>
</head>
<body class="svcart-skin-g00" id="svcart-com">
<div id="header">
	<?php if(isset($SVConfigs['shop_temporal_closed']) && $SVConfigs['shop_temporal_closed'] == 1){?>
	<div id="logo"><?php echo $html->link($html->image($logo,array("alt"=>"")),"/","",false,false);?></div>
	<?php }else{?>
	<?php echo $this->element('header', array('cache'=>'+0 hour','languages'=>$languages,'navigations_top'=>(isset($navigations['T']))?$navigations['T']:array()));?>
	<?php }?>
</div>

<div id="container">
<div class="contents">
<div id="ur_here"><?//php echo $SCLanguages['current_location_system_remind']?></div>
<!--Main Start-->
<div class="home_main" style="display:none;">
	<div class="informations">
	<br /><br /><Br /><br /><Br /><br />
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'msg.gif':'msg.gif',array('align'=>'middle'))?> &nbsp;&nbsp;<strong>
	<?php //pr($_SESSION['cart_back_url']);?>
	<?php if(isset($back_url)){?>
	<?php echo $html->link($message,$back_url,array(),false,false);?>		
	<?php }else if(isset($_SESSION['cart_back_url'])){?>
	<?php echo $html->link($message,$_SESSION['cart_back_url'],array(),false,false);?>		
	<?php }else{?>
	<?php echo $html->link($message,$url,array(),false,false);?>		
	<?php }?>
	</strong></p>
	<br /><br /><Br /><br /><Br /><br /><Br /><br />
	<p class="handdle"><span>
	<?php if(isset($back_url)){?>
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['previous'].$SCLanguages['page'],$back_url,array(),false,false);?>		
	<?php }else if(isset($_SESSION['cart_back_url'])){?>
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['previous'].$SCLanguages['page'],$_SESSION['cart_back_url'],array(),false,false);?>		
	<?php unset($_SESSION['cart_back_url']);?>
	<?php }else{?>
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['previous'].$SCLanguages['page'],$url,array(),false,false);?>		
	<?php }?>
	</span>|<span><?php echo $html->link($SCLanguages['return'].$SCLanguages['user_center'], '/')?></span></p>
	<br /><Br /><br /><Br /><br /><Br /><br />
	</div>
</div>
		
		
<div class="checkout_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['current_location_system_remind'];?></b></h1>
	<div id="globalBalance" class="border" style="border-bottom:none;margin-top:3px;width:auto;">
	<br /><br /><br />
	<p class="succeed">
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."warning_img.gif":"warning_img.gif",array("alt"=>$SCLanguages['order_generated'].$SCLanguages['failed']))?>
	<b><?php echo $message?></b></p>
		<?php if(isset($SVConfigs['shop_temporal_closed']) && $SVConfigs['shop_temporal_closed'] == 1){?>
			<?php echo $SVConfigs['closed_reason'];?>
		<?php }?>
	<br /><br /><br />
	<p class="back_home">
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['previous'].$SCLanguages['page'],$url,array('class'=>'color_4'),false,false);?>
	&nbsp;&nbsp;
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>	
	&nbsp;&nbsp;
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['user_center'],$server_host.$user_webroot,array('class'=>'color_4'),false,false);?>	
    </p>
    <br />
    <?php if(isset($products_error) && sizeof($products_error)>0){?>
    <br /><br />
	<div class="box">
		<div class="Item_List">
    		<ul class="breviary">
    	<?php foreach($products_error as $k=>$v){?>
		<li><p class="pic">
		<?php if($v['Product']['img_thumb'] != ""){?>
		<?php echo $html->link($html->image($v['Product']['img_thumb'],array("alt"=>$v['ProductI18n']['name'],"width"=>isset($this->data['configs']['thumbl_image_width'])?$this->data['configs']['thumbl_image_width']:108,"height"=>isset($this->data['configs']['thumb_image_height'])?$this->data['configs']['thumb_image_height']:108)),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['use_sku']),"",false,false);?>
		<?php }else {
		echo $html->link($html->image("/img/product_default.jpg",array("alt"=>$v['ProductI18n']['name'],"width"=>isset($this->data['configs']['thumbl_image_width'])?$this->data['configs']['thumbl_image_width']:108,"height"=>isset($this->data['configs']['thumb_image_height'])?$this->data['configs']['thumb_image_height']:108)),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['use_sku']),"",false,false);
		}?>
		</p>
		<p class="info">
		<span class="name"><?php echo $html->link($v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['use_sku']),array("target"=>"_blank"),false,false);?></span>
    	</p></li>
    	<?php }?>
    		</ul>
    	</div>
   	</div>
    <?php }?>
</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."succeed02_img.gif":"succeed02_img.gif",array("width"=>"100%","height"=>"58"))?></p>
</div>				
<!--Main Start End-->

</div>
<div id="footer"><?php echo $this->element('footer', array('cache'=>'+0 hour'));?></div>
<?php echo $this->element('dragl', array('cache'=>'+0 hour'));?>
	
<!--订单查询对话框-->
<div id="search_order" style="display:none;">
<div class="loginout" >
	<h1><b><?=$SCLanguages['order']?><?=$SCLanguages['search']?></b></h1>
		<?php echo $this->element('order', array('cache'=>array('time'=> "+0 hour",'key'=>'order'.$template_style)));?>
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."loginout-bottom.gif":"loginout-bottom.gif");?></p>
</div>
</div>
<!--End 订单查询对话框-->	
<!--订阅对话框-->
<div id="add_newsletter" style="display:none;">
<div class="loginout" >
	<h1><b><?=$SCLanguages['subscribe']?></b></h1>
		<?php echo $this->element('newsletter', array('cache'=>array('time'=> "+0 hour",'key'=>'newsletter'.$template_style)));?>
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."loginout-bottom.gif":"loginout-bottom.gif");?></p>
</div>
</div>
<!--End 订阅对话框-->
	
</body>
</html>