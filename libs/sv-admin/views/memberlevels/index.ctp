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
 * $Id: index.ctp 2520 2009-07-02 02:01:40Z zhengli $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增会员等级","add/",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>会员等级名称</th>
	<th>积分下限</th>
	<th>积分上限</th>
	<th>初始折扣率(%)</th>
	<th>显示价格</th>
	<th>特殊会员组</th>
	<th>是否可购买</th>
	<th>操作</th></tr>
<!--Menberleves List--><?php //pr($memberlevel_list)?>
<?php if(isset($memberlevel_list) && sizeof($memberlevel_list)>0){

 foreach($memberlevel_list as $k=>$v){ ?>

	<tr>
	<td align="center"><span><?php echo $v['UserRankI18n']['name'] ?></span></td>
	<td align="center"><?php echo $v['UserRank']['min_points'] ?></td>
	<td align="center"><?php echo $v['UserRank']['max_points'] ?></td>
	<td align="center"><?php echo $v['UserRank']['discount'] ?></td>
	<td align="center"><?php if ($v['UserRank']['show_price'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($v['UserRank']['show_price'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?></td>
	<td align="center"><?php if ($v['UserRank']['special_rank'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($v['UserRank']['special_rank'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?></td>
	<td align="center"><?php if ($v['UserRank']['allow_buy'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($v['UserRank']['allow_buy'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?></td>
	<td align="center">
		<?php echo $html->link("编辑","/memberlevels/edit/".$v['UserRank']['id'],array());?> | <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}memberlevels/remove/{$v['UserRank']['id']}')"));?>
	</td></tr>

	
<?php } }?>
<!--Menberleves List End-->	
</table>
<div class="pagers">
 <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
</div>
<!--Main Start End-->
</div>