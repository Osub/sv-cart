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
 * $Id: add.ctp 943 2009-04-23 10:38:44Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($this->data)?>
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."商品类型列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
<!--ConfigValues-->
<?php //echo $form->create('Productstype',array('action'=>'edit'));?>
<?php echo $form->create('',array('action'=>'/add/'.$this->data['ProductType']['id'],'name'=>"ProductstypeEditForm","id"=>"ProductstypeEditForm","onsubmit"=>"return productstypes_check();"));?>
<fieldset style="display:none;"><input type="hidden" name="_method" value="POST" /></fieldset>
<input id="ProductTypeId" name="data[ProductType][id]" type="hidden" value=""/>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  &nbsp;&nbsp;编辑商品类型&nbsp;&nbsp;</h1></div>
	  <div class="box">
	  
<!--Menus_Config-->
	  <div class="shop_config menus_configs">
	  	<dl><dt>商品类型名称: </dt><dd>
	<?php if(isset($languages) && sizeof($languages))foreach($languages as $k => $v){?>
		<p><input id="ProductTypeI18n<?=$k;?>Locale" name="data[ProductTypeI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
		<input id="ProductTypeI18n<?=$k;?>ProductTypeId" name="data[ProductTypeI18n][<?=$k;?>][type_id]" type="hidden" value="">
		<?=$html->image($v['Language']['img01'],array('align'=>'absmiddle'))?><input type="text" style="width:291px;border:1px solid #649776" id="name<?=$v['Language']['locale']?>" name="data[ProductTypeI18n][<?=$k;?>][name]" value="" /> <font color="#F90071">*</font>
	</p><?php }?>
		</dd></dl>
		

		
		<dl><dt style="padding-top:10px;"><?=$html->image('help_icon.gif',array('align'=>'absmiddle'))?>属性分组: </dt>
		<dd><textarea style="border:1px solid #629373;width:300px;height:80px;overflow-y:scroll" name="data[ProductType][group]" ></textarea><br /><font color="#646464">每行一个商品属性组。排序也将按照顺序排序。</font></dd></dl>
		
		
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