<?php 
/*****************************************************************************
 * SV-Cart 我的优惠券页
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1166 2009-04-30 14:05:59Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['tags']?></b></h1>
        <div class="Edit_box">
 			<?php if((isset($tags_a) && sizeof($tags_a)>0) || (isset($tags_p) && sizeof($tags_p)>0)){?>  
 				<div class="Edit_info">
 					<?if(isset($tags_p) && sizeof($tags_p)>0){?>
 					<br />
						<table cellpadding="8" cellspacing="0" width="100%">
							<tr>
							<td class="green_3" width="55" style="white-space:nowrap;padding-right:0;" valign="top"><?=$SCLanguages['products'].$SCLanguages['tags']?>:</td>
							<td valign="top">
							<?foreach($tags_p as $k=>$v){?>
							<span class="float_l" style="margin-bottom:4px;white-space:nowrap;">
<?=$html->link($v['TagI18n']['name'],"javascript:search_tag('".$v['TagI18n']['name']."')",array(),false,false);?> <?=$html->link($html->image('drop.gif'),"javascript:del_tag(".$v['Tag']['id'].");",array(),false,false);?>
							&nbsp;</span>
								<?}?>
							</td>
							</tr>
						</table>
					<?}?>
 					<?if(isset($tags_a) && sizeof($tags_a)>0){?>
						<table cellpadding="8" cellspacing="0" width="100%">
						<tr>
							<td class="green_3" width="55" style="white-space:nowrap;padding-right:0;" valign="top"><?=$SCLanguages['article'].$SCLanguages['tags']?>:</td>
							<td>
							<?foreach($tags_a as $k=>$v){?>
							<span class="float_l" style="margin-bottom:4px;white-space:nowrap;">
<?=$html->link($v['TagI18n']['name'],"javascript:search_article_tag('".$v['TagI18n']['name']."')",array(),false,false);?> <?=$html->link($html->image('drop.gif'),"javascript:del_tag(".$v['Tag']['id'].");",array(),false,false);?> &nbsp;
							</span><?}?>
							</td>
						</table>
					<?}?>					
				</div>
 			<?}else{?>
 				<div class="Edit_info">
		        <div class="not">
				<br /><br /><br />
				<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."warning_img.gif":"warning_img.gif",array("alt"=>""))?><strong><?php echo $SCLanguages['not_add_any_label'];?></strong>
				<br /><br /><br />
				</div></div>		
 			<?}?>
		</div>
</div>
<br />
<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>
