<?php
/*****************************************************************************
 * SV-Cart 提示模板
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: flash.ctp 943 2009-04-23 10:38:44Z huangbo $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $page_title; ?></title>
<?php
		echo $html->meta('icon');

		echo $html->css('style');

		echo $scripts_for_layout;
		
	//	pr($this);
	?>
<?=$javascript->link('/../js/yui/yahoo-dom-event.js');?>
<?=$javascript->link('/../js/yui/container_core-min.js');?>
<?=$javascript->link('/../js/yui/menu-min.js');?>
<?=$javascript->link('/../js/yui/element-beta-min.js');?>
<?=$javascript->link('/../js/yui/connection-min.js');?>
<?=$javascript->link('/../js/yui/json-min.js');?>
<?=$javascript->link('/../js/yui/container-min.js');?>
<?=$javascript->link('/../js/yui/tabview-min.js');?><!--删除层遮罩-->
	
<!--菜单-->
<script type="text/javascript">
    YAHOO.util.Event.onContentReady("topmenu", function () {

        var oMenuBar = new YAHOO.widget.MenuBar("topmenu", { 
                                                    autosubmenudisplay: true, 
                                                    hidedelay: 750, 
                                                    lazyload: true });
        oMenuBar.render();

    });

	var webroot_dir = "<?=$this->webroot;?>";

    initPage_password();
</script>
<!--菜单end-->

<?php echo $html->charset(); ?>

<?php if (Configure::read() == 0) { ?>
<meta http-equiv="Refresh" content="<?php echo $pause; ?>;url=<?php echo $url; ?>"/>
<?php } ?>
</head>

<body class="yui-skin-sam svcart-skin-g00" id="svcart-com" >
<?php echo $this->element('header', array('cache'=>'+0 hour'));?>
<div class="content">
<div id="ur_here">当前位置：系统提示</div>
<!--Main Start-->
<?if(@$_SESSION['cart_back_url']!=""){$href="/".$_SESSION['cart_back_url'];unset($_SESSION['cart_back_url']);}else{$href=$this->params['controller'];}?>
<div class="home_main">
	<div class="informations">
	<br /><br /><Br /><br /><Br /><br />
	<p><?=$html->image('msg.gif',array('align'=>'absmiddle'))?> &nbsp;&nbsp;<strong><a href="<?php echo $url; ?>"><?php echo $message; ?></a></strong></p>
	<br /><br /><Br /><br /><Br /><br /><Br /><br />
	<p class="handdle"><span><?=$html->link("返回列表页","/{$href}",'',false,false);?></span>|<span><?php echo $html->link('返回管理首页', '/')?></span></p>
	<br /><Br /><br /><Br /><br /><Br /><br />
	</div>

<?  unset($_SESSION['cart_back_url']); ?>
</div>
<!--Main Start End-->
</div>

<?php echo $this->element('footer', array('cache'=>'+0 hour'));?>
</body>
</html>