<?php 
/*****************************************************************************
 * SV-Cart 邮件队列列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3792 2009-08-19 11:21:35Z zhengli $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
	
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'/',"type"=>"get",'name'=>"SearchForm"));?>
	<dl>
	<dt><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p>
	添加时间：
		<input type="text" id="date" style="border:1px solid #649776" name="date" value="<?php echo @$date?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>
		<input type="text" id="date2" style="border:1px solid #649776" name="date2" value="<?php echo @$date2?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>
	关键字：
	<input type="text" style="border:1px solid #649776" name="kword_name" value="<?php echo @$kword_name;?>"/>
	</p>
	</dd>
	<dt class="big_search" style="padding-top:13px;">
		<dt class="small_search"><input type="submit"  value="搜索"  class="search_article" /></dt>
 		</dt>
	</dl><?php echo $form->end();?>
</div>
<br />
<!--Search End-->
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

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">	
	<th>发送时间</th>
	<th>主题</th>
	<th>发送人姓名</th>
	<th>接收人姓名地址</th>
	<th>抄送姓名地址</th>
	<th>暗送人姓名地址</th>
</tr>
<!--User List-->
<?php if(isset($mailsendhistory) && sizeof($mailsendhistory)>0){?>
<?php $ij=0;foreach($mailsendhistory as $k=>$v){ ?>
<tr <?php if((abs($ij)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }$ij++;?> >
	<td><?php echo $v["MailSendHistory"]["created"]; ?></td>
	<td><?php echo $v["MailSendHistory"]["title"]; ?></td>
	<td><?php echo $v["MailSendHistory"]["sender_name"]; ?></td>
	<td><?php echo $v["MailSendHistory"]["receiver_email"]; ?></td>
	<td><?php echo $v["MailSendHistory"]["cc_email"]; ?></td>
	<td><?php echo $v["MailSendHistory"]["bcc_email"]; ?></td>
</tr>
<?php }}else{?>
<tr><td align="center" colspan="7"><br />没有找到任何记录<br /><br /></td></tr>
<?php }?>
</table></div>
<!--User List End-->	
<div class="pagers" style="position:relative">
	<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
<!--Main Start End-->
</div>