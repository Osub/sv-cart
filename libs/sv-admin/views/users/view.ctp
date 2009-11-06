<?php 
/*****************************************************************************
 * SV-Cart 查看用户
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: view.ctp 4893 2009-10-11 10:07:01Z huangbo $
*****************************************************************************/
?>



<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."会员列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>
		  <!--时间控件层start-->
	<div id="container_cal" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal2" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal2"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal3" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal3"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal4" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal4"></div><div style="clear:both;"></div></div>
	</div>
<!--end-->
<!--Main Start-->
<div class="home_main">
<ul class="tab">
	<li class="hover" id="tabs1" onmouseover="overtab('tabs',1,8)"><span>编辑会员</span></li>
	<li class="normal" id="tabs2" onmouseover="overtab('tabs',2,8)"><span>收货地址</span></li>
	<li class="normal" id="tabs3" onmouseover="overtab('tabs',3,8)"><span>订单列表</span></li>
	<li class="normal" id="tabs6" onmouseover="overtab('tabs',6,8)"><span>提问查询</span></li>
	<li class="normal" id="tabs7" onmouseover="overtab('tabs',7,8)"><span>评论查询</span></li>
	<li class="normal" id="tabs8" onmouseover="overtab('tabs',8,8)"><span>会员相册</span></li>
	<li class="normal" id="tabs4" onmouseover="overtab('tabs',4,8)"><span>资金日志</span></li>
	<li class="normal" id="tabs5" onmouseover="overtab('tabs',5,8)"><span>积分日志</span></li>
</ul>
<?php echo $form->create('User',array('action'=>'view' ,'onsubmit'=>'return users_check();'));?>
<input id="UserId" name="data[User][id]" type="hidden" value="<?php echo  $this->data['User']['id'];?>">
<div id="con_tabs_1" class="display">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="box">
	  <br />
  	    <dl>
  			<dt class="config_lang">会员名称：</dt>
  			<input type="hidden" name="data[User][name]" value="<?php echo $this->data['User']['name'];?>">
			<dd><font size="3" face="arial"><?php echo $this->data['User']['name'];?></font></dd></dl>
		<dl><dt class="config_lang">邮件地址：</dt>
			<dd><input type="text" class="text_inputs" style="width:265px;" id="user_email" name="data[User][email]" value="<?php echo $this->data['User']['email'];?>"/> <font color="#F94671">*</font></dd></dl>
		<dl><dt class="config_lang">会员等级：</dt><dd>
		<select style="width:267px;" name="data[User][rank]">
		<option value="-1">用户等级</option>
		<option value="0" <?php if($this->data['User']['rank'] == 0){?>selected<?php }?>>普通用户</option>
		<?php if(isset($rank_list) && sizeof($rank_list)>0){?>
		<?php foreach($rank_list as $k=>$v){?>
		  <option value="<?php echo $v['UserRank']['id']?>" <?php if($v['UserRank']['id'] == $this->data['User']['rank']){?>selected<?php }?>><?php echo $v['UserRank']['name']?></option>
		<?php }}?>
		</select></dd></dl>

		<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px" class="config_lang">性别：</dt><dd class="best_input">
		<input type="radio" name="data[User][sex]" <?php if($this->data['User']['sex'] == 0){?>checked="checked"<?php }?> value="0"/>保密
		<input type="radio" name="data[User][sex]" <?php if($this->data['User']['sex'] == 1){?>checked="checked"<?php }?> value="1"/>男
		<input type="radio" name="data[User][sex]"  <?php if($this->data['User']['sex'] == 2){?>checked="checked"<?php }?> value="2"/>女</dd></dl>
        <dl><dt>出生日期：</dt><dd>
          <input style="width:80px;" class="text_inputs"  type="text" id="date" name="data[User][birthday]"  value="<?php echo $this->data['User']['birthday']?>" /><?php echo $html->image("calendar.gif",array("id"=>"show","class"=>"calendar_edit"))?></dd></dl>
		<?php if(isset($user_infoarr) && sizeof($user_infoarr)>0){?>
		<?php foreach($user_infoarr as $k=>$v){?>
		 <?php if($v['UserInfo']['backend'] == 1){?>
		 	 <?php if($v['UserInfo']['type'] == "text"){?>
		<dl><dt class="config_lang"><?php echo $v['UserInfo']['name']?>：</dt>
		       <input id="ValueId" name="info_value_id[<?php echo @$v['value']['user_info_id']?>]" type="hidden" value="<?php echo $v['UserInfo']['id']?>">
			<dd><input type="text" class="text_inputs" style="width:265px;" name="info_value[<?php echo @$v['value']['user_info_id']?>]" value="<?php echo @$v['value']['value']?>"/></dd></dl>
		<?php }?>
		<?php if(@$v['UserInfo']['type'] == "radio"){?>
		<dl><dt class="config_lang"><?php echo @$v['UserInfo']['name']?>：</dt>
		       <input id="ValueId" name="info_value_id[<?php echo @$v['value']['user_info_id']?>]" type="hidden" value="<?php echo $v['UserInfo']['id']?>">
			<dd>
			<?php $one_arr = explode(";",@$v['UserInfo']['user_info_values']);?>
			<?php foreach($one_arr as $kkk=>$vvv){$two_arr = explode(":",$vvv);?>
				<input type="radio" name="info_value[<?php echo @$v['UserInfo']['id']?>]" value="<?php echo $two_arr[0]?>" <?php if(@$v['value']['value']==$two_arr[0]){echo "checked";}?> ><?php echo $two_arr[1]?>
			<?php }?>

	</dd></dl>
		<?php }?>	<?php if(@$v['UserInfo']['type'] == "checkbox"){?>
		<dl><dt class="config_lang"><?php echo @$v['UserInfo']['name']?>：</dt>
		       <input id="ValueId" name="info_value_id[<?php echo @$v['value']['user_info_id']?>]" type="hidden" value="<?php echo $v['UserInfo']['id']?>">
			<dd>
			<?php $one_arr = explode(";",@$v['UserInfo']['user_info_values']);?>
			<?php foreach($one_arr as $kkk=>$vvv){$two_arr = explode(":",$vvv);?>
				<input type="checkbox" name="info_value[<?php echo @$v['UserInfo']['id']?>][]" value="<?php echo $two_arr[0]?>" <?php if(in_array($two_arr[0],explode(";",@$v['value']['value']))){echo "checked";}?> ><?php echo $two_arr[1]?>
			<?php }?>
	</dd></dl>
		<?php }?>
		 	 <?php if($v['UserInfo']['type'] == "textarea"){?>
		<dl><dt class="config_lang"><?php echo $v['UserInfo']['name']?>：</dt>
		       <input id="ValueId" name="info_value_id[<?php echo @$v['value']['user_info_id']?>]" type="hidden" value="<?php echo $v['UserInfo']['id']?>">
			<dd><textarea type="text" class="text_inputs" style="width:265px;" name="info_value[<?php echo @$v['value']['user_info_id']?>]" /><?php echo @$v['value']['value']?></textarea></dd></dl>
		<?php }?> <?php if(@$v['UserInfo']['type'] == "select"){?>
		<dl><dt class="config_lang"><?php echo @$v['UserInfo']['name']?>：</dt>
		       <input id="ValueId" name="info_value_id[<?php echo @$v['value']['user_info_id']?>]" type="hidden" value="<?php echo $v['UserInfo']['id']?>">
			<dd>
			<?php $one_arr = explode(";",$v['UserInfo']['user_info_values']);?>
			<select class="text_inputs" style="width:265px;" name="info_value[<?php echo @$v['UserInfo']['id']?>]" >
			<?php foreach($one_arr as $kkk=>$vvv){$two_arr = explode(":",$vvv);?>
				<option value="<?php echo $two_arr[0]?>" <?php if(@$v['value']['value']==$two_arr[0]){echo "selected";}?>><?php echo $two_arr[1]?></option>
			<?php }?>
			</select>
	</dd></dl>
		<?php }?>
				<?php }?>
		<?php }}?>
	<!--	<dl><dt class="config_lang">信用额度：</dt>
			<dd><input type="text" class="text_inputs" style="width:115px;" /></dd></dl>	-->
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;">
<!--Password-->
	<div class="order_stat athe_infos tongxun editmember">
	  <div class="box">
		<dl><dt>新密码：</dt>
			<dd><input type="password" class="text_inputs" style="width:270px;" id="user_new_password" name="data[User][new_password]"/> <font color="#F94671">*</font></dd></dl>
		<dl><dt>重复新密码：</dt>
			<dd><input type="password" class="text_inputs" style="width:270px;" id="user_new_password2" name="data[User][new_password2]"/> <font color="#F94671">*</font></dd></dl>
	  </div>
	</div>
<!--Password End-->

<!--Bankcroll-->
	<div class="order_stat athe_infos tongxun" style="margin-top:13px;_margin-top:14px;">
	  
	  <div class="box">
		<dl class="bankcroll">
			<dt>可用资金:</dt>
			<dd class="best_input" style="width:58%;">
			<span style="width:50%;float:left;"><font><?php echo $this->data['User']['balance'];?></font>
			<font face="tahoma">[<?php echo $html->link("查看明细","/balances/?user_id={$this->data['User']['id']}",'',false,false);?>]</font></span>
			<font style="float:left;"><input type="radio" name="balance_type" value="1" checked>加
			<input type="radio" name="balance_type" value="0">减
			<input type="text" class="text_inputs" style="width:50px;" id="user_balance" name="balance" value="0"/></font>
			</dd>
		</dl>
		<dl class="bankcroll">
			<dt>冻结资金:</dt>
			<dd class="best_input" style="width:58%;">
			<span style="width:50%;float:left;"><font><?php echo $this->data['User']['frozen'];?></font>
			<font face="tahoma">[<?php echo $html->link("查看明细","/balances/?user_id={$this->data['User']['id']}",'',false,false);?>]</font></span>
			<font style="float:left;"><input type="radio" name="frozen_type" value="1" checked>加
			<input type="radio" name="frozen_type" value="0">减
			<input type="text" class="text_inputs" style="width:50px;" id="user_frozen" name="frozen" value="0"/></font>
			</dd></dl>
		<dl class="bankcroll">
			<dt>消费积分:</dt>
			<dd class="best_input" style="width:58%;">
			<span style="width:50%;float:left;"><font><?php echo $this->data['User']['point'];?></font>
			<font face="tahoma">[<?php echo $html->link("查看明细","/points/?user_id={$this->data['User']['id']}",'',false,false);?>]</font></span>
			<font style="float:left;"><input type="radio" name="point_type" value="1" checked>加
			<input type="radio" name="point_type" value="0">减
			<input type="text" class="text_inputs" style="width:50px;" id="user_point" name="point" value="0"/></font>
			</dd>
		</dl>
		<dl class="bankcroll">
			<dt>等级积分:</dt>
			<dd>
			<font><?php echo $this->data['User']['user_point']+0;?></font>
			</dd></dl>	
		<dl class="bankcroll"><dt>注册时间:</dt>
			<dd><?php echo $this->data['User']['created'];?> </dd></dl>
		<dl class="bankcroll"><dt>最后登录时间:</dt>
			<dd><?php echo $this->data['User']['last_login_time'];?> </dd></dl>
	  </div>
	</div>
<!--Bankcroll End-->
</td>
</tr>
<tr><td colspan="2"><p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p></td></tr>
</table>
<?php echo $form->end();?>
<!--Addresse List-->
<div id="con_tabs_6" class="none">
	<div class="order_stat operators">
	  <div class="box users_configs">
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
	  </div>
</div></div>
<div id="con_tabs_7" class="none">
	<div class="order_stat operators">
	  <div class="box users_configs">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th align="left" width="6%"><input type="checkbox" name="chkall" value="checkbox" onclick="selectAll(this,'checkbox');" />编号<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th width="12%">用户名</th>
	<th width="35%">评论内容</th>
	<th width="8%"><font face="arial">IP地址</font></th>
	<th width="11%">评论时间<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th width="8%">状态</th>
	<th width="12%">操作</th></tr>
<!--Comment List-->
<?php if(isset($comments_info) && sizeof($comments_info)>0){?>
<?php foreach($comments_info as $k=>$v){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><?php echo $v['Comment']['id']?></td>
	<td><?php echo $v['Comment']['name']?></td>
	<td><?php echo preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,0}'.'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,40}).*#s','$1',$v['Comment']['content']);?></td>
	<td align="center"><?php echo $v['Comment']['ipaddr']?></td>
	<td align="center"><?php echo $v['Comment']['created']?></td>
	<td align="center"><?php if($v['Comment']['status']=='1'){ echo "显示"; }if($v['Comment']['status']=='0'){  echo "不显示"; }if($v['Comment']['status']=='2'){  echo "删除"; } ?></td>
	<td align="center">
	<?php if($v['Comment']['type']=="P"){?>
		<?php echo $html->link("查看",$server_host.$root_all."/products/{$v['Comment']['type_id']}",array("target"=>"_blank"));?> |
	<?php }?>
	<?php if($v['Comment']['type']=="A"){?>
		<?php echo $html->link("查看",$server_host.$root_all."/articles/{$v['Comment']['type_id']}",array("target"=>"_blank"));?> |
	<?php }?>
	
	 <?php echo $html->link("回复","/comments/edit/{$v['Comment']['id']}");?>
| <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}comments/remove/{$v['Comment']['id']}')"));?></td></tr>

<?php }?><?php }?>
</table>
	  </div>
</div></div>
<div id="con_tabs_8" class="none">
	<div class="order_stat operators">
	  <div class="box users_configs">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="10%">用户名</th>	
	<th>商品名称</th>
	<th>图片</th>
	<th width="10%">是否有效</th>
	<th width="14%">创建日期</th>
	<th width="14%">修改日期</th>
	<th width="10%">操作</th></tr>
<!--Products Cat List-->
<?php if(isset($userproductgalleries_data) && sizeof($userproductgalleries_data)>0){?>
<?php foreach($userproductgalleries_data as $k=>$v){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><? echo $html->link($v['User']['name'],"/users/".$v['User']['id'],array("target"=>"_blank"),false,false);?></td>
	<td><?php echo $html->link($product_list[$v["UserProductGallery"]["product_id"]]['ProductI18n']['name'],$server_host.$root_all."/products/".$v["UserProductGallery"]["product_id"],array("target"=>"_blank"),false,false);?></td>
	
	<td align="center"><?php echo $html->image($server_host.$root_all.$v['UserProductGallery']['img'],array('class'=>'vmiddle','width'=>'40','height'=>'40'));?></td>
	<td align="center"><?php if ($v['UserProductGallery']['status'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($v['UserProductGallery']['status'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?></td>
	<td align="center"><?php echo $v['UserProductGallery']['created'];?></td>
	<td align="center"><?php echo $v['UserProductGallery']['modified'];?></td>
	<td align="center">
		<?php if($v['UserProductGallery']['status'] != 1){?>
		<?php echo $html->link("有效","javascript:;",array("onclick"=>"layer_dialog_show('确定设为有效?','{$admin_webroot}user_product_galleries/effective/{$v['UserProductGallery']['id']}')"));?>
		<?php }else{?>
		<?php echo $html->link("无效","javascript:;",array("onclick"=>"layer_dialog_show('确定设为无效?','{$admin_webroot}user_product_galleries/invalid/{$v['UserProductGallery']['id']}')"));?>
		<?php }?>
		| <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}user_product_galleries/remove/{$v['UserProductGallery']['id']}')"));?></td></tr>
<?php }?>
<?php }?></table>
	  </div>
</div></div>
<div id="con_tabs_2" class="none">
<?php echo $form->create('User',array('action'=>'addr/' ));?>
	<div class="order_stat operators">
	  <div class="box users_configs">
	<table cellpadding="0" cellspacing="0" width="100%" class="list_data" id="addr-tables">
		<tr class="thead">
			<th width="3%"></th>
			<th width="10%">收货人</th>
			<th width="30%">地址</th>
			<th width="30%">联系方式</th>
			<th width="27%">其他</th>
		</tr>
		<?php if(!empty($user_address)){foreach( $user_address as $k=>$v ){?>
		<tr id="item" > 
			<td width="3%"><?php if($k>0){?><a href="javascript:;"  onclick="removeaddr(this)">[-]</a><?php }else{?><a href="javascript:;" onclick="addaddr(this)">[+]</a><?php }?></td>
			<td width="10%"><input type="text" name="thisconsignee[]" value="<?php echo $v['UserAddress']['consignee']?>" /></td>
			<td width="30%"><p>地址：<input type="text" name="thisaddress[]" value="<?php echo $v['UserAddress']['address']?>" /></p><p>邮编：<input type="text" name="thiszipcode[]" value="<?php echo $v['UserAddress']['zipcode']?>" /></p></td>
			<td width="30%"><p>电 话：<input type="text"   name="thistelephone[]"  value="<?php echo $v['UserAddress']['telephone']?>" /></p><p>手 机：<input type="text"  name="thismobile[]"  value="<?php echo $v['UserAddress']['mobile']?>" /></p><p>Email：<input type="text"  name="thisemail[]" value="<?php echo $v['UserAddress']['email']?>" /></p></td>
			<td width="27%"><p>最佳送时间：<input type="text"   name="thisbest_time[]" value="<?php echo $v['UserAddress']['best_time']?>" /></p><p>标 志 建筑：<input type="text" name="thissign_building[]" value="<?php echo $v['UserAddress']['sign_building']?>" /> </p></td>
		</tr>
		<?php }}else{?>
		<tr id="item" > 
			<td width="3%"><a href="javascript:;" onclick="addaddr(this)">[+]</a></td>
			<td width="10%"><input type="text" name="thisconsignee[]" /></td>
			<td width="30%"><p>地址：<input type="text" name="thisaddress[]" /></p><p>邮编：<input type="text" name="thiszipcode[]" /></p></td>
			<td width="30%"><p>电 话：<input type="text"   name="thistelephone[]"  /></p><p>手 机：<input type="text"  name="thismobile[]"   /></p><p>Email：<input type="text"  name="thisemail[]" /></p></td>
			<td width="27%"><p>最佳送时间：<input type="text"   name="thisbest_time[]" /></p><p>标 志 建筑：<input type="text" name="thissign_building[]" /> </p></td>
		</tr>
		<?php }?>
			
		</table>
	<table cellpadding="0" cellspacing="0" width="100%" class="list_data" >
		<tr><td colspan="5"><p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p></td></tr>
	</table> 
</div>
</div>
<?php echo $form->end();?>
</div>
<!--Addresse List End-->
<script>
function addaddr(){
    var node = document.getElementById("item").cloneNode(true);
    node.id = "item_" + (0 + 1);
    document.getElementById("item").parentNode.appendChild(node);
}
function removeaddr(obj){
      var row = rowindex(obj.parentNode.parentNode);
      var tbl = document.getElementById('addr-tables');

      tbl.deleteRow(row);
  }

</script>
<!--Orders List-->
<div id="con_tabs_3" class="none">
	<div class="order_stat operators">
	  <div class="box users_configs">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="150px">订单号</th><th width="150px">下单时间</th><th>收货人</th><th width="140px">费用</th><th width="100px">支付方式</th><th width="100px">配送方式</th><th width="140px">订单状态</th><th width="60px">操作</th></tr>
<!--List Start-->
<?php if(isset($orders_list) && sizeof($orders_list)){?>
	  <?php foreach($orders_list as $k=>$v){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td width="140px" align="center" class="order_num no_wrap"><?php echo $html->link($v['Order']['order_code'],"/orders/".$v['Order']['id'],array('target'=>'_blank'),false,false);?></td>
	<td align="center"><?php echo $v['Order']['created']?></td>
	<td><P><?php echo $v['Order']['consignee']?>[TEL:<?php echo $v['Order']['telephone']?>]</P>
		<P><?php echo $v['Order']['address']?></P></td>
	<td>
		<P>总金额:&nbsp&nbsp&nbsp&nbsp<?php echo $v['Order']['subtotal']?></P>
		<P>应付金额:<?php echo $v['Order']['should_pay']?></P></td>
		<td align="center"><?php echo $v['Order']['payment_name']?></td>
		<td align="center"><?php echo $v['Order']['shipping_name']?></td>
		<td align="center" ><?php echo $systemresource_info["order_status"][$v['Order']['status']];?>,<?php echo $systemresource_info["payment_status"][$v['Order']['payment_status']];?>,<?php echo $systemresource_info["shipping_status"][$v['Order']['shipping_status']];?></li>
		<td align="center"><?php echo $html->link("查看","/orders/{$v['Order']['id']}",array('target'=>'_blank'),false,false);?></td></tr>
<?php }}?>		
</table>
		<p style="clear:both;"></p>
	  </div>
	  </div></div>
<!--Orders List End-->
<!--bankcrollLog List-->
<div id="con_tabs_4" class="none">
	<div class="order_stat operators">
	  <div class="box users_configs">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
		<th width="150px" align="center">时间</th>
		<th width="80px">金额</th>
	
		<th width="80px">操作类型</th>
		<th>备注</th>
		</tr>
<?php if(isset($balances_list) && sizeof($balances_list)){?>
<?php foreach($balances_list as $k=>$v){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td align="center"><?php echo $v['UserBalanceLog']['created'];?></td>
	<td align="center"><?php echo $v['UserBalanceLog']['amount'];?></td>

	<td align="center"><?php if($v['UserBalanceLog']['log_type'] == 'O'){?>订单号<?php }elseif($v['UserBalanceLog']['log_type'] == 'B'){?>充值<?php }elseif($v['UserBalanceLog']['log_type'] == 'R'){?>退款<?php }elseif($v['UserBalanceLog']['log_type'] == 'A'){?>管理员操作<?php }?></li>
	<td><?php echo $v['UserBalanceLog']['system_note'];?></td>
	</tr>
<?php }}?>
	</table>
	  </div>
	  </div></div>
<!--bankcrollLog List End-->
<!--IntegralLog List-->
<div id="con_tabs_5" class="none">
	<div class="order_stat operators">
	  <div class="box users_configs">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
		<th width="150px">兑换时间</th>
		<th width="80px">兑换我的积分</th>
		
		<th width="80px">操作类型</th>
		<th>备注</th>
	</tr>
	<?php if(isset($points_list) && sizeof($points_list)>0){?>
<?php foreach($points_list as $k=>$v){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td align="center"><?php echo $v['UserPointLog']['created'];?></td>
	<td align="center"><?php echo $v['UserPointLog']['point'];?></td>

	<td align="center"><?php if($v['UserPointLog']['log_type'] == 'R'){?>注册赠送<?php }elseif($v['UserPointLog']['log_type'] == 'B'){?>订单产生<?php }elseif($v['UserPointLog']['log_type'] == 'O'){?>订单使用<?php }elseif($v['UserPointLog']['log_type'] == 'A'){?>管理员操作<?php }elseif($v['UserPointLog']['log_type'] == 'C'){?>订单返回<?php }?></td>
	<td><?php echo $v['UserPointLog']['system_note'];?></td>
	</tr>	
<?php }}?></table>
	  </div>
	  <br />
	  </div></div>
<!--IntegralLog List End-->
</div>
<!--Main Start End-->
</div>
