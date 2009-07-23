<?php 
/*****************************************************************************
 * SV-Cart 专题管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 2907 2009-07-15 11:04:21Z shenyunfeng $
*****************************************************************************/
?>
 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($topics)?>
<!--Main Start-->
<br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle')).'新增专题','/topics/add','',false,false)?> </strong></p>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<?php echo $form->create('',array('action'=>'','name'=>"UserForm","type"=>"get",'onsubmit'=>"return false"));?>
	<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th align="left"><label><input type="checkbox" name="chkall" value="checkbox" onclick="selectAll(this,'checkbox');" />编号<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></label></th>
	<th>专题名称</th>
	<th>开始时期</th>
	<th>结束时期</th>
	<th>操作</th></tr>
<!--Messgaes List-->
	
	

	<?php if(isset($topics) && sizeof($topics) > 0){?>
	<?php foreach($topics as $topic){?>
	<tr>
	<td><label><input type="checkbox" name="checkbox[]" value="<?php echo $topic['Topic']['id']?>" /><?php echo $topic['Topic']['id']?></label></td>
	<td><?php echo $topic['TopicI18n']['title']?></td>
	<td align="center"><?php echo $topic['Topic']['start_time']?></td>
	<td align="center"><?php echo $topic['Topic']['end_time']?></td>
	<td align="center">
		<?php echo $html->link('查看',$server_host.$cart_webroot.'topics/'.$topic['Topic']['id'],array('target'=>'_blank'),false,false)?>|
		<?php echo $html->link('编辑','/topics/edit/'.$topic['Topic']['id'],'',false,false)?>|
		<?php echo $html->link('移除',"javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}topics/remove/{$topic['Topic']['id']}')"),false,false)?>
	<?php }}?>
	
<!--Messgaes List End-->	
	
	</table>
	
	
 
<div class="pagers" style="position:relative">
<?php if(isset($topics) && sizeof($topics) > 0){?>
<p class='batch'><select style="width:59px;border:1px solid #689F7C;display:none" name="act_type" >
	  <option value="delete">删除</option></select> <input type="submit" onclick="batch_action()" value="删除" style="display:<?php if(isset($topics) && sizeof($topics) > 0){?>block<?php }else{?>none<?php }?>" /></p>
	<?php }?>	  
<?php echo $form->end();?>
    <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
</div>
</div>
</div>
<?php echo $form->end();?>
<script type="text/javascript">
function batch_action() 
{ 
document.UserForm.action=webroot_dir+"topics/batch"; 
document.UserForm.onsubmit= "";
document.UserForm.submit(); 
} 
</script>