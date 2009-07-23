<?php 
/*****************************************************************************
 * SV-Cart 订单管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 2952 2009-07-16 09:56:25Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link('order');?>

<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Search-->

<div class="search_box">
  <?php echo $form->create('',array('action'=>'/','type'=>'get','name'=>"SearchForm"));?>

	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif')?></dt>
	<dd><p class="reg_time">下单时间：<input type="text" id="date" name="date" value="<?php echo @$start_time?>" readonly />
	<?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>
	<input type="text" id="date2" name="date2" value="<?php echo @$end_time?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>
	&nbsp;&nbsp;收货人：<input type="text" class="name" name="consignee" id="consignee" value="<?php echo $consignee?>"/>&nbsp;&nbsp;订单号：<input type="text" class="name" name="order_id" id="order_id" value="<?php echo $order_id?>"/></p>
	<p class="confine">
		<select style="width:110px;" name="order_status">
		<?php foreach( $systemresource_info["order_status"] as $k=>$v ){ ?>
		<option value="<?php echo $k;?>" <?php if ($order_status == $k){?>selected<?php }?> ><?php echo $v;?></option>
		<?php }?>
		</select>
		<select style="width:110px;" name="shipping_status">
		<?php foreach( $systemresource_info["shipping_status"] as $k=>$v ){ ?>
		<option value="<?php echo $k;?>" <?php if ($shipping_status == $k){?>selected<?php }?> ><?php echo $v;?></option>
		<?php }?>
		</select>
		<select style="width:110px;" name="payment_status">
		<?php foreach( $systemresource_info["payment_status"] as $k=>$v ){ ?>
		<option value="<?php echo $k;?>" <?php if ($payment_status == $k){?>selected<?php }?> ><?php echo $v;?></option>
		<?php }?>
		</select>
		<?php if(isset($SVConfigs["mlti_currency_module"]) && $SVConfigs["mlti_currency_module"]==1){?>
	语言:	<select name="order_locale">
			<option value="all">all</option>
		<?php if(isset($languages) && sizeof($languages)>0){
			foreach ($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale']?>" <?php if($v['Language']['locale']==$locale){echo "selected";}?>><?php echo $v['Language']['name']?></option>
		<?php }}?>
	</select>
		<?php }?>
			</p></dd>
	<dt class="big_search"><input type="button" class="big" value="搜索" onclick="search_act()" /> <input type="button" value="导出"   class="big"  onclick="export_act()" />	
</dt>
	</dl>
<?php echo $form->end();?>
</div>


<br />
<!--Search End-->

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<?php echo $form->create('',array('action'=>'/batch_shipping_print/',"name"=>"OrdForm",'onsubmit'=>"return true"));?>
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th align="left" width="120px"><input type="checkbox" class="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>订单号</th>
	<th width="140px" >下单时间</th>
	<th>收货人</th>
	<th width="150px">费用</th>
	<th width="110px">支付方式</th>
	<th width="80px">配送方式</th>
	<th width="140px">订单状态</th>
	<th width="70px" >操作</th>
</tr>
<!--List Start-->
<?php if(isset($orders_list) && sizeof($orders_list)>0){?>
<?php foreach($orders_list as $k=>$v){?>
	<tr>
	<td width="140px" class="order_num no_wrap"><input type="checkbox" class="checkbox" name="checkboxes[]" value="<?php echo $v['Order']['id']?>" /><?php echo $html->link("{$v['Order']['order_code']}","/orders/{$v['Order']['id']}",'',false,false);?></td>
	<td align="center" width="120px"><?php echo $v['Order']['created']?></td>
	<td><p><?php echo $v['Order']['consignee']?><?php if(isset($v['Order']['telephone']) && !empty($v['Order']['telephone'])){?> [TEL:<?php echo $v['Order']['telephone']?>]<?php }?></p>
		<p><?php echo $v['Order']['address']?></p>
	</td>
	<td width="150px">
		<p>总金额:&nbsp&nbsp&nbsp&nbsp  <?php echo $v['Order']['total']?></p>
		<p>应付金额: <?php echo $v['Order']['should_pay']?></p>
	</td>
	<td align="center" width="110px"><?php echo $v['Order']['payment_name']?></td>
	<td align="center" width="80px"><?php echo $v['Order']['shipping_name']?></td>
	<td align="center" width="140px" ><?php echo $systemresource_info["order_status"][$v['Order']['status']];?>,<?php echo $systemresource_info["payment_status"][$v['Order']['payment_status']];?>,<?php echo $systemresource_info["shipping_status"][$v['Order']['shipping_status']];?></td>
	<td align="center" width="70px" ><?php echo $html->link("查看","/orders/{$v['Order']['id']}");?> | <?php echo $html->link("编辑","/orders/edit/{$v['Order']['id']}");?><?php if(($v['Order']['allvirtual']==0)&&((($v['Order']['is_cod']==1)&&($v['Order']['status']==1)&&($v['Order']['shipping_status']==0))||(($v['Order']['is_cod']==0)&&($v['Order']['payment_status']==2)&&($v['Order']['shipping_status']==0)))){?><br/><?php echo $html->link("打印配送单",
"/orders/batch_shipping_print/{$v['Order']['id']}");?><?php } ?></td></tr>
<?php }}?>
</table>
<!--List End-->
<div class="pagers" style="position:relative">
<?php if(isset($orders_list) && sizeof($orders_list)>0){?>	
<p class='batch'>
	<input type="button" value="确认" onclick="batch_change_status('confirm_status')" />
	<input type="button" value="付款" onclick="batch_change_status('payment_status')" />
	<input type="button" value="取消" onclick="batch_change_status('cancel_status')" />
	<input type="button" value="无效" onclick="batch_change_status('invalid_status')" />
	<input name="act" type="hidden" value="batch"/>
	<input type="button" value="打印配送单" onclick="target='_blank';batch_shipping_print()" id="change_button" />
</p>
<?php }?>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
<?php echo $form->end();?>
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
<script>
function batch_change_status(status){
    var id=document.getElementsByName('checkboxes[]');
	var i;
	var j=0;
	for( i=0;i<=parseInt(id.length)-1;i++ ){
		if(id[i].checked){
			j++;
		}
	}
	if( j<1 ){
		return false;
	}else{
		document.OrdForm.action=webroot_dir+"orders/order_status/"+status+"/";
	    document.OrdForm.onsubmit= "";
	    document.OrdForm.submit();
	}
}
function batch_shipping_print(){
    var id=document.getElementsByName('checkboxes[]');
	var i;
	var j=0;
	for( i=0;i<=parseInt(id.length)-1;i++ ){
		if(id[i].checked){
			j++;
		}
	}
	if( j<1 ){
		return false;
	}else{
		document.OrdForm.action=webroot_dir+"orders/batch_shipping_print";
	    document.OrdForm.onsubmit= "";
	    document.OrdForm.submit();
	}
}

function search_act(){ 
	document.SearchForm.action=webroot_dir+"orders/index";
	document.SearchForm.onsubmit= "";
	document.SearchForm.submit(); 
}

function export_act(){ 
//	var url=document.getElementById("url").value;
//	window.location.href=webroot_dir+url;
	document.SearchForm.action=webroot_dir+"orders/index/export";
	document.SearchForm.onsubmit= "";
	document.SearchForm.submit(); 
}
</script>
