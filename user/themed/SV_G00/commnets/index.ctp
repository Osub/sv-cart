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
 * $Id: index.ctp 899 2009-04-22 15:03:02Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here',array('cache'=>'+0 hour'))?>
<?if($my_comments){?>
<div id="Editinfo_title"><h1><span><?=$SCLanguages['my_comments'];?></span></h1></div>
<div id="Edit_box">
  <div id="Edit_info">
  <p class="note"><?php printf($SCLanguages['totally_records_unpaid'],$total);?></p>
  
  <?if(isset($my_comments) && sizeof($my_comments)>0){?>
  
  <?foreach($my_comments as $k=>$v){?>
  <div id="user_msg">
  	<p class="msg_title"><span class="title"><?if($v['Comment']['type'] == 'P'){?>
<?=$html->link($v['ProductI18n']['name'],"/../products/".$v['Product']['id'],array(),false,false);?>
		   	  	 <?}?>评论：<?echo $v['Comment']['title']?><font color="#A7A9A8"><?echo $v['Comment']['created']?></font></span></p>
    <p class="msg_txt" style="padding-left:5px;padding-right:5px;"><span><?echo $v['Comment']['content']?></span></p>
  </div>
  <?if(isset($v['Reply']) && sizeof($v['Reply'])>0){?>
     <?foreach($v['Reply'] as $key=>$val){?>
        <div id="user_msg">
  	<p class="msg_title"><span class="title"><?=$SCLanguages['reply'];?>：<?echo $val['Comment']['title']?><font color="#A7A9A8"><?echo $val['Comment']['created']?></font></span></p>
    <p class="msg_txt"><span><?echo $val['Comment']['content']?></span></p>
  </div>
     <?}?>
  <?}?>
  <?}?>
  	  
  	  <?}?>

     <?if(isset($my_comments)){?>
<div id="pager">
        <div class="nexit_page"><?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
</div>
     <?}?>
<?}else{?> 
<div id="Editinfo_title"><h1><span><?=$SCLanguages['my_comments'];?></span></h1></div>
<div id="Edit_box">
	<div id="Edit_info">
    	<p align="center" style="font-size:14px;color:#FF6C00;">
    	<br /><br />
    	<b><?=$SCLanguages['no_comments'];?></b>
    	<br /><br /></p>
    </div>
</div>
<?}?>
</div>
</div>
<?php echo $this->element('news',array('cache'=>'+0 hour'))?>