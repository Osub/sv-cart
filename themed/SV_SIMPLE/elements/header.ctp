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
 * $Id: header.ctp 3987 2009-09-02 09:28:48Z huangbo $
*****************************************************************************/
?>
<div class="header">
	<div class="logo"><?php echo $html->link($html->image((!empty($SVConfigs['shop_logo']))?$SVConfigs['shop_logo']:"logo.gif",array("alt"=>"SV-Cart","width"=>"192","height"=>"58")),"/","",false,false);?></div>

<div class="tools">
	<div class="member">

	<?php if(is_array($languages) && sizeof($languages)>1){?>
	<?php echo $form->create('commons',array('action'=>'locale','name'=>'select_locale','type'=>'POST'));?>
		<select name="select_locale" onchange="javascript:document.select_locale.submit();"   autocomplete="off">
		<?php foreach($languages as $k=>$v){?>
		<option value="<?php echo $v['Language']['locale'];?>" <?php if($dlocal==$v['Language']['locale']){?>selected<?php }?>><?php echo $v['Language']['name'];?></option>
		<?php }?>
		</select>
	<?php echo $form->end();?>
			|
	<?php }else{ ?>
		<a class="cursor" id="locales"><?php //echo $SCLanguages['switch_languages'];?></a>
	<?php }?>
	
	<?php 	if(isset($can_select_template) && sizeof($can_select_template)>0){?>
	<!--Theme-->
	<?php echo $form->create('commons',array('action'=>'change_theme','name'=>'change_theme','type'=>'POST'));?>
		<select name="select_theme" onchange="javascript:document.change_theme.submit();"   autocomplete="off">
		<?php foreach($can_select_template as $k=>$v){?>
			<?php if(isset($v['style']) && sizeof($v['style'])>0){?>
				<?php foreach($v['style'] as $theme){?>
				<option value="<?php echo $v['name'].'_|_'.$theme;?>" <?php if($template_use==$v['name'] && $theme == $template_style){?>selected<?php }?>><?php echo $v['description']." ".$theme;?></option>
				<?php }?>
			<?php }?>
		<?php }?>
		</select>
			<input type="hidden" name="no_ajax" value="1" />
	<?php echo $form->end();?>|
	<!--Theme End-->
	<?php }?>	
	
	
	<?php if(isset($_SESSION['User']['User']['id'])){ ?>
	<?php echo $SCLanguages['welcome'];?><b>&nbsp;<?php echo $html->link($_SESSION['User']['User']['name'],$server_host.$user_webroot,array("title"=>$SCLanguages['user_center'],"class"=>"name color_f9"));?></b>
		<?php echo $html->link($SCLanguages['log_out'],$server_host.$user_webroot."logout/",array("class"=>""));?>	
		<?php }else{ ?>
		<?php echo $html->link($SCLanguages['login'],$server_host.$user_webroot."login/",array("class"=>""));?> |
		<?php if($SVConfigs['enable_registration_closed'] == 0){?>
		<?php echo $html->link($SCLanguages['register'],$server_host.$user_webroot."register/",array("class"=>""),"",false,false);?>
		<?php }?>
	<?php }//$SCLanguages['member_login']?>
	|
	<?php echo $html->link($SCLanguages['forget_password']."?",$server_host.$user_webroot."forget_password/",array("class"=>""),"",false,false);?>
<?php 
$header_cart=$this->requestAction("commons/header_cart/");
?>	
	</div>
	<p class="cart">
	<a href="<?php echo $server_host.$cart_webroot.'carts'?>"><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."carticon.gif":"carticon.gif",array("class"=>"vmiddle"))?>
	<!--您的购物车中有 <span class="font_red"><?php echo isset($header_cart['quantity'])?$header_cart['quantity']:0;?></span> 件商品，总计 -->
	<?php $header_cart_quantity = empty($header_cart['quantity'])?0:$header_cart['quantity'];
		 $header_cart_sizeof = empty($header_cart['sizeof'])?0:$header_cart['sizeof'];
	printf($SCLanguages['cart_total_product'],"<span class='font_red'>".$header_cart_sizeof."</span>","<span class='font_red'>".$header_cart_quantity."</span>");?>
	<span class="font_red"><?php echo $svshow->price_format(isset($header_cart['total'])?$header_cart['total']:0,$SVConfigs['price_format']);?></span> </a>
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
	<div class="home"><?php echo $html->link($SCLanguages['home'],"/",array(),false,false);?></div>
	<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?>
		<? if($this->params['controller'] == 'articles' || $this->params['controller'] == 'category_articles'){
			$head_category_url = "category/";
		}else{
			$head_category_url = "categories/";
		}?>
	<?php foreach($categories_tree as $first_k=>$first_v){?>
	<li>
		<?php echo $html->link($first_v['CategoryI18n']['name'],"/".$head_category_url.$first_v['Category']['id']."/",false,false);?>
		<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?>
		<ul class="font_white">
		<?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
		<?php echo $html->link($second_v['CategoryI18n']['name'],"/".$head_category_url.$second_v['Category']['id']."/",array("class"=>"font_white"),false,false);?> |<?php }?>
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
	<input type="text" name="ad_keywords" id="ad_keywords" class="keywords" value="<?php if(isset($keywords))echo $keywords;?>"/>

	<select name="category_id" id="category_id" class="category_id">
	<option value="0"><?php echo $SCLanguages['please_choose'];?></option>
	<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?><?php foreach($categories_tree as $first_k=>$first_v){?>
	<option value="<?php echo $first_v['Category']['id'];?>" <?php if(isset($category_id)&&($category_id==$first_v['Category']['id'])){ ?>selected<?php }?>><?php echo $first_v['CategoryI18n']['name'];?></option>
	<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
	<option value="<?php echo $second_v['Category']['id'];?>" <?php if(isset($category_id)&&($category_id==$second_v['Category']['id'])){ ?>selected<?php }?>>|--<?php echo $second_v['CategoryI18n']['name'];?></option>
	<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
	<option value="<?php echo $third_v['Category']['id'];?>" <?php if(isset($category_id)&&($category_id==$third_v['Category']['id'])){ ?>selected<?php }?>>|----<?php echo $third_v['CategoryI18n']['name'];?></option>
	<?php }}}}}}?>
	</select>
		
	<select name="brand_id" id="brand_id" class="brand_id">
	<option value="0">
	<?php echo $SCLanguages['please_choose'];?></option>
	<?php if(isset($brands) && sizeof($brands)>0){?>
	<?php foreach ($brands as $k=>$v){?>
	<option value="<?php echo $v['Brand']['id'] ?>" <?php if(isset($brand_id)&&($brand_id==$v['Brand']['id'])){ ?>selected<?php }?>><?php echo $v['BrandI18n']['name'] ?></option>
	<?php }?>
	<?php }?>
	</select>

	<select class="price_id" id="price_id">
	<option value="">- <?php echo $SCLanguages['price'];?> -</option>
	<option value="0-100" <?php if(isset($min_price)&&isset($max_price)&&($min_price==0)&&($max_price==100)){ ?>selected<?php }?>>0-100</option>
	<option value="100-200" <?php if(isset($min_price)&&isset($max_price)&&($min_price==100)&&($max_price==200)){ ?>selected<?php }?>>100-200</option>
	<option value="200-400" <?php if(isset($min_price)&&isset($max_price)&&($min_price==200)&&($max_price==400)){ ?>selected<?php }?>>200-400</option>
	<option value="400-800" <?php if(isset($min_price)&&isset($max_price)&&($min_price==400)&&($max_price==800)){ ?>selected<?php }?>>400-800</option>
	<option value="800-1600" <?php if(isset($min_price)&&isset($max_price)&&($min_price==800)&&($max_price==1600)){ ?>selected<?php }?>>800-1600</option>
	<option value="1600-3200" <?php if(isset($min_price)&&isset($max_price)&&($min_price==1600)&&($max_price==3200)){ ?>selected<?php }?>>1600-3200</option>
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
	
	
	