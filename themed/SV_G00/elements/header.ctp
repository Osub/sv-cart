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
 * $Id: header.ctp 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
?>
<div id="logo"><?=$html->link($html->image((!empty($SVConfigs['shop_logo']))?$SVConfigs['shop_logo']:"logo.gif",array("alt"=>"SV-Cart","width"=>"192","height"=>"58")),"/","",false,false);?></div>
<div class="header_right">
<div class="tools">
	<div class="member color_5">
	<span id="user_info">
	<? if(isset($_SESSION['User']['User']['id'])){ ?>
	<?php echo $SCLanguages['welcome'];?><b>&nbsp;<?=$html->link($_SESSION['User']['User']['name'],"/user/",array("title"=>$SCLanguages['user_center'],"class"=>"name color_f9"));?></b><font>|
		</font><?=$html->link($SCLanguages['log_out'],"javascript:logout();",array("class"=>"color_4"));?><font>|
		</font><?}else{ ?><a class="cursor color_4" id="login"><?=$SCLanguages['login'];?></a><font>|
		</font><?php if($SVConfigs['enable_registration_closed'] == 0){?>
		<?=$html->link($SCLanguages['register'],"/user/register/",array("class"=>"color_4"),"",false,false);?>
		<font>|</font>
		<?}?>
	<?}//$SCLanguages['member_login']?>
	</span><?=$html->link($SCLanguages['cart'],"/carts/",array("class"=>"color_4"),"",false,false);?>
	<?if(is_array($languages) && sizeof($languages)>1){?><font>|</font>
	<a class="cursor color_4" id="locales"><?=$SCLanguages['switch_languages'];?></a>
	<?}?>
	</div>
	
<div id="search">
<?=$form->create('Product', array('action' => 'Search' ,'onsubmit'=>"return YAHOO.example.ACJson.validateForm();"));?> 
<input id="ysearchinput" type="text" name="keywords" class="enter_text" /><input type="hidden" name="type" value="S" /><span><a href="javascript:ad_search()"><?=$html->image('search_go_btn.png',array("alt"=>"GO","class"=>"go","title"=>"搜索"))?></a></span><a id="adv_search" class="cursor color_53"><?=$SCLanguages['advanced_search'];?></a>
<?=$form->end();?>
</div>

</div>

<div class="header_navs color_5"><?if(isset($navigations_top) && sizeof($navigations_top)>0){
foreach($navigations_top as $k=> $navigation){?>
<?if($k !=0){?>|<?}?><span class="nav"><?if($navigation['NavigationI18n']['url']!="" && $navigation['NavigationI18n']['name'] !="") echo $html->link($navigation['NavigationI18n']['name'],$navigation['NavigationI18n']['url'],array("class"=>"color_f9","target" =>$navigation['Navigation']['target']));
	else echo $html->link("Seevia","http://www.seevia.cn",array("class"=>"color_f9"));?></span><?}}?></div></div>