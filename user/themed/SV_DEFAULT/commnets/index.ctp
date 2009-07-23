<?php 
/*****************************************************************************
 * SV-Cart 我的评论
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3261 2009-07-23 05:38:53Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?><h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['my_comments'];?></b></h1>
<div id="Edit_box">
  <div id="Edit_info">
<?php if($my_comments){?>
  <p class="note"><?php printf($SCLanguages['totally_records_unpaid'],$total);?></p>
  
  <?php if(isset($my_comments) && sizeof($my_comments)>0){?>
  
  <?php foreach($my_comments as $k=>$v){?>
  <div id="user_msg">
  	<p class="msg_title"><span class="title"><?php if($v['Comment']['type'] == 'P'){?>
	<?php echo $html->link($v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku'],$server_host,$cart_webroot),array("target"=>"_blank"),false,false);?>
    <?php }?>
    <?//=$SCLanguages['comments']?> <?php echo $v['Comment']['title']?><font color="#A7A9A8">  <?if($v['Comment']['status'] == 1){?><?=$SCLanguages['checked'];?> <?}else{?><?=$SCLanguages['unchecked'];?> <?}?>  <?php echo $v['Comment']['created']?></font></span></p>
    <p class="msg_txt"><span><?php echo $v['Comment']['content']?></span></p>
  </div>
  <?php if(isset($v['Reply']) && sizeof($v['Reply'])>0){?>
     <?php foreach($v['Reply'] as $key=>$val){?>
    <div id="user_msg">
  	<p class="msg_title"><span class="title"><?php echo $SCLanguages['reply'];?>：<?php echo $val['Comment']['title']?><font color="#A7A9A8"><?php echo $val['Comment']['created']?></font></span></p>
    <p class="msg_txt"><span><?php echo $val['Comment']['content']?></span></p>
  </div>
     <?php }?>
  <?php }?>
  <?php }?>
  	  
  	  <?php }?>

    <?php if(isset($my_comments)){?>
	<div id="pager" style="padding-right:10px;"><?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
    <?php }?>
<?php }else{?> 
	<div class="not">
	<br /><br /><br /><br />
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."warning_img.gif":"warning_img.gif")?><strong><?php echo $SCLanguages['no_comments'];?></strong>
	<br /><br /><br /><br />
	</div>
<?php }?>
</div>
</div>
<?php echo $this->element('news', array('cache'=>array('time'=> "+24 hour",'key'=>'news'.$template_style)));?>
