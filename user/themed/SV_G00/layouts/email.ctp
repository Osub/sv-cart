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
 * $Id: email.ctp 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?>
<title><?php __('SV-Cart: ??? '); ?><?php echo $title_for_layout; ?></title>
<?echo $html->meta('icon');
echo $html->css('style');
if(isset($_SESSION['Config']['locale'])){
echo $html->css($_SESSION['Config']['locale']);
}else{
echo $html->css('zh_cn');
}
echo $scripts_for_layout;
?>
<?=$javascript->link('/../js/yui/yahoo-dom-event.js');?>
<?=$javascript->link('/../js/yui/container_core.js');?>
<?=$javascript->link('/../js/yui/menu.js');?>
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
