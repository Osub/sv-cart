<?php 
/*****************************************************************************
 * SV-Cart  积分报表管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3795 2009-08-19 11:25:53Z huangbo $
*****************************************************************************/
?>


<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<!--
<div class="search_box">
<?php echo $form->create('Report',array('action'=>'point/','name'=>"PointForm"));?>
	<dl>
	<dt style="padding-top:2px;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" name="start_time" value="<?php echo @$start_time?>" class="time" id="date" readonly="readonly"  /><button id="show" type="button"><?php echo $html->image('calendar.gif')?></button>－<input type="text" name="end_time" value="<?php echo @$end_time?>" class="time" id="date2" readonly="readonly" /><button id="show2" type="button"><?php echo $html->image('calendar.gif')?></button>
			<?php if(isset($SVConfigs["mlti_currency_module"]) && $SVConfigs["mlti_currency_module"]==1){?>
	<?php }?>
	</p></dd>
	<dt class="small_search"><input  class="search_article" type="button" value="查询" onclick="sub_action()"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="导出"  onclick="export_action()"/> </dt>
	</dl>
<?php $form->end()?>

</div>

<p class="add_categories"><strong><input type="button" value="重新计算商品冻结数" onclick="amend_num()"/></strong></p>-->

<br />
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>用户名</th>
	<th width="12%">注册时间</th>
	<th width="12%">登录时间</th>
	<th width="8%">商品数量</th>
	<th width="8%">价格</th>
	<th width="12%">最后更新时间</th>
	<th width="8%">操作</th></tr>
	<?php if(isset($cart) && sizeof($cart)>0){?>
	<?php foreach( $cart as $k=>$v ){if(!empty($v)){?>
	<tr id="<?php echo 'row'.$k?>" <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
		<td><?php echo $v['User']['name'];if(isset($v['User']['session_id'])){echo '<br/>';echo $v['User']['session_id'];}?></td>
		<td><?php echo $v['User']['register']?></td>
		<td><?php echo $v['User']['login_time']?></td>
		<td align="center"><?php echo $v['products_quantity']?></td>
		<td><?php echo $v['sum_subtotal']?></td>
		<td align="center"><?php if(isset($v['User']['latest_modify'])){echo $v['User']['latest_modify'];}?></td>
		<td align="center"><span><?php echo $img_obj = $html->image('menu_plus.gif',array("onclick"=>"rowClicked(this)",'name'=>'menu_img','id'=>'menu_img'));?></span><span><?php echo $html->link("详情","javascript:;",array("onclick"=>"textClicked(this)"));?></span></td>
	</tr>
	<tbody style="display:none;" id="<?php echo 'inforow'.$k?>" >
	<?php if(isset($v['product_list']) && sizeof($v['product_list'])>0){?>
	<tr>
	<td>&nbsp;</td>
		<td colspan="6">
			<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
			
			<tr class="thead">
				<th>商品名称</th>
				<th>数量</th>
				<th>单价</th>
				<th>合计</th>
				<th>属性</th>
				<th>加入购物车时间</th>
			</tr>
			
			<?php foreach($v['product_list'] as $kk => $vv ){?>
			<tr>
				<td align="center"><?php echo $vv['name']?></td>
				<td align="center"><?php echo $vv['quantity']?></td>
				<td align="center"><?php echo $vv['single_p']?></td>
				<td align="center"><?php echo $vv['total']?></td>
				<td align="center"><?php echo $vv['attributes']?></td>
				<td align="center"><?php echo $vv['add_time']?></td>
			</tr>
		<?php }?>
			
			</table>
		</td>
	</tr><?php }?>
	</tbody>
	<?php }} }?>
</table></div>
</div>
<!--Main Start End-->
</div>

<!--重新计算冻结数弹出层--> 
<!--对话框start-->
<div id="amend_num" style="display:none">
<input type="hidden" value="" id="select_id">
<div id="loginout" >
	<h1><b>系统提示</b></h1>
	<div class="order_stat athe_infos tongxun" >
	<div id="num_text">
	<div id="buyshop_box">
		<p class="login-alettr" style="border:0;padding-bottom:15px;">
	    <?php echo $html->image("msg.gif",array('class'=>'sub_icon vmiddle'));?><b>重新计算商品冻结数?</b></p>
 		<br />
		<p class="buy_btn mar" style="margin:0 110px 0 0;"><?php echo $html->link("取消","javascript:num_big_panel.hide();");?>
		<?php echo $html->link("确定","javascript:;",array("onclick"=>"confirm_num();"));?></p>
	</div></div>
		<div id="num_confirm" style="display:none">
		<div id="buyshop_box">
		<p class="login-alettr" style="border:0;padding-bottom:15px;"><b>商品冻结数修改成功!</b></p>
		<br />
		<p class="buy_btn" style="padding-right:170px;"><?php echo $html->link("确定","javascript:num_big_panel.hide();");?></p>
		</div></div>
		
	<p><?php echo $html->image("loginout-bottom.png");?></p>
	</div>
</div>	
</div>
<!--对话框end-->

<script type="text/javascript">
function sub_action() 
{ 
	document.PointForm.action=webroot_dir+"reports/point";
	document.PointForm.onsubmit= "";
	document.PointForm.submit(); 
}
function export_action() 
{ 
	document.PointForm.action=webroot_dir+"reports/point/export";
	document.PointForm.onsubmit= "";
	document.PointForm.submit(); 
}

/*重新计算冻结数*/
//冻结数确认
function confirm_num(){
	var sUrl = webroot_dir+"check_online_users/recalcul_frozen_quantity";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, confirm_num_callback);	
}
var confirm_num_Success = function(o){
	if(o.responseText){
		document.getElementById('num_confirm').style.display = "inline";
		document.getElementById('num_text').style.display = "none";
	}
}

var confirm_num_Failure = function(o){
	//alert("error");
}

var confirm_num_callback ={
	success:confirm_num_Success,
	failure:confirm_num_Failure,
	timeout : 10000,	
	argument: {}	
};	
//修改密码对话框	
function amend_num(){
	document.getElementById('amend_num').style.display = "block";
	document.getElementById('num_text').style.display = "block";
	document.getElementById('num_confirm').style.display = "none";
	num_big_panel.show();
}
//遮罩层JS	
function initPage_num(){
	tabView = new YAHOO.widget.TabView('contextPane');
    num_big_panel = new YAHOO.widget.Panel("amend_num",
						{
							visible:false,
							draggable:false,
							modal:true,
							style:"margin 0 auto",
							fixedcenter: true
						} 
					); 
	num_big_panel.render();
}
initPage_num();

/**
 * 折叠菜单列表
 */
function rowClicked(obj){
	obj_id = obj.parentNode.parentNode.parentNode.id;
	if(obj.src.indexOf("minus.gif") != -1){	
		obj.src = server_host+"/sv-admin/img/menu_plus.gif";
		document.getElementById("info"+obj_id).style.display="none";
	}
	else{
		obj.src = server_host+"/sv-admin/img/minus.gif";
		document.getElementById("info"+obj_id).style.display="";
	}

}
function textClicked(obj){
	obj_src = obj.parentNode.parentNode.childNodes[0].childNodes[0];
	obj_id = obj.parentNode.parentNode.parentNode.id;
	if(obj_src.src.indexOf("minus.gif") != -1){	
		obj_src.src = server_host+"/sv-admin/img/menu_plus.gif";
		document.getElementById("info"+obj_id).style.display="none";
	}
	else{
		obj_src.src = server_host+"/sv-admin/img/minus.gif";
		document.getElementById("info"+obj_id).style.display="";
	}

}

</script>