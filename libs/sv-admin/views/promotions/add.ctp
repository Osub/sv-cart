<?php
/*****************************************************************************
 * SV-Cart 添加促销活动
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 943 2009-04-23 10:38:44Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<?=$javascript->link('product');?>
<div class="content">
<?php  echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<br />
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."促销活动列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('Promotion',array('action'=>'add/','onsubmit'=>'return promotions_check();'));?>
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos department_config">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑促销活动</h1></div>
	  <div class="box" style="table-layout:fixed">
	  <br />
  	    <dl><strong style="table-layout:fixed"> 促销活动名称:</strong>
			<dd></dd></dl>

<? if(isset($languages) && sizeof($languages)>0){
 	foreach ($languages as $k => $v){?>
		 <dl><dt class="config_lang"><?=$html->image($v['Language']['img01'])?></dt>
			<dd><input type="text" id="promotion_title_<?=$v['Language']['locale']?>" name="data[PromotionI18n][<?=$k?>][title]" class="text_inputs" style="width:195px;"  /> <font color="#ff0000">*</font></dd></dl>
<?
	}
}?>	
	
		<dl><strong style="table-layout:fixed">促销活动描述:</strong><dd></dd></dl>

<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
			<dl><dt class="config_lang"><?=$html->image($v['Language']['img01'])?></dt><dd><textarea name="data[PromotionI18n][<?=$k?>][meta_description]" ></textarea></dd></dl>

	<input type="hidden" name="data[PromotionI18n][<?=$k?>][locale]" value="<?=$v['Language']['locale']?>" />			
<?
	}
}?>	
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Password-->
	<div class="order_stat athe_infos">
	  
	  <div class="box">
		<br />
		  <dl><dt>金额下限：</dt>
			<dd><input type="text"  class="text_inputs" style="width:120px;" name="data[Promotion][min_amount]"  /> </dd></dl>
			
		<dl><dt>金额上限：</dt>
			<dd><input type="text" name="data[Promotion][max_amount]"  class="text_inputs" style="width:120px;"   />&nbsp 0表示没有上限</dd></dl>
			<dl><dt>促销起始日期：</dt><span class="search_box" style="background:none;padding:0;border:0" >
			<dd><input type="text" name="data[Promotion][start_time]" class="text_inputs" style="width:120px;" id="date" readonly="readonly"/><button  id="show" type="button"><?=$html->image('calendar.gif')?></button></dd></span></dl>
		
		<dl><dt>促销结束日期：</dt><span class="search_box" style="background:none;padding:0;border:0" >
			<dd><input type="text" name="data[Promotion][end_time]" class="text_inputs" style="width:120px;" id="date2" readonly="readonly" /><button  id="show2" type="button"><?=$html->image('calendar.gif')?></button></dd></span></dl>
			<dl><dt><?=$html->image('help_icon.gif',array('align'=>'absmiddle'))?>优惠方式：</dt>
			<dd><select name="data[Promotion][type]">
				<option value="2"  >特惠品</option>
				<option value="1"  >减免</option>
				<option value="0"  >折扣</option>
				</select>&nbsp<input type="text"  class="text_inputs" name="data[Promotion][type_ext]" style="width:50px;"   /></dd>
			</dl>
				<dl><dt></dt>
			<dd>当优惠方式为“享受赠品（特惠品）”时，<br />请输入允许买家选择赠品（特惠品）的最大数量，<br />数量为0表示不限数量；当优惠方式为“享受现金减免”时，<br />请输入现金减免的金额；当优惠方式为“享受价格折扣”时，<br />请输入折扣（1－99），如：打9折，就输入90。</dd>
			</dl>
				
					赠品（特惠品）<span id="tt">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span> 价格<br />
						<span id="special_preference"></span>
			<dl><dt>搜索并加入赠品：</dt>
			<dd><input type="text" name="keywords" id="keywords" class="text_inputs" style="width:120px;" />
			<input type="button" value="搜索" onclick="searchProducts();" />
			<input type="hidden" name="brand_id" id="brand_id">
			<input type="hidden" name="category_id" id="category_id">
				<select name="source_select1" id="source_select1">
				</select>
				<input type="button" value="+" name="" onclick="special_preferences()" />
			</dd></dl>
		
		<br /><br /><br /><br /><br />
		
	  </div>
	</div>
<!--Password End-->

</td>
</tr>
<tr><td colspan="2"><p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p></td></tr>
</table>
<? echo $form->end();?>

</div>
<!--Main Start End-->
<?=$html->image('content_left.gif',array('class'=>'content_left'))?><?=$html->image('content_right.gif',array('class'=>'content_right'))?>
</div>
	
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

<script type="text/javascript">
function special_preferences(){
	var special_preference = document.getElementById("special_preference");
	var tt = document.getElementById("tt");
	var source_select1 = document.getElementById("source_select1");
	for (i=0;i<source_select1.length;i++)
    {
    	if(source_select1.options[i].selected){
    		var specialpreferences = document.getElementsByName("specialpreferences[]");
    		for( var j=0;j<=specialpreferences.length-1;j++ ){
    			if( specialpreferences[j].value == source_select1.value ){
    				alert("该选项已存在");
    				return;
    			}
    		}//alert(source_select1.value);
    	special_preference.innerHTML+="<input type='checkbox' name=specialpreferences[] value="+source_select1.value+" checked>"+source_select1.options[i].text+tt.innerHTML+"<input type='text' name=prices[] size=2 value='0'>"+"<br />";
    	}
    
    }
	
}	
</script>