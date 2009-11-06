<?php 
/*****************************************************************************
 * SV-Cart  添加商品类型
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 4372 2009-09-18 10:38:17Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($this->data)?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."商品类型列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>

<div class="home_main">
<!--ConfigValues-->
<?php //echo $form->create('Productstype',array('action'=>'edit'));?>
<?php echo $form->create('',array('action'=>'/add/'.$this->data['ProductType']['id'],'name'=>"ProductstypeEditForm","id"=>"ProductstypeEditForm","onsubmit"=>"return productstypes_check();"));?>
<fieldset style="display:none;"><input type="hidden" name="_method" value="POST" /></fieldset>
<input id="ProductTypeId" name="data[ProductType][id]" type="hidden" value=""/>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  &nbsp;&nbsp;编辑商品类型&nbsp;&nbsp;</h1></div>
	  <div class="box">
	  
<!--Menus_Config-->
	  <div class="shop_config menus_configs">
	  	<dl><dt>商品类型名称: </dt><dd></dd></dl>
	<?php if(isset($languages) && sizeof($languages))foreach($languages as $k => $v){?>
	  	<dl><dt><?php echo $html->image($v['Language']['img01'],array('align'=>'absmiddle'))?></dt><dd>
		<p><input id="ProductTypeI18n<?php echo $k;?>Locale" name="data[ProductTypeI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
		<input id="ProductTypeI18n<?php echo $k;?>ProductTypeId" name="data[ProductTypeI18n][<?php echo $k;?>][type_id]" type="hidden" value="">
		<input type="text" style="width:291px;border:1px solid #649776" id="name<?php echo $v['Language']['locale']?>" name="data[ProductTypeI18n][<?php echo $k;?>][name]" value="" /> <font color="#F90071">*</font>
	</p>
		</dd></dl>
		<?php }?>

		<dl><dt>编码: </dt>
		<dd><input type="text" style="width:291px;border:1px solid #649776"  name="data[ProductType][code]"   /></dd></dl>

		<dl><dt style="padding-top:10px;"><?php echo $html->image('help_icon.gif',array('align'=>'absmiddle',"onclick"=>"help_show_or_hide('help_text')"))?>属性分组: </dt>
		<dd><textarea style="border:1px solid #629373;width:300px;height:80px;overflow-y:scroll" name="data[ProductType][group_code]" ></textarea><br /><span style="display:none" id="help_text"><font color="#646464">每行一个商品属性组。排序也将按照顺序排序。</font></span></dd></dl>
		
		
		<br /><br /><br /><br /><br /><br /><br />
		
		</div>
<!--Menus_Config End-->
		
		
		
	  </div>
	  <p class="submit_values"><input type="submit" value="确 定" /><input type="submit" value="重 置" /></p>
	</div>
<?php $form->end();?>	
<!--ConfigValues End-->


</div>
<!--Main End-->
</div>