<?php 
/*****************************************************************************
 * SV-Cart Ʒ��
 *===========================================================================
 * ��Ȩ���� �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: view.ctp 3225 2009-07-22 10:59:01Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<?php if(isset($flashes['FlashImage']) && sizeof($flashes['FlashImage'])>0){?>
<div id="Flash"><?php echo $flash->renderSwf('img/bcastr4.swf?xml='.$cart_webroot.'flashes/index/B/'.$id,$flashes['Flash']['width'],$flashes['Flash']['height'],false,array('params' => array('movie'=>$cart_webroot.'img/bcastr4.swf?xml='.$cart_webroot.'flashes/index/B/'.$id,'wmode'=>'Opaque')));?></div>
<?php }?>
<?php echo $this->element('products_list', array('cache'=>'+0 hour'));?>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
<br />
<?php echo $this->element('news', array('cache'=>array('time'=> "+24 hour",'key'=>'news'.$template_style)));?>
