<?php 
/*****************************************************************************
 * SV-Cart 评论
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3949 2009-08-31 07:34:05Z huangbo $
*****************************************************************************/
?>
<div id="Right">
	<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
	<div id="Products_box">
    	<h1><span><?php echo $SCLanguages['latest_comments'];?></span></h1>
        
<div class="Edit_box"><!--文章列表-->
  <div id="Edit_info">
  <p class="note article_title"><?php printf($SCLanguages['records_statistics'],$total);?></p>
  <div id="user_msg">
  	<p class="article_time article_title">
		<span class="title"><?php echo $SCLanguages['comment_title'];?></span>
		<span class="user_name"><?php echo $SCLanguages['author'];?></span>
		<span class="add_time"><?php echo $SCLanguages['issue_time'];?></span></p>
    <div id="article_box">
    
<?php if(isset($comment_list) && sizeof($comment_list)>0){
	  	foreach($comment_list as $key=>$v){ ?>    
    
		<p class="list">
			<span class="title"><?php echo $html->link($v['Comment']['title'],"/articles/detail/{$v['Comment']['type_id']}",array(),false,false);?></span>
			<span class="name"><?php echo $v['Comment']['ipaddr'];?></span>
			<span class="time"><?php echo $v['Comment']['created'];?></span>
		</p>
<?php } }?>
	
	</div>
  </div>
  
  </div>
</div><!--文章列表End-->
</div>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>

</div>