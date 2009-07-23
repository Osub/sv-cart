<?php 
/*****************************************************************************
 * SV-Cart  添加角色
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 2485 2009-06-30 11:33:00Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."角色列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<!--Main Start-->
<?php echo $form->create('Role',array('action'=>'add/','onsubmit'=>'return roles_check();'));?>
<div class="home_main">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  添加角色</h1></div>
	  <div class="box">
	  <br />
	  
	  <h2>角色名称：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	 foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input type="text" style="width:195px;" id="name<?php echo $v['Language']['locale']?>" name="data[OperatorRoleI18n][<?php echo $k;?>][name]"  /> <font color="#F90046">*</font></span></p>
		
<?php } }?>
<?php if(isset($languages) && sizeof($languages)>0){
	 foreach ($languages as $k => $v){?>
	<input name="data[OperatorRoleI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
<?php 
	}
}?>
		<br />
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Other Stat-->
	<div class="order_stat athe_infos tongxun">
	  
	  <div class="box">
		
		<br />
			<dl style="margin-bottom:5px;padding-top:8px;"><dt>角色排序：</dt>
			<dd>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="text_inputs" style="width:190px;" name="data[OperatorRole][orderby]" onkeyup="check_input_num(this)" /> <br /> 如果您不输入排序号，系统将默认为50</dd></dl>
		<dl><dt>是否有效：</dt>
			<dd>&nbsp;&nbsp;<input type="radio" name="data[OperatorRole][status]" value="1" checked /> 是 <input type="radio" name="data[OperatorRole][status]" value="0"  /> 否</dd></dl>
		<br />
	  </div>
	</div>
<!--Other Stat End-->
</td>
</tr>

</table>

<!--Categories List-->
		<!--Order Stat-->
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
  	    <p class="select_operators" style="margin-top:-30px;"></p>
			<?php  foreach($operatoraction as $k=>$v){ ?>
				<div class="purview_set" >
					<p>
						<label>
							<input type="checkbox" name="checkbox" value="checkbox" onclick="javascript:check('<?php if(isset($v['SubAction']))foreach($v['SubAction'] as $vv){ echo $vv['Operator_action']['id'].',';}?>',this,'competence')" /><?php echo $v['Operator_action']['name'];?>
						</label>
					</p>
					<ul>
					<?php  if(isset($v['SubAction'])){foreach($v['SubAction'] as $kk=>$vv){  ?>
						<li>
						<label><input type="checkbox" name="competence[]" value="<?php echo $vv['Operator_action']['id'];?>" /><?php echo $vv['Operator_action']['name'];?></label>
						</li>
					<?php }} ?>
					</ul>
				</div>
				<?php } ?>		
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
					<input type="checkbox" name="checkbox" value="checkbox" onclick="javascript:check('<?php if(isset($operators))foreach($operators as $vv){ if($vv['Operator']['department_id'] == $s){echo $vv['Operator']['id'].',';}}?>',this,'operators')"/><?php echo $d?>
				</label>
			</p>
				<ul>
				<?php foreach($operators as $k=>$v){?>
						<?php if($v['Operator']['department_id'] == $s){?>
						<li>
							<label><input type="checkbox" name="operators[]" value="<?php echo $v['Operator']['id'];?>" /><?php echo $v['Operator']['name']?></label>
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
					<input type="checkbox" name="checkbox" value="checkbox"  onclick="javascript:check('<?php if(isset($operators))foreach($operators as $vv){ if($vv['Operator']['department_id'] == 0){echo $vv['Operator']['id'].',';}}?>',this,'operators')"/>无部门
				</label>
			</p>
		<ul>
			<?php foreach($operators as $k=>$v){?>
				<?php if($v['Operator']['department_id'] == 0){?>
				<li>
					<label><input type="checkbox" name="operators[]" value="<?php echo $v['Operator']['id'];?>" /><?php echo $v['Operator']['name']?></label>
				</li>
				<?php }?>		
			<?php }?>
		</ul>
		</div>
	</div>
<!-- gin add end -->
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>

</div>
<?php echo $form->end();?>
</div>
<!--Main Start End-->
<?php echo $html->image('content_left.gif',array('class'=>'content_left'))?><?php echo $html->image('content_right.gif',array('class'=>'content_right'))?>
</div>