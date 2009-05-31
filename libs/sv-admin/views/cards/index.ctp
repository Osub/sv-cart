<?php
/*****************************************************************************
 * SV-Cart 贺卡管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1841 2009-05-27 06:51:37Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle')).'新增贺卡','/cards/add',array(),false,false);?></strong></p>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist card_headers">
	<li class="card_name">贺卡名称</li>
	<li class="picture">图片</li>
	<li class="expenses">费用</li>
	<li class="gratis">免费额度</li>
	<li class="card_bewrite">贺卡描述</li>
	<li class="effective">是否有效</li>
	<li class="hadle">操作</li></ul>
<!--Products Processing List-->
<?if(isset($cards) && sizeof($cards)>0){?>
<?php foreach($cards as $card){?>
	<ul class="product_llist card_headers card_list">
	<li class="card_name"><span><!--<?=$html->image('picflag.gif',array('align'=>'absmiddle'))?>--><strong><?php echo $card['CardI18n']['name'];?></strong></span></li>
	<li class="picture"><?=$html->image("/..{$card['Card']['img01']}",array('width'=>'39','height'=>'39','align'=>'absmiddle'))?>
	<li class="expenses"><?php echo $card['Card']['fee']?></li>
	<li class="gratis"><?php echo $card['Card']['free_money']?></li>
	<li class="card_bewrite"><span><?php echo $card['CardI18n']['description']?></span></li>
	<li class="effective"><?php if($card['Card']['status'])echo $html->image('yes.gif',array('align'=>'absmiddle'));else echo $html->image('no.gif',array('align'=>'absmiddle')) ?></li>
	<li class="hadle">

	<?php echo $html->link("编辑","/cards/edit/{$card['Card']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}cards/remove/{$card['Card']['id']}')"));?>
	
	</li></ul>
	
	<?php }?>
<?}?>
<!--Products Processing List End-->
<div class="pagers" style="position:relative">
<?php echo $this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
</div>
	
<!--Main Start End-->
</div>