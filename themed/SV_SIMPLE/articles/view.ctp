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
 * $Id: view.ctp 3123 2009-07-21 02:23:49Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<br />
<h3><span><?php echo $article_detail['ArticleI18n']['title']; ?></span></h3>
	<div class="article_view">
		<p align="right"><?php echo $article_detail['ArticleI18n']['author']."  ".$article_detail['Article']['modified']; ?></p>
		<div class="description">
	<?php echo $article_detail['ArticleI18n']['content']; ?></div>
		<div class="select_article">
			<?php if($neighbours['next']){ ?>
			 <?php echo $SCLanguages['next'];?><?php echo $SCLanguages['piece'];?>: 
			  <?php echo $html->link("{$neighbours['next']['ArticleI18n']['title']}","{$neighbours['next']['Article']['id']}",array(),false,false); } ?>
			<br />
			 <?php if($neighbours['prev']){?>
			 <?php echo $SCLanguages['previous'];?><?php echo $SCLanguages['piece'];?>: 
			 <?php echo $html->link("{$neighbours['prev']['ArticleI18n']['title']}","{$neighbours['prev']['Article']['id']}",array(),false,false); } ?>
			
		</div>
	</div>
<!--文章列表End-->

<!-- 加文章标签 -->
<?php if(isset($SVConfigs['use_tag']) && $SVConfigs['use_tag'] == 1){?>					
<h3><span><?php echo $SCLanguages['article']?><?php echo $SCLanguages['tags']?></span></h3>
<div class="article_view">
	<br />
	<?php echo $form->create('commons',array('action'=>'add_tag','name'=>'add_tag','type'=>'POST'));?>
	<dl>
	<dd><input type="text" name="tag" id="tag" class="text_input"  />&nbsp;</dd>
	<dt style="padding-top:4px;">
		<input type="hidden" name="type_id" id="tag" class="text_input" value="<?php echo $article_detail['Article']['id']?>"  />
		<input type="hidden" name="type" id="tag" class="text_input" value="A"  />
		<a href="javascript:add_tags(<?=isset($_SESSION['User']['User']['id'])?1:0;?>)"><?php echo $SCLanguages['add_to_my_tags']?></a>
	</dt>
	</dl>
	<?php echo $form->end();?>
	<br />	<br /> 	<br />
	<?php if(isset($tags) && sizeof($tags)>0){?>
	<?php foreach($tags as $k=>$v){?>
		<div id="user_msg">
			<p class="msg_title"><span class="title"><?php echo $html->link($v['TagI18n']['name'],"/category_articles/tag/".$v['TagI18n']['name'],array('target'=>'_blank'),false,false)?></span></p>
		</div>	
	<?php }}?>
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
<?php if(isset($product_list) && sizeof($product_list)>0){?>
<h3><span><?php echo $SCLanguages['correlative_products'];?><?php echo $SCLanguages['previous'];?><?php echo $SCLanguages['piece'];?></span></h3>
<div class="products">
	<ul>
	<?php 
		foreach($product_list as $key=>$v){
			if($v['Product']['img_thumb'] == ""){
				$v['Product']['img_thumb'] = "/img/product_default.jpg";
			}
			echo $html->tag('li',$html->para('pic',
				 $html->link(
				 $html->image("{$v['Product']['img_thumb']}",array('width'=>'108','height'=>'108',))
				 ,$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),'',false,false)
				 ,array(),false)
				 .$html->para('info',
				 $html->tag('span',$html->link("{$v['ProductI18n']['name']}",$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false),'name')
				 .$html->tag('span',$html->tag('font',"{$v['Product']['shop_price']}",array('color'=>'#F9630C')),'Price')		 		
				 ,array(),false),'');				
			}
	
?>
</ul>
</div>
<!--相关商品End-->
<?php } ?>    		

<!--用户评论-->
<h3><span><?php echo $SCLanguages['user'];?><?php echo $SCLanguages['comments'];?></span></h3>
<div id="Edit_box">
  <div id="Edit_info">
<span id="waitcheck"></span>
<?php 
	//pr($comment_list);
	if(isset($comment_list) && sizeof($comment_list)>0){
		foreach($comment_list as $key=>$v){
?>
<div id="user_msg">
		<p class="msg_title"><span class="title"><?php echo $SCLanguages['comments'];?>:<?php echo $v['Comment']['name'] ?> <font color="#A7A9A8">
		<?php echo $v['Comment']['modified'] ?></font></span></p>
		<div class="msg_txt"><?php echo $v['Comment']['content'] ?></div>
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
<br />
<div class="not"><?php echo $SCLanguages['no_comments_now'];?></div>
<?php }?>
<br />
<?php echo $this->element('comment', array('cache'=>'+0 hour'));?>
	</div>
</div>
<!--用户评论End-->
    

		
		
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