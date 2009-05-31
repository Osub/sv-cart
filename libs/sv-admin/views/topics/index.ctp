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
 * $Id: index.ctp 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('listtable');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($topics)?>
<!--Main Start-->
<br />
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle')).'新增专题','/topics/add','',false,false)?> </strong></p>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<?php echo $form->create('',array('action'=>'','name'=>"UserForm","type"=>"get",'onsubmit'=>"return false"));?>
	<ul class="product_llist topics_headers">
	<li class="number"><label><input type="checkbox" name="chkall" value="checkbox" onclick="selectAll(this,'checkbox');" />编号<?=$html->image('sort_desc.gif',array('align'=>'absmiddle'))?></label></li>
	<li class="theme_name">专题名称</li>
	<li class="star_time">开始时期</li>
	<li class="end_time">结束时期</li>
	<li class="hadle">操作</li></ul>
<!--Messgaes List-->
	
	

	<?if(isset($topics) && sizeof($topics) > 0){?>
	<?php foreach($topics as $topic){?>
	<ul class="product_llist topics_headers topics_list">
	<li class="number"><label><input type="checkbox" name="checkbox[]" value="<?php echo $topic['Topic']['id']?>" /><?php echo $topic['Topic']['id']?></label></li>
	<li class="theme_name"><?php echo $topic['TopicI18n']['title']?></li>
	<li class="star_time"><?php echo $topic['Topic']['start_time']?></li>
	<li class="end_time"><?php echo $topic['Topic']['end_time']?></li>
	<li class="hadle">
		<?=$html->link('查看','/../topics/'.$topic['Topic']['id'],array('target'=>'_blank'),false,false)?>|
		<?=$html->link('编辑','/topics/edit/'.$topic['Topic']['id'],'',false,false)?>|
		<?=$html->link('移除',"javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}topics/remove/{$topic['Topic']['id']}')"),false,false)?>|
		<?=$html->link('发布到广告','/advertisements/add/?title='.$topic['TopicI18n']['title']."&id=".$topic['Topic']['id'],'',false,false)?>|
		<?=$html->link('发布到Flash播放列表','/flashes/add/?id='.$topic['Topic']['id'],'',false,false)?></li></ul>
	<?php }}?>
	
<!--Messgaes List End-->	
	
	
	
	
 
<div class="pagers" style="position:relative">
<p class='batch'><select style="width:59px;border:1px solid #689F7C;display:none" name="act_type" >
	  <option value="delete">删除</option></select> <input type="submit" onclick="batch_action()" value="删除" /></p>
<? echo $form->end();?>
    <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
</div>
</div>
</div>
<? echo $form->end();?>
<script type="text/javascript">
function batch_action() 
{ 
document.UserForm.action=webroot_dir+"topics/batch"; 
document.UserForm.onsubmit= "";
document.UserForm.submit(); 
} 
</script>