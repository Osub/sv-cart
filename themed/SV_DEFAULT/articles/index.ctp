<?php 
/*****************************************************************************
 * SV-Cart 文章主页
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 4578 2009-09-25 10:21:49Z huangbo $
*****************************************************************************/
?>
<cake:nocache>
<? 	$session->check('Config.locale');
	$locale = $session->read('Config.locale');
	header("/articles/index/".$locale);
?>
</cake:nocache>


<script type="text/javascript"> 
<!-- 
/*第一种形式 第二种形式 更换显示样式*/ 
	function overtab(name,cursel,n){ 
	for(i=1;i<=n;i++){ 
	var menu=document.getElementById(name+i); 
	var con=document.getElementById("con_"+name+"_"+i); 
	menu.className=i==cursel?"hover":""; 
	con.style.display=i==cursel?"block":"none"; 
	} 
	} 
//--> 
</script>
<?php echo $this->element('ur_here', array('cache'=>array('key' => 'article_index_ur_here', 'time' => '+0 hour')));?>
<div id="all_article">
<div id="left_article">
<!-- 1 -->
<div class="information">
<?php if(isset($news['Article_list']) && sizeof($news['Article_list'])>0){  ?>
<h1 class="headers"><span class="l">&nbsp;</span><span class="r">&nbsp;</span><b><?php echo $SCLanguages['latest'];?><?php echo $SCLanguages['news'];?></b><span class="more"><?php echo $html->link($SCLanguages['more'],"/category_articles/{$news['Category']['id']}",array(),false,false);?></span></h1>
<div class="infos">   
<div class="comment_list">
<dl class="artic_head">
	<dt><?php echo $SCLanguages['title'];?><?php echo $SCLanguages['list'];?></dt>
	<dd><?php echo $SCLanguages['issue_time'];?></dd>
</dl>
<?php foreach($news['Article_list'] as $key=>$v){ ?>
	<?php if(isset($v['ArticleI18n'])){?>
	<p>
		<span class="title"><?php echo $html->link($v['ArticleI18n']['title'],$svshow->article_link($v['Article']['id'],$dlocal,$v['ArticleI18n']['title'],$this->data['configs']['article_link_type']),array(),false,false)."</span><span>".$v['Article']['modified'];
		?></span>
	</p>
	<?php }?>
<?php }?>
</div>
</div>
<?php }?>
</div>
<!-- 1 -->

<!-- 2 -->
<div class="information">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php printf($SCLanguages['this_week'],$SCLanguages['hot'].$SCLanguages['article']);?>
</b><span class="more"><?php echo $html->link($SCLanguages['more'],"/category_articles/view/hot","",false,false)?></span></h1>
<div class="infos">
<div class="comment_list">
<?php 
 if(isset($hot_list) && sizeof($hot_list)>0){
	  	foreach($hot_list as $key=>$v){ 
?>
<p><span class="title">
<?php echo $html->link($v['ArticleI18n']['title'],$svshow->article_link($v['Article']['id'],$dlocal,$v['ArticleI18n']['title'],$this->data['configs']['article_link_type']),array(),false,false);?>
</span><span>
<?php echo $v['Article']['modified'];?>
</span></p>
<?php }}?>
</div></div></div>
<!-- 2 -->
</div><!-- left_article -->

<div id="right_article">
<div class="activity_column">
<h1 class="headers"><span class="l"></span><span class="r"></span></h1>
<ul class="article_tab" style='margin-top:-32px;margin-bottom:-3px;position:relative;zoom:1;z-index:55;'>
<li id="one1" onmouseover="overtab('one',1,2)" class="hover">
<span>
<?php if(isset($wondeful_news) && $wondeful_news){  ?>
<?php echo $wondeful_news['CategoryI18n']['name']; ?> 
<?php }?>
</span>
</li>
<li id="one2" onmouseover="overtab('one',2,2)">
<span>
<?php if(isset($actives_news) && $actives_news){?>
<?php echo $actives_news['CategoryI18n']['name']; ?> 
<?php }?>
</span>
</li>
</ul>
<div class="main" style="margin-bottom:4px;">
<!--精彩专题-->
<div id="con_one_1">
<sub><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'pic_30.jpg':'pic_30.jpg')?></sub>
<div class="subject" style="padding-bottom:4px;">
<?php if(isset($wondeful_news['Article_list']) && sizeof($wondeful_news['Article_list'])>0){?>
<ul>
<?php if(isset($wondeful_news['Article_list']) && sizeof($wondeful_news['Article_list'])>0){
	  	foreach($wondeful_news['Article_list'] as $key=>$v){ ?>
<li>
<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'right_icon02.gif':'right_icon02.gif').$html->link($v['ArticleI18n']['title'],$svshow->article_link($v['Article']['id'],$dlocal,$v['ArticleI18n']['title'],$this->data['configs']['article_link_type']),array(),false,false)."&nbsp;&nbsp;&nbsp;&nbsp;".$v['Article']['modified'];?>
</li>
<?php }}else{echo '<br /><p align="center" class="no_article">$SCLanguages[no_article] </p><br />';}?>
</ul>
<?php }?>
</div>
</div>
<!--精彩专题 End-->
<!--活动看板-->
<div id="con_one_2" style="display:none;">
<div class="subject" style="border:none;padding-bottom:4px;">
<p class="pic"><?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'item02.gif':'item02.gif'),"#","",false,false);?></p>
<?php if(isset($actives_news['Article_list']) && sizeof($actives_news['Article_list'])>0){?>
<ul>
	<?php if(isset($actives_news['Article_list'])){
	  	foreach($actives_news['Article_list'] as $key=>$v){ ?>
<li>
<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'right_icon02.gif':'right_icon02.gif').$html->link($v['ArticleI18n']['title'],$svshow->article_link($v['Article']['id'],$dlocal,$v['ArticleI18n']['title'],$this->data['configs']['article_link_type']),array(),false,false)."&nbsp;&nbsp;&nbsp;&nbsp;".$v['Article']['modified'];
?>
</li>
<?php }}?>
</ul>
<?php }?>
</div>
<!--活动看板 End-->
</div>
</div>
	
	
	
<div class="activity_column">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php printf($SCLanguages['this_week'],$SCLanguages['hot'].$SCLanguages['comments']);?></b><span class="more"><?php echo $html->link($SCLanguages['more'],"/commons/","",false,false);?></span></h1>
<div class="main">
<div class="comment_list">
<?php 
if(isset($comment_list) && sizeof($comment_list)>0){
		$comment_type_ids = array();
	  	foreach($comment_list as $key=>$v){ 
	  		if((!in_array($v['Comment']['type_id'],$comment_type_ids)) && isset($comment_articles_list[$v['Comment']['type_id']])){
?>
<p><span class="title">
<?php echo $html->link($comment_articles_list[$v['Comment']['type_id']]['ArticleI18n']['title'],"/articles/{$v['Comment']['type_id']}",array(),false,false);?>
</span><span>
<?php echo $v['Comment']['name'];?>
</span></p>
<?php 
	$comment_type_ids[] = $v['Comment']['type_id'];
	}}}?>
</div>
</div>
</div>
</div></div></div> 
<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>