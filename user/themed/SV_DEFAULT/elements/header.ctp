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
 * $Id: header.ctp 4447 2009-09-22 12:00:27Z huangbo $
*****************************************************************************/
?>
<?php if($this->data['configs']['shop_logo'] != ""){
		$logo = "/../".$this->data['configs']['shop_logo'];
	}else{
		$logo = isset($img_style_url)?$img_style_url."/"."logo.gif":"logo.gif";
	}
	?>
<div id="logo"><?php echo $html->link($html->image($logo,array("alt"=>$this->data['languages']['free_open_independent_b2c'],"width"=>"192","height"=>"58")),$this->data['server_host'].$this->data['cart_webroot'],"",false,false);?></div>
<div class="header_right">
<!-- gears -->
<?php echo $javascript->link('gears_init');?>
<?php echo $javascript->link(array('autocomplete','/../js/yui/autocomplete-min'));?>
<script type="text/javascript">
var STORE_NAME = 'SV_Cart_Store'
var localServer;
//location.pathname
var filesToCapture = [
  <?if(isset($gears_file) && sizeof($gears_file)>0){?><?foreach($gears_file as $k=>$v){?>"<? echo $v;?>"<?if((sizeof($gears_file)-1) != $k){?>,<?}?><?}?><?}?>
];
</script>



<div class="tools">
	<div class="member color_5">
	<cake:nocache>
	<span>
	<?php if($session->check('User.User.name')){ ?>
	<?php echo $this->data['languages']['welcome'];?><b>&nbsp;<?php echo $html->link($session->read('User.User.name'),$this->data['server_host'].$this->data['user_webroot'],array("title"=>$this->data['languages']['user_center'],"class"=>"name color_f9"));?></b><font>|</font><?php echo $html->link($this->data['languages']['log_out'],"javascript:logout();",array("class"=>"color_4"));?>
		<?php }else{ ?>
		<a class="cursor color_4" id="login"><?php echo $this->data['languages']['login'];?></a><?php if($this->data['configs']['enable_registration_closed'] == 0){?><font>|</font><?php echo $html->link($this->data['languages']['register'],$this->data['server_host'].$this->data['user_webroot']."register/",array("class"=>"color_4"),"",false,false);?>
		<?php }?>
	<?php }//$this->data['languages']['member_login']?>
	</span>
	</cake:nocache>
	<?//php echo $html->link($this->data['languages']['cart'],"/carts/",array("class"=>"color_4","title"=>sprintf($this->data['languages']['cart_total_product'],isset($this->data['header_cart']['quantity'])?$this->data['header_cart']['quantity']:0).$svshow->price_format(isset($this->data['header_cart']['total'])?$this->data['header_cart']['total']:0,$this->data['configs']['price_format'])),"",false,false);?>
	&nbsp;&nbsp;&nbsp;<?php if(is_array($this->data['language_locale']) && sizeof($this->data['language_locale'])>1){?><a class="cursor color_4" id="locales"><?php echo $this->data['languages']['switch_languages'];?></a><?php }?><?php if(isset($can_select_template) && sizeof($can_select_template)>0){?><?php if(is_array($this->data['language_locale']) && sizeof($this->data['language_locale'])>1){ ?><font>|</font><?php }?><a class="cursor color_4" id="themes"><?php echo $this->data['languages']['switch_template'];?></a><?php }?><?php if(isset($this->data['currencies']) && sizeof($this->data['currencies'])>0 && $session->check('Config.locale')){?><?php if((is_array($this->data['language_locale']) && sizeof($this->data['language_locale'])>1) || ($can_select_template) && sizeof($can_select_template)){ ?><font>|</font><?php }?><a class="cursor color_4" id="currencies"><?php echo $this->data['languages']['switch_currency'];?></a><?php }?>
	<?if(isset($this->data['configs']['gears_setting']) && $this->data['configs']['gears_setting'] == 1){?>
	<script type="text/javascript">show_gears();</script>
	<?}?>
	</div>

<div id="search">
<?php echo $form->create('Product', array('action' => 'Search','onsubmit'=>'return false;'));?> 
<select name="search_type" id="search_type"><option value="P"><?php echo $this->data['languages']['products'];?></option><option value="A"><?php echo $this->data['languages']['article'];?></option></select>&nbsp;<input id="ysearchinput" onchange='javascript:YAHOO.example.ACJson.validateForm();' type="text" name="keywords" class="enter_text" /><input type="hidden" name="type" value="S" /><span><a href="javascript:ad_search()"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'search_go_btn.png':'search_go_btn.png',array("alt"=>"GO","class"=>"go","title"=>"搜索"))?></a></span><a id="adv_search" class="cursor color_53"><?php echo $this->data['languages']['advanced_search'];?></a>
	<!-- 热门关键字 -->
<?php 
$header_keywords = explode(" ",$this->data['configs']['home_search_keywords']);
if(isset($header_keywords) && sizeof($header_keywords)>0){
?>
| <a id="header_keyword" class="cursor color_53"><?php echo $this->data['languages']['hot_keyword'];?></a>
<?php }?>	
	
<div id="ysearchcontainer_search"></div>
<?php echo $form->end();?>
	<? /*php if(isset($this->data['configs']['home_search_keywords'])&&!empty($this->data['configs']['home_search_keywords'])){
		$header_weywords = explode(" ",$this->data['configs']['home_search_keywords']);
		if(isset($header_weywords) && sizeof($header_weywords)>0){
			echo $this->data['languages']['hot'].$this->data['languages']['keywords'].": ";
			foreach($header_weywords as $k=>$v){
				echo $html->link($v,'/products/advancedsearch/SAD/'.$v,array(),false,false)." ";
			}
		}
	}*/?>
	
	<cake:nocache>
		
<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
	<?php  $sv_head_total  = $session->check('header_cart.total')?$session->read('header_cart.total'):0;
			$sv_head_total = $sv_head_total*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'];
			$sv_price_format = $this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format'];
		?>
<?php }else{
	$sv_head_total = $session->check('header_cart.total')?$session->read('header_cart.total'):0;
	$sv_price_format = $this->data['configs']['price_format'];
}?>

<p class="color_53 cart">
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'cart.gif':'cart.gif',array("class"=>"vmiddle",))?>
	<?php if($session->check('header_cart.sizeof') && $session->read('header_cart.sizeof') >0){?>
	<?php echo $html->link("<font id='header_cart_msg'>".sprintf($this->data['languages']['cart_total_product'],
	$session->check('header_cart.sizeof')?"<strong class='number'>".$session->read('header_cart.sizeof')."</strong>":"<strong class='number'>0</strong>",
	$session->check('header_cart.quantity')?"<strong class='number'>".$session->read('header_cart.quantity')."</strong>":"<strong class='number'>0</strong>").
	"<strong>".$svshow->price_format($sv_head_total,$sv_price_format)."</strong></font>",$this->data['server_host'].$this->data['cart_webroot']."carts/",
	array("class"=>"color_4",
	"title"=>sprintf($this->data['languages']['cart_total_product'],$session->check('header_cart.sizeof')?"".$session->read('header_cart.sizeof')."":"0",
	$session->check('header_cart.quantity')?$session->read('header_cart.quantity'):0).
	$svshow->price_format($sv_head_total,$sv_price_format)),"",false,false);?>	
	<?php }else{?>
		<?php echo $html->link("<font id='header_cart_msg'>".$this->data['languages']['no_products_in_cart']."</font>",$server_host.$cart_webroot.'carts/',array("class"=>"color_4"),false,false);?>
	<?php }?>
</p>
	</cake:nocache>
		
</div>
<div class="header_navs color_5"><?php if(isset($navigations_top) && sizeof($navigations_top)>0){
	$nav_num = 0;
foreach($navigations_top as $k=> $navigation){?>
<?php if($nav_num !=0){?>|<?php }?><span class="nav"><?php if(isset($navigation['NavigationI18n']) && $navigation['NavigationI18n']['url']!="" && $navigation['NavigationI18n']['name'] !="") echo $html->link($navigation['NavigationI18n']['name'],$server_host.substr($cart_webroot,0,-1).$navigation['NavigationI18n']['url'],array("class"=>"color_f9","target" =>$navigation['Navigation']['target']));
	else echo $html->link("Seevia","http://www.seevia.cn",array("class"=>"color_f9"));?></span><?php $nav_num++;}}?>
</div>
</div>


</div>