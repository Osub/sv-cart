<?php
/*****************************************************************************
 * SV-Cart 促销活动管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1670 2009-05-25 00:47:18Z huangbo $
*****************************************************************************/
?>


<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations',$navigations));//pr($promotions);?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'/','name'=>"ReportPromotionForm","type"=>"get"));?>

	<dl>
	<dt style="padding-top:0;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">活动名称：<input type="text" class="name" name='promotion_title'value="<?php if(isset($promotion_title))echo $promotion_title;?>"/>&nbsp;&nbsp;活动时间：<input type="text" class="time" name="start_time" value="<?php echo $start_time?>"id="date" readonly="readonly"/><button  id="show" type="button"><?=$html->image('calendar.gif')?></button>－<input type="text" class="time" name="end_time" id="date2" readonly="readonly"value="<?php echo $end_time?>"/><button id="show2" type="button"><?=$html->image('calendar.gif')?></button></p></dd>
	<dt class="small_search"><input type="submit" value="搜索" class="search_article" /></dt>
	</dl><? echo $form->end();?>
</div>
<br />
<!--Search End-->
<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle')).'新增促销','/promotions/add','',false,false)?></strong></a></p>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<?php echo $form->create('',array('action'=>''));?>

	<ul class="product_llist articles_type promotions">
	<li class="number">编号</li>
	<li class="name">&nbsp;&nbsp;活动名称</li>
	<li class="type">类型</li>
	<li class="start_time">活动开始时间</li>
	<li class="end_time">活动结束时间</li>
	<li class="hadle">操作</li></ul>
<!--Promotions List-->
<?if(isset($promotions) && sizeof($promotions)>0){?>
<?php foreach($promotions as $promotion){?>
	<ul class="product_llist articles_type promotions promotions_list">
	<li class="number"><?php echo $promotion['Promotion']['id']?></li>
	<li class="name"><span><strong><?php echo $promotion['PromotionI18n']['title']?></strong></span></li>
	<li class="type"><?php echo $promotion['Promotion']['typename']?></li>
	<li class="start_time"><?php echo $promotion['Promotion']['start_time']?></li>
	<li class="end_time"><?php echo $promotion['Promotion']['end_time']?></li>
	<li class="hadle">
	<?php echo $html->link("查看","../../promotions/{$promotion['Promotion']['id']}");?>|<?php echo $html->link("编辑","edit/{$promotion['Promotion']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}promotions/remove/{$promotion['Promotion']['id']}')"));?>

	</li>
	
		</ul>
<?php }}?>
<!--Promotions List End-->	
	
	
	
	
<? echo $form->end();?>
  <div class="pagers" style="position:relative">
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
<!--Main Start End-->
</div><!--时间控件层start-->
	<div id="container_cal" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal2" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal2"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal3" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal3"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal4" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal4"></div><div style="clear:both;"></div></div>
	</div>
<!--end-->