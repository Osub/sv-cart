<?php
/*****************************************************************************
 * SV-Cart 商店设置向导
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 517 2009-04-14 01:18:28Z huangbo $
*****************************************************************************/
?>


<?php echo $form->create('virtual_cards',array('action'=>'/card_edit/'.$id.'/'.$product_id));?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start--><br />
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."补货列表","/virtual_cards/card/".$product_id,'',false,false);?></strong></p>

<div class="home_main" id="guides_1">
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	<?=$html->image('tab_left.gif',array('class'=>'left'))?>
	<?=$html->image('tab_right.gif',array('class'=>'right'))?>
	补货</h1></div>
	<div class="box">
	<div class="shop_config menus_configs guides" style="width:500px;">
	<br />	
	<dl><dt style="width:100px;">商品名称： </dt>
	<dd></dd></dl>
	<? if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>	
	<dl><dt style="width:100px;"><?=@$html->image($v['Language']['img01'])?></dt>
	<dd><input type="text" style="width:300px;*width:180px;border:1px solid #649776" value="<?=@$product_name_list[$v['Language']['locale']]['ProductI18n']['name']?>" disabled /></dd></dl>
	<?}}?>
	
	
	<dl><dt style="width:100px;">卡片序号： </dt>
	<dd><input type="text" style="width:300px;*width:180px;border:1px solid #649776" name="data[VirtualCard][card_sn]" value="<?=$virtualcard_info['VirtualCard']['card_sn']?>" /></dd></dl>
	<dl><dt style="width:100px;">卡片密码： </dt>
	<dd><input type="text" style="width:300px;*width:180px;border:1px solid #649776" name="data[VirtualCard][card_password]" value="<?=$virtualcard_info['VirtualCard']['card_password']?>" /></dd></dl>
	<dl><dt style="width:100px;">截至使用日期： </dt>
	<dd><input type="text" style="width:120px;*width:180px;border:1px solid #649776" name="data[VirtualCard][end_date]" id="date" value="<?=date('Y-m-d',strtotime($virtualcard_info['VirtualCard']['end_date']))?>"  readonly="readonly" /></dd><button id="show" type="button"><?=$html->image('calendar.gif')?></button></dl>
	

	</div>
	</div>
		<p class="submit_btn"><input type="submit" value="确定"  /><input type="reset" value="重置" /></p>
	</div>
</div>
<? echo $form->end();?>
</div><!--时间控件层start-->
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