<?php 
/*****************************************************************************
 * SV-Cart  编辑操作员
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 4482 2009-09-24 03:35:50Z huangbo $
*****************************************************************************/
?>
 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($operator_actions);pr($operator_roles);pr($this->data);?>
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."操作员列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('Operator',array('action'=>'edit','name'=>"login_form",'onsubmit'=>'return operators_check();'));?>

<?php  if(isset($languages) && sizeof($languages)>0){
		foreach ($languages as $k => $v){?>
	<input name="data[OperatorI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
<?php 
	}
}?>
	
	<input id="OperatorId" name="data[Operator][id]" type="hidden" value="<?php echo  $this->data['Operator']['id'];?>">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑操作员</h1></div>
	  <div class="box">
	  <br />
  	    <dl><dt>用户名：</dt>
			<dd><input type="text" class="text_inputs" style="width:260px;" id="OperatorName"  name="data[Operator][name]" value="<?php echo  $this->data['Operator']['name'];?>"/> <font color="#F94671">*</font></dd></dl>
		<dl><dt>Email地址：</dt>
			<dd><input type="text" class="text_inputs" style="width:260px;" id="OperatorEmail" name="data[Operator][email]" value="<?php echo  $this->data['Operator']['email'];?>"/> <font color="#F94671">*</font></dd></dl>
		<dl><dt>手机：</dt>
			<dd><input type="text" class="text_inputs" style="width:260px;" id="Operatormobile" name="data[Operator][mobile]" value="<?php echo  $this->data['Operator']['mobile'];?>"/> <font color="#F94671">*</font></dd></dl>
		<dl><dt>所属部门：</dt><dd>
			<select style="width:262px;*width:265px;" name="data[Operator][department_id]">
			<option value="0">没有部门</option>
				<?php  if(isset($departments) && sizeof($departments)>0){
			 foreach($departments as $k => $v){?>
			
			<option value="<?php echo $v['Department']['id'];?>" <?php if(!empty($this->data['Operator']['department_id'])&&$v['Department']['id']==$this->data['Operator']['department_id']) echo "selected"; ?>><?php echo $v['DepartmentI18n']['name']?></option>
			<?php }}?>
			</select> </dd></dl>
			<dl><dt>默认语言：</dt><dd>
			<select style="width:262px;*width:265px;" name="data[Operator][default_lang]">
				<?php  if(isset($languages) && sizeof($languages)>0){
			 foreach($languages as $k => $v){
				//pr($languages);?>
			<option value="<?php echo $v['Language']['locale'];?>"　<?php if(!empty($this->data['Operator']['default_lang'])&&$v['Language']['locale']==$this->data['Operator']['default_lang']) echo "selected"; ?>><?php echo $v['Language']['name']?></option>
			<?php }}?>
			</select> </dd></dl>
			
		<dl style="padding:5px 0;*padding:6px 0;">
		<dt style="padding-top:1px">状态：</dt>
		<dd class="best_input">
			<input id="OperatorStatus" name="data[Operator][status]" type="radio" class="radio" value="1" <?php if($this->data['Operator']['status']==1){?>checked<?php }?> >有效&nbsp;
			<input id="OperatorStatus" name="data[Operator][status]" type="radio" class="radio" value="0" <?php if($this->data['Operator']['status']==0){?>checked<?php }?> >无效&nbsp;
				<input id="OperatorStatus" name="data[Operator][status]" class="radio" type="radio" value="3" <?php if($this->data['Operator']['status']==3){?>checked<?php }?> >冻结&nbsp;
		</dd>
		</dl>		
		<dl style="padding:5px 0;*padding:6px 0;">
		<dt style="padding-top:1px">时区：</dt>
		<dd class="best_input">
		<select style="width:262px;*width:265px;" name="data[Operator][time_zone]">
		<?php foreach( $config_timezone as $k=>$v ){$str = explode(":",$v);?>
			<option value="<?php echo $str[0];?>" <?php if($str[0]==$this->data['Operator']['time_zone']){ echo "selected";} ?>><?php echo $str[1];?></option>
		<?php }?>
		</select>
		</dd>
		</dl>
	  </div>
		  
	</div>
	
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Other Stat-->
	<div class="order_stat athe_infos">
	  <div class="box">
		<br />
		<dl><dt>旧密码：</dt>
			<dd><input type="password" class="text_inputs" style="width:270px;" name="oldpassword" id="OldPassword"/> <font color="#F94671">*</font></dd></dl>
		<dl><dt>新密码：</dt>
			<dd><input type="password" class="text_inputs" style="width:270px;" name="newpassword" id="NewPassword"/> <font color="#F94671">*</font></dd></dl>
		<dl><dt>确认密码：</dt>
			<dd><input type="password" class="text_inputs" style="width:270px;" name="confirmpassword" id="ConfirmPassword"/> <font color="#F94671">*</font></dd></dl>
	  </div>
	</div>
<!--Other Stat End-->
</td>
</tr>
</table>
<?php if( $this->data['Operator']['id'] !=1 ){?>
<!--Categories List-->
	<!--Order Stat-->
	<div class="order_stat operators properies">
	  <div class="title">
	  <h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  <span>操作员权限</span></h1></div>
	  <div class="box">
		<table id="list-table" width="100%" cellpadding="0" cellspacing="0" class="" border="1" style="border-collapse: collapse;border-color:#C4F9A4;">
		<tr>
			<td width="9%" valign="top" > &nbsp&nbsp&nbsp&nbsp&nbsp 角色维护</td>
			<td  width="91%">		<?php if(isset($operator_roles) && sizeof($operator_roles)>0){?>
		<?php foreach($operator_roles as $ov){?>
		<span><input type="checkbox" name="operator_role[]" value="<?php echo $ov['OperatorRole']['id']?>" onclick="javascript:check('<?php if(isset($ov['OperatorRole']['actions'])){ echo $ov['OperatorRole']['actions'];}?>',this,'operator_action')" <?php if(in_array($ov['OperatorRole']['id'],$this->data['Operator']['role_arr'])) echo 'checked';?>   /><?php echo $ov['OperatorRole']['name']?></span>
		<?php }}?></td>
		</tr>

		<?php if(isset($operator_actions) && sizeof($operator_actions)>0){?>
		<?php foreach($operator_actions as $k=>$v){?>
		<tr class="1">
			<td width="9%" valign="top" > &nbsp&nbsp <?php echo $html->image('minus.gif',array("onclick"=>"rowClicked(this)")); ?> <?php echo $v['Operator_action']['name']?></td>
			<td width="91%"></td>
		</tr>
		<tr class="2">
			<td width="9%"></td><td  width="91%">
			<table width="100%" cellpadding="0" cellspacing="0" class="" border=1 style="border: medium none ;padding-left: 30px; border-collapse: collapse; font-family: 宋体;border-color:#C4F9A4;">
				<?php if(isset($v['SubAction']) && sizeof($v['SubAction'])>0)foreach($v['SubAction'] as $vv){?>
				<tr>
				<td width="13%" valign="top" ><input type="checkbox"  value="<?php echo $vv['Operator_action']['id']?>" onclick="javascript:check('<?php if(isset($vv['SubAction']))foreach($vv['SubAction'] as $vvv){ echo $vvv['Operator_action']['id'].',';}?>',this,'operator_action')" /><?php echo $vv['Operator_action']['name']?></td>
				<td width="87%">
				<table width="100%" cellpadding="0" cellspacing="0" class=""  >
					<?php if(isset($vv['SubAction']) && sizeof($vv['SubAction'])>0){$trnum=1;foreach($vv['SubAction'] as $vvv){?>
					<?php if( $trnum == 1){?><tr><?php }?>
					<td width="20%">
					<input type="checkbox" name="operator_action[]" value="<?php echo $vvv['Operator_action']['id']?>" <?php if(in_array($vvv['Operator_action']['id'],$this->data['Operator']['action_arr'])) echo 'checked';?> /><?php echo $vvv['Operator_action']['name']?>
					</td>
					<?php if($trnum == count($vv['SubAction'])){for($i=1;$i<5-count($vv['SubAction']);$i++){?>
					<td width="20%"></td>
					<?php }}?>
					<?php $trnum++;if( $trnum == 5){?></tr><?php $trnum=1;}?><?php }?>
					<?php }?>
				</table>
				</td>
			</tr>
				<?php }?>
			</table>
			</td>

	 	</tr>
		<?php }}?>
		</table>
	  <p class="submit_operators"><label><input type="checkbox" name="checkbox" value="checkbox" onclick="checkAll(this.form, this);" />全选</label><input type="submit" value="保 存" class="submit_main" /></p>
	</div>
<!--Order Stat End-->
<!--Categories List End-->
<?php } ?>
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>

</div>
<?php  echo $form->end();?>
</div>
<!--Main Start End-->
<?php echo $html->image('content_left.gif',array('class'=>'content_left'))?><?php echo $html->image('content_right.gif',array('class'=>'content_right'))?>
</div>
<script type="text/javascript">
/**
 * 折叠菜单列表
 */
function rowClicked(obj){
	if(obj.src.indexOf("minus.gif") != -1){	
		obj.src = server_host+"/sv-admin/img/menu_plus.gif";
	}
	else{
		obj.src = server_host+"/sv-admin/img/minus.gif";
	}
	obj = obj.parentNode.parentNode;
	
  	var tbl = document.getElementById("list-table");
  	var lvl = parseInt(obj.className);
  	var fnd = false;
  	
  	for (i = 0; i < tbl.rows.length; i++){
		var row = tbl.rows[i];
		if (tbl.rows[i] == obj){
			fnd = true;
		}
		else{
			if (fnd == true){
				var cur = parseInt(row.className);
				if (cur > lvl){
					row.style.display = (row.style.display != 'none') ? 'none' : (BrowserisIE()) ? 'block' : 'table-row';
				}
				else{
					fnd = false;
					break;
				}
			}
		}
  	}

	
}
function BrowserisIE(){
	if(navigator.userAgent.search("Opera")>-1){
		return false;
	}
	if(navigator.userAgent.indexOf("Mozilla/5.")>-1){
        return false;
    }
    if(navigator.userAgent.search("MSIE")>0){
        return true;
    }
}
</script>