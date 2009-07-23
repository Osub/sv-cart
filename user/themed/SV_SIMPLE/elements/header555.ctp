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
		
	<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
	<?php echo $form->create('commons',array('action'=>'locale','name'=>'select_locale','type'=>'POST'));?>
		<select name="select_locale" onchange="document.select_locale.submit();"  autocomplete="off">
		<option value='0' selected><?php echo $SCLanguages['switch_languages'];?></option>
		<?php foreach($languages as $k=>$v){?>
		<option value="<?php echo $v['Language']['locale'];?>"><?php echo $v['Language']['name'];?></option>
		<?php }?>
		</select>
	<?php echo $form->end();?>
	
	<?php }else{?>
		<a class="cursor" id="locales"><?php echo $SCLanguages['switch_languages'];?></a>
	<?php }?>		
	<?php }?>
		|
	<?php if(isset($_SESSION['User']['User']['id'])){ ?>
	<?php echo $SCLanguages['welcome'];?><b>&nbsp;<?php echo $html->link($_SESSION['User']['User']['name'],"/",array("title"=>$SCLanguages['user_center'],"class"=>"name color_f9"));?></b>
		
	<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
		<?php echo $html->link($SCLanguages['log_out'],"/logout/",array("class"=>""));?>
	<?php }else{?>
		<?php echo $html->link($SCLanguages['log_out'],"javascript:logout();",array("class"=>""));?>
	<?php }?>	
		<?php }else{ ?>
	<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
		<?php echo $html->link($SCLanguages['login'],"/login/",array("class"=>""));?> |
	<?php }else{?>
			<a class="cursor" id="login"><?php echo $SCLanguages['login'];?></a> |
	<?php }?>	
		<?php if($SVConfigs['enable_registration_closed'] == 0){?>
		<?php echo $html->link($SCLanguages['register'],"/register/",array("class"=>""),"",false,false);?>
		<?php }?>
	<?php }//$SCLanguages['member_login']?>
	|
	<?php echo $html->link("忘记密码？","/pages/forget_password/",array("class"=>""),"",false,false);?>
<?php 
$header_cart=$this->requestAction("commons/header_cart/");
?>	
	</div>
	<p class="cart">
	<a href="<?php echo $server_host.$cart_webroot.'carts'?>"><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."carticon.gif":"carticon.gif",array("class"=>"vmiddle"))?>您的购物车中有 <span class="font_red"><?php echo isset($header_cart['quantity'])?$header_cart['quantity']:0;?></span> 件商品，总计 <span class="font_red"><?php echo $svshow->price_format(isset($header_cart['total'])?$header_cart['total']:0,$SVConfigs['price_format']);?>
</span> </a>
	</p>
</div>
<p class="clear">&nbsp;</p>
	<ul class="navs">
	<?php if(isset($navigations_top) && sizeof($navigations_top)>0){?>
	<?php foreach($navigations_top as $k=> $navigation){?>
	<li><?php if($navigation['NavigationI18n']['url']!="" && $navigation['NavigationI18n']['name'] !="") echo $html->link($navigation['NavigationI18n']['name'],$navigation['NavigationI18n']['url'],array("class"=>"","target" =>$navigation['Navigation']['target']));
	else echo $html->link("Seevia","http://www.seevia.cn",array("class"=>""));?></li>
	<?php }?><?php }?>
	</ul>

	
<div class="search font_white">
<form action="" method="post" name="ad_search">
<span class="float_left keys">
	搜索<?php echo $SCLanguages['keywords'];?>:
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
	<option value="">- 价格区间 -</option>
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
	
	
	