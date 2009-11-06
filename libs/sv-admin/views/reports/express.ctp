<?php 
/*****************************************************************************
 * SV-Cart 快递单列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 2520 2009-07-02 02:01:40Z zhengli $
*****************************************************************************/
?> 
<?php echo $javascript->link('order');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>

<div class="search_box">
  <?php echo $form->create('reports',array('action'=>'express','type'=>'get','name'=>"SearchForm"));?>

	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif')?></dt>
	<dd><p class="reg_time">打印时间：<input type="text" id="date" name="date" style="border:1px solid #649776" value="<?php echo @$start_time?>" readonly />
	<?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>
	<input type="text" id="date2" name="date2" value="<?php echo @$end_time?>" style="border:1px solid #649776"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>

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
		<select style="width:120px;" name="express_status">
		<?php foreach( $systemresource_info["express_status"] as $k=>$v ){ ?>
		<option value="<?php echo $k;?>" <?php if ($express_status == $k){?>selected<?php }?> ><?php echo $v;?></option>
		<?php }?>
		</select>
	</p></dd>
	<dt class="big_search"><input type="submit" class="search_article" value="搜索" onclick="search_act()" /> </dt>
	</dl>
<?php echo $form->end();?>
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

<!--Main Start-->
<?php echo $form->create('orders',array('action'=>'/batch_shipping_print/',"name"=>"OrdForm",'onsubmit'=>"return batch_shipping_print();"));?>
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="10%"><input type="checkbox" class="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>订单编号</th>
	<th width="10%">收货人</th>
	<th width="18%">收货地址</th>
	<th width="5%">邮编</th>
	<th width="12%">联系方式</th>
	<th width="8%">配送方式</th>
	<th width="8%">支付方式</th>
	<th width="13%">发货时间</th>
	<th width="7%">打印状态</th>
	<th width="8%">操作</th>
</tr>
<!--Products Cat List-->
<?php if(isset($order_list) && sizeof($order_list)>0){?>
<?php foreach($order_list as $k=>$v){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td align="center"><input type="checkbox" class="checkbox" name="checkboxes[]" value="<?php echo $v['Order']['id']?>" /><?php echo $html->link("{$v['Order']['order_code']}","/orders/{$v['Order']['id']}",array("target"=>"_blank"),false,false);?></td>
	<td><?php echo $v['Order']['consignee'];?></td>
	<td><?php echo $v['Order']['address'];?></td>
	<td align="center"><?php echo $v['Order']['zipcode'];?></td>
	<td>电话:<?php echo $v['Order']['telephone'];?><br />手机:<?php echo $v['Order']['mobile'];?></td>
	<td align="center" ><?php echo $v['Order']['shipping_name'];?></td>

	<td align="center"><?php echo $v['Order']['payment_name'];?></td>
	<td align="center"><?php echo $v['Order']['shipping_time'];?></td>
	<td align="center"><?php echo $systemresource_info["express_status"][$v['Order']['express_status']];?></td>
	<td align="center"><?php echo $html->link("打印配送单","/orders/batch_shipping_print/{$v['Order']['id']}",array("target"=>"_blank"));?></td>
</tr>
<?php }?>
<?php }?></table></div>
<input name="act" type="hidden" value="batch"/>

<!--Products Cat List End-->
<div class="pagers" style="position:relative">
<p class='batch'>
	
	<input type="submit" value="打印配送单" onclick="target='_blank';" id="change_button" />
</p>
    <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>

</div>
<?php echo $form->end();?>
<!--Main Start End-->

</div>
	<script>
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
		return true;
	}
}

	</script>