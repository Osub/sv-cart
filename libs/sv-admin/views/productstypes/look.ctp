<?php
/*****************************************************************************
 * SV-Cart  查看商品类型
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: look.ctp 1250 2009-05-07 13:59:20Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($coupons);?>

<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle')).'新增属性','/productstypes/lookadd/'.$id,'',false,false)?> </strong></p>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist memberlevels">
	<li class="gratis">编号</li>
	<li class="piture" style="width:28%">属性名称</li>
	<li class="hadle_coupons" style='border-right:1px solid #F8F8F7'>商品类型</li>
	<li class="coupon_name">属性值的录入方式</li>
	<li class="gratis">可选值列表</li>
	<li class="expense">排序</li>
	<li class="effective" style='border-right:0'>操作</li></ul>
<!--Menberleves List-->
<?if(isset($attribute) && sizeof($attribute)>0){?>
<? foreach( $attribute as $k=>$v ){ ?>
	<ul class="product_llist memberlevels memberlevels_list coupons">
	<li class="gratis"><span> <strong><?=$v['ProductTypeAttribute']["id"]?></strong></span></li>
	<li class="piture" style="width:28%"><?=$v['ProductTypeAttributeI18n']["name"]?></li>
	<li class="hadle_coupons" style='border-right:1px solid #F8F8F7'><?=$v['ProductTypeAttribute']["typename"]?></li>
	<li class="coupon_name"><span><? if($v['ProductTypeAttribute']["attr_input_type"]==0){ echo "手工录入";}?><? if($v['ProductTypeAttribute']["attr_input_type"]==1){ echo "从列表中选择";}?><? if($v['ProductTypeAttribute']["attr_input_type"]==2){ echo "多行文本框";}?></span></li>
	<li class="gratis"><? if($v['ProductTypeAttribute']["attr_type"]==0){ echo "不可选";}?><? if($v['ProductTypeAttribute']["attr_type"]==1){ echo "可选";}?></li>
	<li class="expense"><?=$v['ProductTypeAttribute']["orderby"]?></li>
	<li class="effective" style='border-right:0'>
		<?=$html->link($html->image('icon_edit.gif',$title_arr['edit']),'/productstypes/lookedit/'.$v['ProductTypeAttribute']['id']."/".$id,'',false,false)?>
	<?=$html->link($html->image('icon_drop.gif',$title_arr['remove']),'/productstypes/lookremove/'.$v['ProductTypeAttribute']['id']."/".$id,'',false,false)?>
</li></ul>
<?}}?>
	

<!--Menberleves List End-->	
<div class="pagers" style="position:relative">
<?php // echo $this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
</div>
<!--Main Start End-->
</div>