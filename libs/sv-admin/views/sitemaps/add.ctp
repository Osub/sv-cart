<?php 
/*****************************************************************************
 * SV-Cart 站点地图添加
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
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!-- Main Start-->
<br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."站点地图模块列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('sitemap',array('action'=>'add/','onsubmit'=>'return sitemap_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  添加模块</h1>
	</div>
	<div class="box">
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
		  	<dl><dt style="width:105px;">模块名称： </dt>
			<dd><input type="text" style="width:300px;border:1px solid #649776" id="name" name="data[Sitemap][name]"  /> <font color="#ff0000">*</font></dd></dl>
			
			<dl><dt style="width:105px;">URL： </dt>
			<dd><input type="text" style="width:300px;border:1px solid #649776" id="url" name="data[Sitemap][url]" /> <font color="#ff0000">*</font></dd></dl>
			<dl><dt style="width:105px;">优先级： </dt>
			<dd><select style="width:100px;border:1px solid #649776" id="orderby" name="data[Sitemap][orderby]"  > 
				<?php foreach($frequency as $k=>$v) {?>
				<option value="<?php echo $k?>" ><?php echo $v?></option>				
				<?php }?>			
				</select>  <font color="#ff0000">*</font></dd></dl>			
			<dl><dt style="width:105px;">周期： </dt>
			<dd></dd><select id="cycle" name="data[Sitemap][cycle]" style="width:100px;border:1px solid #649776"> 
				<?php foreach($cycle as $k=>$v) {?>
				<option value="<?php echo $k?>" ><?php echo $v?></option>				
				<?php }?>
				</select>  <font color="#ff0000">*</font></dl>
			<dl><dt style="width:105px;">类型： </dt>
			<dd></dd><input type="text" style="width:300px;border:1px solid #649776" id="type" name="data[Sitemap][type]"  /> </dl>

			<dl><dt style="width:105px;">是否有效： </dt>
			<dd></dd><input type="radio"  name="data[Sitemap][stuts]"  value="1" checked/>是  <input type="radio"  name="data[Sitemap][stuts]"  value="0"/>否</dl>
		</div>
<!--Mailtemplates_Config End-->

	  </div>
	  <p class="submit_values"><input type="submit" value="确 定" /><input type="reset" value="重 置" /></p>
	</div>
<?php echo $form->end();?>


</div>
<!--Main End-->
</div>

<!--end-->
