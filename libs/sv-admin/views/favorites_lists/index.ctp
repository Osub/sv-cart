<?php 
/*****************************************************************************
 * SV-Cart 邮件队列列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3792 2009-08-19 11:21:35Z zhengli $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div class="search_box">

<?php echo $form->create('favorites_lists',array('action'=>'batch_addtolist','name'=>'PointForm',"type"=>"get"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">
		将此日期后更新的商品全部插入发送队列：<input type="text" id="date" style="border:1px solid #649776" name="date"   readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>
	<select name="toppri">
	<?php foreach($systemresource_info["message_queue_priority"] as $kk=>$vv){?>
	<option value="<?php echo $kk;?>"><?php echo $vv;?></option>
	<?php }?>
	</select>
	</dd>
	<dt class="small_search"><input  class="search_article" type="submit" onclick="search_html()" value="确定"  /></dt>
	</dl>
<?php echo $form->end();?>
</div><br />
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
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">	
	<th>关注名称</th>
	<th width="12%">最新更新日期</th>
	<th width="12%">插入发送队列</th>
</tr>
<!--User List-->
<?php if(isset($userfavorite_data) && sizeof($userfavorite_data)>0){?>
<?php $ij=0;foreach($userfavorite_data as $k=>$v){ ?>
<tr <?php if((abs($ij)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }$ij++;?> >
	<td><?php echo $v["UserFavorite"]["type_id_name"]; ?></td>
	<td align="center"><?php echo $v["UserFavorite"]["modified"]; ?></td>
	<td align="center">
	<select id="pri<?php echo $k;?>">
	<?php foreach($systemresource_info["message_queue_priority"] as $kk=>$vv){?>
	<option value="<?php echo $kk;?>"><?php echo $vv;?></option>
	<?php }?>
	</select>
	<input type="button" value="确定" onclick='addtolist(<?php echo $v["UserFavorite"]["id"]; ?>,<?php echo $k;?>);'>
	</td>
</tr>
<?php }}else{?>
<tr><td align="center" colspan="7"><br />没有找到任何记录<br /><br /></td></tr>
<?php }?>
</table></div>
<!--User List End-->	
<div class="pagers" style="position:relative">
	<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
<!--Main Start End-->
</div>
<script type="text/javascript">
function addtolist(favorite_id,myk){ 
	window.location.href = webroot_dir+"favorites_lists/addtolist/"+favorite_id+"/"+GetId("pri"+myk).value+"/";
}

</script>