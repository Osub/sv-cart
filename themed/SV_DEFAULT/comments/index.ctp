<?php 
/*****************************************************************************
 * SV-Cart 所有评论
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3390 2009-07-29 10:39:28Z shenyunfeng $
*****************************************************************************/
?>
<div id="Right">
	<div id="Products_box">	<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
    <h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $this->data['languages']['all'].$this->data['languages']['comments'];?></b></h1>
<!--所有相册-->
	<div class="categoryArticle border">
	<?php if(isset($products_lists) && sizeof($products_lists)>0){?>
	<?php $num = 0; ?>
	<?php foreach($products_lists as $key=>$v){ ?>
		<?php if(isset($v['Product'])){?>
		<div class="title"><?php echo $html->link($v['ProductI18n']['name'],'/products/'.$v['Product']['id'],array(),false,false);?></div>
		<div class="meta <?php if($num==sizeof($products_lists)-1){?>last<?php }?>">
			<table  cellspacing="0" cellpadding="5"><tr>
				<?php if(sizeof($v['comments'])>=3){?>
					<th rowspan="4">
				<?php }else{?>
					<th rowspan="<?php echo (sizeof($v['comments'])+2)?>">
				<?php }?>
			<?php if($v['Product']['img_thumb'] != ""){?>
				<?php echo $html->link($html->image($v['Product']['img_thumb'],
					array("width"=>isset($this->data['configs']['thumbl_image_width'])?$this->data['configs']['thumbl_image_width']:108,
					"height"=>isset($this->data['configs']['thumb_image_height'])?$this->data['configs']['thumb_image_height']:108,
					"alt"=>$v['ProductI18n']['name'])),"javascript:show_pic_original('".$v['Product']['img_original']."')",array('title'=>$v['ProductI18n']['name']),false,false);?>
				<?php }?></th></tr>
			<?php foreach($v['comments'] as $kk=>$vv){?>
				<?php if($kk <= 2){?>
					<?php if(isset($vv['User']['User']['name'])){
						$user_name = $vv['User']['User']['name'];
					 }else{
						$user_name = $this->data['languages']['anonymous'].$this->data['languages']['user'];
					 }?>
			<tr><td><?php printf($this->data['languages']['sb_comments_st'],$user_name,$vv['Comment']['created'])?>&nbsp;&nbsp;&nbsp;<?php echo $vv['Comment']['sub_content']?></td></tr>
				<?php }?>
			<?php }?>
				<?php if(sizeof($v['comments']) == '1'){?>
					<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
				<?php }elseif(sizeof($v['comments']) == '2'){?>
					<tr><td>&nbsp;</td></tr>
				<?php }?>
				</table>
		</div>
		<?php }
			$num++;
		?>
	<?php }?>	
	<?php }else{?>
  	  <div class='not'><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array('alt'=>''))?>
<strong><?php echo $SCLanguages['coming_please_note'];?></strong></div>
  <?php }?>
</div>
<!--所有相册End-->
<?php if (isset($products_lists) && sizeof($products_lists)>0){ ?>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
<?php }?>
    
    
<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>
</div>