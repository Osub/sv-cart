<?php
/*****************************************************************************
 * SV-Cart 红包管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 943 2009-04-23 10:38:44Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>

<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增包装","add/",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist memberlevels packages_header">
	<li class="coupon_name">商品包装名称</li>
	<li class="piture">图片</li>
	<li class="expense">费用</li>
	<li class="gratis">免费额度</li>
	<li class="coupon_bewrite">包装描述</li>
	<li class="in_effect">是否有效</li>
	<li class="hadle_coupons">操作</li></ul>
<!--Menberleves List-->
<?if(isset($package_list) && sizeof($package_list)>0){?>
<?php foreach($package_list as $k=>$v){ ?>
	<ul class="product_llist memberlevels memberlevels_list coupons packages_header">
	<li class="coupon_name"><span><?=$html->image('picflag.gif',array('align'=>'absmiddle'))?> <strong><?php echo $v['PackagingI18n']['name'] ?></strong></span></li>
	<li class="piture">
		<?=@$html->image("/..{$v['Packaging']['img01']}",array('width'=>'40','height'=>'40','align'=>'absmiddle'))?>
	</li>
	<li class="expense"><?php echo $v['Packaging']['fee'] ?></li>
	<li class="gratis"><?php echo $v['Packaging']['free_money'] ?></li>
	<li class="coupon_bewrite"><span><?php echo $v['PackagingI18n']['description'] ?></span></li>
	<li class="in_effect"><?php if($v['Packaging']['status'])echo $html->image('yes.gif',array('align'=>'absmiddle'));else echo $html->image('no.gif',array('align'=>'absmiddle')) ?></li>
	<li class="hadle_coupons">

	<?php echo $html->link("编辑","/packages/edit/{$v['Packaging']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}packages/remove/{$v['Packaging']['id']}')"));?>
	
	
	
	</li></ul>
<? }} ?>
	

<!--Menberleves List End-->	
<div class="pagers" style="position:relative">
<?php echo $this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
</div>
<!--Main Start End-->
</div>