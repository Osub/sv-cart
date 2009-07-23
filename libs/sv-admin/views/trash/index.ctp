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
 * $Id: index.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($topics)?>
<!--Main Start-->
<br />
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'/','name'=>'searchtrash'));?>
	<dl>
	<dt><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p>商品：<input type="text" style="width:105px;" name="keywords" id="keywords" value="<?php echo @$keywords?>"/></p></dd>
	<dt class="big_search"><input type="submit" class="big"  value="搜索" /></dt>
	</dl><?php echo $form->end();?>
</div>
<br />
<!--Search End-->

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<?php echo $form->create('',array('action'=>'/',"name"=>"ProForm",'onsubmit'=>"return false"));?>
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th align="left"><label><input type="checkbox" name="checkbox[]" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>编号<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></label></th>
	<th>商品名称</th>
	<th>货号</th>
	<th>价格</th>
	<th>操作</th></tr>
<!--Messgaes List-->
	<?php if(isset($products_list) && sizeof($products_list)>0){?>
<?php foreach($products_list as $k=>$v){?>		
	<tr>
	<td><label><input type="checkbox" name="checkboxes[]" value="<?php echo $v['Product']['id']?>" /><?php echo $v['Product']['id']?></label></td>
	<td><?php echo $v['ProductI18n']['name']?></td>
	<td align="center"><?php echo $v['Product']['code']?></td>
	<td align="center"><?php echo $v['Product']['format_shop_price']?></td>
	<td align="center">
	<?php echo $html->link("还原","javascript:;",array("onclick"=>"layer_dialog_show('确定还原?','{$this->webroot}trash/revert/{$v['Product']['id']}')"));?>|
	<?php echo $html->link("删除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}trash/com_delete/{$v['Product']['id']}')"));?></td></tr>
	<?php }}?>
<!--Messgaes List End-->	
	</table>
<div class="pagers" style="position:relative">
	<?php if(isset($products_list) && sizeof($products_list)>0){?>
  <p class='batch'>
   <select style="top:-2px;*top:-5px;position:relative;width:80px" name="act_type" id="act_type">
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
	var a=document.getElementById("act_type").value;
	if(a!='0'){
		operate_select();
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