<?php
/*****************************************************************************
 * SV-Cart flash
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: flash.ctp 1314 2009-05-11 07:20:51Z huangbo $
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
<?echo $html->meta('icon');
echo $html->css('style');
if(isset($_SESSION['Config']['locale'])){
echo $html->css($_SESSION['Config']['locale']);
}else{
echo $html->css('zh_cn');
}
echo $scripts_for_layout;
?>
<?=$javascript->link('/js/yui/yahoo-dom-event.js');?>
<?=$javascript->link('/js/yui/container_core-min.js');?>
<?=$javascript->link('/js/yui/menu-min.js');?>
<?=$javascript->link('/js/yui/element-beta-min.js');?>
<?=$javascript->link('/js/yui/animation-min.js');?>
<?=$javascript->link('/js/yui/connection-min.js');?>
<?=$javascript->link('/js/yui/json-min.js');?>
<?=$javascript->link('/js/yui/container-min.js');?>

<script type="text/javascript">
	var webroot_dir = "<?=$this->webroot;?>";
	var themePath = "<?=$this->themeWeb;?>";
// 这里把JS用到的所有语言都赋值到这里
<?php if(isset($js_languages) && sizeof($js_languages)>0){?>
<?php foreach($js_languages as $k=>$v){?>
var <?php echo $k;?> = "<?php echo $v;?>";
<? }?>
<?}?>
<?php if(isset($search_autocomplete_image) && sizeof($search_autocomplete_image)>0){?>
<?php foreach($search_autocomplete_image as $k=>$v){?>
var <?php echo $k;?> = "<?php echo $v;?>";
<? }?>
<?}?>
</script>
<?=$javascript->link('common');?>
</head>
<body class="svcart-skin-g00" id="svcart-com">
<?php echo $this->element('dragl', array('cache'=>'+0 hour'));?>
	<div id="container">
		<div id="header">
			<?if(isset($SVConfigs['shop_temporal_closed']) && $SVConfigs['shop_temporal_closed'] == 1){?>
			<div id="logo"><?=$html->link($html->image('logo.gif',array("alt"=>"SV-Cart")),"/","",false,false);?></div>
			<?}else{?>
			<?echo $this->element('header', array('cache'=>'+0 hour','languages'=>$languages,'navigations_top'=>(isset($navigations['T']))?$navigations['T']:array()));?>
			<?}?>
		</div>
<div class="contents">
<div id="ur_here"><?=$SCLanguages['current_location_system_remind']?></div>
<p class="height_5"></p>
<!--Main Start-->
<div class="home_main">
	<div class="informations">
	<br /><br /><Br /><br /><Br /><br />
	<?if(isset($shop_logo) && $shop_logo != ""){?>
	<?=$html->image($shop_logo,array('align'=>'middle'))?>
	<?}?>
	<p><?=$html->image('msg.gif',array('align'=>'middle'))?> &nbsp;&nbsp;<strong>
		<?=$html->link($message,$url,array(),false,false);?>			
			</strong></p>
	<?if(isset($closed_reason)){?>
	<p>网站关闭原因: &nbsp;&nbsp;<strong>
		<?=$html->link($closed_reason,$url,array(),false,false);?>					
		</strong></p>
	<?}?>
	
	<br /><br /><Br /><br /><Br /><br /><Br /><br />
	<p class="handdle"><span>
		<?if(isset($SVConfigs['shop_temporal_closed']) && $SVConfigs['shop_temporal_closed'] != 1){?>
		<?=$html->link($SCLanguages['return'].$SCLanguages['previous'].$SCLanguages['page'],$url,array(),false,false);?>					
		<?}?>	
	</span></p>
	<br /><Br /><br /><Br /><br /><Br /><br />
	</div>

</div>
<!--Main Start End-->
</div>
<div id="footer">
<?php echo $this->element('footer', array('cache'=>'+0 hour'));?>
</div>
</body>
</html>