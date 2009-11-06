<?php
/*****************************************************************************
 * SV-Cart 查看订单
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: view.ctp 2721 2009-07-09 07:51:21Z zhengli $
 *****************************************************************************/
?>
<?php echo $javascript->link('utils');?>	
<?php echo $javascript->link('listtable');?>	
<?php echo $javascript->link('product');?>
<?php echo $javascript->link('order');?>
<?php echo $javascript->link('regions');?>
<?php echo $form->create('Order',array('action'=>'add' ,"onsubmit"=>"return add_order_basicinfo();"));?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."订单列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>
<!--Main Start-->
<span id="ajax_edit">
<div class="home_main">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="40%" valign="top" style="padding-right:5px">
<!--BaseInfo-->
	<div class="order_stat athe_infos order_base">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  基本信息</h1></div>
	  <div class="box">
	  <br />
		<table width="100%">
			<tr>
			<td width="16%" style="font-weight: bolder " align="right">购货人：</td>
			<td  width="20%"><input type="text" name="data[Order][user_id]" id="opener_select_user_id"></td>
			<td><?php echo $html->link("查找用户","javascript:;",array("onclick"=>"search_user();"),false,false);?></td>
			</tr>
		</table>
  	    <table  width="100%">
  	    	<tr><td style="font-weight: bolder " align="right">支付费用：</td><td width="84%" valign="top"><input type="text"  style="border:1px solid #649776" name="data[Order][payment_fee]"></td></tr>
  	    	<tr><td style="font-weight: bolder " align="right" valign="top">支付方式：</td><td width="84%" valign="top">
  	    		<?php if(isset($payment_list) && sizeof($payment_list)>0){?>
  				<table>
  	    		<?php $ij=0;foreach($payment_list as $k=>$v){?>
  	    		<?php $ij++;if($ij==1){?><tr><?php  }?>
  	    			<td><input type="hidden" name="data[Order][payment_name][<?php echo $v['Payment']['id']?>]" value="<?php echo $v['PaymentI18n']['name']?>"><input class="radio" type="radio" style="width:auto;border:0;" value="<?php echo $v['Payment']['id']?>" name="data[Order][payment_id]" /><?php echo $v['PaymentI18n']['name']?></td>
  	    		<?php if($ij==4){$ij=0;?></tr><?php }?>
  	    		<?php }?>
  	    		</table>
  	    		<?php }?>
  	    	</td></tr>
  	    </table>
  	    <table  width="100%">
  	    	<tr><td style="font-weight: bolder " align="right">配送费用：</td><td width="84%" valign="top"><input type="text"  style="border:1px solid #649776" name="data[Order][shipping_fee]"></td></tr>
  	    	<tr><td style="font-weight: bolder " align="right">配送方式：</td><td width="84%" valign="top">
  	    		<?php if(isset($shipping_list) && sizeof($shipping_list)>0){?>
  				<table>
  				<tr><td valign="top" colspan="4"></td></tr>
  	    		<?php $ij=0;foreach($shipping_list as $k=>$v){?>
  	    		<?php $ij++;if($ij==1){?><tr><?php  }?>
  	    			<td><input type="hidden" name="data[Order][shipping_name][<?php echo $v['Shipping']['id']?>]" value="<?php echo $v['ShippingI18n']['name']?>">
  	    				<input type="radio" class="radio" style="width:auto;border:0;" value="<?php echo $v['Shipping']['id']?>" name="data[Order][shipping_id]" /><?php echo $v['ShippingI18n']['name']?></td>
  	    		<?php if($ij==4){$ij=0;?></tr><?php }?>
  	    		<?php }?>
  	    		</table>
  	    		<?php }?>
  	    	</td></tr>
  	    </table>
		<dl><dt>订单语言：</dt><dd><?php echo $_SESSION["Admin_Locale_Name"];?><input type="hidden" name="data[Order][order_locale]" value='<?php echo $_SESSION["Admin_Locale"];?>'></dd></dl>
		<dl><dt>订单货币：</dt><dd><?php echo "RMB";?><input type="hidden" name="data[Order][order_currency]" value='RMB'></dd></dl>
		<dl><dt>下单域名：</dt><dd><?php echo $thisurl;?><input type="hidden" name="data[Order][order_domain]" value='<?php echo $thisurl;?>'></dd></dl>
	  </div>
	</div>
<!--BaseInfo Stat End-->
</td>
<td valign="top" width="58%" style="padding-left:5px;">
			
<!--TakeOver-->
	<div class="order_stat athe_infos tongxun orders_config">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  收货人信息</h1></div>
	  <div class="box">
		<dl><dt>收货人：</dt><dd><input type="text" class="text_inputs" style="width:150px;" name="data[Order][consignee]" id="OrderConsignee" /> <font color="#F90000">*</font></dd></dl>
		<dl><dt>区域：</dt><dd><span id="regions"></span><span id="region_loading" style="display:none;"><?php echo $html->image('regions_loader.gif',array("class"=>"vmiddle"))?></span></dd></dl>
		<dl><dt>电子邮件：</dt><dd><input type="text" class="text_inputs" style="width:285px;" name="data[Order][email]" id="OrderEemail"   /> <font color="#F90000">*</font></dd></dl>
		<dl><dt>地址：</dt><dd><input type="text" class="text_inputs" style="width:285px;" name="data[Order][address]" id="OrderAddress"  /> <font color="#F90000">*</font></dd></dl>
		<dl><dt>邮编：</dt><dd><input type="text" class="text_inputs" style="width:150px;" name="data[Order][zipcode]" id="OrderZipcode"  /></dd></dl>
		<dl><dt>电话：</dt><dd><input type="text" class="text_inputs" style="width:150px;" name="data[Order][telephone]" id="OrderTelephone"  /> <font color="#F90000">*</font></dd></dl>
		<dl><dt>手机：</dt><dd><input type="text" class="text_inputs" style="width:150px;" name="data[Order][mobile]" id="Ordermobile"  /> <font color="#F90000">*</font></dd></dl>
		<dl><dt>标志性建筑：</dt><dd><input type="text" class="text_inputs" style="width:285px;" name="data[Order][sign_building]" id="OrderSignBuilding" /></dd></dl>
		<dl><dt>最佳送货时间：</dt><dd><input type="text" class="text_inputs" style="width:285px;" name="data[Order][best_time]" id="OrderBestTime"  />
		<select onchange="document.getElementById('OrderBestTime').value=this.value">
			<option value="">请选择。。。</option>
			<?php foreach( $InformationResource["best_time"] as $k=>$v){?>
			<option value="<?php echo $v?>"><?php echo $v?></option>
			<?php }?>
		</select>

	 	</dd></dl>
	    <dl><dt>备注：</dt><textarea id="data_order_note" name="data[Order][note]" style="width:355px;height:60px;border:1px solid #649776;overflow-y:scroll"></textarea><dd></dd></dl>
  	  </div>
	</div>
<!--TakeOver End-->
<!--Other Stat-->
	<div class="order_stat athe_infos tongxun">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  其他信息</h1></div>
	  <div class="box">
		<dl><dt>客户给商家留言：</dt><dd><textarea style="width:355px;height:60px;border:1px solid #649776;overflow-y:scroll" name="data[Order][postscript]" id="data_order_postscript" ></textarea></dd></dl>
		<dl><dt>商家给客户的留言：</dt><dd><textarea style="width:355px;height:60px;border:1px solid #649776;overflow-y:scroll" id="data_order_to_buyer" name="data[Order][to_buyer]"></textarea></dd></dl>
		<dl><dt>发票类型：</dt><dd>
		<select name="data[Order][invoice_type]" id="data_order_invoice_type" >
			<option value='' >请选择发票。。。</option>
			<?php if(isset($InvoiceType) && sizeof($InvoiceType)>0){foreach( $InvoiceType as $k=>$v ){?>
				<option value='<?php echo $v["InvoiceType"]["id"];?>' ><?php echo $v["InvoiceTypeI18n"]["name"];?></option>
			<?php }}?>
		</select>
		</dd></dl>
		<dl><dt>发票抬头：</dt><dd><input type="text" name="data[Order][invoice_payee]" id="data_order_invoice_payee" class="text_inputs" style="width:198px;" /></dd></dl>
		<dl><dt>发票内容：</dt><dd><textarea name="data[Order][invoice_content]" id="data_order_invoice_content" style="width:355px;height:60px;border:1px solid #649776;overflow-y:scroll"></textarea></dd></dl>
		<dl><dt>缺货处理：</dt><dd><input type="text" id="data_order_how_oos" class="text_inputs" style="width:198px;"  name="data[Order][how_oos]"/>
		<select onchange="document.getElementById('data_order_how_oos').value=this.value">
			<option value="">请选择。。。</option>
			<?php foreach( $InformationResource["how_oos"] as $k=>$v){?>
			<option value="<?php echo $v?>"><?php echo $v?></option>
			<?php }?>
		</select>
		</dd></dl>
		<span style="display:none"><dl><dt>包装：</dt><dd><input type="text" id="data_order_pack_name" class="text_inputs" style="width:198px;" value="<?php echo $order_info['Order']['pack_name']?>" name="data[Order][pack_name]"/></dd></dl>
		</span>
  	  </div>
	</div>
<!--Other Stat End-->

</td>
</tr>
</table>

<p class="submit_btn"><input type="submit" value="确定"  /><input type="reset" value="重置" /></p>
</div></div>
<?php echo $form->end();?>
<script type="text/javascript">
var numvalue=0;
function insert_product_list(){
	var product_name=GetId("product_name");
	var product_code=GetId("product_code");
	var product_cat=GetId("product_cat");
	var product_brand=GetId("product_brand");
	var add_product_price = GetName('add_price[]');//价格
	var shop_price = "";
	for( var i=0;i<add_product_price.length;i++){
		if(add_product_price[i].checked){
			shop_price = add_product_price[i].value;
		}
		if(add_product_price[i].checked&&add_product_price[i].value == "user_input"){
			shop_price = GetId('user_input_price').value;
		}
	
	}
	//end
	var product_attr=GetId("product_attr");
	var product_number=GetId("product_number");
	var list_product=GetId("list_product");
	var product_id = GetId("product_id");
	list_product.innerHTML+= "<tr><td align='center'><input type='hidden' name='data[OrderProduct]["+numvalue+"][product_id]' value='"+product_id.value+"'><input type='hidden' name='data[OrderProduct]["+numvalue+"][product_code]' value='"+product_code.value+"'>"+product_code.value+"</td><td align='center'><input type='hidden' name='data[OrderProduct]["+numvalue+"][product_name]' value='"+product_name.value+"'>"+product_name.value+"</td><td align='center'>"+product_attr.innerHTML+"</td><td align='center'><input type='hidden' name='data[OrderProduct]["+numvalue+"][product_price]' id='shop_price_"+product_code.value+"' value='"+shop_price+"'   />"+shop_price+"</td><td align='center'><input type='hidden' name='data[OrderProduct]["+numvalue+"][product_quntity]' id='product_number_"+product_code.value+"' value='"+product_number.value+"' />"+product_number.value+"</td><td align='center'><input type='hidden' id='sum_shop_price_"+product_code.value+"' value='"+product_number.value*shop_price+"' />"+product_number.value*shop_price+"</td><td align='center'><a href='javascript:;' name='1'onclick='removeImg(this)'>删除</a></td></tr>";
	numvalue++;
}
  /**
   * 删除商品当前行
   */
  function removeImg(obj){	
      var row = rowindex(obj.parentNode.parentNode);
      var tbl = document.getElementById('list_product');
      tbl.deleteRow(row);
  }
function add_order_basicinfo(){
	var opener_select_user_id = GetId("opener_select_user_id");
	//基本信息
	var order_payment_obj = GetName('data[Order][payment_id]');//支付方式obj
	var order_payment_id = "";
	for( var i=0;i<=order_payment_obj.length-1;i++ ){
		if(order_payment_obj[i].checked){
			order_payment_id = order_payment_obj[i].value;//支付方式
		}
	}
	var order_shipping_obj = GetName('data[Order][shipping_id]');//配送方式obj
	var order_shipping_id  = "";
	for( var i=0;i<=order_shipping_obj.length-1;i++ ){
		if(order_shipping_obj[i].checked){
			order_shipping_id = order_shipping_obj[i].value;//配送方式
		}
	}
	var OrderConsignee=GetId('OrderConsignee').value;//收货人
	var Ordermobile=GetId('Ordermobile').value;//手机
	var OrderTelephone=GetId('OrderTelephone').value;//电话
	var OrderAddress=GetId('OrderAddress').value;//地址
	var OrderEemail=GetId('OrderEemail').value;//电子邮件

	if( Trim(opener_select_user_id.value,'g') == "" ){
		layer_dialog();
		layer_dialog_show("请选择购货人!","",3);
		return false;
	}
	if( Trim(order_payment_id,'g') == "" ){
		layer_dialog();
		layer_dialog_show("请选择支付方式!","",3);
		return false;
	}
	if( Trim(order_shipping_id,'g') == "" ){
		layer_dialog();
		layer_dialog_show("请选择配送方式!","",3);
		return false;
	}
	//收货人信息
	if( Trim(OrderConsignee,'g') == "" ){
		layer_dialog();
		layer_dialog_show("请输入收货人!","",3);
		return false;
	}
	if( Trim(OrderEemail,'g') == "" ){
		layer_dialog();
		layer_dialog_show("请输入电子邮件!","",3);
		return false;
	}
	if( Trim(OrderAddress,'g') == "" ){
		layer_dialog();
		layer_dialog_show("请输入地址!","",3);
		return false;
	}
	if( Trim(Ordermobile,'g') == "" && Trim(OrderTelephone,'g') == ""){
		layer_dialog();
		layer_dialog_show("请输入手机或电话!","",3);
		return false;
	}
}
	
function search_user(){
	window.open (webroot_dir+"users/order_search_user_information/?status=1", 'newwindow', 'height=600, width=800, top=300, left=500, toolbar=no, menubar=yes, scrollbars=yes,resizable=yes,location=no, status=no');
}
reload_regions();
</script>