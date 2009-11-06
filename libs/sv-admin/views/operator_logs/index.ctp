<?php 
/*****************************************************************************
 * SV-Cart 日志
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 4366 2009-09-18 09:49:37Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('operator_logs',array('action'=>'/','name'=>'searchtrash','type'=>"get"));?>
	<dl>
	<dt><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p>
	操作时间：<input type="text" id="date" name="date" value="<?php echo @$date?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>
		<input type="text" id="date2" name="date2" value="<?php echo @$date2?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>

	操作员：
		<select name="operator_id">
		<option value="">请选择...</option>
		<?php foreach( $operator_list as $k=>$v ){?>
		<option value="<?php echo $v['Operator']['id']?>" <?php if($operator_id == $v['Operator']['id']){echo "selected";}?>><?php echo $v['Operator']['name']?></option>
		<?php }?>
		</select>
	关键字：<input type="text" style="width:105px;" name="keywords" id="keywords" value="<?php echo @$keywords?>"/>

	</p></dd>
	<dt class="big_search"><input type="submit" class="search_article"  value="搜索" /></dt>
	</dl><?php echo $form->end();?>
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
<?php echo $form->create('operator_logs',array('action'=>'','name'=>"OperatorLogForm","type"=>"get",'onsubmit'=>"return false"));?>
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' );">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="6%"><input type="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes");'/>编号</th>
	<th width="11%">操作日期</th>
	<th width="9%">IP地址</th>
	<th width="34%">操作记录</th>
	<th width="24%">访问地址</th>
	<th width="6%">操作</th>
</tr>
<!--Messgaes List-->
    <?php foreach($operator_log_info as $k=>$v){?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?>>
	<td align="center"><input type="checkbox" name="checkboxes[]" value="<?php echo $v['Operator_log']['id']?>" /><?php echo $v['Operator_log']['id']?></td>
	<td align="center"><?php echo $v["Operator_log"]["created"]; ?></td>
	<td align="center"><?php echo $v["Operator_log"]["ipaddress"]; ?></td>
	<td><?php echo $v["Operator_log"]["info"]; ?></td>
	<td><?php echo $v["Operator_log"]["action_url"]; ?></td>
	<td align="center">
		<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}operator_logs/remove/{$v['Operator_log']['id']}')"));?>
	</td>
</tr>
    <?php } ?>
</table></div>
 <?php echo $form->end();?>
<!--Messgaes List End-->	
</div>
<div class="pagers" style="position:relative">
   <p class='batch'>
    <select style="width:66px;border:1px solid #689F7C;display:none" name="act_type" id="act_type">
    <option value="del">删除</option>
    </select> 
   	<?php if(isset($operator_log_info) && sizeof($operator_log_info)>0 && count($operator_log_info)>0){?>
	<input type="button" value="删除" onclick="diachange()" onfocus="this.blur()" />
    <?php } ?>
	</p>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
<!--Main Start End-->
</div>
		
<script>
function batch_action() 
{ 
document.OperatorLogForm.action=webroot_dir+"operator_logs/batch";
document.OperatorLogForm.onsubmit= "";
document.OperatorLogForm.submit(); 
} 

function diachange(){
	var a=document.getElementById("act_type");
	if(a.value!='0'){
		for(var j=0;j<a.options.length;j++){
			if(a.options[j].selected){
				var vals = a.options[j].text ;
			}
		}
		var id=document.getElementsByName('checkboxes[]');
		var i;
		var j=0;
		var image="";
		for( i=0;i<=parseInt(id.length)-1;i++ ){
			if(id[i].checked){
				j++;
			}
		}
		if( j>=1 ){
			layer_dialog_show('确定'+vals+'?','operate_select()',5);
		}else{
			layer_dialog_show('请选择！！','operate_select()',3);
		}
	}

	}

function operate_select(){//删除
	var id=document.getElementsByName('checkboxes[]');
	var i;
	var j=0;
	var image="";
	for( i=0;i<=parseInt(id.length)-1;i++ ){
		if(id[i].checked){
			j++;
		}
	}
	if( j<1 ){
		return false;
	}else{
		document.OperatorLogForm.onsubmit= "";
		document.OperatorLogForm.submit(); 
		batch_action();
	}
}
</script>