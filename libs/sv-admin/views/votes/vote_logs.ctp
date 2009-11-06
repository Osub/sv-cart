<?php 
/*****************************************************************************
 * SV-Cart 在线日志列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: vote_logs.ctp 4433 2009-09-22 10:08:09Z huangbo $
*****************************************************************************/
?>


 
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('class'=>'vmiddle'))."调查列表","/votes/",'',false,false);?></strong></p>

	
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>用户</th>
	<th>主题</th>
	<th>ip地址</th>
	<th>操作系统</th>
	<th>浏览器</th>
	<th>分辨率</th>
	<th>投票内容</th>
	<th>前台是否显示</th>
	<th>操作</th>
</tr>
<!--Article List-->

<?php if(isset($vote_logs_list) && sizeof($vote_logs_list)>0){?>
<?php foreach($vote_logs_list as $k=>$v ){?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td align="center"><?php echo empty($new_user_list[$v['VoteLog']['user_id']])?"匿名用户/游客":$new_user_list[$v['VoteLog']['user_id']];?></td>
	<td align="center"><?php echo @$new_vote_list[$v['VoteLog']['vote_id']]?></td>
	<td align="center"><?php echo @$v['VoteLog']['ip_address']?></td>
	<td align="center"><?php echo @$v['VoteLog']['system']?></td>
	<td align="center"><?php echo @$v['VoteLog']['browser']?></td>
	<td align="center"><?php echo @$v['VoteLog']['resolution']?></td>
	<td align="center">
		<?php if(isset($v['VoteLog']['vote_option_id_arr']) && sizeof($v['VoteLog']['vote_option_id_arr'])>0){?>		
		<?php foreach($v['VoteLog']['vote_option_id_arr'] as $vv){
			echo "<p>".@$new_voteoption_list[$vv]."</p>";
		}}?>
	</td>
	<td align="center"> 
	<?php if ($v['VoteLog']['status'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($v['VoteLog']['status'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?>
	</td>
	<td align="center">
	<?php echo $html->link("编辑","vote_logs_edit/{$v['VoteLog']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}vote_logs_remove/{$v['VoteLog']['id']}')"));?>
	</td>
	</tr>

<?php } ?>	
<?php }?>
</table></div>
</div>

