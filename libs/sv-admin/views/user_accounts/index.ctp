<?php 
/*****************************************************************************
 * SV-Cart 待处理冲值
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 4218 2009-09-11 02:34:41Z huangbo $
*****************************************************************************/
?> 
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
<p class="none"><span id="show3">&nbsp;eee</span><span id="show4">&nbsp;</span></p>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'/','name'=>'UserAccountForm','type'=>'get'));?>
	<dl>
	<dt style="padding-top:2px;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" name="start_time" style="border:1px solid #649776" id="date" value="<?php echo @$start_time?>" readonly="readonly"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>－<input type="text" name="end_time" value="<?php echo @$end_time?>" style="border:1px solid #649776" id="date2" readonly="readonly" /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>
	状态：
	<select name="account_status">
	<option value="" >全部</option>
	<option value="0"<?php if(@$status=="0"){ echo "selected";}?>>待处理</option>
	<option value="1"<?php if(@$status=="1"){ echo "selected";}?>>已确认</option>
	<option value="2"<?php if(@$status=="2"){ echo "selected";}?>>已取消</option>
	</select>
	&nbsp;&nbsp;
	支付方式：
	<select name="payment">
	<option value="" >全部</option>
	<?php foreach($payments as $v){?>
	<option value="<?php echo $v['Payment']['id'];?>"<?php if(@$v['Payment']['id']==@$payment){ echo "selected";}?>><?php echo $v['PaymentI18n']['name'];?></option>
	<?php }?>
	</select>
	&nbsp;&nbsp;会员名称：<input type="text" style="border:1px solid #649776" name="name" value="<?php echo @$names?>" style="width:120px;" /></p></dd>
	<dt style="" class="small_search"><input  class="search_article" type="button" onclick="search_user_accounts()" value="查询" /></dt>
	</dl>
<?php echo $form->end();?>
</div>
<!--Search End--><br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."待处理充值","/balances/search",'',false,false);?></strong></p>

<!--Main Start-->

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="12%">操作日期</th>
	<th>会员名称</th>
	<th width="12%">金额</th>
	<th width="12%">支付方式</th>
	<th width="8%">状态</th>
	<th width="8%">操作</th>
	</tr>
<!--Products Processing List-->
<?php if(isset($UserAccount_list) && sizeof($UserAccount_list)>0){?>
<?php foreach( $UserAccount_list as $k=>$v ){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td align="center" width="150px"><span><?php echo $v['UserAccount']['created']?></span></td>
	<td><?php echo $v['UserAccount']['name']?></td>
	<td align="center"><span><?php echo $v['UserAccount']['amount']?></span></td>
	<td align="center"><?php echo $v['UserAccount']['payment_name']?></td>
	<td align="center"><span><?php if( $v['UserAccount']['status']==1 ){ echo "已确认"; }else if($v['UserAccount']['status']==2){ echo "已取消";} else{ echo "待处理";}?></span></td>
	<td align="center"><?php if($v['UserAccount']['status']==0){ ?><?php echo $html->link("确认","/user_accounts/verify/{$v['UserAccount']['id']}",'',false,false);?>|<?php echo $html->link("取消","/user_accounts/cancel/{$v['UserAccount']['id']}",'',false,false);?><?php }else{ echo "无操作";}?></td></tr>

<?php }?><?php }?>
</table></div>
<!--Products Processing List End-->
<div class="pagers" style="position:relative">
    <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>

</div>
<!--Main Start End-->
</div>
	<script type="text/javascript">
function search_user_accounts() 
{ 
	document.UserAccountForm.action=webroot_dir+"user_accounts/"; 
	document.UserAccountForm.submit(); 
} 
</script>

