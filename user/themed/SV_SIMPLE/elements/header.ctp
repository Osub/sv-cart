<?php 
/*****************************************************************************
 * SV-Cart 头文件
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: header.ctp 1564 2009-05-19 10:10:37Z tangyu $
*****************************************************************************/
?>
<div class="header">
	<div class="logo"><?php echo $html->link($html->image((!empty($SVConfigs['shop_logo']))?$SVConfigs['shop_logo']:"logo.gif",array("alt"=>"SV-Cart","width"=>"192","height"=>"58")),$server_host.$cart_webroot,"",false,false);?></div>

<div class="tools">
	<div class="member">

	<?php if(is_array($languages) && sizeof($languages)>1){?>
		
	<?php echo $form->create('commons',array('action'=>'locale','name'=>'select_locale','type'=>'POST'));?>
		<select name="select_locale" onchange="user_change_locale(this.options[selectedIndex].value)"  autocomplete="off">
		<?php foreach($languages as $k=>$v){?>
		<option value="<?php echo $v['Language']['locale'];?>" <?php if($dlocal==$v['Language']['locale']){?>selected<?php }?>><?php echo $v['Language']['name'];?></option>
		<?php }?>
		</select>
	<?php echo $form->end();?>
	|
	<?php }?>
	
	<?php if(isset($_SESSION['User']['User']['id'])){ ?>
	<?php echo $SCLanguages['welcome'];?><b>&nbsp;<?php echo $html->link($_SESSION['User']['User']['name'],"/",array("title"=>$SCLanguages['user_center'],"class"=>"name color_f9"));?></b>
		<?php echo $html->link($SCLanguages['log_out'],$server_host.$user_webroot."logout/",array("class"=>""));?>	
		<?php }else{ ?>
		<?php echo $html->link($SCLanguages['login'],$server_host.$user_webroot."login/",array("class"=>""));?> |
		<?php if($SVConfigs['enable_registration_closed'] == 0){?>
		<?php echo $html->link($SCLanguages['register'],"/register/",array("class"=>""),"",false,false);?>
		<?php }?>
	<?php }//$SCLanguages['member_login']?>
	|
	<?php echo $html->link($SCLanguages['forget_password']."?","/pages/forget_password/",array("class"=>""),"",false,false);?>
<?php 
$header_cart=$this->requestAction("commons/header_cart/");
?>	
	</div>
	<p class="cart">
	<a href="<?php echo $server_host.$cart_webroot.'carts'?>"><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."carticon.gif":"carticon.gif",array("class"=>"vmiddle"))?>
	<!--您的购物车中有 <span class="font_red"><?php echo isset($header_cart['quantity'])?$header_cart['quantity']:0;?></span> 件商品，总计-->
	<?php $header_cart_quantity = empty($header_cart['quantity'])?0:$header_cart['quantity'];
	printf($SCLanguages['cart_total_product'],"<span class='font_red'>".$header_cart_quantity."</span>");?> 
	<span class="font_red"><?php echo $svshow->price_format(isset($header_cart['total'])?$header_cart['total']:0,$SVConfigs['price_format']);?>
</span> </a>
	</p>
</div>
<p class="clear">&nbsp;</p>
<script type="text/javascript">

headerNav = function() {
if (document.all&&document.getElementById) {
categoriesRoot = document.getElementById("categories");
   for (i=0; i<categoriesRoot.childNodes.length; i++) {
    node = categoriesRoot.childNodes[i];
    if (node.nodeName=="LI") {
     node.onmouseover=function() {
     this.className+=" over";document.getElementById('search').style.visibility="hidden";
     //over
       for(j=0;j<this.childNodes.length;j++){
       if (this.childNodes[j].nodeName=="UL"){
        if (this.childNodes[j].childNodes[0].nodeName=="LI"){
         if (this.offsetLeft+this.childNodes[j].childNodes.length*this.childNodes[j].childNodes[0].offsetWidth-categoriesRoot.offsetLeft>categoriesRoot.offsetWidth){
        var len=this.childNodes[j].childNodes.length*this.childNodes[j].childNodes[0].offsetWidth; //菜单的长度
        (len>categoriesRoot.offsetWidth) ? this.childNodes[j].style.width=776+"px" : this.childNodes[j].style.width=len+"px"; //
        len =this.offsetLeft+len-categoriesRoot.offsetLeft-categoriesRoot.offsetWidth;
        (len>this.offsetLeft-categoriesRoot.offsetLeft) ? this.childNodes[j].style.marginLeft=-(this.offsetLeft-categoriesRoot.offsetLeft) : this.childNodes[j].style.marginLeft=-len+"px";
        }
        }
       }
      }
    }
    //Over之后
    node.onmouseout=function() {
     this.className=this.className.replace(" over", "");document.getElementById('search').style.visibility="visible";
    }
   }
}
}
}
window.onload=headerNav;
</script>
	<ul class="navs" id="categories">
	<div class="home"><?php echo $html->link($SCLanguages['home'],$server_host.$cart_webroot,array());?></div>
	<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?>
	<?php foreach($categories_tree as $first_k=>$first_v){?>
	<li>
		<?php echo $html->link($first_v['CategoryI18n']['name'],$server_host.$cart_webroot."categories/".$first_v['Category']['id']."/",false,false);?>
		<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?>
		<ul class="font_white">
		<?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
		<?php echo $html->link($second_v['CategoryI18n']['name'],$server_host.$cart_webroot."categories/".$second_v['Category']['id']."/",array("class"=>"font_white"),false,false);?> |<?php }?>
		</ul>
		<?php }?>
		</li>
	<?php }}?>
	</ul>

<div class="search font_white">
<div id="search">
<form action="" method="post" name="ad_search">
<span class="float_left keys">
	<?php echo $SCLanguages['keywords'];?>:
	<input type="text" name="ad_keywords" id="ad_keywords" class="keywords" />

	<select name="category_id" id="category_id" class="category_id">
	<option value="0"><?php echo $SCLanguages['please_choose'];?></option>
	<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?><?php foreach($categories_tree as $first_k=>$first_v){?>
	<option value="<?php echo $first_v['Category']['id'];?>"><?php echo $first_v['CategoryI18n']['name'];?></option>
	<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
	<option value="<?php echo $second_v['Category']['id'];?>">|--<?php echo $second_v['CategoryI18n']['name'];?></option>
	<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
	<option value="<?php echo $third_v['Category']['id'];?>">|----<?php echo $third_v['CategoryI18n']['name'];?></option>
	<?php }}}}}}?>
	</select>
		
	<select name="brand_id" id="brand_id" class="brand_id">
	<option value="0">
	<?php echo $SCLanguages['please_choose'];?></option>
	<?php if(isset($brands) && sizeof($brands)>0){?>
	<?php foreach ($brands as $k=>$v){?>
	<option value="<?php echo $v['BrandI18n']['brand_id'] ?>"><?php echo $v['BrandI18n']['name'] ?></option>
	<?php }?>
	<?php }?>
	</select>

	<select class="price_id" id="price_id">
	<option value="">- <?php echo $SCLanguages['price'];?> -</option>
	<option value="0-100">0-100</option>
	<option value="100-200">100-200</option>
	<option value="200-400">200-400</option>
	<option value="400-800">400-800</option>
	<option value="800-1600">800-1600</option>
	<option value="1600-3200">1600-3200</option>
	</select>
	</span>
	<!--
	<input type="text" name="min_price" id="min_price" class="" /><span>-</span><input type="text" name="max_price" id="max_price" class="" />
	-->
	<span class="button float_left"><a href="javascript:ad_search()"><?php echo $SCLanguages['search']?></a></span>
	</form>
</div>
</div>
	
</div>
	
	
	