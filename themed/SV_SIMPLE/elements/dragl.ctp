<?php if(!isset($_SESSION['User']['User']['id'])){ ?>
<!--Login-->
<div id="User_Login" class="yui-overlay"><div class="hd title"><b><?php //=$SCLanguages['member'];?><?php echo $SCLanguages['login'];?></b></div>
<div class="keywords"><dl><dt><?php echo $SCLanguages['username'];?></dt><dd><input type="text" name="data[User][name]" id="UserName" class="enter text_input" /></dd></dl>
	<dl>
	<dt><?php echo $SCLanguages['password'];?></dt>
	<dd><input type="password" name="data[User][password]" id="UserPassword" class="enter text_input" /></dd>
	</dl>
    <dl class="captcha" 	<?php if($SVConfigs['use_captcha'] == 0){?>style="display:none"<?php }?>>
    <dt><?php echo $SCLanguages['verify_code'];?></dt>
    <dd class="passbox"><input type="text" name="data[User][captcha]" id="UserCaptcha" class="Price text_input" style="width:80px;" /><a  href="javascript:show_login_captcha('login_captcha')"><img id="login_captcha" src="" alt="<?php echo $SCLanguages['verify_code']?>" title="<?php echo $SCLanguages['not_clear']?>" /></a></dd>
    </dl>
    <p id="panel_login_message"></p>
    <dl class="btn">
    <dt class="logon"><?php echo $html->link(__($SCLanguages['login'],true),"javascript:panel_login();","",false,false);?></dt><dd class="forget_pass">
<?php echo $html->link("<font face='宋体'>>></font>".$SCLanguages['forget_password'],$user_webroot."forget_password/",array(),false,false);?>
    </dd>
    </dl>
</div><?php echo $html->image("adv_searchbottom.png",array("align"=>"left"))?></div>
<!--Login End-->
<?php }?>
<?php 	if(isset($languages) && sizeof($languages)>0){?>
<!--Language-->
<div id="language" class="yui-overlay">
<div class="hd title"><b><?php echo $SCLanguages['switch_languages'];?></b></div>
<ul>
<?php 
foreach($languages as $language){?><li><?php echo $html->link($html->image($language['Language']['img01'],array("alt"=>$language['Language']['name'],'align'=>'middle')).$language['Language']['name'],"javascript:change_locale('".$language['Language']['locale']."');","",false,false);?></li>
<?php }?></ul><?php echo $html->image('lauguage_bottom.gif',array("align"=>"left"));?>
</div>
<!--Language End-->
<?php }?>
<!--AdvancedSearch-->
<div id="advanced_search" class="yui-overlay" style="height:100%;">
<div class="hd title"><b><?php echo $SCLanguages['advanced_search'];?></b></div>
<form action="" method="post" name="ad_search">
<div class="keywords">
	<dl><dt><?php echo $SCLanguages['keywords'];?></dt><dd><input type="text" name="ad_keywords" id="ad_keywords" class="enter text_input" /></dd></dl>
	<dl>
		<dt><?php echo $SCLanguages['category'];?></dt>
		<dd>
		<select name="category_id" id="category_id" class="category_id">
		<option value="0"><?php echo $SCLanguages['please_choose'];?></option>
		<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?><?php foreach($categories_tree as $first_k=>$first_v){?>
		<option value="<?php echo $first_v['Category']['id'];?>"><?php echo $first_v['CategoryI18n']['name'];?></option>
		<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
		<option value="<?php echo $second_v['Category']['id'];?>">|--<?php echo $second_v['CategoryI18n']['name'];?></option>
		<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
		<option value="<?php echo $third_v['Category']['id'];?>">|----<?php echo $third_v['CategoryI18n']['name'];?></option>
		<?php }}}}}}?>
		</select></dd>
	</dl>
	<dl>
		<dt><?php echo $SCLanguages['brand'];?></dt>
		<dd>
		<select name="brand_id" id="brand_id" class="brand_id">
		<option value="0">
		<?php echo $SCLanguages['please_choose'];?></option>
		<?php if(isset($brands) && sizeof($brands)>0){
			foreach ($brands as $k=>$v){?>
		<option value="<?php echo $v['BrandI18n']['brand_id'] ?>"><?php echo $v['BrandI18n']['name'] ?></option>
		<?php }}?>
		</select></dd>
		</dl>
		<dl>
		<dt><?php echo $SCLanguages['price'];?></dt>
		<dd><input type="text" name="min_price" id="min_price" class="Price text_input" /><span>-</span><input type="text" name="max_price" id="max_price" class="Price text_input" /></dd>
	</dl>
	<p class="go"><a href="javascript:ad_search()"><?php echo $html->image("search_go_btn.png",array("alt"=>"搜索","title"=>"搜索"))?></a></p>
</div></form><?php echo $html->image("adv_searchbottom.png",array("align"=>"left"))?>
</div>
<!--AdvancedSearch End-->