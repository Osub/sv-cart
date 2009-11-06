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
 * $Id: area.ctp 3673 2009-08-17 09:57:45Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增配送区域","area_add/{$ids}",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="4%">编号</th>
	<th width="22%">配送区域名称</th>
	<th width="22%">描述</th>
	<th width="44%">所辖地区</th>
	<th width="8%">操作</th>
</tr>
<!--Advertisement List-->
<?php if(isset($shippingarea) && sizeof($shippingarea)>0){?>
<?php foreach( $shippingarea as $k=>$v ){?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td align="center"><?php echo $v['ShippingArea']['id']?></td>
	<td><?php echo $v['ShippingArea']['name']?></td>
	<td><?php echo $v['ShippingArea']['description']?></td>
	<td><?php echo $v['ShippingArea']['areaname']?></td>
	<td align="center"><?php echo $html->link("编辑","/shippingments/area_edit/{$v['ShippingArea']['id']}/{$ids}");?> | <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}shippingments/remove/{$v['ShippingArea']['id']}/{$v['ShippingArea']['name']}')"));?></td>
</tr>
<?php }}?>
	</table></div>
<div class="pagers" style="position:relative">
<?php // echo $this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
	</div>
	
<!--Main Start End-->
</div>