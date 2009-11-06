<?php 
/*****************************************************************************
 * SV-Cart 待处理留言
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
 
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>

<!--Main Start-->
<br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."留言管理","/messages/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<?php echo $form->create('',array('action'=>'',"type"=>"get",'name'=>'UserForm','onsubmit'=>"return false"));?>
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th align="left"><input type="checkbox" name="chkall" value="checkbox" onclick="selectAll(this,'checkbox');" />编号<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th>用户名</th>
	<th>会员等级</th>
	<th>留言标题</th>
	<th>类型</th>
	<th width="400px">留言对象</th>
	<th width="150px">留言时间<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th width="80px">操作</th></tr>
<!--Comment Uncheck-->
	<?php if(isset($UserMessage_list) && sizeof($UserMessage_list)>0){?>
	<?php foreach($UserMessage_list as $k=>$v){ ?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><input type="checkbox" name="checkbox[]" value="<?php echo $v['UserMessage']['id'] ?>" /><?php echo $v['UserMessage']['id'] ?></td>
	<td><span><?php echo $v['UserMessage']['name'] ?></span></td>
	<td align="center"><?php echo $v['UserMessage']['rank'] ?></td>

	<td><span><?php echo $html->link("{$v['UserMessage']['msg_title']}","/messages/view_search/{$v['UserMessage']['id']}",'',false,false);?></span></td>
	<td align="center"><?php echo $systemresource_info["msg_type"][$v['UserMessage']['msg_type']] ?></td>
	<td  width="400px">
		<?php echo @$systemresource_info["type"][$v['UserMessage']['type']]?>
		<?php if( $v['UserMessage']['type'] == "P"){?>
			：<?php echo @$products_list[$v['UserMessage']['value_id']]?>
		<?php }else if($v['UserMessage']['type'] == "O"){?>
			：<?php echo @$order_list[$v['UserMessage']['value_id']]["Order"]["order_code"]?>
		<?php }else{?>
			未知对象
		<?php }?>
	</td>

	<td align="center"><?php echo $v['UserMessage']['created'] ?></td>
	<td align="center">


	<?php echo $html->link("编辑","/messages/view_search/{$v['UserMessage']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}messages/remove_search/{$v['UserMessage']['id']}/{$v['UserMessage']['msg_title']}')"));?>

		</td></tr>
	<?php } }?>
</table></div>
<!--Comment Uncheck End-->	
	<?php if(isset($UserMessage_list) && sizeof($UserMessage_list)>0){?>	
	<input type="hidden" name="search" value="search">
<div class="pagers" style="position:relative">
<p class='batch'><select name="act_type"  style="width:59px;border:1px solid #689F7C;display:none;"><option value="delete">删除</option></select> <input type="button" onclick="batch_action()" value="删除" />&nbsp; &nbsp;<input type="button" value="导出"  onclick="export_act()"  /></p>
<?php }?>
    <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
    <input type="hidden" id="url" <?php   if(isset($ex_page)){  ?> value="/messages/search/unprocess?page=<?php echo $ex_page;?>&export=export"<?php }else{ ?> value="/messages/search/unprocess?export=export"<?php } ?>/>
</div>
<!--Main Start End-->
</div>  
<?php echo $form->end();?>
<script type="text/javascript">
function batch_action() 
{ 
document.UserForm.action=webroot_dir+"messages/batch"; 
document.UserForm.onsubmit= "";
document.UserForm.submit(); 
} 
function export_act(){ 
	var url=document.getElementById("url").value;
	window.location.href=webroot_dir+url;
} 
</script>