<?php 
/*****************************************************************************
 * SV-Cart 插件管理
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
<!-- Main Start-->
<br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."插件列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('plugins',array('action'=>'/add/','name'=>"theForm","enctype"=>"multipart/form-data"));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  新增插件</h1></div>
	  <div class="box">
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">

	  	<dl><dt style="width:105px;">选择ZIP文件： </dt>
		<dd>
		<select name="zipfile">
        	<option value="" selected>- 请选择 -</option>
    		<?php foreach( $zip_arr as $k=>$v ){?>
    			<option value="<?php echo $v?>" ><?php echo $v?></option>
    		<?php }?>
    	</select>
		</dd></dl>
		
		<dl><dt style="width:105px;">或上传ZIP文件： </dt>
		<dd><input name="upfile" size="20" type="file"></dd></dl>
		
		</div>
<!--Mailtemplates_Config End-->
	  </div>
	  <p class="submit_values"><input type="submit" value="确 定" /><input type="reset" value="重 置" /></p>
	</div>
<?php echo $form->end();?>
</div>
<!--Main End-->
</div>










