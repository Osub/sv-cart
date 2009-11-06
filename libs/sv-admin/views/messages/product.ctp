<?php 
/*****************************************************************************
 * SV-Cart 留言管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3304 2009-07-24 09:18:00Z zhangshisong $
*****************************************************************************/
?>
<p class="none"><span id="show3">&nbsp;eee</span><span id="show4">&nbsp;</span></p>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('messages',array('action'=>'product','name'=>'UserForm','type'=>'get','onsubmit'=>"return false"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">留言标题：<input type="text" name="title" value="<?php echo @$titles?>" class="name" />&nbsp;&nbsp;发布时间：<input type="text" name="start_time" style="border:1px solid #649776" id="date"value="<?php echo @$start_time?>" readonly="readonly" /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>－<input type="text" name="end_time" value="<?php echo @$end_time?>" style="border:1px solid #649776" id="date2" readonly="readonly" /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?></p></dd>
	<dt class="small_search"><input type="submit" value="搜索" onclick="search_user()"  class="search_article" /></dt>
<input type="hidden" name="search" value="search">
</div>
<br /><br />
<!--Search End-->
<!--Main Start-->

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="190px">用户名</th>
	<th width="190px">提问标题</th>
	<th width="400px">提问对象</th>

	<th width="150px" >提问时间</th>
	<th width="60px"> 回复</th>
	<th width="90px">操作</th></tr>
<!--Messgaes List-->
	<?php if(isset($UserMessage_list) && sizeof($UserMessage_list)>0){?>

	<?php foreach($UserMessage_list as $k=>$v){ ?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><span><?php echo $v['UserMessage']['user_name'] ?></span></td>
	<td><span><?php echo $v['UserMessage']['msg_title'] ?></span></td>
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
	<td align="center"><?php if( $v['UserMessage']['status'] == 0 ){ echo "未回复";}else{echo "已回复";}?></td>
	<td align="center">
	<?php echo $html->link("编辑","product_view/{$v['UserMessage']['id']}");?> | <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}messages/remove/{$v['UserMessage']['id']}')"));?>
		</td></tr>
	<?php }} ?><?php //pr($UserMessage_list); ?>
<!--Messgaes List End-->	
	</table></div>
	
	
	

<div class="pagers" style="position:relative">
<?php echo $form->end();?>
    <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
</div>
</div>
	
	<!--时间控件层start-->
	<div id="container_cal" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal2" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal2"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal3" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal3"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal4" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal4"></div><div style="clear:both;"></div></div>
	</div>
<!--end-->
<script type="text/javascript">
function batch_action() 
{ 
document.UserForm.action=webroot_dir+"messages/batch"; 
document.UserForm.onsubmit= "";
document.UserForm.submit(); 
} 
function search_user() 
{ 
document.UserForm.onsubmit= "";
document.UserForm.action=webroot_dir+"messages/product"; 
document.UserForm.submit(); 
} 

</script>