<?php
/*****************************************************************************
 * SV-Cart 商品分类
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
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