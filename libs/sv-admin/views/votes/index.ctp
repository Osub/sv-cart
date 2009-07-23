<?php
/*****************************************************************************
 * SV-Cart 在线调查列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 2703 2009-07-08 11:54:52Z huangbo $
 *****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>


<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('class'=>'vmiddle'))."添加调查主题","add/",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
	<tr class="thead">
	<th>调查主题</th>
	<th>开始日期</th>
	<th>截止日期</th>
	<th>投票数</th>
	<th>是否有效</th>
	<th>操作</th>
	</tr>
<!--Products Cat List-->
<?php if(isset($vote_list) && sizeof($vote_list)>0){?>
<?php foreach($vote_list as $k=>$v){?>
	<tr>
	<td align="center"><?php echo $v['VoteI18n']['name'];?></td>
	<td align="center"><?php echo $v['Vote']['start_time']?></td>
	<td align="center"><?php echo $v['Vote']['end_time'];?></td>
	<td align="center"><?php echo $v['Vote']['vote_count'];?></td>
    <td align="center"><?php if ($v['Vote']['status'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($v['Vote']['status'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?></td>
	<td align="center">
		<?php echo $html->link("调查选项","/votes/option_list/{$v['Vote']['id']}");?>
		|<?php echo $html->link("查看","/votes/vote_logs/{$v['Vote']['id']}");?>
		|<?php echo $html->link("编辑","/votes/edit/{$v['Vote']['id']}");?>
		|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}votes/remove/{$v['Vote']['id']}')"));?>
	</td>
	</tr>
<?php }?>
<?php }?>
</table>
<!--Products Cat List End-->
<div class="pagers" style="position:relative">
    <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
<!--Main Start End-->
</div>