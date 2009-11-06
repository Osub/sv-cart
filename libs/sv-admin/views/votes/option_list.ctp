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
 * $Id: option_list.ctp 3673 2009-08-17 09:57:45Z huangbo $
*****************************************************************************/
?> 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>

<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('class'=>'vmiddle'))."添加选项","option_add/".$vote_id,'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="6%">选项编号</th>
	<th width="15%">调查选项</th>
	<th >选项描述</th>
	<th width="8%">选项投票数</th>
	<th width="8%">是否有效</th>
	<th width="8%">操作</th>
</tr>
<!--Products Cat List-->
<?php if(isset($voteoption_list) && sizeof($voteoption_list)>0){?>
<?php foreach($voteoption_list as $k=>$v){?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >	
	<td align="center"><?php echo $v['VoteOption']['id'];?></td>
	<td align="center"><?php echo $v['VoteOptionI18n']['name']?></td>
	<td align="center"><?php echo $v['VoteOptionI18n']['description'];?></td>
	<td align="center"><?php echo $v['VoteOption']['option_count'];?></td>
	<td align="center">
		<?php if ($v['VoteOption']['status'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($v['VoteOption']['status'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?>
	</td>
	<td align="center">
		<?php echo $html->link("编辑","/votes/option_edit/{$vote_id}/{$v['VoteOption']['id']}");?>
		|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}votes/option_remove/{$v['VoteOption']['id']}')"));?>
	</td>
</tr>
<?php }?>
<?php }?>
</table></div>
<!--Products Cat List End-->
<div class="pagers" style="position:relative">
   
</div>

</div>

<!--Main Start End-->

</div>