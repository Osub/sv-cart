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
 * $Id: index.ctp 2520 2009-07-02 02:01:40Z zhengli $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle')).'新增贺卡','/cards/add',array(),false,false);?></strong></p>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
	<tr class="thead">
	<th>贺卡名称</th>
	<th>图片</th>
	<th>费用</th>
	<th>免费额度</th>
	<th>贺卡描述</th>
	<th>是否有效</th>
	<th>操作</th></tr>
<!--Products Processing List-->
<?php if(isset($cards) && sizeof($cards)>0){?>
<?php foreach($cards as $card){?>
	<tr>
	<td><span><!--<?php echo $html->image('picflag.gif',array('align'=>'absmiddle'))?>--><strong><?php echo $card['CardI18n']['name'];?></strong></span></td>
	<td align="center"><?php echo $html->image("/..{$card['Card']['img01']}",array('width'=>'39','height'=>'39','align'=>'absmiddle'))?></td>
	<td align="center"><?php echo $card['Card']['fee']?></td>
	<td align="center"><?php echo $card['Card']['free_money']?></td>
	<td align="center"><span><?php echo $card['CardI18n']['description']?></span></td>
	<td align="center"><?php if($card['Card']['status'])echo $html->image('yes.gif',array('align'=>'absmiddle'));else echo $html->image('no.gif',array('align'=>'absmiddle')) ?></td>
	<td align="center">

	<?php echo $html->link("编辑","/cards/edit/{$card['Card']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}cards/remove/{$card['Card']['id']}')"));?>
	
	</td></tr>
	
	<?php }?>
<?php }?></table>
<!--Products Processing List End-->
<div class="pagers" style="position:relative">
<?php echo $this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
</div>
	
<!--Main Start End-->
</div>