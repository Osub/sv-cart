<?php 
/*****************************************************************************
 * SV-Cart 商品待处理缺货
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: search.ctp 3949 2009-08-31 07:34:05Z huangbo $
*****************************************************************************/
?>
 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));//pr($bookingproducts)?>

<div class="search_box">
<?php echo $form->create('products',array('action'=>'search',"type"=>"get",'name'=>"SearchForm"));?>
	<dl>
	<dt><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p>

	时间：<input type="text" id="date" name="date" value="<?php echo @$date?>" style="border:1px solid #649776" readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>
		<input type="text" id="date2" name="date2" value="<?php echo @$date2?>" style="border:1px solid #649776" readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>&nbsp
	商品关键字：<input name="keywords" value="<?php echo @$keywords;?>"style="border:1px solid #649776"  />&nbsp
	联系人名称：<input name="contact_man" value="<?php echo @$contact_man;?>" style="border:1px solid #649776" />&nbsp
	状态：<select name="bookstatus"><option value="">请选择...</option><option value="1" <?php if(@$bookstatus=="1"){echo "selected";}?> >已处理</option><option value="0" <?php if(@$bookstatus=="0"){echo "selected";}?>>未处理</option></select>&nbsp
	&nbsp&nbsp<input type="button" class="search_article" value="搜索" onclick="search_act()" />
	</p>


	</dl><?php echo $form->end();?>


</div>
<br />
<!--Search End-->
<!--时间控件层start-->
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

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<?php echo $form->create('',array('action'=>''));?>
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="6%">编号</th>
	<th>联系人</th>
	<th width="8%">Email地址</th>
	<th>缺货商品名</th>
	<th width="12%">商品货号</th>
	<th width="12%">登记时间<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th width="8%">是否已处理</th>
	<th width="8%">操作</th></tr>
<!--Products Wanted-->
<?php if(isset($new_bookingproduct_list) && sizeof($new_bookingproduct_list)>0){?>
<?php foreach($new_bookingproduct_list as $k => $bookingproduct){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><?php echo $bookingproduct['BookingProduct']['id']?></td>
	<td><span><?php echo $bookingproduct['BookingProduct']['contact_man']?></span></td>
	<td align="center"><span><?php echo $bookingproduct['BookingProduct']['email']?></span></td>
	<td><span><?php echo $bookingproduct['BookingProduct']['product_name']?></span></td>
	<td><?php echo $bookingproduct['BookingProduct']['code']?></td>
	<td align="center"><?php echo $bookingproduct['BookingProduct']['booking_time']?></td>
	<td align="center"><?php if ($bookingproduct['BookingProduct']['is_dispose'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($bookingproduct['BookingProduct']['is_dispose'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?></td>
	<td align="center">
	<?php echo $html->link("查看","booking_show/{$bookingproduct['BookingProduct']['id']}");?>  |  <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}products/search_remove/{$bookingproduct['BookingProduct']['id']}')"));?>

</td></tr>
<?php }}?>
</table></div>
<!--Products Wanted End-->	
<?php echo $form->end();?>
  <div class="pagers" style="position:relative"> <?php if(isset($new_bookingproduct_list) && sizeof($new_bookingproduct_list)>0){?> <p class='batch'><input type="button" value="导出" onclick=export_act() /></p> <?php } ?>
<input type="hidden" id="url" <?php   if(isset($ex_page)){  ?> value="products/search/wanted?page=<?php echo $ex_page;?>&export=export"<?php }else{ ?> value="products/search/wanted?export=export"<?php } ?>/>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
<!--Main Start End-->
</div>
<script type="text/javascript">
function export_act(){ 
	var url=document.getElementById("url").value;
	window.location.href=webroot_dir+url;
}

function search_act(){ 
	document.SearchForm.action=webroot_dir+"products/search";
	document.SearchForm.onsubmit= "";
	document.SearchForm.submit(); 
}

</script>