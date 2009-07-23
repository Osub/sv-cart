<?php 
/*****************************************************************************
 * SV-Cart 默认模板
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: default.ctp 2715 2009-07-09 02:51:28Z zhengli $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?>
<title><?php echo $title_for_layout; ?> - <?php __('Powered by Seevia'); ?></title>
	<?php 
		echo $html->meta('icon');
	?>
	
<script type="text/javascript">
	var root_all = "<?php echo $root_all;?>";
	var webroot_dir = "<?php echo $admin_webroot;?>";
	var admin_webroot = "<?php echo $admin_webroot;?>";
	var user_webroot = "<?php echo $user_webroot;?>";
	var cart_webroot = "<?php echo $cart_webroot;?>";
	var server_host = "<?php echo $server_host;?>";
	var themePath = "<?php echo $this->themeWeb;?>";
	var now_locale = "<?php echo $now_locale?>";//当前语言
</script>
<?php echo $minify->css(array('/css/layout','/css/admin','/css/calendar','/css/menu','/css/container','/css/treeview','/css/image','/css/swfupload','/css/tabview','/css/style'));?>
<?php echo $minify->js(array('/../js/yui/yahoo-dom-event.js','/../js/yui/container_core-min.js','/../js/yui/menu-min.js','/../js/yui/element-beta-min.js','/../js/yui/animation-min.js','/../js/yui/connection-min.js','/../js/yui/get-min.js','/../js/yui/container-min.js','/../js/yui/tabview-min.js','/../js/yui/json-min.js','/../js/yui/calendar-min.js','/js/common.js','/js/calendar.js','/../js/swfobject.js'));?>
<!--菜单-->
<script type="text/javascript">
    YAHOO.util.Event.onContentReady("topmenu", function () {

        var oMenuBar = new YAHOO.widget.MenuBar("topmenu", { 
                                                    autosubmenudisplay: true, 
                                                    hidedelay: 750, 
                                                    lazyload: true });
        oMenuBar.render();

    });
    
</script>
<!--菜单end-->
</head>
<body class="yui-skin-sam svcart-skin-g00"  id="svcart-com" onload="layer_dialog();" >

<?php 
	if(@!isset($this->params['url']['status'])){
		echo $this->element('header', array('cache'=>'+0 hour'));
	}
?>
<?php echo $content_for_layout; ?>
<?php 
	if(@!isset($this->params['url']['status'])){
		echo $this->element('footer', array('cache'=>'+0 hour'));
	}
	?>
<?php echo $cakeDebug; ?>
<!--对话框-->
<input type="hidden" value="" id="img_src_text_number" />
<input type="hidden" value="" id="assign_dir" />
<div id="layer_dialog" class="svcart-overlay">
<div id="loginout">
	<h1><b>系统提示</b></h1>
	<div id="buyshop_box">
		<p class="login-alettr">
		<?php echo $html->image("msg.gif",array('class'=>'sub_icon vmiddle'));?>
		<b>
		<span id="admin_dialog_content"></span>
		</b>
		</p>
		<br /><input type="hidden" id="confirm" />
		<p class="buy_btn mar" ><span id="admin_button_replace"><?php echo $html->link("取消","javascript:;",array("onclick"=>"layer_dialog_obj.hide()"));?>
		<?php echo $html->link("确定","javascript:;",array("onclick"=>"confirm_record()"));?></span></p>
	</div>
	<p><?php echo $html->image("loginout-bottom.png");?></p>
</div>
</div>
<!--End 对话框-->

</body>
</html>