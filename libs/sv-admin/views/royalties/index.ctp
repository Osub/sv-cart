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
<?php echo $form->create('products',array('action'=>'search',"type"=>"get",'name'=>"SearchForm"));?>
	<dl>
	<dt><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p>

	时间：<input type="text" id="date" name="date" value="<?php echo @$date?>" style="border:1px solid #649776" readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>
		<input type="text" id="date2" name="date2" value="<?php echo @$date2?>" style="border:1px solid #649776" readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>&nbsp
	订单号：<input name="order_code" style="border:1px solid #649776" value="<?php echo @$order_code;?>" >&nbsp
	来源：<input name="order_domain" style="border:1px solid #649776" value="<?php echo @$order_domain;?>">&nbsp

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
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."推荐设置","/recommends/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">

<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="10%">订单号</th>
	<th width="10%">订单状态</th>
	<th width="10%">操作状态</th>
	<th width="50%">操作信息</th>
	<th width="10%">分成类型</th>
	<th width="10%">操作</th></tr>
<!--Products Cat List-->
<?php if(isset($order_info) && sizeof($order_info)>0){?>
<?php foreach($order_info as $k=>$v){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td align="center"><?php echo $v['Order']['order_code'];?></td>
	<td align="center"><?php echo $systemresource_info["order_status"][$v['Order']['status']];?></td>
	<td align="center"><?php echo $systemresource_info["royalties"][$v['Order']['is_separate']];?></td>
	<td><?php if($affiliatelog_data[$v['Order']['id']]["AffiliateLog"]["separate_type"] == "-1"||$affiliatelog_data[$v['Order']['id']]["AffiliateLog"]["separate_type"] == "-2"){?>
		<s>
		<?php }?>
		用户ID <?php echo $affiliatelog_data[$v['Order']['id']]["AffiliateLog"]["user_id"];?>(<?php echo $affiliatelog_data[$v['Order']['id']]["AffiliateLog"]["user_name"];?>)，分成：金钱 <?php echo $affiliatelog_data[$v['Order']['id']]["AffiliateLog"]["point"];?> 积分 <?php echo $affiliatelog_data[$v['Order']['id']]["AffiliateLog"]["money"];?>
		<?php if($affiliatelog_data[$v['Order']['id']]["AffiliateLog"]["separate_type"] == "-1"||$affiliatelog_data[$v['Order']['id']]["AffiliateLog"]["separate_type"] == "-2"){?>
		</s>
		<?php }?>
	</td>
	<td align="center"><?php echo $systemresource_info["separate_type"][$affiliatelog_data[$v['Order']['id']]["AffiliateLog"]["separate_type"]];?></td>
	<td align="center">
	<?php if($v['Order']['is_separate']==0 && $v['Order']['separate_able'] == 1 && $affiliate["on"] == 1){ ?>
	<?php echo $html->link("分成","javascript:;",array("onclick"=>"layer_dialog_show('您确定要分成吗？','separate/{$v['Order']['id']}',6)"));?>|<?php echo $html->link("取消","javascript:;",array("onclick"=>"layer_dialog_show('您确定要取消分成吗？此操作不能撤销。','concendel/{$v['Order']['id']}',6)"));?>
	<?php }else if($affiliatelog_data[$v['Order']['id']]["AffiliateLog"]["separate_type"] != "-1"&&$affiliatelog_data[$v['Order']['id']]["AffiliateLog"]["separate_type"] != "-2"){?>
	<?php echo $html->link("撤销","javascript:;",array("onclick"=>"layer_dialog_show('您确定要撤销此次分成吗？','rollback/".$affiliatelog_data[$v['Order']['id']]["AffiliateLog"]["id"]."',6)"));?>
	<?php }else{?>
	-
	<?php }?>
	</td></tr>
<?php }?>
<?php }?></table></div>
<!--Products Cat List End-->
<div class="pagers" style="position:relative">
    <?php //echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>

</div>

<!--Main Start End-->

</div>
<script>
function search_act(){ 
	document.SearchForm.action=webroot_dir+"royalties/";
	document.SearchForm.onsubmit= "";
	document.SearchForm.submit(); 
}

</script>