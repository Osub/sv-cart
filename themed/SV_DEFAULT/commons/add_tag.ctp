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
 * $Id: add_tag.ctp 2845 2009-07-14 10:58:39Z shenyunfeng $
*****************************************************************************/
ob_start();?>
<div id="loginout">
	<h1><b><?php echo $SCLanguages['add'];?><?php echo $SCLanguages['tags']?></b></h1>
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
	$result['message'] = ob_get_contents();
	ob_end_clean();ob_start();
	?>
	<?php if(isset($result['tag_type']) && $result['tag_type'] == 'P'){
		?>		<li><dd class="l">-<?php echo $SCLanguages['products']?><?php echo $SCLanguages['tags']?>-</dd><dd></li>
<?
			if(isset($tags) && sizeof($tags)>0){ 
			foreach($tags as $k=>$v){?>
				<li>
				<dd class="l"><a href="javascript:search_tag('<?php echo $v['TagI18n']['name']?>');"><?php echo $v['TagI18n']['name']?></a></dd><dd>
				</dd>
				</li>
		<?php }}
		}elseif(isset($result['tag_type']) && $result['tag_type'] == 'A'){if(isset($tags) && sizeof($tags)>0){ foreach($tags as $k=>$v){?>
						<div id="user_msg">
			<p class="msg_title"><span class="title"><?php echo $html->link($v['TagI18n']['name'],"/category_articles/tag/".$v['TagI18n']['name'],array('target'=>'_blank'),false,false)?></span></p>
		</div>	
				<?}}}?>	
	<?
	$result['tag_con'] = ob_get_contents();
	ob_end_clean();
	echo json_encode($result);
?>