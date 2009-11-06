<?php 
/*****************************************************************************
 * SV-Cart 推荐管理
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
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."分成管理","/royalties/",'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('recommends',array('action'=>'/index/','name'=>"theForm"));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  推荐设置</h1></div>
	  <div class="box">
<!--Mailtemplates_Config-->
<div class="shop_config menus_configs">
	<dl><dt style="width:105px;"></dt>
	<dd>
	<table>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){if($v['Language']['locale']!="chi"){continue;}?>
	<tr>
	<td><!--<?php echo $html->image($v['Language']['img01'])?>：--></td><td><input type="radio" name="data[<?php echo $v['Language']['locale']?>][on]" value="1" onclick="open_or_close(this,'<?php echo $v['Language']['locale']?>')" <?php if($affiliate_config["ConfigI18n"][$v["Language"]["locale"]]["value"]['on']==1){echo "checked";}?> />开启</td><td><input type="radio" value="0"   name="data[<?php echo $v['Language']['locale']?>][on]" onclick="open_or_close(this,'<?php echo $v['Language']['locale']?>')" <?php if($affiliate_config["ConfigI18n"][$v["Language"]["locale"]]["value"]['on']==0){echo "checked";}?> />关闭</td>
	</tr>
<?php }}?>
	</table>
	</dd></dl>
</div>
<!--Mailtemplates_Config End-->
</div>
<br />
<div class="box">
<!--Mailtemplates_Config-->
<div class="shop_config menus_configs">
<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){if($v['Language']['locale']!="chi"){continue;}?>
<span id="<?php echo $v['Language']['locale'];?>_open_or_close_status" <?php if($affiliate_config["ConfigI18n"][$v["Language"]["locale"]]["value"]['on']!=1){echo "style='display:none'";}?>  >
	<table>
	<tr><td><!--<?php echo $html->image($v['Language']['img01'])?>：--></td>
	<td><input type="radio" name="data[<?php echo $v['Language']['locale']?>][config][separate_by]" value="1" onclick="user_or_order_opencloase(this,'<?php echo $v['Language']['locale']?>')" <?php if($affiliate_config["ConfigI18n"][$v["Language"]["locale"]]["value"]['config']['separate_by']==1){echo "checked";}?> >推荐注册分成
		<input type="radio" name="data[<?php echo $v['Language']['locale']?>][config][separate_by]" value="0" onclick="user_or_order_opencloase(this,'<?php echo $v['Language']['locale']?>')" <?php if($affiliate_config["ConfigI18n"][$v["Language"]["locale"]]["value"]['config']['separate_by']==0){echo "checked";}?> >推荐订单分成
	</td></tr>
	<tr><td style="font-size:12px; font-weight: bold; color: #666;vertical-align: top;">推荐时效：
	<td  style="bold; color: #666;">
	<input type="text" style="width:100px;border:1px solid #649776" name="data[<?php echo $v['Language']['locale']?>][config][expire]" value="<?php echo $affiliate_config['ConfigI18n'][$v['Language']['locale']]['value']['config']['expire']?>" />
	<select name="data[<?php echo $v['Language']['locale']?>][config][expire_unit]">
	<option value="hour" <?php if($affiliate_config['ConfigI18n'][$v['Language']['locale']]['value']['config']['expire_unit']=="hour"){echo "selected";}?> >小时</option>
	<option value="day"<?php if($affiliate_config['ConfigI18n'][$v['Language']['locale']]['value']['config']['expire_unit']=="day"){echo "selected";}?> >天</option>
	<option value="week"<?php if($affiliate_config['ConfigI18n'][$v['Language']['locale']]['value']['config']['expire_unit']=="week"){echo "selected";}?> >周</option>                        
	</select>
	<br />访问者点击某推荐人的网址后，在此时间段内注册、下单，均认为是该推荐人的所介绍的。</td></tr>

	<tr><td style="font-size:12px; font-weight: bold; color: #666;vertical-align: top;">积分分成总额百分比：</td>
		<td  style="bold; color: #666;"><input type="text" style="width:100px;border:1px solid #649776" name="data[<?php echo $v['Language']['locale']?>][config][level_point_all]" value="<?php echo $affiliate_config['ConfigI18n'][$v['Language']['locale']]['value']['config']['level_point_all']?>"  />
		<br />订单积分的此百分比部分作为分成用积分。</td></tr>

	
	<tr><td style="font-size:12px; font-weight: bold; color: #666;vertical-align: top;">现金分成总额百分比：</td>
		<td style="bold; color: #666;"><input type="text" style="width:100px;border:1px solid #649776"  name="data[<?php echo $v['Language']['locale']?>][config][level_money_all]" value="<?php echo $affiliate_config['ConfigI18n'][$v['Language']['locale']]['value']['config']['level_money_all']?>"  />
		<br />订单金额的此百分比部分作为分成用金额。</td></tr>

	
	<tr><td style="font-size:12px; font-weight: bold; color: #666;vertical-align: top;">注册积分分成数：</td>
		<td style="bold; color: #666;"><input type="text" style="width:100px;border:1px solid #649776"  name="data[<?php echo $v['Language']['locale']?>][config][level_register_all]" value="<?php echo $affiliate_config['ConfigI18n'][$v['Language']['locale']]['value']['config']['level_register_all']?>"  />
		<br />介绍会员注册，介绍人所能获得的等级积分。</td></tr>


	<tr><td style="font-size:12px; font-weight: bold; color: #666;vertical-align: top;" >等级积分分成上限：</td>
		<td style="bold; color: #666;"><input type="text" style="width:100px;border:1px solid #649776" name="data[<?php echo $v['Language']['locale']?>][config][level_register_up]" value="<?php echo $affiliate_config['ConfigI18n'][$v['Language']['locale']]['value']['config']['level_register_up']?>" />
		<br />等级积分到此上限则不再奖励介绍注册积分。</td></tr>
</table></span>
<?php }}?>
		
</div>
</div>

<br /><br />

<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="10%">推荐人级别</th>
	<th width="40%">积分分成百分比</th>
	<th width="40%">现金分成百分比</th>
	<th width="10%">操作</th>
</tr>
</table>
<span id="heavy_recomment">
<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $kk => $vv){if($vv['Language']['locale']!="chi"){continue;}?>
<span id="<?php echo @$vv['Language']['locale'];?>_user_or_order_opencloase_status" <?php if($affiliate_config["ConfigI18n"][$vv["Language"]["locale"]]["value"]['config']['separate_by']!=1){echo "style='display:none'";}?> <?php if($affiliate_config["ConfigI18n"][$vv["Language"]["locale"]]["value"]['on']!=1){echo "style='display:none'";}?>>
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<!--<tr><td align="center"><?php echo $html->image($vv['Language']['img01'])?></td></tr>-->
</table>
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<?php foreach( $affiliate_config['ConfigI18n'][$vv['Language']['locale']]['value']["item"] as $k=>$v){?>

<tr><input type="hidden" name="data[<?php echo $vv['Language']['locale']?>][item][<?php echo $k;?>][level_point]" value="<?php echo $v['level_point']?>">
	<input type="hidden" name="data[<?php echo $vv['Language']['locale']?>][item][<?php echo $k;?>][level_money]" value="<?php echo $v['level_money']?>">
	<td align="center" width="10%"><?php echo $addid = $k+1?></td>
	<td align="center" width="40%"><?php echo $v["level_point"]?></td>
	<td align="center" width="40%"><?php echo $v["level_money"]?></td>
	<td align="center" width="10%"><?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','del_recomment_config({$k},\"{$vv['Language']['locale']}\")',5)"));?></td>
</tr>
<?php }?>

<tr>
	<td align="center"></td>
	<td align="center"><input type="text" style="width:100px;border:1px solid #649776" id="mypoint" /></td>
	<td align="center"><input type="text" style="width:100px;border:1px solid #649776" id="mymoney" /></td>
	<td align="center"><?php echo $html->link("新增","javascript:;",array("onclick"=>"add_recomment_config(".$addid.",'".$vv['Language']['locale']."')"));?></td>
</tr>

</table>
</span>
<?php }}?>
</span>
</div>
<p class="submit_values"><input type="submit" style="cursor:pointer;"  value="确 定" /><input type="reset" value="重 置" style="cursor:pointer;"  /></p>

</div>
<?php echo $form->end();?>
</div>
<!--Main End-->
</div>
<script type="text/javascript">
function add_recomment_config(addid,locale){
	YAHOO.example.container.wait.show();
	var mypoint = GetId("mypoint");
	var mymoney = GetId("mymoney");
	var sUrl = webroot_dir+"recommends/add_recomment_config/"+addid+"/"+locale+"/"+mypoint.value+"/"+mymoney.value+"/";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, add_recomment_config_callback);
		
}
var add_recomment_config_Success = function(o){
	heavy_recomment_config();
}
	
var add_recomment_config_Failure = function(o){
	YAHOO.example.container.wait.hide();
}

var add_recomment_config_callback ={
	success:add_recomment_config_Success,
	failure:add_recomment_config_Failure,
	timeout : 10000,
	argument: {}
};
function del_recomment_config(delid,locale){
	YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"recommends/remove/"+delid+"/"+locale+"/";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, del_recomment_config_callback);
		
}
var del_recomment_config_Success = function(o){
	heavy_recomment_config();

}
	
var del_recomment_config_Failure = function(o){
	YAHOO.example.container.wait.hide();
}

var del_recomment_config_callback ={
	success:del_recomment_config_Success,
	failure:del_recomment_config_Failure,
	timeout : 10000,
	argument: {}
};
//重载
function heavy_recomment_config(){
	YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"recommends/ajax_index/?status=1";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, heavy_recomment_config_callback);
		
}
var heavy_recomment_config_Success = function(o){
	GetId("heavy_recomment").innerHTML = o.responseText;
	YAHOO.example.container.wait.hide();
}
	
var heavy_recomment_config_Failure = function(o){
	YAHOO.example.container.wait.hide();
}

var heavy_recomment_config_callback ={
	success:heavy_recomment_config_Success,
	failure:heavy_recomment_config_Failure,
	timeout : 10000,
	argument: {}
};
function open_or_close(obj,locale){
	var open_or_close_status = GetId(locale+"_open_or_close_status");
	var user_or_order_opencloase_status = GetId(locale+"_user_or_order_opencloase_status");
	if(obj.value==1){
		open_or_close_status.style.display = "block";
		user_or_order_opencloase_status.style.display = "block";
	}
	else{
		open_or_close_status.style.display = "none";
		user_or_order_opencloase_status.style.display = "none";
	}

}
function user_or_order_opencloase(obj,locale){
	var user_or_order_opencloase_status = GetId(locale+"_user_or_order_opencloase_status");
	if(obj.value==1){
		user_or_order_opencloase_status.style.display = "block";
	}
	else{
		user_or_order_opencloase_status.style.display = "none";
	}

}
</script>