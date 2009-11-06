<?php 
/*****************************************************************************
 * SV-Cart 商品回收站列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 4433 2009-09-22 10:08:09Z huangbo $
*****************************************************************************/
?>
 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($topics)?>
<!--Main Start-->
<br />
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'/','name'=>'searchtrash','type'=>"get"));?>
	<dl>
	<dt><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p>
			<?php if(!empty($categories_tree)){?>
	<select class="all" name="category_id" id="category_id">
	<option value="0">所有分类</option>
	<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?><?php foreach($categories_tree as $first_k=>$first_v){?>
	<option value="<?php echo $first_v['Category']['id'];?>" <?php if($category_id == $first_v['Category']['id']){?>selected<?php }?>><?php echo $first_v['CategoryI18n']['name'];?></option>
		<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
		<option value="<?php echo $second_v['Category']['id'];?>" <?php if($category_id == $second_v['Category']['id']){?>selected<?php }?>>&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
			<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
			<option value="<?php echo $third_v['Category']['id'];?>" <?php if($category_id == $third_v['Category']['id']){?>selected<?php }?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
	<?php }}}}}}?>
	</select><?php }?>
	最后修改时间：<input type="text" id="date" name="date" value="<?php echo @$date?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>
		<input type="text" id="date2" name="date2" value="<?php echo @$date2?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>

	商品：<input type="text" style="width:105px;" name="keywords" id="keywords" value="<?php echo @$keywords?>"/>


	
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

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<?php echo $form->create('',array('action'=>'/',"name"=>"ProForm",'onsubmit'=>"return false"));?>
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th align="left" width="6%"><label><input type="checkbox" name="checkbox[]" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>编号<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></label></th>
	<th width="12%">货号</th>
	<th>商品名称</th>

	<th width="8%">价格</th>
	<th width="12%">最后修改时间</th>
	<th width="12%">操作</th></tr>
<!--Messgaes List-->
	<?php if(isset($products_list) && sizeof($products_list)>0){?>
<?php foreach($products_list as $k=>$v){?>		
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><label><input type="checkbox" name="checkboxes[]" value="<?php echo $v['Product']['id']?>" /><?php echo $v['Product']['id']?></label></td>
	<td align="center"><?php echo $v['Product']['code']?></td>	<td><?php echo $v['ProductI18n']['name']?></td>
	<td align="center"><?php echo $v['Product']['format_shop_price']?></td>
	<td align="center"><?php echo $v['Product']['modified']?></td>
	<td align="center">
	<?php echo $html->link("还原","javascript:;",array("onclick"=>"layer_dialog_show('确定还原?','{$admin_webroot}trash/revert/{$v['Product']['id']}')"));?>|
	<?php echo $html->link("删除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}trash/com_delete/{$v['Product']['id']}')"));?></td></tr>
	<?php }}?>
<!--Messgaes List End-->	
	</table></div>
<div class="pagers" style="position:relative">
	<?php if(isset($products_list) && sizeof($products_list)>0){?>
  <p class='batch'>
   <select style="top:-2px;*top:-5px;position:relative;width:80px" name="act_type" id="act_type"  >
   <option value="0">请选择...</option>
   <option value="rev">还原</option>
   <option value="del">删除</option>
   </select>
<input type="button" value="确定"  onclick="operate_change()"  id="change_button"/></p>
<?php }?>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
<?php echo $form->end();?>
</div>
</div>
<?php echo $form->end();?>
<script>
function operate_change(){
	var a=document.getElementById("act_type");
	if(a.value!='0'){
		for(var j=0;j<a.options.length;j++){
			if(a.options[j].selected){
				var vals = a.options[j].text ;
			}
		}
		layer_dialog_show('确定'+vals+'?','operate_select()',5);
	}
}

function batch_action()
{ 
	document.ProForm.action=webroot_dir+"trash/batch";
	document.ProForm.onsubmit= "";
	document.ProForm.submit();
}

function operate_select(){//删除
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
		batch_action();
		}
	}
</script>