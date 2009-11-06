<?php 
/*****************************************************************************
 * SV-Cart  新增供应商
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 4820 2009-10-09 12:22:53Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link("供应商列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),false,false);?></strong></p>

<!--Main Start-->

<div class="home_main">
<?php echo $form->create('Provider',array('action'=>'add','onsubmit'=>'return providers_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  新增供应商</h1></div>
	  <div class="box">
	  
<!--Providers_Config-->
	  <div class="shop_config menus_configs">
	  	<dl><dt style="width:105px;">供应商名称: </dt>
		<dd><input type="text" style="width:200px;border:1px solid #649776;" id="provider_name" name="data[Provider][name]"/> <font color="#F90046">*</font></dd></dl>
	  	<dl><dt style="width:105px;">供应商编号: </dt>
		<dd><input type="text" style="width:200px;border:1px solid #649776;" id="provider_name" name="data[Provider][provider_sn]"/></dd></dl>
		<dl><dt style="width:105px;">供应商描述: </dt>
		<dd><input type="text" style="width:200px;border:1px solid #649776;" id="provider_description" name="data[Provider][description]"/> <font color="#F90046">*</font></dd></dl>
		
		<dl><dt style="width:105px;">关键字: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776;" id="Providermeta_keywords" name="data[Provider][meta_keywords]"/>
			<select style="width:90px;border:1px solid #649776" onchange="add_to_seokeyword(this,'Providermeta_keywords')">
				<option value='常用关键字'>常用关键字</option>
				<?php foreach( $seokeyword_data as $sk=>$sv){?>
					<option value='<?php echo $sv["SeoKeyword"]["name"]?>'><?php echo $sv["SeoKeyword"]["name"]?></option>
				<?php }?>
			</select>

		</dd></dl>
		
		<dl><dt style="width:105px;">关键字描述: </dt>
		<dd><textarea style="width:355px;border:1px solid #649776;height:95px;overflow-y:scroll;"name="data[Provider][meta_description]"></textarea></dd></dl>
		
		<dl><dt style="width:105px;">联系人: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776;" name="data[Provider][contact_name]"/></dd></dl>
		<dl><dt style="width:105px;">Email地址: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776;" name="data[Provider][contact_email]"/></dd></dl>
		<dl><dt style="width:105px;">邮编: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776;" name="data[Provider][contact_zip]"/></dd></dl>
		<dl><dt style="width:105px;">联系电话: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776;" name="data[Provider][contact_tele]"/></dd></dl>
		<dl><dt style="width:105px;">手机: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776;"name="data[Provider][contact_mobile]"/></dd></dl>
		<dl><dt style="width:105px;">传真: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776;" name="data[Provider][contact_fax]"/></dd></dl>
		<dl><dt style="width:105px;">邮件地址: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776;"name="data[Provider][contact_address]" /></dd></dl>
		<dl><dt style="width:105px;">备注: </dt>
		<dd><textarea style="width:355px;border:1px solid #649776;height:50px;overflow-y:scroll;"name="data[Provider][contact_remark]"></textarea></dd></dl>
		<dl><dt style="width:105px;">排序: </dt>
		<dd><input type="text" style="width:113px;border:1px solid #649776;" name="data[Provider][orderby]"/></dd></dl>
		<dl><dt style="width:105px;">是否有效: </dt>
		<dd><input id="BrandStatus" name="data[Provider][status]" type="radio" value="1" checked> <label>是</label> <input id="BrandStatus" name="data[Provider][status]" type="radio" value="0"> <label>否</label></dd></dl>
		

		
		
		<br />
		<br />
		<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
		<br /><br />
		</div>
<!--Providers_Config End-->
		
	  </div>
	  
	</div>
<?php echo $form->end();?>
<!--	
<div class="order_stat athe_infos operators">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  供应商商品列表</h1></div>
	  <div class="box users_configs">
	  
<!--Providers_List-->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="pay_addresse">
	  <tr>
	  	<th width="13%">分类名称</th><th width="20%">商品名称</th><th width="13%">货号</th><th width="10%">市场价</th><th width="9%">销售价</th><th width="9%">进价</th><th width="9%">起订数</th><th width="16%">操作</th>
	  </tr>
	  <tr>
	  	<td width="13%" align="center">手机</td>
		<td width="20%" align="left"><strong>KG119</strong></td>
		<td width="13%" align="left">SV200820</td>
		<td width="10%" align="center">5000.00</td>
		<td width="9%" align="center">5200.00</td>
		<td width="9%" align="center">8000.00</td>
		<td width="9%" align="center">1.0235</td>
		<td width="16%" align="center">
		<?php echo $html->link($html->image('icon_view.gif'),'','',false,false)?>
		<?php echo $html->link($html->image('icon_edit.gif'),'','',false,false)?>
		<?php echo $html->link($html->image('icon_trash.gif'),'','',false,false)?></td>
	  </tr>
	  <tr>
	  	<td width="13%" align="center">照相机</td>
		<td width="20%" align="left"><strong>KG119</strong></td>
		<td width="13%" align="left">SV200820</td>
		<td width="10%" align="center">5000.00</td>
		<td width="9%" align="center">5200.00</td>
		<td width="9%" align="center">8000.00</td>
		<td width="9%" align="center">1.0235</td>
		<td width="16%" align="center">
		<?php echo $html->link($html->image('icon_view.gif'),'','',false,false)?>
		<?php echo $html->link($html->image('icon_edit.gif'),'','',false,false)?>
		<?php echo $html->link($html->image('icon_trash.gif'),'','',false,false)?></td>
	  </tr>
	  <tr>
	  	<td width="13%" align="center">数码打印机</td>
		<td width="20%" align="left"><strong>KG119(新款进口1000美元大暴价)</strong></td>
		<td width="13%" align="left">SV200820</td>
		<td width="10%" align="center">5000.00</td>
		<td width="9%" align="center">5200.00</td>
		<td width="9%" align="center">8000.00</td>
		<td width="9%" align="center">1.0235</td>
		<td width="16%" align="center">
		<?php echo $html->link($html->image('icon_view.gif'),'','',false,false)?>
		<?php echo $html->link($html->image('icon_edit.gif'),'','',false,false)?>
		<?php echo $html->link($html->image('icon_trash.gif'),'','',false,false)?></td>
	  </tr>
	  
	  </table>
-->
<!--Providers_List End-->
		
	  </div>
	  
	</div>
</div>
<!--Main End-->
</div>
<script type="text/javascript">
  function add_to_seokeyword(obj,keyword_id){
	
	var keyword_str = GetId(keyword_id).value;
	var keyword_str_arr = keyword_str.split(",");
	for( var i=0;i<keyword_str_arr.length;i++ ){
		if(keyword_str_arr[i]==obj.value){
			return false;
		}
	}
	if(keyword_str!=""){
		GetId(keyword_id).value+= ","+obj.value;
	}else{
		GetId(keyword_id).value+= obj.value;
	}
}
</script>

<style>
label{vertical-align:middle}
.inputcheckboxradio{vertical-align:middle;}
body{font-family:tahoma;font-size:12px;}
</style>