<?php
/*****************************************************************************
 * SV-Cart  会员等级管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1201 2009-05-05 13:30:17Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增会员等级","add/",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist memberlevels">
	<li class="grade">会员等级名称</li>
	<li class="lowerlimit">积分下限</li>
	<li class="upperlimit">积分上限</li>
	<li class="rebate">初始折扣率(%)</li>
	<li class="block">显示价格</li>
	<li class="group">特殊会员组</li>
	<li class="buy">是否可购买</li>
	<li class="hadle">操作</li></ul>
<!--Menberleves List--><?//pr($memberlevel_list)?>
<? if(isset($memberlevel_list) && sizeof($memberlevel_list)>0){

 foreach($memberlevel_list as $k=>$v){ ?>

	<ul class="product_llist memberlevels memberlevels_list">
	<li class="grade"><span><?php echo $v['UserRankI18n']['name'] ?></span></li>
	<li class="lowerlimit"><?php echo $v['UserRank']['min_points'] ?></li>
	<li class="upperlimit"><?php echo $v['UserRank']['max_points'] ?></li>
	<li class="rebate"><?php echo $v['UserRank']['discount'] ?></li>
	<li class="block"><?if ($v['UserRank']['show_price'] == 1){?><?=$html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?}elseif($v['UserRank']['show_price'] == 0){?><?=$html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?}?></li>
	<li class="group"><?if ($v['UserRank']['special_rank'] == 1){?><?=$html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?}elseif($v['UserRank']['special_rank'] == 0){?><?=$html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?}?></li>
	<li class="buy"><?if ($v['UserRank']['allow_buy'] == 1){?><?=$html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?}elseif($v['UserRank']['allow_buy'] == 0){?><?=$html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?}?></li>
	<li class="hadle">
		<?php echo $html->link("编辑","/memberlevels/edit/".$v['UserRank']['id'],array());?> | <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}memberlevels/remove/{$v['UserRank']['id']}')"));?>
	</li></ul>

	
<? } }?>
<!--Menberleves List End-->	

<div class="pagers">
 <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
</div>
<!--Main Start End-->
</div>