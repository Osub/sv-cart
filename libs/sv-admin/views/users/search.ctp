<?php 
/*****************************************************************************
 * SV-Cart 搜索用户
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: search.ctp 3673 2009-08-17 09:57:45Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour',"navigations"=>$navigations));//pr($users);?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."用户查询","/users/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">	
	<th align="left" width="6%"><input type="checkbox" name="checkbox" value="checkbox" />编号<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th>会员名称</th>
	<th width="15%">邮件地址</th>
	<th width="12%">注册日期</th>
	<th width="8%">余额</th>
	<th width="8%">操作</th></tr>
<!--Unvalidate List-->
<?php if(isset($users) && sizeof($users)>0){?>
	<?php foreach($users as $k=>$user){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><input type="checkbox" name="checkbox" value="checkbox" /><?php echo $user['User']['id']?></td>
	<td><strong><?php echo $user['User']['name']?></strong></td>
	<td align="center"><span><?php echo $user['User']['email']?></span></td>
	<td align="center"><?php echo $user['User']['created']?></td>
	<td align="center"><?php echo $user['User']['balance']?></td>
	<td align="center">
		<span><?php echo $html->link('认证','search/userconfirm/'.$user['User']['id'],'',false,false)?></a></span>|<span><?php echo $html->link('取消认证','search/cancel/'.$user['User']['id'],'',false,false)?></span>
	</td></tr>
	<?php }}?>
</table></div>
<!--<p class='batch'><select style="width:59px;border:1px solid #689F7C"><option>删除</option></select> <input type="button" value="批量处理" /></p>-->
<div class="pagers" style="position:relative">
<?php if(isset($users) && sizeof($users)>0){?>  <p class='batch'><input type="button" value="导出"  onclick="export_act()"/></p><?php }?>
<input type="hidden" id="url" <?php   if(isset($ex_page)){  ?> value="/users/search/unvalidate?page=<?php echo $ex_page;?>&export=export"<?php }else{ ?> value="/users/search/?export=export"<?php } ?>/>
<?php echo $this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
</div>
<!--Main Start End-->
</div>
<script type="text/javascript">
function export_act(){ 
	var url=document.getElementById("url").value;
	window.location.href=webroot_dir+url;
}
</script>