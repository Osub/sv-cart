<?php
/*****************************************************************************
 * SV-Cart ��Ʒ����
 *===========================================================================
 * ��Ȩ�����Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: view.ctp 899 2009-04-22 15:03:02Z huangbo $
*****************************************************************************/
?>
<?=$this->element('ur_here', array('cache'=>'+0 hour'));?>
<?if(isset($flashes['FlashImage']) && sizeof($flashes['FlashImage'])>0){?>
<div id="Flash" style="margin-bottom:5px;">
<?=$flash->renderSwf('img/bcastr4.swf?xml='.$this->webroot.'flashes/index/PC/'.$id,$flashes['Flash']['width'],$flashes['Flash']['height'],false,array('params' => array('movie'=>$this->webroot.'img/bcastr4.swf?xml='.$this->webroot.'flashes/index/PC/'.$id,'wmode'=>'Opaque')));?>
</div>
<?}?>
<?=$this->element('products_list', array('cache'=>'+0 hour'));?>
<?=$this->element('pagers', array('cache'=>'+0 hour'));?>
<br /> 
<?=$this->element('news',array('cache'=>'+0 huor'))?>