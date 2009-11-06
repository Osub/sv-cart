<?php 
/*****************************************************************************
 * SV-Cart  编辑角色
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 4372 2009-09-18 10:38:17Z huangbo $
*****************************************************************************/
?>
 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."角色列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>
<!--Main Start-->
<?php echo $form->create('Role',array('action'=>'edit/'.$operatorrole['OperatorRole']['id'],'onsubmit'=>'return roles_check();'));?>
<div class="home_main">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑角色</h1></div>
	  <div class="box">
	  <input type="hidden" name="data[OperatorRole][id]" value="<?php echo $operatorrole['OperatorRole']['id']?>" />
	  <h2>角色名称：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	 foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input type="text" style="width:195px;" id="name<?php echo $v['Language']['locale']?>" name="data[OperatorRoleI18n][<?php echo $k;?>][name]" <?php if(@isset($this->data['OperatorRoleI18n'][$v['Language']['locale']])){?>value="<?php echo @$this->data['OperatorRoleI18n'][$v['Language']['locale']]['name'];?>"<?php }else{?>value=""<?php }?>/> <font color="#F90046">*</font></span></p>
<?php }} ?>
<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		<input name="data[OperatorRoleI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
		<input id="OperatorRoleI18n<?php echo $k;?>Id" name="data[OperatorRoleI18n][<?php echo $k;?>][id]" type="hidden" value="<?php echo @$this->data['OperatorRoleI18n'][$v['Language']['locale']]['id'];?>">
		<input id="OperatorRoleI18n<?php echo $k;?>OperatorRoleId" name="data[OperatorRoleI18n][<?php echo $k;?>][operator_role_id]" type="hidden" value="<?php echo  $this->data['OperatorRole']['id'];?>">
<?php }}?>
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Other Stat-->
	<div class="order_stat athe_infos">
	  <div class="box"  style="padding-top:20px;" >
		<dl><dt>角色编号：</dt>
			<dd><?php echo $operatorrole['OperatorRole']['id']?><input type="hidden" class="text_inputs" style="width:190px;" name="data[OperatorRole][id]" value="<?php echo $operatorrole['OperatorRole']['id']?>" /></dd></dl>
			<dl><dt>角色排序：</dt>
			<dd><input class="text_inputs" style="width:190px;" name="data[OperatorRole][orderby]" value="<?php echo $operatorrole['OperatorRole']['orderby']?>"  onkeyup="check_input_num(this)" /><br /> 如果您不输入排序号，系统将默认为50</dd></dl>
		<dl><dt>是否有效：</dt>
			<dd><input type="radio" name="data[OperatorRole][status]" value="1" <?php if($operatorrole['OperatorRole']['status']==1){echo "checked";} ?> /> <label>是</label> <input type="radio" name="data[OperatorRole][status]" value="0" <?php if($operatorrole['OperatorRole']['status']==0){echo "checked";} ?> /><label>否</label></dd></dl>
		</div>
	</div>
<!--Other Stat End-->
</td>
</tr>
</table>
<style>
label{vertical-align:middle}
.inputcheckboxradio{vertical-align:middle;}
body{font-family:tahoma;font-size:12px;}
</style>

<script language="javascript">
	function show_intro(pre,pree, n, select_n,css) {
		for (i = 1; i <= n; i++) {
			var intro = document.getElementById(pre + i);
			var cha = document.getElementById(pree + i);
			intro.style.display = "none";
			cha.className=css + "_off";
			if (i == select_n) {
				intro.style.display = "block";
				cha.className=css + "_on";
			}
		}
	}
	
	
	function check(list, obj,chk)
	{
	  var frm = obj.form;

	    for (i = 0; i < frm.elements.length; i++)
	    {
	      if (frm.elements[i].name == chk+"[]")
	      {
	          var regx = new RegExp(frm.elements[i].value + "(?!_)", "i");

	          if (list.search(regx) > -1) frm.elements[i].checked = obj.checked;
	      }
	    }
	}
</script>
<!--Categories List-->
		<!--Order Stat-->

		<div class="article_list">
	      <div class="box">
	        <ul>
	          <li class="hdblock3_on" id="hdblock3_t21" onmouseover="show_intro('hdblock3_c2','hdblock3_t2',2,1,'hdblock3')">
			  默认权限</li>
		      <li class="hdblock3_off" id="hdblock3_t22" onmouseover="show_intro('hdblock3_c2','hdblock3_t2',2,2,'hdblock3')">
			  部门</li>
	        </ul>
	      </div>
  		</div>
	<div class="order_stat operators properies">
	<div class="box" id="hdblock3_c21" style="display:block;">
		<table id="list-table" width="100%" cellpadding="0" cellspacing="0" class="" border="1" style="border-collapse: collapse;border-color:#C4F9A4;">


		<?php if(isset($operatoraction) && sizeof($operatoraction)>0){?>
		<?php foreach($operatoraction as $k=>$v){?>
		<tr class="1">
			<td width="9%" valign="top" > &nbsp&nbsp <?php echo $html->image('minus.gif',array("onclick"=>"rowClicked(this)")); ?> <?php echo $v['Operator_action']['name']?></td>
			<td width="91%"></td>
		</tr>
		<tr class="2">
			<td width="9%"></td><td  width="91%">
			<table width="100%" cellpadding="0" cellspacing="0" class="" border=1 style="border: medium none ;padding-left: 30px; border-collapse: collapse; font-family: 宋体;border-color:#C4F9A4;">
				<?php if(isset($v['SubAction']) && sizeof($v['SubAction'])>0)foreach($v['SubAction'] as $vv){?>
				<tr>
				<td width="13%" valign="top" ><input type="checkbox"  value="<?php echo $vv['Operator_action']['id']?>" onclick="javascript:check('<?php if(isset($vv['SubAction']))foreach($vv['SubAction'] as $vvv){ echo $vvv['Operator_action']['id'].',';}?>',this,'competence')" /><?php echo $vv['Operator_action']['name']?></td>
				<td width="87%">
				<table width="100%" cellpadding="0" cellspacing="0" class=""  >
					<?php if(isset($vv['SubAction']) && sizeof($vv['SubAction'])>0){$trnum=1;foreach($vv['SubAction'] as $vvv){?>
					<?php if( $trnum == 1){?><tr><?php }?>
					<td width="20%">
					<input type="checkbox" name="competence[]" value="<?php echo $vvv['Operator_action']['id']?>" <?php if(in_array($vvv['Operator_action']['id'],$actions_arr)) echo 'checked';?> /><?php echo $vvv['Operator_action']['name']?>
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
	</div>
<!--Order Stat End-->
<!--Categories List End-->
<!-- gin add start -->
<?php //pr($operators);?>
<?php //pr($departments);?>
	<div class="box" id="hdblock3_c22" style="display:none;">
  	    <p class="select_operators" style="margin-top:-30px;"></p>
		<?php if(isset($departments) && sizeof($departments)>0){?>
			<?php foreach($departments as $s=>$d){?>
			<div class="purview_set">
			<p>
				<label>
					<input type="checkbox" name="checkbox" value="checkbox" onclick="javascript:check('<?php if(isset($operators))foreach($operators as $gg){ if($gg['Operator']['department_id'] == $s){echo $gg['Operator']['id'].',';}}?>',this,'operators')"/><?php echo $d?>
				</label>
			</p>
				<ul>
				<?php foreach($operators as $a=>$b){?>
						<?php if($b['Operator']['department_id'] == $s){?>
						<li>
							<label><input type="checkbox" name="operators[]" value="<?php echo $b['Operator']['id'];?>" <?php if(in_array($role_id, explode(';',$b['Operator']['role_id'])) ){echo "checked";}?> /><?php echo $b['Operator']['name']?></label>
						</li>
						<?php }?>
					<?php }?>
				</ul>
			</div>
				<?php }?>
		<?php }?>
		<div class="purview_set">
			<p>
				<label>
					<input type="checkbox" name="checkbox" value="checkbox"  onclick="javascript:check('<?php if(isset($operators))foreach($operators as $vvvv){ if($vvvv['Operator']['department_id'] == 0){echo $vvvv['Operator']['id'].',';}}?>',this,'operators')"/>无部门
				</label>
			</p>
		<ul>
			<?php foreach($operators as $kkk=>$vvv){?>
				<?php if($vvv['Operator']['department_id'] == 0){?>
				<li>
					<label><input type="checkbox" name="operators[]" value="<?php echo $vvv['Operator']['id'];?>" <?php if(in_array($role_id, explode(';',$vvv['Operator']['role_id']))){echo "checked";}?> /><?php echo $vvv['Operator']['name']?></label>
				</li>
				<?php }?>		
			<?php }?>
		</ul>
		</div>
	</div>
<!-- gin add end -->
<!--Order Stat End-->
<!--Categories List End-->
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>

</div>
<?php echo $form->end();?>
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