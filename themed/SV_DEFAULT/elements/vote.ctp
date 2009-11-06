<?php 
/*****************************************************************************
 * SV-Cart 站内调查
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: vote.ctp 3732 2009-08-18 12:01:02Z huangbo $
*****************************************************************************/
?>
<div id="vote_aa">
<?php echo $form->create('votes',array('action'=>'save_vote','name'=>'save_vote','type'=>'POST'));?>
<div class="category_box brand_box">
<h3><span class="l"></span><span class="r"></span><?php echo $SCLanguages['site_survey']?></h3>
<div class="category homeorderlist box green_3">
<ul>
<?php if(isset($vote_lists) && sizeof($vote_lists)>0){?>
<?php foreach($vote_lists as $k=>$v){?>
<li class="text"><?php echo $v['VoteI18n']['name']?></li>
<li class="text">(<?php echo $SCLanguages['number_of_participation']?>:<?php echo $v['Vote']['vote_count']?>)</li>
<?php if(isset($v['options']) && sizeof($v['options'])>0){?><?php $num = 0;?><?php foreach($v['options'] as $kk=>$vv){?><?php if($v['Vote']['can_multi'] == 1){?><li class="text"><input type="radio" name="option[<?php echo $v['Vote']['id']?>]" id="vote_id<?php echo $num?>" value="<?php echo $vv['VoteOption']['id']?>"/><?php }else if($v['Vote']['can_multi'] == 0){?><li class="text"><input type="checkbox" name="option[<?php echo $v['Vote']['id']?>]" id="vote_id<?php echo $num?>" value="<?php echo $vv['VoteOption']['id']?>" /><?php }?><?php echo $vv['VoteOptionI18n']['name']?> (<?php if(isset($vv['VoteOption']['dis'])){echo $vv['VoteOption']['dis'];}else{echo '0';}?>%)</li>	<?php $num++;?><?php }?><?php }?>	
<li class="query"><span class="find-btns"><input type="button" class="find" onclick="javascript:savevote(<?php echo $v['Vote']['id']?>,<?php echo $v['Vote']['can_multi']?>);" value="<?php echo $SCLanguages['vote']?>" /></span><span class="find-btns"><input class="find" value="<?php echo $SCLanguages['reelect']?>" type="reset"/></span></li><?php }?><?php }?>
</ul>
</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'category_ulbt.gif':'category_ulbt.gif',array("alt"=>""))?></p>
</div>
<?php echo $form->end();?>
</div>