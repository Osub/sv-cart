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
 * $Id: view.ctp 1314 2009-05-11 07:20:51Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><? echo $article_detail['ArticleI18n']['title']; ?></b></h1>
<div id="Edit_box">
	<div id="article_info">
		<div id="user_msg">
			<p class="article_time"><span class="title">&nbsp;<? echo $article_detail['ArticleI18n']['author']."  ".$article_detail['Article']['modified']; ?></span></p>
			<div class="article"><? echo $article_detail['ArticleI18n']['content']; ?></div>
		</div>

		<div id="select_article">
			<p><? if($neighbours['next']){ ?>
			 <?=$SCLanguages['next'];?><?=$SCLanguages['piece'];?>: 
			  <?php echo $html->link("{$neighbours['next']['ArticleI18n']['title']}","{$neighbours['next']['Article']['id']}",array(),false,false); } ?>
			<br />
			 <? if($neighbours['prev']){?>
			 <?=$SCLanguages['previous'];?><?=$SCLanguages['piece'];?>: 
			 <?php echo $html->link("{$neighbours['prev']['ArticleI18n']['title']}","{$neighbours['prev']['Article']['id']}",array(),false,false); } ?>
			</p>
		</div>
	</div>
</div>
<!--文章列表End-->
<!--相关商品-->
<?php 
	if(isset($product_list) && sizeof($product_list)>0){?>
<div id="Correlation" class="article_items">
    <h1 class="title_nobg"><span><?=$html->image('icon_08.gif')?></span><?=$SCLanguages['correlative_products'];?><?=$SCLanguages['previous'];?><?=$SCLanguages['piece'];?></h1>
    <div id="Item_List" style="border:none;">
	<ul id="content1" class="Relevancy">
	<?php
		foreach($product_list as $key=>$v){
			if($v['Product']['img_thumb'] == ""){
				$v['Product']['img_thumb'] = "/img/product_default.jpg";
			}
			echo $html->tag('li',$html->para('pic',
				 $html->link(
				 $html->image("{$v['Product']['img_thumb']}",array('width'=>'108','height'=>'108',))
				 ,"/products/{$v['Product']['id']}",'',false,false)
				 ,array(),false)
				 .$html->para('info',
				 $html->tag('span',$html->link("{$v['ProductI18n']['name']}","/products/{$v['Product']['id']}",array(),false,false),'name')
				 .$html->tag('span',$html->tag('font',"{$v['Product']['shop_price']}",array('color'=>'#F9630C')),'Price')		 		
				 ,array(),false),'');				
			}
	
?>
</ul>
</div>
</div><!--相关商品End-->
<?php } ?>    		

<!--用户评论-->
<div id="Edit_box">
  <div id="Edit_info">
	  <p class="note article_title">
	  <?=$html->image('comment-left.gif',array('class'=>'comment-left'))?>
	  <?=$html->image('comment-rigth.gif',array('class'=>'comment-right'))?>
	  <b><?=$SCLanguages['user'];?><?=$SCLanguages['comments'];?></b>
		<a id="comments" class="comments"><span><?php echo $SCLanguages['issue_comments'];?></span></a>
	</p>
	<?echo $this->element('comment', array('cache'=>'+0 hour'));?>
	<span id="waitcheck"></span>
<?php 
	//pr($comment_list);
	if(isset($comment_list) && sizeof($comment_list)>0){
		foreach($comment_list as $key=>$v){
?>
<div id="user_msg">
		<p class="msg_title"><span class="title"><?php echo $SCLanguages['comments'];?>:<?php echo $v['Comment']['name'] ?> <font color="#A7A9A8">
		<?php echo $v['Comment']['modified'] ?></font></span></p>
		<p class="msg_txt"><span><?php echo $v['Comment']['content'] ?></span></p>
	  </div>
<?php
	if(isset($v['reply']) && sizeof($v['reply'])>0){
		foreach($v['reply'] as $k=>$v){
?>
		<div id="user_msg">
		<p class="msg_title"><span class="title"><?php echo $SCLanguages['reply'];?>:<?php echo $v['Comment']['name'] ?> <font color="#A7A9A8">
		<?php echo $v['Comment']['modified'] ?></font></span></p>
		<p class="msg_txt"><span><?php echo $v['Comment']['content'] ?></span></p>
	   </div>
<?php
	}
}
	}
	}else{
?>
	  <div id="user_msg">
		<p class="msg_txt" align="center"><br /><span><?php echo $SCLanguages['no_comments_now'];?></span></p>
	  </div>
<?php }?>
	  
	</div>
</div><!--用户评论End-->
    </div>
    
<? echo $this->element('news', array('cache'=>'+0 hour'));?>

		
		
<!--BEGIN SOURCE CODE FOR EXAMPLE =============================== -->

<script>
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