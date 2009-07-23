<?php 
/*****************************************************************************
 * SV-Cart 编辑广告位
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 2791 2009-07-13 07:07:02Z wuchao $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!-- Main Start-->
<br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."广告位列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('',array('action'=>'edit/'.$advertisement_position['AdvertisementPosition']['id'],'onsubmit'=>'return advertisement_positions_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑广告位</h1></div>
	  <div class="box">
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
	  	<dl><dt style="width:105px;">广告位名称： </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="advertisement_name" name="data[AdvertisementPosition][name]" value="<?php echo $advertisement_position['AdvertisementPosition']['name'];?>" /> <font color="#ff0000">*</font></dd></dl>
		
		<dl><dt style="width:105px;">广告位宽度：</dt>
		<dd><input type="text" style="width:180px;*width:180px;border:1px solid #649776" id="advertisement_width" name="data[AdvertisementPosition][ad_width]" value="<?php echo $advertisement_position['AdvertisementPosition']['ad_width'];?>" />&nbsp;像素<font color="#ff0000">*</font></dd></dl>
		<dl><dt style="width:105px;">广告位高度：</dt>
		<dd><input type="text" style="width:180px;*width:180px;border:1px solid #649776" id="advertisement_height" name="data[AdvertisementPosition][ad_height]" value="<?php echo $advertisement_position['AdvertisementPosition']['ad_height'];?>" />&nbsp;像素<font color="#ff0000">*</font></dd></dl>
		
		<dl><dt style="width:105px;">广告位描述：</dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[AdvertisementPosition][position_desc]" value="<?php echo $advertisement_position['AdvertisementPosition']['position_desc'];?>" /></dd></dl>
		<dl><dt style="width:105px;">排序：</dt>
		<dd><input type="text" style="width:50px;*width:180px;border:1px solid #649776" name="data[AdvertisementPosition][orderby]" value="<?php echo $advertisement_position['AdvertisementPosition']['orderby'];?>" id="orderby"/></dd></dl>
		<dl><dt style="width:105px;">广告js：</dt>
		<dd><textarea name="ads_js" cols="55" rows="3"><?php echo $js_code;?></textarea></dd></dl>
		<br />
		</div>
<!--Mailtemplates_Config End-->
	  </div>
	  <p class="submit_values"><input type="submit" value="确 定" /><input type="reset" value="重 置" /></p>
	</div>
<?php echo $form->end();?>

</div>
<!--Main End-->
</div>

<script>
//广告位置管理
function advertisement_positions_check(){
    var advertisement_name = document.getElementById('advertisement_name');
    var advertisement_width = document.getElementById('advertisement_width');
	var advertisement_height = document.getElementById('advertisement_height');
	var orderby = document.getElementById('orderby');
	
	layer_dialog();
	if( Trim( advertisement_name.value,'g' ) == "" ){
		layer_dialog_show("广告位名称不能为空!","",3);
		return false;
	}
	
	var reg = /^[\d|\-|\s]+$/;
	if (!reg.test(advertisement_width.value)||!reg.test(advertisement_height.value))
	{
	  layer_dialog_show("像素应该是数字","",3);
	  return false;
	}
	if (!reg.test(orderby.value)||!reg.test(orderby.value))
	{
	  layer_dialog_show("排序应该是数字","",3);
	  return false;
	}
}
</script>