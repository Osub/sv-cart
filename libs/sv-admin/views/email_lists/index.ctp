<?php 
/*****************************************************************************
 * SV-Cart 杂志模板管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3669 2009-08-17 09:24:48Z zhengli $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增杂志","add/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' );height:auto!important;">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="43%">杂志标题</th>
	<th width="12%">杂志上次编辑时间</th>
	<th width="12%">杂志上次发送时间</th>
	<th width="25%">插入发送队列</th>
	<th width="8%">操作</th>
</tr>
<!--Competence List-->
<?php if(isset($MailTemplate_list) && sizeof($MailTemplate_list)>0){?>
<?php foreach( $MailTemplate_list as $k=>$v ){ ?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><?php echo $v["MailTemplateI18n"]["title"]?></td>
	<td><?php echo $v["MailTemplate"]["modified"]?></td>
	<td><?php echo $v["MailTemplate"]["last_send"]?></td>
	<td align="center">	
	<select id="toppri<?php echo $v['MailTemplate']['id']?>">
	<?php foreach($systemresource_info["message_queue_priority"] as $kk=>$vv){?>
	<option value="<?php echo $kk;?>"><?php echo $vv;?></option>
	<?php }?>
	</select>
	<select id="usermode<?php echo $v['MailTemplate']['id']?>">
	<option value="newsletter_user">邮件订阅用户</option>
	<option value="user_all">全体会员</option>
	<?php foreach($user_rank_data as $kk=>$vv){?>
	<option value="<?php echo $vv['UserRank']['id'];?>"><?php echo $vv['UserRankI18n']['name'];?></option>
	<?php }?>
	</select>
	<input type="button" value="确定" onclick="newsletter_email(<?php echo $v['MailTemplate']['id']?>)">
</td>
	<td align="center">
		<?php echo $html->link("编辑","/email_lists/edit/{$v['MailTemplate']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}email_lists/remove/{$v['MailTemplate']['id']}')"));?>
	</td>
</tr>
<?php } }?>
</table></div>
<!--Competence List End-->	

<br />
</div>

<!--Main Start End-->
</div>
<script type="text/javascript">
function newsletter_email(num){
	var usermode = GetId("usermode"+num);
	var toppri = GetId("toppri"+num);
	window.location.href = webroot_dir+"email_lists/insert_email_queue/"+usermode.value+"/"+toppri.value+"/"+num+"/";
}
</script>