<?php 
/*****************************************************************************
 * SV-Cart  配送方式添加设置区域
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: area_add.ctp 3743 2009-08-19 06:43:32Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link('shipping');?>

<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."配送区域列表","/shippingments/area/{$ids}",'',false,false);?></strong></p>

<?php echo $form->create('Shippingment',array('action'=>'area_add/'.$ids,'onsubmit'=>'return shippingments_check();'));?>
<div class="home_main">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑配送区域</h1></div>
	  <div class="box">
	  <br /><input type="hidden" name="data[ShippingArea][shipping_id]" value="<?php echo $ids?>">
	
	  <h2>配送区域名称：</h2>
	    <?php if(isset($languages) && sizeof($languages)>0){?>
<?php foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input type="text" style="width:195px;" id="name<?php echo $v['Language']['locale']?>" name="data[ShippingAreaI18n][<?php echo $k?>][name]" /> <font color="#ff0000">*</font></span></p>
		
<?php } }?>
	<h2>配送区域描述：</h2>
	    <?php if(isset($languages) && sizeof($languages)>0){?>
<?php foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><textarea name="data[ShippingAreaI18n][<?php echo $k?>][description]"></textarea></span></p>
		<input type="hidden" name="data[ShippingAreaI18n][<?php echo $k?>][locale]" value="<?php echo $v['Language']['locale']?>" />		
<?php }} ?>

		<br />
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Other Stat-->
	<div class="order_stat athe_infos">
	  
	  <div class="box" style="padding-top:35px;">
		<table>
		  <tr><td style="vertical-align:top; font-weight: bolder " align="right">1000克以内费用：</td><td><input type="text" class="text_inputs" style="width:190px;border:1px solid #649776"  name="money[][value]" /></td></tr>
		  <tr><td style="vertical-align:top; font-weight: bolder " align="right">&nbsp&nbsp&nbsp 5000克以内续重每500克费用：</td><td><input type="text" class="text_inputs" style="width:190px;border:1px solid #649776" name="money[][value]" /></td></tr>
		  <tr><td style="vertical-align:top; font-weight: bolder " align="right">5001克以上续重500克费用：</td><td><input type="text" class="text_inputs" style="width:190px;border:1px solid #649776" name="money[][value]" /></td></tr>
		  <tr><td style="vertical-align:top; font-weight: bolder " align="right">免费额度：</td><td><input type="text" class="text_inputs" style="width:90px;border:1px solid #649776" name="data[ShippingArea][free_subtotal]" /></td></tr>
		  <tr><td style="font-weight: bolder " align="right">是否有效：</td><td><input type="radio" name="data[ShippingArea][status]" value="1" checked /> 是 <input type="radio" name="data[ShippingArea][status]" value="0" /> 否</td></tr>
		  <tr><td style="vertical-align:top; font-weight: bolder " align="right">排序：</td><td><input type="text" class="text_inputs" style="width:90px;border:1px solid #649776"  name="data[ShippingArea][orderby]" onkeyup="check_input_num(this)"  /><br /> 如果您不输入排序号，系统将默认为50</td></tr>
		 </table>
	  </div>
	</div>
<!--Other Stat End-->
</td>
</tr>

</table>

<!--Categories List-->
		<!--Order Stat-->

	<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  所辖地区</h1></div>
	  <div class="box">
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
		<dl>
		<dd><span id="item_id"></span>	
		</dd></dl>
	  	<dl>一级地区：
		<select multiple size="10" style="width: 85px;" id="country_id" onclick="region_country('country')">
		<?php if(isset($region_country) && sizeof($region_country)>0){?>
		<?php $i=0; foreach( $region_country as $kz=>$v ){?>
		<option value="<?php echo $v['Region']['id']?>" if($kz==0){echo "selected";}><?php echo $v['RegionI18n']['name']?></option>
		<?php $i++;}}?>
		</select>
		二级地区：
		<select multiple size="10" style="width: 85px;" id="province_id" onclick="regions('province')">
		<option value="" selected>请选择...</option>
		</select >
		三级地区：
		<select multiple size="10" style="width: 85px;"id="citys" onclick="region_city('city')">
			<option value="" selected>请选择...</option>
		</select>
		四级地区：
		<select multiple size="10" style="width: 85px;" id="area_id">
			<option value="" selected>请选择...</option>
			</select>
				<input type="button" value="+" onclick="addItems()" />
		</dl>
		</div>
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
	window.onload = region_country('country');
function addItems(){
	var item = document.getElementById('item_id');
	var country = document.getElementById('country_id');	
	var province = document.getElementById('province_id');
	var city = document.getElementById('citys');
	var area = document.getElementById('area_id');
	
	if( cTrim(area.value,0)!="" ){
		//alert("");
		for (i=0;i<area.length;i++){
    		if(area.options[i].selected){
    			var items = document.getElementsByName("items[]");
    			for( var j=0;j<=items.length-1;j++ ){
	    			if( items[j].value == area.options[i].value ){
	    				layer_dialog();
	    				layer_dialog_show('该选项已存在','',3);
	    				return;
	    			}
    			}
    			item.innerHTML= item.innerHTML+"<input type=checkbox name=items[] value="+area.options[i].value+" checked>"+area.options[i].text;
				
    		}
    	}return
    
    
	}
	
	if( cTrim(city.value,0)!="" ){
		//alert("");
		for (i=0;i<city.length;i++){
    		if(city.options[i].selected){
    			var items = document.getElementsByName("items[]");
    			for( var j=0;j<=items.length-1;j++ ){
	    			if( items[j].value == city.options[i].value ){
	    				layer_dialog();
	    				layer_dialog_show('该选项已存在','',3);
	    				return;
	    			}
    			}
    			item.innerHTML= item.innerHTML+"<input type=checkbox name=items[] value="+city.options[i].value+" checked>"+city.options[i].text;
				
    		}
    	}return
    
    
	}
	
	if( cTrim(province.value,0)!="" ){
		//alert("");
		for (i=0;i<province.length;i++){
    		if(province.options[i].selected){
    			var items = document.getElementsByName("items[]");
    			for( var j=0;j<=items.length-1;j++ ){
	    			if( items[j].value == province.options[i].value ){
	    				layer_dialog();
	    				layer_dialog_show('该选项已存在','',3);
	    				return;
	    			}
    			}
    			item.innerHTML= item.innerHTML+"<input type=checkbox name=items[] value="+province.options[i].value+" checked>"+province.options[i].text;
				
    		}
    	}return
    
    
	}
	if( cTrim(country.value,0)!="" ){
		//alert("");
		for (i=0;i<country.length;i++){
    		if(country.options[i].selected){
    			var items = document.getElementsByName("items[]");
    			for( var j=0;j<=items.length-1;j++ ){
	    			if( items[j].value == country.options[i].value ){
	    				layer_dialog();
	    				layer_dialog_show('该选项已存在','',3);
	    				return;
	    			}
    			}
    			item.innerHTML= item.innerHTML+"<input type=checkbox name=items[] value="+country.options[i].value+" checked>"+country.options[i].text;
				
    		}
    	}return
    
    
	}
}
function cTrim(sInputString,iType){
	var sTmpStr = ' '
	var i = -1
	if(iType == 0 || iType == 1){
		while(sTmpStr == ' '){
			++i
			sTmpStr = sInputString.substr(i,1)
		}
		sInputString = sInputString.substring(i)
	}

	if(iType == 0 || iType == 2){
		sTmpStr = ' '
		i = sInputString.length
		while(sTmpStr == ' '){
			--i
			sTmpStr = sInputString.substr(i,1)
		}
		sInputString = sInputString.substring(0,i+1)
	}
	return sInputString
}
      </script>
</script>