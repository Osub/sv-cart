<?php 
/*****************************************************************************
 * SV-Cart 文章详细
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: view.ctp 4433 2009-09-22 10:08:09Z huangbo $
*****************************************************************************/
?>
<cake:nocache>
<? 	$session->check('Config.locale');
	$locale = $session->read('Config.locale');
	header('/articles/'.$this->data['article_detail']['Article']['id']."/".$locale);
?>
</cake:nocache>

<div id="Products_box"><?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>

<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $article_detail['ArticleI18n']['title']; ?></b></h1>
<div class="Edit_box">
	<div id="article_info">
		<div id="user_msg">
			<p class="article_time"><span class="title">&nbsp;<?php echo $article_detail['ArticleI18n']['author']."  ".$article_detail['Article']['modified']; ?></span></p>
			<div class="article"><?php echo $article_detail['ArticleI18n']['content']; ?></div>
		</div>

		<div id="select_article">
			<p><?php if($neighbours['next']){ ?>
			 <?php echo $this->data['languages']['next'];?><?php echo $this->data['languages']['piece'];?>: 
			  <?php echo $html->link("{$neighbours['next']['ArticleI18n']['title']}","{$neighbours['next']['Article']['id']}",array(),false,false); } ?>
			<br />
			 <?php if($neighbours['prev']){?>
			 <?php echo $this->data['languages']['previous'];?><?php echo $this->data['languages']['piece'];?>: 
			 <?php echo $html->link("{$neighbours['prev']['ArticleI18n']['title']}","{$neighbours['prev']['Article']['id']}",array(),false,false); } ?>
			</p>
		</div>
	</div>
</div>
<!--文章列表End-->

<!--  相关文章 -->
<?php if(isset($related_articles) && sizeof($related_articles)>0){?>
<div class="Edit_box">
    <div id="Edit_info" style="border-top:none;">
	  <div class="head"><strong><?php echo $this->data['languages']['related_article']?></strong></div>
		<div id="user_msg">
		  	<p class="article_time article_title" style="display:none;">
				<span class="title"><?php echo $SCLanguages['article'];?><?php echo $SCLanguages['list'];?></span>
				<span class="add_time"><?php echo $SCLanguages['issue_time'];?></span></p>	
			    <div id="article_box">
					<?php foreach($related_articles as $key=>$v){ ?>    
							<p class="list">
								<span class="title"><?php echo $html->link($v['ArticleI18n']['title'],$svshow->article_link($v['Article']['id'],$dlocal,$v['ArticleI18n']['title'],$this->data['configs']['article_link_type']),array(),false,false);?></span>
								<span class="time"><?php echo substr($v['Article']['created'],0,10);?></span>
							</p>
					<?php } ?>
				</div>
		</div>
	</div>
</div>
<?php }?>
<!--相关文章End-->

<!-- 加文章标签 -->
<?php if(isset($this->data['configs']['use_tag']) && $this->data['configs']['use_tag'] == 1){?>					
<div class="Edit_box">
    <div id="Edit_info" style="border-top:none;">
	  <div class="head"><strong><?php echo $this->data['languages']['article']?><?php echo $this->data['languages']['tags']?></strong></div>
	<br />
	<dl>
	  <dd>&nbsp;&nbsp;&nbsp;<input type="text" name="tag" id="tag" class="text_input"  />&nbsp;</dd>
	  <dd class="btn_list">
		<a href="javascript:add_tag(<?php echo $article_detail['Article']['id']?>,'A',<?=isset($_SESSION['User']['User']['id'])?1:0;?>)" class="float_l"><span><?php echo $this->data['languages']['add_to_my_tags']?></span></a></dd>
	</dl>
	<br /><br />
	<div id='update_tag' class="tags">
	<?php if(isset($tags) && sizeof($tags)>0){?>
		<?php
			$tag_arr = array();
			foreach($tags as $k=>$v){?>
		<?php if(!in_array($v['TagI18n']['name'],$tag_arr)){?>
		<span class="float_l" style="white-space:nowrap;margin-top:5px;"><?php echo $html->link($v['TagI18n']['name'],"/articles/tag/".$v['TagI18n']['name'],array('target'=>'_blank'),false,false)?>&nbsp;&nbsp;</span>
		
		<?php 
		}$tag_arr[] = $v['TagI18n']['name'];
		}}?>
		</div>	
	</div>
</div>
	<!--
		<li class="btn_list">
		<dd >	<input type="text" name="tag" id="tag" class="text_input"  />&nbsp;</dd><dd><a href="javascript:add_tag(<?php echo $article_detail['Article']['id']?>,'P')" class="addfav"><span>加入我的标签</span></a></dd>
		</li>
			
		<?php if(isset($tags) && sizeof($tags)>0){?>
		<li><dd class="l">-文章标签-</dd><dd></li>
			<?php foreach($tags as $k=>$v){?>
			<li>
			<dd class="l"><a href="javascript:search_tag('<?php echo $v['TagI18n']['name']?>');"><?php echo $v['TagI18n']['name']?></a></dd><dd>
			</dd>
			</li>
			<?php }?>
		<?php }?>				
			
	<?php }?> -->
	<!-- 加文章标签end -->

<!--相关商品-->
	<cake:nocache>
<?php if(isset($this->data['cache_products']) && sizeof($this->data['cache_products'])>0){?>
<div class="Edit_box">
	<div id="Edit_info" style="padding-bottom:0;border-top:none;">
	<div class="head"><strong><?php echo $this->data['languages']['correlative_products'];?><?//php echo $this->data['languages']['previous'];?><?//php echo $this->data['languages']['piece'];?></strong></div>
    <div class="Item_List" style="border:none;">
	<ul style="margin:0;">
	<?php 
		foreach($this->data['cache_products'] as $key=>$v){
			if($v['Product']['img_thumb'] == ""){
				if($this->data['configs']['products_default_image'] == ""){
					$v['Product']['img_thumb'] = "/img/product_default.jpg";
				}else{
					$v['Product']['img_thumb'] = $this->data['configs']['products_default_image'];
				}
			}
			echo $html->tag('li',$html->para('pic',
				 $html->link(
				 $html->image("{$v['Product']['img_thumb']}",array('width'=>'108','height'=>'108','alt'=>$v['ProductI18n']['name']))
				 ,$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),'',false,false)
				 ,array(),false)
				 .$html->para('info',
				 $html->tag('span',$html->link("{$v['ProductI18n']['name']}",$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank"),false,false),'name')
				 .$html->tag('span',$html->tag('font',
				 	 (isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')]))?$svshow->price_format($v['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']):$svshow->price_format($v['Product']['shop_price'],$this->data['configs']['price_format'])
				 	 ,array('color'=>'#F9630C')),'Price')		 		
				 ,array(),false),array('style'=>'padding:0;'));				
			}
	
?>
</ul>
</div>
	</div>
</div>
</cake:nocache><!--相关商品End-->
<?php } ?>    		
<div class="height_5">&nbsp;</div>
<!--用户评论-->
<div class="cont" <?php if($this->data['article_detail']['Article']['comment'] == 0){?> style="display:none;"<?php }?>>
  <div class="head"><strong><?php echo $this->data['languages']['user'];?><?php echo $this->data['languages']['comments'];?></strong><span <?php if($this->data['configs']['articles_comment_condition'] == '0'){?>style="display:none;"<?php }elseif($this->data['configs']['articles_comment_condition'] == '2' && (!($session->check('User.User.name')))){?> style="display:none;" <?php }?>><a id="comments" class="action"><?php echo $this->data['languages']['issue_comments'];?></a></span>
  </div>
	<?if(isset($_SESSION['User']['User']['id'])){?>
	<?php echo $this->element('comment', array('cache'=>array('key' => 'article_view_', 'time' => '+0 hour')));?>
	<?}else{?>
	<?php echo $this->element('comment', array('cache'=>array('key' => 'article_view_', 'time' => '+0 hour')));?>
	<?}?>
	<span id="waitcheck"></span>
<?php if(isset($comment_list) && sizeof($comment_list)>0){?>
<div class="box comments">
<?php foreach($comment_list as $key=>$v){?>
		<p class="msg_title"><?php echo $this->data['languages']['comments'];?>:<?php echo $v['Comment']['name'] ?>		<font color="#A7A9A8"><?php echo $v['Comment']['modified'] ?></font></p>
		<div class="message_cont" <?php if($key==sizeof($comment_list)-1){?>style="border-bottom:none;padding-bottom:0;"<?php }?>><?php echo $v['Comment']['content'] ?></div>
<?php if(isset($v['reply']) && sizeof($v['reply'])>0){
		foreach($v['reply'] as $k=>$v){?>
		<p class="msg_title"><?php echo $this->data['languages']['reply'];?>:<?php echo $v['Comment']['name'] ?> 		<font color="#A7A9A8"><?php echo $v['Comment']['modified'] ?></font></p>
		<div class="message_cont"><?php echo $v['Comment']['content'] ?></div>
<?php }}?>
<?php }?>
</div>
<?php }else{?>
	  <div class="not">
		<br /><br />
		<strong><?php echo $this->data['languages']['no_comments_now'];?>！</strong>
		<br /><br />
	  </div>
<?php }?>
	</div>
<!--用户评论End-->
</div>
    
<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>

		
		
<!--BEGIN SOURCE CODE FOR EXAMPLE =============================== 

<script type="text/javascript">
/*
var div = document.getElementById('Edit_info');
var commentSuccess = function(o){
	    try{   
	    	var result = YAHOO.lang.JSON.parse(o.responseText);  
		}catch (e){   
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 
		div.innerHTML += '<div id="user_msg"><p class="msg_title"><span class="title">'+comment+': '+result.name+' <font color="#A7A9A8">'+waitting_for_check+'</font></span></p><p class="msg_txt"><span>'+result.content+'</span></p></div> ';
		};

var commentFailure = function(o){
 	alert("Failure");
};

var commentback =
{
  success:commentSuccess,
  failure:commentFailure,
  argument:{}
};
function submitComment(frm){
  var cmt = new Object;
  cmt.username        = frm.elements['username'].value;
  cmt.user_id        = frm.elements['user_id'].value;
  cmt.email           = frm.elements['email'].value;
  cmt.content         = frm.elements['content'].value;
  cmt.type            = frm.elements['cmt_type'].value;
  cmt.id              = frm.elements['id'].value;
 // cmt.enabled_captcha = frm.elements['enabled_captcha'] ? frm.elements['enabled_captcha'].value : '0';
 // cmt.captcha         = frm.elements['captcha'] ? frm.elements['captcha'].value : '';
  cmt.rank            = 0;

  for (i = 0; i < frm.elements['comment_rank'].length; i++)
  {
    if (frm.elements['comment_rank'][i].checked)
    {
       cmt.rank = frm.elements['comment_rank'][i].value;
     }
  }
//  if (cmt.username.length == 0)
//  {
//     alert(cmt_empty_username);
//     return false;
//  }

  if (cmt.email.length > 0)
  {
     if (cmt.email.length<5)
     {
        alert('cmt_error_email');
        return false;
      }
   }
   else
   {
        alert('cmt_empty_email');
        return false;
   }

   if (cmt.content.length == 0)
   {
      alert('cmt_empty_content');
      return false;
   }

 //  if (cmt.enabled_captcha > 0 && cmt.captcha.length == 0 )
 //  {
 //     alert('captcha_not_null');
 //     return false;
 //  }
	
	
	var sUrl = "/commons/add_comment/";
	//alert(document.getElementById('user_name').innerHTML);
	var postData ='cmt='+YAHOO.lang.JSON.stringify(cmt);
	postData+='&username='+cmt.username+'&user_id='+cmt.user_id+"&email="+cmt.email+"&content="+cmt.content+"&type="+cmt.type+"&id="+cmt.id+"&rank="+cmt.rank;
//	alert(sUrl+postData);
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, commentback,postData);
	frm.reset();
}
*/
</script>
-->