<?php 
/*****************************************************************************
 * SV-Cart 待处理评论
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
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."评论查询","/comments/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">

<?php echo $form->create('',array('action'=>'','name'=>'UserForm','type'=>'get','onsubmit'=>"return false"));?>
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">	
	<th align="left" width="6%"><input type="checkbox" name="chkall" value="checkbox" onclick="selectAll(this,'checkbox');" />编号</th>
	<th>用户名</th>
	<th width="8%">会员等级</th>
	<th width="8%">类型</th>
	<th width="8%">评论对象</th>
	<th width="12%">IP地址</th>
	<th width="14%">评论时间<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th width="10%">操作</th></tr>
<!--Comment Uncheck-->
<?php if(isset($comments_info) && sizeof($comments_info)>0){?>
<?php foreach($comments_info as $k=>$v){?>

<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><input type="checkbox" name="checkbox[]" value="<?php echo $v['Comment']['id']?>" /><?php echo $v['Comment']['id']?></td>
	<td><span><?php echo $v['Comment']['name']?></span></td>
	<td align="center"><?php echo $v['Comment']['user_rank'];?></td>
	<td align="center"><?php echo $v['Comment']['type']?></td>
	<td align="center"><span><?php echo $v['Comment']['object']?></span></td>
	<td align="center"><span><?php echo $v['Comment']['ipaddr']?></span></td>
	<td align="center"><?php echo $v['Comment']['created']?></td>
	<td align="center">
	<?php echo $html->link("查看详情","/comments/edit_search/{$v['Comment']['id']}");?>
	|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}comments/searchremove/{$v['Comment']['id']}')"));?>
	</td></tr>
	<?php }?><?php }?></table></div>
<!--Comment Uncheck End-->	
 <input type="hidden" name="search" value="search">
<div class="pagers" style="position:relative">
<?php if(isset($comments_info) && sizeof($comments_info)>0){?>
<p class='batch'><select style="width:59px;border:1px solid #689F7C;display:none;" name="act_type"><option value="delete">删除</option></select> <input type="button" onclick="batch_action()" value="删除" /> &nbsp; &nbsp;<input type="button" value="导出"  onclick=export_act()  /></p><?php }?>
<?php echo $form->end();?>
<input type="hidden" id="url" <?php   if(isset($ex_page)){  ?> value="/comments/search/uncheck?page=<?php echo $ex_page;?>&export=export"<?php }else{ ?> value="/comments/search/uncheck?export=export"<?php } ?>/>
 <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
</div>
<!--Main Start End-->
</div>
<script type="text/javascript">
function batch_action(){ 
	document.UserForm.action=webroot_dir+"comments/batch"; 
	document.UserForm.onsubmit= "";
	document.UserForm.submit(); 
} 
function export_act(){ 
	var url=document.getElementById("url").value;
	window.location.href=webroot_dir+url;
} 

</script>