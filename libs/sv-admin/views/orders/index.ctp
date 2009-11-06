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
 * $Id: index.ctp 4893 2009-10-11 10:07:01Z huangbo $
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
		<dd><p class="reg_time">下单时间：<input type="text" id="date" name="date" style="border:1px solid #649776" value="<?php echo @$start_time?>" readonly /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?> <input type="text" id="date2" name="date2" style="border:1px solid #649776" value="<?php echo @$end_time?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>
	 	收货人：<input type="text" style="border:1px solid #649776" name="consignee" id="consignee" value="<?php echo $consignee?>"/> 订单号：<input type="text" style="border:1px solid #649776" name="order_id" id="order_id" value="<?php echo $order_id?>"/></p>
	<p>
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
		下单语言:
			<select name="order_locale">
			<option value="all">所有语言</option>
			<?php if(isset($languages) && sizeof($languages)>0){
			foreach ($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale']?>" <?php if($v['Language']['locale']==$locale){echo "selected";}?>><?php echo $v['Language']['name']?></option>
			<?php }}?>
			</select>
		<?php }?>
		CSV导出编码:
			<select id="csv_export_code">
			<?php if(isset($systemresource_info["csv_export_code"]) && sizeof($systemresource_info["csv_export_code"])>0){
			foreach ($systemresource_info["csv_export_code"] as $k => $v){if($k!=""){?>
			<option value="<?php echo $k;?>" <?php if($k==$csv_export_code){echo "selected";}?>><?php echo $v;?></option>
			<?php }}}?>
			</select>
			<input type="button" value="导出" class="search_article" onclick="export_act()" />
		</p></dd>
		<dt class="big_search"><input type="button" class="big" value="搜索" onclick="search_act()" /></dt>
	</dl>
<?php echo $form->end();?>
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
<br />
<!--Search End-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增订单","/orders/add/",'',false,false);?> <?php echo $html->link("待处理订单","/orders/?search=search",'',false,false);?></strong></p>
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<?php echo $form->create('',array('action'=>'/batch_shipping_print/',"name"=>"OrdForm",'onsubmit'=>"return true"));?>
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="10%"><input type="checkbox" class="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>订单号</th>
	<th width="11%" >下单时间</th>
	<th>收货人</th>
	<th width="13%">会员名称</th>
	<th width="13%">费用</th>
	<th width="6%">支付方式</th>
	<th width="6%">配送方式</th>
	<th width="12%">订单状态</th>
	<th width="11%" >操作</th>
</tr>
<!--List Start-->
<?php if(isset($orders_list) && sizeof($orders_list)>0){?>
<?php foreach($orders_list as $k=>$v){?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><input type="checkbox" class="checkbox" name="checkboxes[]" value="<?php echo $v['Order']['id']?>" /><?php echo $html->link("{$v['Order']['order_code']}","/orders/{$v['Order']['id']}",array("target"=>"_blank"),false,false);?></td>
	<td align="center"><?php echo $v['Order']['created']?></td>
	<td>
		<?php echo $v['Order']['consignee']?><?php if(isset($v['Order']['telephone']) && !empty($v['Order']['telephone'])){?> [TEL:<?php echo $v['Order']['telephone']?>]<?php }?><br />
		<?php echo $v['Order']['address']?>
	</td>
	<td>
		<?php echo @$user_info[$v['Order']['user_id']]?><br />
		<?php echo @$v['Order']['email']?>
	</td>
	<td>
		总 金 额:<?php echo $v['Order']['total']?><br />
		应付金额:<?php echo $v['Order']['should_pay']?>
	</td>
	<td align="center"><?php echo $v['Order']['payment_name']?></td>
	<td align="center"><?php echo $v['Order']['shipping_name']?></td>
	<td align="center"><?php echo $systemresource_info["order_status"][$v['Order']['status']];?>,<?php echo $systemresource_info["payment_status"][$v['Order']['payment_status']];?>,<?php echo $systemresource_info["shipping_status"][$v['Order']['shipping_status']];?></td>
	<td align="center"><?php echo $html->link("查看","/orders/{$v['Order']['id']}",array("target"=>"_blank"));?> | <?php echo $html->link("编辑","/orders/edit/{$v['Order']['id']}");?> | <?php echo $html->link("删除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除该订单?','{$admin_webroot}orders/delete_order/{$v['Order']['id']}')"));?><?php if(($v['Order']['allvirtual']==0)&&((($v['Order']['is_cod']==1)&&($v['Order']['status']==1)&&($v['Order']['shipping_status']==0))||(($v['Order']['is_cod']==0)&&($v['Order']['payment_status']==2)&&($v['Order']['shipping_status']==0)))){?><br/><?php echo $html->link("打印配送单","/orders/batch_shipping_print/{$v['Order']['id']}");?><?php } ?></td>
</tr>
<?php }}?>
</table></div>
<!--List End-->
<div class="pagers" style="position:relative">
<?php if(isset($orders_list) && sizeof($orders_list)>0){?>	
<p class='batch'>
	<input type="button" value="确认" onclick="diachange(this,'confirm_status')" />
	<input type="button" value="付款" onclick="diachange(this,'payment_status')" />
	<input type="button" value="取消" onclick="diachange(this,'cancel_status')" />
	<input type="button" value="无效" onclick="diachange(this,'invalid_status')" />
	<input type="button" value="删除" onclick="batch_delete()" />
	<input name="act" type="hidden" value="batch"/>
	<input type="button" value="打印配送单" onclick="target='_blank';batch_shipping_print()" id="change_button" />
</p>
<?php }?>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
<?php echo $form->end();?>
</div>
</div>

<script>
function diachange(obj,thisstatus){

		var id=document.getElementsByName('checkboxes[]');
		var j=0;
		var image="";
		for( i=0;i<=parseInt(id.length)-1;i++ ){
			if(id[i].checked){
				j++;
			}
		}
		if( j>=1 ){
			layer_dialog_show('确定'+obj.value+'?','batch_change_status("'+thisstatus+'")',5);
		}else{
			layer_dialog_show('请选择！！','',3);
		}
	}

	

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

function batch_delete(){
    var id=document.getElementsByName('checkboxes[]');
	var i;
	var j=0;
	for( i=0;i<=parseInt(id.length)-1;i++ ){
		if(id[i].checked){
			j++;
		}
	}
	if( j<1 ){
		layer_dialog_show('请选择！！','',3);
	}else{
		layer_dialog_show('确定删除选中的订单吗?','batch_delete_act()',5);
	}
}

function batch_delete_act(){
		document.OrdForm.action=webroot_dir+"orders/batch_delete";
	    document.OrdForm.onsubmit= "";
		document.OrdForm.submit();
}



function search_act(){ 
	document.SearchForm.action=webroot_dir+"orders/index";
	document.SearchForm.onsubmit= "";
	document.SearchForm.submit(); 
}

function export_act(){ 
	var csv_export_code = GetId("csv_export_code");
	document.SearchForm.action=webroot_dir+"orders/index/export/"+csv_export_code.value;
	document.SearchForm.onsubmit= "";
	document.SearchForm.submit(); 
}

</script>
