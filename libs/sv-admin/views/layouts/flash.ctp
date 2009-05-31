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
 * $Id: flash.ctp 1670 2009-05-25 00:47:18Z huangbo $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $page_title; ?></title>
<?php
		echo $html->meta('icon');
	?>
<?=$minify->css(array('/css/layout','/css/admin','/css/calendar','/css/menu','/css/container','/css/treeview','/css/image','/css/swfupload','/css/tabview','css/style'));?>
<?=$minify->js(array('/../js/yui/yahoo-dom-event.js','/../js/yui/container_core-min.js','/../js/yui/menu-min.js','/../js/yui/element-beta-min.js','/../js/yui/animation-min.js','/../js/yui/connection-min.js','/../js/yui/container-min.js','/../js/yui/tabview-min.js','/../js/yui/json-min.js','/js/common.js','/../js/swfobject.js'));?>
	
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
<?if(!empty($_SESSION['cart_back_url'])){$href="/".$_SESSION['cart_back_url'];}else{$href=$this->params['controller'];}?>
<div class="home_main">
	<div class="informations">
	<br /><br /><Br /><br /><Br /><br />
	<p><?if($type=='true'){echo $html->image('success.jpg',array('align'=>'absmiddle'));}else{ echo $html->image('failure.jpg',array('align'=>'absmiddle'));}?> &nbsp;&nbsp;<a href="<?php echo $url; ?>" style="color:<?if($type=='true'){?>#188B40<?}else{?>#EE6203<?}?>"><?php echo $message; ?></a></p>
	<br /><br /><Br /><br /><Br /><br /><Br /><br />
	<p class="handdle"><span><?=$html->link("返回列表页","/{$href}",'',false,false);?></span>|<span><?php echo $html->link('返回管理首页', '/')?></span></p>
	<br /><Br /><br /><Br /><br /><Br /><br />
	</div>


</div>
<!--Main Start End-->
</div>

<?php echo $this->element('footer', array('cache'=>'+0 hour'));?>
</body>
</html>