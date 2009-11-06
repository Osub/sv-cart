<?php 
/*****************************************************************************
 * SV-Cart 文章分类
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: tag.ctp 3390 2009-07-29 10:39:28Z shenyunfeng $
*****************************************************************************/
?>
<div id="Right">
	<div id="Products_box">	<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
    <h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $this->data['languages']['all'].$this->data['languages']['albums'];?></b></h1>
<!--所有相册-->
	<div class="categoryArticle border">
	<?php if(isset($product_lists) && sizeof($product_lists)>0){?>
	<?php $num = 0; ?>
	<?php foreach($product_lists as $key=>$v){ ?>
		<?php if(isset($v['gallery']) && sizeof($v['gallery'])>0 && isset($v['gallery'][0])){?>
		<div class="title"><?php echo $html->link($v['ProductI18n']['name'],'/products/'.$v['Product']['id'],array('title'=>$v['ProductI18n']['name']),false,false);?>&nbsp;<small><?php printf($SCLanguages['updated_albums'],$v['gallery'][0]['UserProductGallerie']['created'],$user_lists[$v['gallery'][0]['UserProductGallerie']['user_id']]['User']['name']);?>&nbsp;</small></div>
		<div class="meta <?php if($num==sizeof($product_lists)-1){?>last<?php }?>">
			<?php if($v['Product']['img_thumb'] != ""){?>
				<?php echo $html->link($html->image($v['Product']['img_thumb'],
					array("width"=>isset($this->data['configs']['thumbl_image_width'])?$this->data['configs']['thumbl_image_width']:108,
					"height"=>isset($this->data['configs']['thumb_image_height'])?$this->data['configs']['thumb_image_height']:108,
					"alt"=>$v['ProductI18n']['name'])),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array('title'=>$v['ProductI18n']['name']),false,false);?>
				<?php }?>				
			
			<?php foreach($v['gallery'] as $k=>$gallery){?>
				<?php if($gallery['UserProductGallerie']['img'] != ""){?>
				<?php echo $html->link($html->image($gallery['UserProductGallerie']['img'],
					array("width"=>70,
					"height"=>70,
					"alt"=>sprintf($SCLanguages['updated_albums'],$gallery['UserProductGallerie']['created'],$user_lists[$gallery['UserProductGallerie']['user_id']]['User']['name']))),"javascript:show_pic_original('".$gallery['UserProductGallerie']['img']."')",array('title'=>sprintf($SCLanguages['updated_albums'],$gallery['UserProductGallerie']['created'],$user_lists[$gallery['UserProductGallerie']['user_id']]['User']['name'])),false,false);?>
				<?php }?>			
			<?php }?>
			&nbsp;
		<?//php echo $html->link($SCLanguages['view_full_text']." >>","gin",array(),false,false)?></div>
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
<?php if (isset($this->data['user_gallery']) && sizeof($this->data['user_gallery'])>0){ ?>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
<?php }?>
    
    
<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>
</div>