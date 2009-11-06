<?php 
/*****************************************************************************
 * SV-Cart 添加菜单
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<p class="add_categories"><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."供应商商品列表","product/",array(),false,false);?></p>

<div class="home_main">
<!--ConfigValues-->
<?php echo $form->create('Provider',array('action'=>'product_edit/'.$ProviderProduct_info["providerProduct"]["id"]));?>

<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑供应商商品</h1></div>
	  <div class="box">
	  
<!--Menus_Config--><?php //pr($parentmenu);?>
	  <div class="shop_config menus_configs">
		<dl><dt>商品: </dt><dd><select style="width:120px;" name="data[ProviderProduct][product_id]">
		<?php foreach( $products_list as $k=>$v ){?>
		<option value='<?php echo $v["Product"]["id"]?>' <?php if($ProviderProduct_info["providerProduct"]["product_id"]==$v["Product"]["id"]){echo "selected";}?> ><?php echo $v["ProductI18n"]["name"]?></option>
		<?php }?></select>
		</dd></dl>
		<dl><dt>供应商:</dt><select style="width:120px;" name="data[ProviderProduct][provider_id]">
		<?php foreach( $Provider_list as $k=>$v ){?>
		<option value='<?php echo $v["Provider"]["id"]?>' <?php if($ProviderProduct_info["providerProduct"]["provider_id"]==$v["Provider"]["id"]){echo "selected";}?> ><?php echo $v["Provider"]["name"]?></option>
		<?php }?></select> 
		<dd></dd></dl>
		<dl><dt>价格: </dt>
		<dd><input type="text" style="width:130px;border:1px solid #649776" name="data[ProviderProduct][price]" value='<?php echo $ProviderProduct_info["providerProduct"]["price"];?>' /></dd></dl>
		<dl><dt>最小进货量: </dt>
		<dd><input type="text" style="width:130px;border:1px solid #649776" name="data[ProviderProduct][min_buy]" value='<?php echo $ProviderProduct_info["providerProduct"]["min_buy"];?>' /></dd></dl>
	
		<dl><dt style="padding-top:2px">是否可用: </dt>
		<dd><input type="radio" name="data[ProviderProduct][status]" value="1" class="radio" <?php if($ProviderProduct_info["providerProduct"]["status"]==1){echo "checked";}?> />是<input type="radio" class="radio" name="data[ProviderProduct][status]" value="0" <?php if($ProviderProduct_info["providerProduct"]["status"]=="0"){echo "checked";}?> />否</dd></dl>
		<dl><dt>排序: </dt>
		<dd><input type="text" style="width:113px;border:1px solid #649776" name="data[ProviderProduct][orderby]" value='<?php echo $ProviderProduct_info["providerProduct"]["orderby"];?>' /><p class="msg">如果您不输入排序号，系统将默认为50</p></dd></dl>
	</div>
<!--Menus_Config End-->
	  </div>
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	</div>
<?php echo $form->end();?>
<!--ConfigValues End-->
</div>
<!--Main End-->
</div>