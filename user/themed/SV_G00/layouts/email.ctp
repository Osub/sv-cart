<?php
/*****************************************************************************
 * SV-Cart emailģ��
 *===========================================================================
 * ��Ȩ���� �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: email.ctp 1670 2009-05-25 00:47:18Z huangbo $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?>
<title><?php __('SV-Cart: ??? '); ?><?php echo $title_for_layout; ?></title>
<?echo $html->meta('icon');
$lang_css = isset($_SESSION['Config']['locale']) ? $_SESSION['Config']['locale']:'chi';
?>
<?=$minify->css(array($this->themeWeb.'css/layout',$this->themeWeb.'css/component',$this->themeWeb.'css/login',$this->themeWeb.'css/menu',$this->themeWeb.'css/containers',$this->themeWeb.'css/autocomplete',$this->themeWeb.'css/calendar',$this->themeWeb.'css/treeview',$this->themeWeb.'css/container',$this->themeWeb.'css/style',$this->themeWeb.'css/'.$lang_css));?>
<?=$minify->js(array('/../js/yui/yahoo-dom-event.js','/../js/yui/container_core-min.js','/../js/yui/menu-min.js','/../js/yui/element-beta-min.js','/../js/yui/animation-min.js','/../js/yui/connection-min.js','/../js/yui/container-min.js','/../js/yui/json-min.js','/../js/yui/button-min.js','/../js/yui/calendar-min.js',$this->themeWeb.'/js/regions.js',$this->themeWeb.'/js/common.js'));?>
<script type="text/javascript">
    YAHOO.util.Event.onContentReady("productsandservices", function () {

        var oMenuBar = new YAHOO.widget.MenuBar("productsandservices", { 
                                                    autosubmenudisplay: true, 
                                                    hidedelay: 750, 
                                                    lazyload: true });
        oMenuBar.render();

    });

</script>
</head>
<body class="svcart-skin-g00" id="svcart-com">
<?php echo $this->element('header', array('cache'=>'+0 hour'));?>

<?php echo $content_for_layout; ?>

<?php echo $this->element('footer', array('cache'=>'+0 hour'));?>
<?php echo $this->element('dragl', array('cache'=>'+0 hour'));?>
<?php echo $cakeDebug; ?>
</body>
</html>
