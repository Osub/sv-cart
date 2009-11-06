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
 * $Id: index.ctp 4661 2009-09-28 05:31:13Z huangbo $
*****************************************************************************/
?><!--时间控件层start-->
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
<p class="none"><span id="show3">&nbsp;eee</span><span id="show4">&nbsp;</span></p><div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations',$navigations));//pr($promotions);?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'/','name'=>"ReportPromotionForm","type"=>"get"));?>

	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">活动名称：<input type="text" class="name" name='promotion_title'value="<?php if(isset($promotion_title))echo $promotion_title;?>"/>&nbsp;&nbsp;促销日期：从 <input type="text" style="border:1px solid #649776" name="start_time" value="<?php echo $start_time?>"id="date" readonly="readonly"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?> 到 <input type="text" style="border:1px solid #649776" name="end_time" id="date2" readonly="readonly"value="<?php echo $end_time?>"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?></p></dd>
	<dt class="small_search"><input type="submit" value="搜索" class="search_article" /></dt>
	</dl><?php echo $form->end();?>
</div>
<br />
<!--Search End-->
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle')).'新增促销','/promotions/add','',false,false)?></strong></a></p>
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<?php echo $form->create('',array('action'=>''));?>
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="6%">编号</th>
	<th width="50%">&nbsp;&nbsp;活动名称</th>
	<th width="8%">类型</th>
	<th width="12%">活动开始时间</th>
	<th width="12%">活动结束时间</th>
	<th width="12%">操作</th></tr>
<!--Promotions List-->
<?php if(isset($promotions) && sizeof($promotions)>0){?>
<?php foreach($promotions as $k=>$promotion){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td align="center"><?php echo $promotion['Promotion']['id']?></td>
	<td><span><strong><?php echo $promotion['PromotionI18n']['title']?></strong></span></td>
	<td align="center"><?php echo $promotion['Promotion']['typename']?></td>
	<td align="center"><?php echo $promotion['Promotion']['start_time']?></td>
	<td align="center"><?php echo $promotion['Promotion']['end_time']?></td>
	<td align="center">
	<?php echo $html->link("查看",$server_host.$cart_webroot."promotions/{$promotion['Promotion']['id']}");?>|<?php echo $html->link("编辑","edit/{$promotion['Promotion']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}promotions/remove/{$promotion['Promotion']['id']}')"));?>

	</td>
	
		</tr>
<?php }}?>
<!--Promotions List End-->	
	</table></div>
	
	
	
<?php echo $form->end();?>
  <div class="pagers" style="position:relative">
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
<!--Main Start End-->
</div>