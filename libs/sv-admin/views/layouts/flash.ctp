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
 * $Id: flash.ctp 3268 2009-07-23 06:02:01Z huangbo $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $page_title; ?></title>
<?php 
header("Content-Type: text/html; charset=utf-8");
?>
<?php if (Configure::read() == 0) { ?>
<meta http-equiv="Refresh" content="<?php echo $pause; ?>;url=<?php echo $url; ?>"/>
<?php } ?>
<?php 
		echo $html->meta('icon');
	?>
<?php echo $minify->css(array('/css/layout','/css/admin','/css/calendar','/css/menu','/css/container','/css/treeview','/css/image','/css/swfupload','/css/tabview','/css/style'));?>
<?php echo $minify->js(array('/../js/yui/yahoo-dom-event.js','/../js/yui/container_core-min.js','/../js/yui/menu-min.js','/../js/yui/element-beta-min.js','/../js/yui/animation-min.js','/../js/yui/connection-min.js','/../js/yui/container-min.js','/../js/yui/tabview-min.js','/../js/yui/json-min.js','/js/common.js','/../js/swfobject.js'));?>
	
<!--菜单-->
<script type="text/javascript">
    YAHOO.util.Event.onContentReady("topmenu", function () {

        var oMenuBar = new YAHOO.widget.MenuBar("topmenu", { 
                                                    autosubmenudisplay: true, 
                                                    hidedelay: 750, 
                                                    lazyload: true });
        oMenuBar.render();

    });
	var root_all = "<?php echo $root_all;?>";
	var webroot_dir = "<?php echo $admin_webroot;?>";
	var admin_webroot = "<?php echo $admin_webroot;?>";
	var user_webroot = "<?php echo $user_webroot;?>";
	var cart_webroot = "<?php echo $cart_webroot;?>";
	var server_host = "<?php echo $server_host;?>";
	var themePath = "<?php echo $this->themeWeb;?>";

    //initPage_password();
</script>
<!--菜单end-->

<?php echo $html->charset(); ?>


</head>

<body class="yui-skin-sam svcart-skin-g00" id="svcart-com" >
<?php echo $this->element('header', array('cache'=>'+0 hour'));?>
<div class="content">
<div id="ur_here" class="flash_urhere" style="padding-bottom:5px;">当前位置：系统提示</div>
<!--Main Start-->
<?php if(!empty($_SESSION['cart_back_url'])){$href=$_SESSION['cart_back_url'];}else{$href=$this->params['controller'];}?>
	<div class="informations">
	<p><?php if($type=='true'){echo $html->image('success.jpg',array('align'=>'absmiddle'));}else{ echo $html->image('failure.jpg',array('align'=>'absmiddle'));}?> &nbsp;&nbsp;<a href="<?php echo $url; ?>" style="color:<?php if($type=='true'){?>#188B40<?php }else{?>#EE6203<?php }?>"><?php echo $message; ?></a></p>
	</div>
	<p class="handdles"><span><?php echo $html->link("返回列表页","/{$href}",'',false,false);?></span>|<span><?php echo $html->link('返回管理首页', '/')?></span></p>

<!--Main Start End-->
</div>
<?php if(isset($spt)){?><?php echo $spt;?><?php }?>
<?php echo $this->element('footer', array('cache'=>'+0 hour'));?>
</body>
</html>