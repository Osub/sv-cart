<?php 
/*****************************************************************************
 * SV-Cart  添加会员等级
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 4372 2009-09-18 10:38:17Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."会员等级列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>
<div class="home_main">
<!--ConfigValues-->
<?php echo $form->create('memberlevels',array('action'=>'edit/'.$userrank_info['UserRank']['id'],'onsubmit'=>'return memberlevels_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  &nbsp;&nbsp;添加会员等级&nbsp;&nbsp;</h1></div>
	  <div class="box">
	  
<!--Menus_Config-->
	  <div class="shop_config menus_configs">	
	  	<dl><dt>会员等级名称: </dt>
		<dd></dd></dl>
<?php if(isset($languages) && sizeof($languages)>0){?>
		<?php foreach ($languages as $k => $v){?>
		<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd><input type="text" id="user_rank_name_<?php echo $v['Language']['locale']?>" name="data[UserRankI18n][<?php echo $k;?>][name]" style="width:145px;border:1px solid #649776" value="<?php echo @$userrank_info['UserRankI18n'][$v['Language']['locale']]['name']?>"  /> <font color="#F90071">*</font></dd></dl>
		<?php }}?>
			
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input name="data[UserRankI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
<input name="data[UserRankI18n][<?php echo $k;?>][user_rank_id]" type="hidden" value="<?php echo @$userrank_info['UserRankI18n'][$v['Language']['locale']]['user_rank_id']?>">

	<?php 
	}
}?>
<input type="hidden" name="data[UserRank][id]" value="<?php echo @$userrank_info['UserRank']['id']?>"   />
		<dl><dt>积分下限: </dt>
		<dd><input type="text" name="data[UserRank][min_points]" value="<?php echo @$userrank_info['UserRank']['min_points']?>" style="width:76px;border:1px solid #649776"  /></dd></dl>
		<dl><dt>积分上限: </dt>
		<dd class="intagrel">
		<input type="text" name="data[UserRank][max_points]" value="<?php echo @$userrank_info['UserRank']['max_points']?>" style="width:76px;border:1px solid #649776" value="0" /><br />
		<div class="msg"><input type="checkbox" class="checkbox" name="data[UserRank][show_price]" value="1" <?php if($userrank_info['UserRank']['show_price']==1){echo "checked";}?> />在商品详细页显示会员等级的商品价格</div>
		<div class="msg"><input type="checkbox" class="checkbox" name="data[UserRank][special_rank]" value="1" <?php if($userrank_info['UserRank']['special_rank']==1){echo "checked";}?> />特殊会员组 <?php echo $html->image('help_icon.gif',array('class'=>'vmiddle icons',"onclick"=>"help_show_or_hide('help_text')"))?></div>
		<p style="display:none" id="help_text" class="msg"><font color="#646464">特殊会员组的会员不会随着积分的变化而变化。</font></p>
		</dd>
		</dl>
		<dl><dt>是否可购买: </dt>
			<input type="radio" class="radio" name="data[UserRank][allow_buy]" value="1" <?php if($userrank_info['UserRank']['allow_buy']==1){echo "checked";}?> />是&nbsp;
			<input type="radio" class="radio" name="data[UserRank][allow_buy]" value="0" <?php if($userrank_info['UserRank']['allow_buy']==0){echo "checked";}?> />否

		</dd></dl>
		<dl><dt>初始折扣率: </dt>
		<dd><input type="text" name="data[UserRank][discount]" value="<?php echo @$userrank_info['UserRank']['discount']?>" style="width:76px;border:1px solid #649776"  /> <font color="#F90071">*</font></dd></dl>
		
		<dl><dt> </dt>
		<dd>请填写为0-100的整数,如填入80，表示初始折扣率为8折 </dd></dl>
		
		<br /><br /><br />
		

		</div>
<!--Menus_Config End-->
		
		
		
	  </div>
	  <p class="submit_values"><input type="submit" value="确 定" /><input type="reset" value="重 置" /></p>
	</div>
<?php echo $form->end();?>
<!--ConfigValues End-->


</div>
<!--Main End-->
</div>