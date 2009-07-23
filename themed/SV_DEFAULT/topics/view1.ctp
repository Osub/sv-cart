<?php 
/*****************************************************************************
 * SV-Cart 促销详细页
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: view1.ctp 3225 2009-07-22 10:59:01Z huangbo $
*****************************************************************************/
?>
<style type="text/css">
<!--
<?php if(isset($topic['Topic']['css']) && $topic['Topic']['css'] != ""){?>
<?php echo $topic['Topic']['css']?>
<?php }?>
-->
</style>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
	<div id="Products_box">
    	<h1><b><?php echo $topic['TopicI18n']['title']; ?></b></h1>
        <div id="Edit_box">
  <div id="article_info">
    
  <p class="note article_title">
  <div id="user_msg">
  	<p class="article_time">
  	  <span class="title">&nbsp;<?php echo $topic['Topic']['start_time']." - ".$topic['Topic']['end_time']; ?></span></p><br />
    <p class="article">
    	<span>
    		<?php echo $topic['TopicI18n']['intro']; ?>
    	</span>
    </p>
  </div>
  <div id="select_article"> <p><?php if($neighbours['next']){ ?>
 <?php echo $SCLanguages['next'].$SCLanguages['piece'];?>: 
  <?php echo $html->link("{$neighbours['next']['TopicI18n']['title']}","{$neighbours['next']['Topic']['id']}",array(),false,false); } ?>
<br />
 <?php if($neighbours['prev']){?>
 <?php echo $SCLanguages['previous'].$SCLanguages['piece'];?>: 
 <?php echo $html->link("{$neighbours['prev']['TopicI18n']['title']}","{$neighbours['prev']['Topic']['id']}",array(),false,false); } ?>
</p></div> </div>
</div><!--文章列表End-->
<!--相关商品-->
<?php 
	if(isset($products) && sizeof($products)>0){?>
<div id="Correlation" class="article_items">
        	<h1 class="title_nobg"><span><?php echo $html->image('icon_08.gif')?></span><?php echo $SCLanguages['correlative_products'];?></h1>
        <div id="Item_List" style="border:none;">
	<ul id="content1" class="Relevancy">
	<?php 
		foreach($products as $key=>$v){
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
</div>
<?php echo $this->element('news', array('cache'=>array('time'=> "+24 hour",'key'=>'news'.$template_style)));?>

<!--BEGIN SOURCE CODE FOR EXAMPLE =============================== -->

<script>
var div = document.getElementById('Edit_info');
var commentSuccess = function(o){
	    try{   
	    	var result = YAHOO.lang.JSON.parse(o.responseText);  
		}catch (e){   
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 
		div.innerHTML += '<div id="user_msg"><p class="msg_title"><span class="title">'+comment+'： '+result.name+' <font color="#A7A9A8">'+waitting_for_check+'</font></span></p><p class="msg_txt"><span>'+result.content+'</span></p></div> ';
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

</script>