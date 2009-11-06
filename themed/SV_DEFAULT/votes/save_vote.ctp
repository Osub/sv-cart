<?php 
/*****************************************************************************
 * SV-Cart 提交标签
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: save_vote.ctp 3779 2009-08-19 10:40:08Z huangbo $
*****************************************************************************/
ob_start();?>
<?php if($result['type']==0){?>
<?php echo $form->create('votes',array('action'=>'/save_vote','name'=>'save_vote','type'=>'POST'));?>
<div class="category_box brand_box">
<h3><span class="l"></span><span class="r"></span><?php echo $SCLanguages['site_survey']?></h3>
<div class="category homeorderlist box green_3">
<ul>
<?php if(isset($vote_list) && sizeof($vote_list)>0){?>
<?php foreach($vote_list as $k=>$v){?>
<li class="text">	<?php echo $v['VoteI18n']['name']?></li>
	<li class="text">	(<?php echo $SCLanguages['number_of_participation']?>:<?php echo $v['Vote']['vote_count']?>)</li>
	<?php if(isset($v['options']) && sizeof($v['options'])>0){?>
			<?php $num = 0;?>
		<?php foreach($v['options'] as $kk=>$vv){?>
			<?php if($v['Vote']['can_multi'] == 1){?>
				<li class="text"><input type="radio" name="option[<?php echo $v['Vote']['id']?>]" id="vote_id<?php echo $num?>" value="<?php echo $vv['VoteOption']['id']?>"/>
			<?php }else if($v['Vote']['can_multi'] == 0){?>
				<li class="text"><input type="checkbox" name="option[<?php echo $v['Vote']['id']?>]" id="vote_id<?php echo $num?>" value="<?php echo $vv['VoteOption']['id']?>" />
			<?php }?>
			<?php echo $vv['VoteOptionI18n']['name']?> (<?php if(isset($vv['VoteOption']['dis'])){echo $vv['VoteOption']['dis'];}else{echo '0';}?>%)</li>	<?php $num++;?>
		<?php }?>
	<?php }?>	

<li class="query">
<?//php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
<!-- input type="submit" value="" /-->
<?//php }else{?>
<span class="find-btns"><input type="button" class="find" onclick="javascript:savevote(<?php echo $v['Vote']['id']?>,<?php echo $v['Vote']['can_multi']?>);" value="<?php echo $SCLanguages['vote']?>" /></span>
<?//php }?>
<span class="find-btns"><input class="find" value="<?php echo $SCLanguages['reelect']?>" type="reset"/></span>
</li>
<?php }?>
<?php }?></ul>
</div><p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'category_ulbt.gif':'category_ulbt.gif',array("alt"=>""))?></p>
</div>
<?php echo $form->end();?>

<?php }else{?>
<div id="loginout" class="loginout">
	<h1><b><?=$SCLanguages['site_survey']?></b></h1>
	<div class="border_side" id="buyshop_box">
		<p class="login-alettr">
 	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'icon-10.gif':'icon-10.gif',array("align"=>"middle"));?>
	<b><?php echo $result['msg']?></b></p>
		<p class="buy_btn" style='padding-right:145px;'>
		<br />
		<?php if($result['type'] == "0"){?>
		<?php echo $html->link($SCLanguages['confirm'],"javascript:window.location.reload();");?>
		<?php }else{?>
		<?php echo $html->link($SCLanguages['confirm'],"javascript:close_message();");?>
		<?php }?>
		</p>
	</div>
	 	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'loginout-bottom.gif':'loginout-bottom.gif',array("align"=>"texttop"));?>
</div>
<?php }?>
<?php 	
	$result['message'] = ob_get_contents();
	ob_end_clean();
?><?php if($result['type']==0){?>

<?php ob_start();?>
<div id="loginout" class="loginout">
	<h1><b><?php echo $SCLanguages['site_survey']?></b></h1>
	<div class="border_side" id="buyshop_box">
		<p class="login-alettr">
 	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'icon-10.gif':'icon-10.gif',array("align"=>"middle"));?>
	<b><?php echo $result['msg']?></b></p>
		<p class="buy_btn" style='padding-right:145px;'>
		<br />
		<?php echo $html->link($SCLanguages['confirm'],"javascript:close_message();");?>
		</p>
	</div>
	 	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'loginout-bottom.gif':'loginout-bottom.gif',array("align"=>"texttop"));?>
</div>
<?php 
	$result['msg'] = ob_get_contents();
	ob_end_clean();
	}
	echo json_encode($result);
?>