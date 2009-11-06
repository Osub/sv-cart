<?php if(!isset($_SESSION['User']['User']['id'])){ ?>
<!--Login-->
<div id="User_Login" class="yui-overlay dialog">
<span class="upleft">&nbsp;</span>
<h4 class="hd"><?php echo $SCLanguages['login'];?></h4>
<div class="box keywords">
	<dl><dt><?php echo $SCLanguages['username'];?></dt><dd><input type="text" name="data[User][name]" id="UserName" class="text_input" /></dd></dl>
	<dl><dt><?php echo $SCLanguages['password'];?></dt><dd><input type="password" name="data[User][password]" id="UserPassword" class="text_input" /></dd></dl>
	<dl class="captcha"	<?php if($this->data['configs']['use_captcha'] == 0){?>style="display:none"<?php }?>><dt><?php echo $SCLanguages['verify_code'];?></dt><dd><input type="text" name="data[User][captcha]" id="UserCaptcha" class="text_input" style="width:80px;" /><a  href="javascript:change_captcha('login_captcha')"><span id="captcha_inner"></span></a></dd></dl>
	<p id="panel_login_message"></p>
	<dl class="action"><dt><?php echo $html->link("<span>".$SCLanguages['login']."</span>","javascript:panel_login();",array("class"=>"button_3"),false,false);?></dt><dd><?php echo $html->link("<font face='宋体'>>></font>".$SCLanguages['forget_password'],$server_host.$user_webroot."forget_password/",array(),false,false);?></dd></dl>
</div>
<div class="bottom">&nbsp;</div>
<span class="downleft">&nbsp;</span><span class="downright">&nbsp;</span>
</div>
<!--Login End-->
<?php }?>

<?php if(isset($languages) && sizeof($languages)>0){?>
<!--Language-->
<div id="language" class="yui-overlay dialog">
<span class="upleft">&nbsp;</span>
<h4 class="hd"><?php echo $SCLanguages['switch_languages'];?></h4>
	<div class="box">
	<ul>
	<?php foreach($languages as $language){?>
	<li><?php echo $html->link($html->image($language['Language']['img01'],array("alt"=>$language['Language']['name'],'align'=>'middle')).$language['Language']['name'],"javascript:change_locale('".$language['Language']['locale']."');","",false,false);?></li><?php }?>
	</ul>
	</div>
<div class="bottom">&nbsp;</div>
<span class="downleft">&nbsp;</span><span class="downright">&nbsp;</span>
</div>
<!--Language End-->
<?php }?>
<?php if(isset($can_select_template) && sizeof($can_select_template)>0){?>
<!--Theme-->
<div id="theme" class="yui-overlay dialog">
<span class="upleft">&nbsp;</span>
<h4 class="hd"><?php echo $this->data['languages']['switch_template'];?></h4>
	<div class="drag theme">
		<div class="box"><?php foreach($can_select_template as $k=>$v){?><ul><li class="lang"><?php echo $v['description']?></li><?php if(isset($v['style']) && sizeof($v['style'])>0){?><li class="thems"><?php foreach($v['style'] as $theme){?><?php echo $html->link($html->image($theme.".gif"),"javascript:change_theme('".$v['name']."','".$theme."')",array(),false,false)?>&nbsp;<?php }?></li><?php }?></ul><?php }?></div>
	</div>
<div class="bottom">&nbsp;</div>
<span class="downleft">&nbsp;</span><span class="downright">&nbsp;</span>
</div>
<!--Theme End-->
<?php }?>
<cake:nocache>
<?php if(isset($this->data['currencies']) && sizeof($this->data['currencies'])>0 && $session->check('Config.locale')){?>
<!--Currency-->
<div id="currencie" class="yui-overlay dialog">
<span class="upleft">&nbsp;</span>
<h4 class="hd"><?php echo $this->data['languages']['switch_currency'];?></div>
	<div class="drag currencie">
		<div class="box"><ul><?php foreach($this->data['currencies'] as $k=>$v){?>
	<?php if($session->check('Config.locale') && isset($v[$session->read('Config.locale')])){?><li>
<?php if($session->check('currencies') && $session->read('currencies') == $k){?><b><?php }?>
			<?php echo $html->link($v[$session->read('Config.locale')]['Currency']['name'],"javascript:change_currencie('".$k."')",array(),false,false)?>
<?php if($session->check('currencies') && $session->read('currencies') == $k){?></b><?php }?>		</li>	
		<?php }?>
			<?php }?></ul></div>
	</div>
<div class="bottom">&nbsp;</div>
<span class="downleft">&nbsp;</span><span class="downright">&nbsp;</span>
</div>
<!--Currency End-->
<?php }?>	
</cake:nocache>
<!--keywords-->
<?php 
if(isset($this->data['configs'])){
	$header_keywords = explode(" ",$this->data['configs']['home_search_keywords']);
}
if(isset($header_keywords) && sizeof($header_keywords)>0){
?>
<div id="Select_Header_Keyword" class="yui-overlay dialog">
<span class="upleft">&nbsp;</span>
<h4 class="hd"><?php echo $this->data['languages']['hot'];?><?php echo $this->data['languages']['keywords'];?></h4>
	<div class="drag hotkeyword">
		<div class="box">
		<ul>
		<?php foreach($header_keywords as $value){?>
		<li><?php echo $html->link($value,'/products/advancedsearch/SAD/'.$value,array(),false,false);?></li>
		<?php }?>
		</ul>
		</div>
	</div>
<div class="bottom">&nbsp;</div>
<span class="downleft">&nbsp;</span><span class="downright">&nbsp;</span>
</div>
<?php }?>
<!--keywords End-->	
<!--AdvancedSearch-->
<div id="advanced_search" class="yui-overlay dialog">
<span class="upleft">&nbsp;</span>
<h4 class="hd"><?php echo $SCLanguages['advanced_search'];?></h4>
<form action="" method="post" name="ad_search">
<div class="box keywords">
	<dl><dt><?php echo $SCLanguages['keywords'];?></dt><dd><input type="text" name="ad_keywords" id="ad_keywords" class="text_input" /></dd></dl>
	<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?>
	<dl>
		<dt><?php echo $SCLanguages['category'];?></dt>
		<dd>
		<select name="category_id" id="category_id" class="category_id">
		<option value="0"><?php echo $SCLanguages['please_choose'];?></option>
		<?php foreach($categories_tree as $first_k=>$first_v){?>
		<option value="<?php echo $first_v['Category']['id'];?>"><?php echo $first_v['CategoryI18n']['name'];?></option>
		<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
		<option value="<?php echo $second_v['Category']['id'];?>">|--<?php echo $second_v['CategoryI18n']['name'];?></option>
		<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
		<option value="<?php echo $third_v['Category']['id'];?>">|----<?php echo $third_v['CategoryI18n']['name'];?></option>
		<?php }}}}}?>
		</select></dd>
	</dl><?}else{?>
	<input type='hidden' name="category_id" id="category_id" value='0' />
	<?}?>
<?php if(isset($brands) && sizeof($brands)>0){?>	<dl>
		<dt><?php echo $SCLanguages['brand'];?></dt>
		<dd>
		<select name="brand_id" id="brand_id" class="brand_id">
		<option value="0">
		<?php echo $SCLanguages['please_choose'];?></option>
		<?
			foreach ($brands as $k=>$v){?>
		<option value="<?php echo $v['Brand']['id'] ?>"><?php echo $v['BrandI18n']['name'] ?></option>
		<?php }?>
		</select></dd>
		</dl><?}else{?>
	<input type='hidden' name="brand_id" id="brand_id" value='0' />
		<?}?>
		<dl>
		<dt><?php echo $SCLanguages['price'];?></dt>
		<dd><input type="text" name="min_price" id="min_price" class="Price text_input" /><span>-</span><input type="text" name="max_price" id="max_price" class="Price text_input" /></dd>
	</dl>
	<p class="go"><a href="javascript:ad_search()"><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."search_go_btn.png":''."search_go_btn.png",array("alt"=>"搜索","title"=>"搜索"))?></a></p>
</div></form>
<div class="bottom">&nbsp;</div>
<span class="downleft">&nbsp;</span><span class="downright">&nbsp;</span>
</div>
<!--AdvancedSearch End-->