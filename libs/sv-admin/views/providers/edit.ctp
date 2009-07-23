<?php 
/*****************************************************************************
 * SV-Cart  编辑供应商
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 2504 2009-07-01 08:24:22Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."供应商列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>
<!--Main Start-->

<div class="home_main">
<?php echo $form->create('Provider',array('action'=>'edit/'.$provider_edit["Provider"]["id"],'onsubmit'=>'return providers_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑供应商</h1></div>
	  <div class="box">
	<br />
<!--Providers_Config-->
	  <div class="shop_config menus_configs">
	  	<dl><dt style="width:105px;">供应商名称: </dt>
		<dd><input type="text" style="width:200px;border:1px solid #649776;" id="provider_name" name="data[Provider][name]"value="<?php echo $provider_edit['Provider']['name'];?>"/> <font color="#F90046">*</font></dd></dl>
		<dl><dt style="width:105px;">供应商描述: </dt>
		<dd><input type="text" style="width:200px;border:1px solid #649776;" id="provider_description" name="data[Provider][description]" value="<?php echo $provider_edit['Provider']['description'];?>" /> <font color="#F90046">*</font></dd></dl>
		<dl><dt style="width:105px;">关键字: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776;" name="data[Provider][meta_keywords]"value="<?php echo $provider_edit['Provider']['meta_keywords'];?>"/></dd></dl>
		
		<dl><dt style="width:105px;">关键字描述: </dt>
		<dd><textarea style="width:355px;border:1px solid #649776;height:95px;overflow-y:scroll;"name="data[Provider][meta_description]"><?php echo $provider_edit['Provider']['meta_description'];?></textarea></dd></dl>
		<input id="BrandId" name="data[Provider][id]" type="hidden" value="<?php echo  $provider_edit['Provider']['id'];?>">
		<dl><dt style="width:105px;">联系人: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776;" name="data[Provider][contact_name]"value="<?php echo $provider_edit['Provider']['contact_name'];?>"/></dd></dl>
		<dl><dt style="width:105px;">Email地址: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776;"  name="data[Provider][contact_email]"value="<?php echo $provider_edit['Provider']['contact_email'];?>"/></dd></dl>
		<dl><dt style="width:105px;">邮编: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776;" name="data[Provider][contact_zip]" value="<?php echo $provider_edit['Provider']['contact_zip'];?>" /></dd></dl>
		<dl><dt style="width:105px;">联系电话: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776;"name="data[Provider][contact_tele]" value="<?php echo $provider_edit['Provider']['contact_tele'];?>"/></dd></dl>
		<dl><dt style="width:105px;">手机: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776;"name="data[Provider][contact_mobile]"value="<?php echo $provider_edit['Provider']['contact_mobile'];?>" /></dd></dl>
		<dl><dt style="width:105px;">传真: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776;" name="data[Provider][contact_fax]"value="<?php echo $provider_edit['Provider']['contact_fax'];?>"/></dd></dl>
		<dl><dt style="width:105px;">邮件地址: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776;"name="data[Provider][contact_address]"value="<?php echo $provider_edit['Provider']['contact_address'];?>" /></dd></dl>
		<dl><dt style="width:105px;">备注: </dt>
		<dd><textarea style="width:355px;border:1px solid #649776;height:50px;overflow-y:scroll;"name="data[Provider][contact_remark]"><?php echo $provider_edit['Provider']['contact_remark'];?></textarea></dd></dl>
		<dl><dt style="width:105px;">排序: </dt>
		<dd><input type="text" style="width:113px;border:1px solid #649776;"name="data[Provider][orderby]" value="<?php echo $provider_edit['Provider']['orderby'];?>"/></dd></dl>
		<dl><dt style="width:105px;">是否有效: </dt>
		<dd>
			<input id="BrandStatus" name="data[Provider][status]" type="radio" class="radio" value="1" <?php if($provider_edit['Provider']['status']){?>checked<?php }?> >是&nbsp;
			<input id="BrandStatus" name="data[Provider][status]" type="radio" class="radio" value="0" <?php if($provider_edit['Provider']['status']==0){?>checked<?php }?> >否</dd>
		</dl>
		
		<dl><dt style="width:105px;padding-top:0;">添加时间: </dt>
		<dd><?php echo $provider_edit['Provider']['created'];?></dd></dl>
		<dl><dt style="width:105px;padding-top:0;">最后修改时间: </dt>
		<dd><?php echo $provider_edit['Provider']['modified'];?></dd></dl>
		
		
		<br />
		<br />
		<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
		<br /><br />
		</div>
<!--Providers_Config End-->
		
	  </div>
	  
	</div>
<?php echo $form->end();?>

<div class="order_stat athe_infos operators">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  供应商商品列表</h1></div>
	  <div class="box users_configs">
	  
<!--Providers_List-->
	  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="pay_addresse">
	  <tr>
	  	<th>分类名称</th>
		<th>商品名称</th>
		<th>货号</th>
		<th>市场价</th>
		<th>销售价</th>
		<th>进价</th>
		<th>起订数</th>
		<th>操作</th>
	  </tr>
<?php if(isset($product_list) && sizeof($product_list)>0){?>
<?php foreach( $product_list as $k=>$v ){?>
	  <tr>
	  	<td align="center">ss</td>
		<td align="left"><strong><?php echo $v['ProductI18n']['name'];?></strong></td>
		<td align="center"><?php echo $v['Product']['code'];?></td>
		<td align="center"><?php echo $v['Product']['market_price'];?> </td>
		<td align="center"><?php echo $v['Product']['shop_price'];?></td>
		<td align="center">未知</td>
		<td align="center">未知</td>
		<td align="center">
		<?php echo $html->link($html->image('icon_view.gif'),'/products/'.$v['Product']['id'],'',false,false)?>
		<?php echo $html->link($html->image('icon_edit.gif'),'/products/'.$v['Product']['id'],'',false,false)?>
		<?php echo $html->link($html->image('icon_trash.gif'),'trash/'.$v['Product']['id'].'/'.$providerid,'',false,false)?></td>
	  </tr>
<?php }} ?>
	 
	  
	  </table>
<!--Providers_List End-->
		
	  </div>
	  
	</div>
</div>
<!--Main End-->
</div>