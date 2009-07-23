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
 * $Id: search.ctp 2608 2009-07-06 03:14:12Z shenyunfeng $
*****************************************************************************/
?>
 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));//pr($bookingproducts)?>
<!--Main Start-->
<br />
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<?php echo $form->create('',array('action'=>''));?>
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>编号</th>
	<th>联系人</th>
	<th>Email地址</th>
	<th>缺货商品名</th>
	<th>商品货号</th>
	<th>登记时间<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th>是否已处理</th>
	<th>操作</th></tr>
<!--Products Wanted-->
<?php if(isset($new_bookingproduct_list) && sizeof($new_bookingproduct_list)>0){?>
<?php foreach($new_bookingproduct_list as $k => $bookingproduct){?>
	<tr>
	<td><?php echo $bookingproduct['BookingProduct']['id']?></td>
	<td><span><?php echo $bookingproduct['BookingProduct']['contact_man']?></span></td>
	<td align="center"><span><?php echo $bookingproduct['BookingProduct']['email']?></span></td>
	<td align="center"><span><?php echo $bookingproduct['BookingProduct']['product_name']?></span></td>
	<td align="center"><?php echo $bookingproduct['BookingProduct']['code']?></td>
	<td align="center"><?php echo $bookingproduct['BookingProduct']['booking_time']?></td>
	<td align="center"><?php if ($bookingproduct['BookingProduct']['is_dispose'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($bookingproduct['BookingProduct']['is_dispose'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?></td>
	<td align="center">
	<?php echo $html->link("查看","booking_show/{$bookingproduct['BookingProduct']['id']}");?>  |  <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}products/search_remove/{$bookingproduct['BookingProduct']['id']}')"));?>

</td></tr>
<?php }}?>
</table>
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
</script>