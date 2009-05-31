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
 * $Id: search.ctp 725 2009-04-17 08:00:21Z huangbo $
*****************************************************************************/
?> 


<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'/','name'=>'UserAccountForm','type'=>'get'));?>
	<dl>
	<dt style="padding-top:2px;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" name="start_time" class="time" id="date" value="<?=@$start_time?>" readonly="readonly"/><button id="show" type="button"><?=$html->image('calendar.gif')?></button>－<input type="text" name="end_time" value="<?=@$end_time?>" class="time" id="date2" readonly="readonly" /><button id="show2" type="button"><?=$html->image('calendar.gif')?></button>
	状态：
	<select name="account_status">
	<option value="" >全部</option>
	<option value="0"<?if(@$status=="0"){ echo "selected";}?>>待处理</option>
	<option value="1"<?if(@$status=="1"){ echo "selected";}?>>已确认</option>
	<option value="2"<?if(@$status=="2"){ echo "selected";}?>>已取消</option>
	</select>
	&nbsp;&nbsp;
	支付方式：
	<select name="payment">
	<option value="" >全部</option>
	<?php foreach($payments as $v){?>
	<option value="<?=$v['Payment']['id'];?>"<?if(@$v['Payment']['id']==@$payment){ echo "selected";}?>><?=$v['PaymentI18n']['name'];?></option>
	<?php }?>
	</select>
	&nbsp;&nbsp;会员名称：<input type="text" class="time" name="name" value="<?=@$names?>" style="width:120px;" /></p></dd>
	<dt style="" class="curement"><input type="button" onclick="search_user_accounts()" value="查询" /></dt>
	</dl>
<? echo $form->end();?>
</div>
<!--Search End-->

<!--Main Start-->
<br />
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist products_processing">
	<li class="membername">会员名称</li>
	<li class="handel_time">操作日期</li>
	<li class="money">金额</li>
	<li class="payment">支付方式</li>
	<li class="remark">状态</li>
	<li class="hadle">操作</li></ul>
<!--Products Processing List-->
<?if(isset($UserAccount_list) && sizeof($UserAccount_list)>0){?>
<? foreach( $UserAccount_list as $k=>$v ){?>
	<ul class="product_llist products_processing products_processing_list">
	<li class="membername"><span><?=$v['UserAccount']['name']?></span></li>
	<li class="handel_time"><?=$v['UserAccount']['created']?></li>
	<li class="money"><span><?=$v['UserAccount']['amount']?></span></li>
	<li class="payment"><?=$v['UserAccount']['payment_name']?></li>
	<li class="remark"><span><?if( $v['UserAccount']['status']==1 ){ echo "已确认"; }else if($v['UserAccount']['status']==2){ echo "已取消";} else{ echo "待处理";}?></span></li>
	<li class="hadle"><?php if($v['UserAccount']['status']==0){ ?><?=$html->link("确认","/user_accounts/verify/{$v['UserAccount']['id']}",'',false,false);?>|<?=$html->link("取消","/user_accounts/cancel/{$v['UserAccount']['id']}",'',false,false);?><?php }else{ echo "无操作";}?></li></ul>

<?}?><?}?>

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