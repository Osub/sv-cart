<?php 
/*****************************************************************************
 * SV-Cart 编辑促销活动
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 2989 2009-07-17 02:03:04Z huangbo $
*****************************************************************************/
?>


 
<?php echo $javascript->link('selectzone');?>
<?php echo $javascript->link('product');?>
<div class="content">
<?php  echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<br />

<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."促销活动列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>
<div class="home_main">
<?php echo $form->create('Promotion',array('action'=>'edit/'.$promotion['Promotion']['id'],'onsubmit'=>'return promotions_check();'));?>
		<input type="hidden" name="data[Promotion][id]" value="<?php echo $promotion['Promotion']['id']?>">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos department_config">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑促销活动</h1></div>
	  <div class="box" style="table-layout:fixed">
	  <br />
  	    <dl><strong style="table-layout:fixed"> 促销活动名称:</strong>
			<dd></dd></dl>

<?php if(isset($languages) && sizeof($languages)>0){
 	foreach ($languages as $k => $v){?>
		 <dl><dt class="config_lang"><?php echo $html->image($v['Language']['img01'])?></dt>
			<dd><input type="text" id="promotion_title_<?php echo $v['Language']['locale']?>" name="data[PromotionI18n][<?php echo $k?>][title]" class="text_inputs" style="width:195px;"  <?php if(isset($promotion['PromotionI18n'][$v['Language']['locale']])){?>value="<?php echo  $promotion['PromotionI18n'][$v['Language']['locale']]['title'];?>"<?php }else{?>value=""<?php }?>/> <font color="#ff0000">*</font></dd></dl>
<?php 
	}
}?>	
	
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="PromotionI18n<?php echo $k;?>Locale" name="data[PromotionI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
	   <?php if(isset($promotion['PromotionI18n'][$v['Language']['locale']])){?>
	<input id="PromotionI18n<?php echo $k;?>Id" name="data[PromotionI18n][<?php echo $k;?>][id]" type="hidden" value="<?php if(isset($promotion['PromotionI18n'][$v['Language']['locale']]['id'])){echo $promotion['PromotionI18n'][$v['Language']['locale']]['id'];}?>">
	   <?php }?>
	   	   <input id="PromotionI18n<?php echo $k;?>PromotionId" name="data[PromotionI18n][<?php echo $k;?>][promotion_id]" type="hidden" value="<?php echo  $promotion['Promotion']['id'];?>">
<?php 
	}
}?>
	
	
		<dl><strong style="table-layout:fixed">促销活动描述:</strong><dd></dd></dl>

<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
			<dl><dt class="config_lang"><?php echo $html->image($v['Language']['img01'])?></dt><dd><textarea name="data[PromotionI18n][<?php echo $k?>][meta_description]" ><?php echo @$promotion['PromotionI18n'][$k]['meta_description']?></textarea></dd></dl>

	<input type="hidden" name="data[PromotionI18n][<?php echo $k?>][locale]" value="<?php echo @$v['Language']['locale']?>" />		
<?php 
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
		  <dl>
		  <dt>金额下限：</dt>
		  <dd><input type="text"  class="text_inputs" style="width:120px;" name="data[Promotion][min_amount]" value="<?php echo $promotion['Promotion']['min_amount']?>"  /></dd>
		  </dl>
			
		<dl><dt>金额上限：</dt>
			<dd><input type="text" name="data[Promotion][max_amount]"  class="text_inputs" style="width:120px;"  value="<?php echo $promotion['Promotion']['max_amount']?>" />&nbsp 0表示没有上限</dd></dl>
			<dl>
			<dt style="*padding-top:8px;">促销起始日期：</dt>
			<dd><input type="text" name="data[Promotion][start_time]" class="text_inputs" style="width:120px;" value="<?php echo $promotion['Promotion']['start_time']?>" id="date" readonly="readonly"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?></dd>
			</dl>
		
		<dl><dt style="*padding-top:8px;">促销结束日期：</dt>
			<dd><input type="text"  name="data[Promotion][end_time]" class="text_inputs" style="width:120px;" value="<?php echo $promotion['Promotion']['end_time']?>"id="date2" readonly="readonly"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?></dd>
		</dl>
			<dl><dt>
			<span id="helps"><?php echo $html->image('help_icon.gif',array('align'=>'absmiddle',"onclick"=>"help_show_or_hide('help_text')"))?>优惠方式：</span></dt>
			<dd><select name="data[Promotion][type]" onchange="pagesizeq(this.options[this.options.selectedIndex].value)">
				<option value="2" <?php if( $promotion['Promotion']['type'] == 2 ){ echo "selected"; } ?> >特惠品</option>
				<option value="0" <?php if( $promotion['Promotion']['type'] == 0 ){ echo "selected"; } ?> >减免</option>
				<option value="1" <?php if( $promotion['Promotion']['type'] == 1 ){ echo "selected"; } ?> >折扣</option>
				</select>&nbsp<input type="text"  class="text_inputs" name="data[Promotion][type_ext]" style="width:50px;" value="<?php echo $promotion['Promotion']['type_ext']?>"  />
				<p class="msg"><span style="display:none" id="help_text">当优惠方式为“享受赠品（特惠品）”时，请输入允<br />许买家选择赠品（特惠品）的最大数量，数量为0表<br />示不限数量；当优惠方式为“享受现金减免”时，请<br />输入现金减免的金额；当优惠方式为“享受价格折<br />扣”时，请输入折扣（1－99），如：打9折，就输入<br />90。</span></p>
				</dd>
			</dl>
			<span  id="show_hide">
			<div>
				<?php if( $promotion['Promotion']['type'] == 2 ){?>
				<ul class="ajax_promotion headers_promodion">
					<li class="special">赠品（特惠品）</li>
					<li class="price"><span id="tt"></span> 价格</li>
				</ul>
				<div id="special_preference">
				<?php if( isset($PromotionProduct) && sizeof($PromotionProduct)>0){foreach( $PromotionProduct as $k=>$v ){?>
				<ul class="ajax_promotion">
				<li class="special"><input class="checkbox" type='checkbox' name='specialpreferences[]' value="<?php echo $v['PromotionProduct']['product_id']?>" checked> <?php echo $v['PromotionProduct']['name'];?></li>
				<li class="price"><input type='text' name=prices[] size=2 value='<?php echo $v["PromotionProduct"]["price"]?>' /></li>
				</ul>
				<?php }}?>
				</div>
			<dl><dt>搜索并加入赠品：</dt>
			<dd>
			<input type="text" name="keywords" id="keywords" class="text_inputs" style="width:120px;" />
			<input type="button" value="搜索" onclick="searchProducts();" />
			<input type="hidden" name="brand_id" id="brand_id">
			<input type="hidden" name="products_id" id="products_id" value="0" />
			<input type="hidden" name="category_id" id="category_id">
				<select name="source_select1" id="source_select1" style="width:120px;" >
				</select>
				<input type="button" value="+" name="" onclick="special_preferences()" />
			</dd></dl>
		<?php }?></div></span>
		<br /><br /><br /><br /><br />
		
	  </div>
	</div>
<!--Password End-->

</td>
</tr>
<tr><td colspan="2"><p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p></td></tr>
</table>
<?php echo $form->end();?>
<span id="gg" style="display:none">赠品（特惠品）<span id="tt">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span> 价格<br />
						<span id="special_preference"></span>
			<dl><dt>搜索并加入赠品：</dt>
			<dd><input type="text" name="keywords" id="keywords" class="text_inputs" style="width:120px;" /><input type="button" value="搜索" onclick="searchProducts();" /><input type="hidden" name="brand_id" id="brand_id">	<input type="hidden" name="category_id" id="category_id">
				<select name="source_select1" id="source_select1">
				</select>
			</dd><input type="button" value="+" name="" onclick="special_preferences()" /></dl></span>
</div>
<!--Main Start End-->
<?php echo $html->image('content_left.gif',array('class'=>'content_left'))?><?php echo $html->image('content_right.gif',array('class'=>'content_right'))?>
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
    	special_preference.innerHTML+="<ul class='ajax_promotion'><li class='special'><input class='checkbox' type='checkbox' name=specialpreferences[] value="+source_select1.value+" checked>"+source_select1.options[i].text+tt.innerHTML+"</li><li class='price'><input type='text' name=prices[] size=2 value='0'></li></ul>";
    	}
    
    }
	
}	

function pagesizeq(s){
	var show_hide = document.getElementById('show_hide');
	var gg = document.getElementById('gg');
	if( s!=2 ){
		show_hide.style.display = "none";
	}else{
		show_hide.style.display = "block";
		if(show_hide.innerHTML.length == 5){
			show_hide.innerHTML = gg.innerHTML;
		}
	}
}
</script>