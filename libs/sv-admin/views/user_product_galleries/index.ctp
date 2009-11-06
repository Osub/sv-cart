<?php 
/*****************************************************************************
 * SV-Cart 品牌列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 2520 2009-07-02 02:01:40Z zhengli $
*****************************************************************************/
?> 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>

<div class="search_box">
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd>
	添加时间：<input type="text" id="date" name="date" style="border:1px solid #649776" value="<?php echo @$date?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>
	<input type="text" id="date2" name="date2" style="border:1px solid #649776" value="<?php echo @$date2?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>

	<select name="status" id="status">
		<option value="all">审核状态</option>
		<option value="1" <?php if($status == "1"){echo "selected";}?> >有效</option>
		<option value="0" <?php if($status == "0"){echo "selected";}?> >无效</option>
	</select>
	货号：<input type="text" id="product_code" name="product_code" style="border:1px solid #649776" value="<?php echo $product_code?>" />
	会员名：<input type="text" id="user_name" name="user_name" style="border:1px solid #649776" value="<?php echo $user_name?>" />
	</dd>
	<dt class="small_search"><input type="button"  value="搜索"  class="search_article" onclick="search_html()" /></dt>
	</dl>

</div><br></br>
<!--Main Start-->
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

<!--Main Start-->
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="10%">用户名</th>	
	<th>商品名称</th>
	<th>图片</th>
	<th width="10%">是否有效</th>
	<th width="14%">创建日期</th>
	<th width="14%">修改日期</th>
	<th width="10%">操作</th></tr>
<!--Products Cat List-->
<?php if(isset($userproductgalleries_data) && sizeof($userproductgalleries_data)>0){?>
<?php foreach($userproductgalleries_data as $k=>$v){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><? echo $html->link($v['User']['name'],"/users/".$v['User']['id'],array("target"=>"_blank"),false,false);?></td>
	<td><?php echo $html->link($product_list[$v["UserProductGallery"]["product_id"]]['ProductI18n']['name'],$server_host.str_replace("//","/",$root_all."/products/".$v["UserProductGallery"]["product_id"]),array("target"=>"_blank"),false,false);?></td>
	
	<td align="center"><?php $gallery_src = strpos($v['UserProductGallery']['img'],"http://")=="false"?$v['UserProductGallery']['img']:$server_host.$root_all.$v['UserProductGallery']['img'];   echo $html->link($html->image($gallery_src,array('class'=>'vmiddle','width'=>'40','height'=>'40')),$server_host.str_replace("//","/",$root_all."/products/".$v["UserProductGallery"]["product_id"]),array("target"=>"_blank"),false,false);?></td>
	<td align="center"><?php if ($v['UserProductGallery']['status'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($v['UserProductGallery']['status'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?></td>
	<td align="center"><?php echo $v['UserProductGallery']['created'];?></td>
	<td align="center"><?php echo $v['UserProductGallery']['modified'];?></td>
	<td align="center">
		<?php if($v['UserProductGallery']['status'] != 1){?>
		<?php echo $html->link("有效","javascript:;",array("onclick"=>"layer_dialog_show('确定设为有效?','{$admin_webroot}user_product_galleries/effective/{$v['UserProductGallery']['id']}')"));?>
		<?php }else{?>
		<?php echo $html->link("无效","javascript:;",array("onclick"=>"layer_dialog_show('确定设为无效?','{$admin_webroot}user_product_galleries/invalid/{$v['UserProductGallery']['id']}')"));?>
		<?php }?>
		| <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}user_product_galleries/remove/{$v['UserProductGallery']['id']}')"));?></td></tr>
<?php }?>
<?php }?></table></div>
<!--Products Cat List End-->
<div class="pagers" style="position:relative">
    <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>

</div>

<!--Main Start End-->
</div>
<script>
	function search_html(){
		var status = GetId("status");
		var date = GetId("date");
		var date2 = GetId("date2");
		var product_code = GetId("product_code");
		var user_name = GetId("user_name");
		var mydate = date.value;
		var mydate2 = date.value;
		if(mydate==""){
			mydate = "all"
		}
		if(mydate2==""){
			mydate2 = "all"
		}
		window.location.href=webroot_dir+"user_product_galleries/index/"+status.value+"/"+mydate+"/"+mydate2+"/"+product_code.value+"/"+user_name.value;
	}
</script>