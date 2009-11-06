<?php 
/*****************************************************************************
 * SV-Cart 实体店
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3863 2009-08-24 07:36:59Z zhangshisong $
*****************************************************************************/
?>
	<div id="Products_box">
    	<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['physical_store'];?></b></h1>
<div class="Edit_box">
<!--文章列表-->
  <div id="Edit_info">
 <?php if(isset($stores) && sizeof($stores)>0){?>
    <div id="user_msg">
  	<p class="article_time article_title">
		<span class="title"><?php echo $SCLanguages['shop_name'];?></span>
		<span class="add_time"><?php echo $SCLanguages['time'];?></span></p>
    <div id="article_box">
<?php foreach($stores as $key=>$v){ ?>    
		<p class="list">
			<span class="title">
			<?php echo $html->link($v['StoreI18n']['name'],$v['StoreI18n']['url'],array('title'=>$v['StoreI18n']['description'],'target'=>'_blank'),false,false);?>
			</span>
			<span class="time"><?php echo $v['Store']['created'];?></span>
		</p>
<?php } ?>
	</div>
  <?php }else{?>
  	<div class='not'><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array('alt'=>''))?>
<strong><?php echo $SCLanguages['coming_please_note'];?></strong></div>
  <?php }?>
  </div>
  </div>
</div><!--文章列表End-->

