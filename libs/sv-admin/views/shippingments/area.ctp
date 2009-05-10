<?php
/*****************************************************************************
 * SV-Cart  配送方式设置区域
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: area.ctp 1201 2009-05-05 13:30:17Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增配送区域","area_add/{$ids}",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist advertisement">
	<li class="ad_name">编号<?=$html->image('sort_desc.gif')?></li>
	<li class="ad_position">配送区域名称</li>
	<li class="type"></li>
	<li class="start_time">描述</li>
	<li class="end_time">所辖地区</li>
	<li class="click"></li>
	<li class="order"></li>
	<li class="hadle">操作</li></ul>
<!--Advertisement List-->
<?if(isset($shippingarea) && sizeof($shippingarea)>0){?>
<?foreach( $shippingarea as $k=>$v ){?>
	<ul class="product_llist advertisement advertisement_list">
	<li class="ad_name"><span><strong><?=$v['ShippingArea']['id']?></strong></span></li>
	<li class="ad_position"><span><?=$v['ShippingArea']['name']?></span></li>
	<li class="type"><span></span></li>
	<li class="start_time"><?=$v['ShippingArea']['description']?></li>
	<li class="end_time"><?=$v['ShippingArea']['areaname']?></li>
	<li class="click"></li>
	<li class="order"></li>
	<li class="hadle">
<?php echo $html->link("编辑","/shippingments/area_edit/{$v['ShippingArea']['id']}/{$ids}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}shippingments/remove/{$v['ShippingArea']['id']}')"));?>
 
		</li></ul>
<?}}?>
<div class="pagers" style="position:relative">
<?php // echo $this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
	</div>
	
<!--Main Start End-->
</div>