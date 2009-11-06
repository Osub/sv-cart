<?php 
/*****************************************************************************
 * SV-Cart 首页
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: home.ctp 4482 2009-09-24 03:35:50Z huangbo $
*****************************************************************************/
?>
<!--热门话题-->
<?php if(isset($home_article) && is_array($home_article) && sizeof($home_article)>0){?>
<div id="hot-list">
	<p class="l fff"><b><?php echo $this->data['languages']['latest_dynamic']?></b></p>
	<ul><?php if(isset($home_article[0])){?><li><?php echo $html->link($home_article[0]['ArticleI18n']['sub_title'],$svshow->article_link($home_article[0]['Article']['id'],$dlocal,$home_article[0]['ArticleI18n']['title'],$this->data['configs']['article_link_type']),array('class'=>'color_6d','title'=>$home_article[0]['ArticleI18n']['title']),false,false);?></li><?php }else{?><li></li><?}?><?php if(isset($home_article[1])){?><li><?php echo $html->link($home_article[1]['ArticleI18n']['sub_title'],$svshow->article_link($home_article[1]['Article']['id'],$dlocal,$home_article[1]['ArticleI18n']['title'],$this->data['configs']['article_link_type']),array('class'=>'color_6d','title'=>$home_article[1]['ArticleI18n']['title']),false,false);?></li><?php }else{?><li></li><?}?></ul>		
	<ul><?php if(isset($home_article[2])){?><li><?php echo $html->link($home_article[2]['ArticleI18n']['sub_title'],$svshow->article_link($home_article[2]['Article']['id'],$dlocal,$home_article[2]['ArticleI18n']['title'],$this->data['configs']['article_link_type']),array('class'=>'color_6d','title'=>$home_article[2]['ArticleI18n']['title']),false,false);?></li><?php }else{?><li></li><?}?><?php if(isset($home_article[3])){?><li><?php echo $html->link($home_article[3]['ArticleI18n']['sub_title'],$svshow->article_link($home_article[3]['Article']['id'],$dlocal,$home_article[3]['ArticleI18n']['title'],$this->data['configs']['article_link_type']),array('class'=>'color_6d','title'=>$home_article[3]['ArticleI18n']['title']),false,false);?></li><?php }else{?><li></li><?}?></ul>		
	<p class="more"><?php echo $html->link("&nbsp;",'/articles/',array('title'=>'查看更多文章'),false,false);?></p>
</div>
<?php }?>	
<!--热门话题End-->
<div class="height_5"></div>
<?php if(isset($flashes['FlashImage']) && sizeof($flashes['FlashImage'])>0){?><?php //pr($flashes);?>
<!--Flash-->
<div id="Flash"><?php echo $flash->renderSwf('img/bcastr4.swf?xml='.$cart_webroot.'flashes/index/H',
	$flashes['Flash']['width'],$flashes['Flash']['height'],false,
	array('params' => array('movie'=>$root_all.'img/bcastr4.swf?xml='.$cart_webroot.'flashes/index/H','wmode'=>'Opaque')));?></div>
<!--Flash End-->
<?php }?>
<div class="tab_head"><span class="name"><?php echo $this->data['languages']['all'].$this->data['languages']['products'];?></span>
<ul class="content_tab">
<?php if(isset($this->data['products_promotion'])  && sizeof($this->data['products_promotion']) > 0 ){?>
<?php if(isset($this->data['sign']) && $this->data['sign'] == "products_promotion"){?>
<li id="one<?php echo $this->data['tab_arr']['products_promotion']?>" onmouseover="overtab('one',<?php echo $this->data['tab_arr']['products_promotion']?>,<?php echo $this->data['size']?>)" class="hover">
<?php }else{?>
<li id="one<?php echo $this->data['tab_arr']['products_promotion']?>" onmouseover="overtab('one',<?php echo $this->data['tab_arr']['products_promotion']?>,<?php echo $this->data['size']?>)">
<?php }?>
<span><?php echo $this->data['languages']['promotion'];?></span></li>
<?php }?>
<?php if(isset($this->data['products_newarrival']) && sizeof($this->data['products_newarrival']) > 0){?>
<?php if(isset($this->data['sign']) && $this->data['sign'] == "products_newarrival"){?>
<li id="one<?php echo $this->data['tab_arr']['products_newarrival']?>" onmouseover="overtab('one',<?php echo $this->data['tab_arr']['products_newarrival']?>,<?php echo $this->data['size']?>)"  class="hover">
<?php }else{?>
<li id="one<?php echo $this->data['tab_arr']['products_newarrival']?>" onmouseover="overtab('one',<?php echo $this->data['tab_arr']['products_newarrival']?>,<?php echo $this->data['size']?>)" >
<?php }?>
<span><?php echo $this->data['languages']['new_arrival'];?></span></li><?php }?>
<?php if(isset($this->data['products_recommand']) && sizeof($this->data['products_recommand']) > 0){?>
<?php if(isset($this->data['sign']) && $this->data['sign'] == "products_recommand"){?>
<li id="one<?php echo $this->data['tab_arr']['products_recommand']?>" onmouseover="overtab('one',<?php echo $this->data['tab_arr']['products_recommand']?>,<?php echo $this->data['size']?>)" class="hover">
<?php }else{?>
<li id="one<?php echo $this->data['tab_arr']['products_recommand']?>" onmouseover="overtab('one',<?php echo $this->data['tab_arr']['products_recommand']?>,<?php echo $this->data['size']?>)" >
<?php }?>
<span><?php echo $this->data['languages']['recommend'];?></span></li><?php }?>
</ul>
</div>
<div  class="border Item_List">
<cake:nocache>
<?php if(isset($this->data['products_promotion'])  && sizeof($this->data['products_promotion']) > 0 ){?>
<!--促销-->
<?php if($this->data['sign'] == "products_promotion"){?>
<div id="con_one_<?php echo $this->data['tab_arr']['products_promotion']?>">
<?php }else{?>
<div id="con_one_<?php echo $this->data['tab_arr']['products_promotion']?>" style="display:none">
<?php }?>
<?php foreach($this->data['products_promotion'] as $k=>$v){?>
<?php if($k==0){?><ul class="home-products"><?php }?>
	<li>
		<p class="pic">
		<?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("alt"=>$v['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image'],$v['ProductI18n']['name']);?>
		</p>
		<p class="info">
		<span class="name"><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank",'title'=>$v['ProductI18n']['name']),false,false);?></span>
		</p></li>
<?php  if( $k%5==4 && $k<sizeof($this->data['products_promotion'])-1 ){?>
	<?php if($k == 0){?>
	<?php }else{?>
	</ul>
	<ul class="home-products">
	<?php }?>
	<?php }else if($k==sizeof($this->data['products_promotion'])-1){?>
	</ul><?php }else{?><?php }?>
<?php }?>
<div class="more"><?php echo $html->link($this->data['languages']['more'].">>",'/products/advancedsearch/SAD/search_promotion/',array(),false,false)?></div>
</div>
<!--促销 End-->
<?php }?>
</cake:nocache>
<cake:nocache>
<?php if(isset($this->data['products_newarrival']) && sizeof($this->data['products_newarrival']) > 0){?>
<!--新品-->
<?php if($this->data['sign'] == "products_newarrival"){?>
<div id="con_one_<?php echo $this->data['tab_arr']['products_newarrival']?>">
<?php }else{?>
<div id="con_one_<?php echo $this->data['tab_arr']['products_newarrival']?>" style="display:none;">
<?php }?>
<?php foreach($this->data['products_newarrival'] as $k=>$v){?>
<?php if($k==0){?><ul class="home-products"><?php }?>
	<li>
	<p class="pic">
	<?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("alt"=>$v['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image'],$v['ProductI18n']['name']);?></p>
	<p class="info">
	<span class="name"><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank",'title'=>$v['ProductI18n']['name']),false,false);?></span>
	</p>
	</li>
<?php  if( $k%5==4 && $k<sizeof($this->data['products_newarrival'])-1 ){?>
	<?php if($k == 0){?>
	<?php }else{?>
	</ul>
	<ul class="home-products">
	<?php }?>
	<?php }else if($k==sizeof($this->data['products_newarrival'])-1){?>
	</ul><?php }else{?><?php }?>
<?php }?>
<div class="more"><?php echo $html->link($this->data['languages']['more'].">>",'/products/advancedsearch/SAD/search_newarrival/',array(),false,false)?></div>
</div>
<!--新品 End-->
<?php }?>
</cake:nocache>
<cake:nocache>
<?php if(isset($this->data['products_recommand']) && sizeof($this->data['products_recommand']) > 0){?>
<!--推荐-->
<?php if($this->data['sign'] == "products_recommand"){?>
<div id="con_one_<?php echo $this->data['tab_arr']['products_recommand']?>">
<?php }else{?>
<div id="con_one_<?php echo $this->data['tab_arr']['products_recommand']?>" style="display:none">
<?php }?>
<?php foreach($this->data['products_recommand'] as $kk=>$vv){?>
<?php if($kk==0){?><ul class="home-products"><?php }?>
	<li>
	<p class="pic">
	<?php echo $svshow->productimagethumb($vv['Product']['img_thumb'],$svshow->sku_product_link($vv['Product']['id'],$vv['ProductI18n']['name'],$vv['Product']['code'],$this->data['configs']['product_link_type']),array("alt"=>$vv['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image'],$vv['ProductI18n']['name']);?></p>
	<p class="info">
	<span class="name"><?php echo $html->link( $vv['ProductI18n']['name'],$svshow->sku_product_link($vv['Product']['id'],$vv['ProductI18n']['name'],$vv['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank",'title'=>$vv['ProductI18n']['name']),false,false);?></span>
	</p>
	</li>
<?php  if( $kk%5==4 && $kk<sizeof($this->data['products_recommand'])-1 ){?>
	<?php if($kk == 0){?>
	<?php }else{?>
	</ul>
	<ul class="home-products">
	<?php }?>
	<?php }else if($kk==sizeof($this->data['products_recommand'])-1){?>
	</ul><?php }else{?><?php }?>
<?php }?>
<div class="more"><?php echo $html->link($this->data['languages']['more'].">>",'/products/advancedsearch/SAD/search_recommand/',array(),false,false)?></div>
</div>
<!--推荐 End-->
<?php }?></cake:nocache>
</div>
<!-- 广告时间 -->
<?php
 //$advertisements_5 = $this->requestAction("/advertisements/show/5/1");
	if(isset($this->data['advertisement_list']['5']) && $this->data['advertisement_list']['5'] != ""){?>
		<div id="advertisements_5" style="margin-top:10px;text-align:center;">
			<?php echo $this->data['advertisement_list']['5'];?>
		</div>
	<?}?>
<!-- 广告时间END -->
	
	
<!-- 所有1级的分类下的 推荐 促销 新品 -->
<cake:nocache>
	<?php if(isset($this->data['home_category_products']) && sizeof($this->data['home_category_products'])>0){?>
	<?php foreach($this->data['home_category_products'] as $a=>$b){?><?php $this_size = 0; unset($tab_arr);?>
	<?php $all_tag = 0;?><?php if(isset($b['all_list']) && sizeof($b['all_list'])>0){?><?php $all_tag++;?><?}?><?php if(isset($b['promotion']) && sizeof($b['promotion'])>0){?><?php $all_tag++;?><?}?><?php if(isset($b['newarrival']) && sizeof($b['newarrival'])>0){?><?php $all_tag++;?><?}?><?php if(isset($b['recommand']) && sizeof($b['recommand'])>0){?><?php $all_tag++;?><?}?>
	<?if($all_tag >0){?>
	<div class="tab_head"><span class="name"><?php echo $b['CategoryI18n']['name'];?></span><ul class="content_tab">
		<?php if(isset($b['all_list']) && sizeof($b['all_list'])>0){?><?php $this_size++; ?>
		<li id="onec<?php echo $a.'_'.$this_size?>" onmouseover="overtab('onec<?php echo $a;?>_',<?php echo $this_size?>,<?php echo $all_tag;?>)" class="hover"><span><?php echo $this->data['languages']['all'].$this->data['languages']['products'];?></span></li><?php $tab_arr = 1;$home_category_products[$a]['sign'] ="all_list"; }?>		
		<?php if(isset($b['promotion']) && sizeof($b['promotion'])>0){?><?php $this_size++; ?>
		<?php if(isset($tab_arr)){?><li id="onec<?php echo $a.'_'.$this_size?>" onmouseover="overtab('onec<?php echo $a;?>_',<?php echo $this_size?>,<?php echo $all_tag;?>)"><?php }else{?><li id="onec<?php echo $a.'_'.$this_size?>" onmouseover="overtab('onec<?php echo $a;?>_',<?php echo $this_size?>,<?php echo $all_tag;?>)" class="hover"><?php }?><span><?php echo $this->data['languages']['promotion'];?></span></li><?php $tab_arr = 1;$home_category_products[$a]['sign'] ="products_promotion"; }?>
		<?php if(isset($b['newarrival']) && sizeof($b['newarrival'])>0){?><?php $this_size++; ?><?php if(isset($tab_arr)){?><li id="onec<?php echo $a.'_'.$this_size?>" onmouseover="overtab('onec<?php echo $a;?>_',<?php echo $this_size?>,<?php echo $all_tag;?>)"><?php }else{?><li id="onec<?php echo $a.'_'.$this_size?>" onmouseover="overtab('onec<?php echo $a;?>_',<?php echo $this_size?>,<?php echo $all_tag;?>)" class="hover"><?php }?><span><?php echo $this->data['languages']['new_arrival'];?></span></li><?php $tab_arr = 1; 				$home_category_products[$a]['sign'] ="products_newarrival";}?>	<?php if(isset($b['recommand']) && sizeof($b['recommand'])>0){?><?php $this_size++; ?><?php if(isset($tab_arr)){?><li id="onec<?php echo $a.'_'.$this_size?>" onmouseover="overtab('onec<?php echo $a;?>_',<?php echo $this_size?>,<?php echo $all_tag;?>)"><?php }else{?><li id="onec<?php echo $a.'_'.$this_size?>" onmouseover="overtab('onec<?php echo $a;?>_',<?php echo $this_size?>,<?php echo $all_tag;?>)" class="hover"><?php }?><span><?php echo $this->data['languages']['recommend'];?></span></li><?php $tab_arr = 1; $home_category_products[$a]['sign'] ="products_recommand"; }?></ul></div>
<?php $pro_size = 0;?>
<div class="border Item_List">
	
<!-- 所有商品 -->
<?php if(isset($b['all_list'])  && sizeof($b['all_list']) > 0 ){?>
<?php $pro_size++;?>
<?php if(isset($home_category_products[$a]['sign']) &&$home_category_products[$a]['sign'] == "all_list"){?>
<div id="con_onec<?php echo $a?>__<?php echo $pro_size?>">
<?php }else{?>
<div id="con_onec<?php echo $a?>__<?php echo $pro_size?>" style="display:none">
<?php }?>
<?php foreach($b['all_list'] as $k=>$v){?>
<?php if($k==0){?><ul class="home-products"><?php }?>
	<li>
		<p class="pic">
		<?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("alt"=>$v['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']));?>
		</p>
		<p class="info">
		<span class="name"><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank"),false,false);?></span>
		</p></li>
<?php  if( $k%5==4 && $k<sizeof($b['all_list'])-1 ){?>
	<?php if($k == 0){?>
	<?php }else{?>
	</ul>
	<ul class="home-products">
	<?php }?>
	<?php }else if($k==sizeof($b['all_list'])-1){?>
	</ul><?php }else{?><?php }?>
<?php }?>
<div class="more"><?php echo $html->link($this->data['languages']['more'].">>",'/categories/'.$b['Category']['id'],array(),false,false)?></div>
</div>	
<?php }?>
<!-- 所有商品END -->


<?php if(isset($b['promotion'])  && sizeof($b['promotion']) > 0 ){?>
	<?php $pro_size++;?>
<!--促销-->
<?php if(isset($home_category_products[$a]['sign']) &&$home_category_products[$a]['sign'] == "products_promotion"){?>
<div id="con_onec<?php echo $a?>__<?php echo $pro_size?>">
<?php }else{?>
<div id="con_onec<?php echo $a?>__<?php echo $pro_size?>" style="display:none">
<?php }?>
<?php foreach($b['promotion'] as $k=>$v){?>
<?php if($k==0){?><ul class="home-products"><?php }?>
	<li>
		<p class="pic">
		<?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("alt"=>$v['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image'],$v['ProductI18n']['name']);?>
		</p>
		<p class="info">
		<span class="name"><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank",'title'=>$v['ProductI18n']['name']),false,false);?></span>
		</p></li>
<?php  if( $k%5==4 && $k<sizeof($b['promotion'])-1 ){?>
	<?php if($k == 0){?>
	<?php }else{?>
	</ul>
	<ul class="home-products">
	<?php }?>
	<?php }else if($k==sizeof($b['promotion'])-1){?>
	</ul><?php }else{?><?php }?>
<?php }?>
<div class="more"><?php echo $html->link($this->data['languages']['more'].">>",'/categories/'.$b['Category']['id'],array(),false,false)?></div>
</div>
<!--促销 End-->
<?php }?>
<?php if(isset($b['newarrival']) && sizeof($b['newarrival']) > 0){?>
<!--新品-->
	<?php $pro_size++;?>
<?php if(isset($home_category_products[$a]['sign']) && $home_category_products[$a]['sign'] == "products_newarrival"){?>
<div id="con_onec<?php echo $a?>__<?php echo $pro_size?>">
<?php }else{?>
<div id="con_onec<?php echo $a?>__<?php echo $pro_size?>" style="display:none;">
<?php }?>
<?php foreach($b['newarrival'] as $k=>$v){?>
<?php if($k==0){?><ul class="home-products"><?php }?>
	<li>
	<p class="pic">
	<?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("alt"=>$v['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image'],$v['ProductI18n']['name']);?></p>
	<p class="info">
	<span class="name"><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank",'title'=>$v['ProductI18n']['name']),false,false);?></span>
	</p>
	</li>
<?php  if( $k%5==4 && $k<sizeof($b['newarrival'])-1 ){?>
	<?php if($k == 0){?>
	<?php }else{?>
	</ul>
	<ul class="home-products">
	<?php }?>
	<?php }else if($k==sizeof($b['newarrival'])-1){?>
	</ul><?php }else{?><?php }?>
<?php }?>
<div class="more"><?php echo $html->link($this->data['languages']['more'].">>",'/categories/'.$b['Category']['id'],array(),false,false)?></div>
</div>

<!--新品 End-->
<?php }?>
<?php if(isset($b['recommand']) && sizeof($b['recommand']) > 0){?>
<!--推荐-->	<?php $pro_size++;?>
<?php if(isset($home_category_products[$a]['sign']) &&$home_category_products[$a]['sign'] == "products_recommand"){?>
<div id="con_onec<?php echo $a?>__<?php echo $pro_size?>">
<?php }else{?>
<div id="con_onec<?php echo $a?>__<?php echo $pro_size?>" style="display:none">
<?php }?>
<?php foreach($b['recommand'] as $kk=>$vv){?>
<?php if($kk==0){?><ul class="home-products"><?php }?>
	<li>
	<p class="pic">
	<?php echo $svshow->productimagethumb($vv['Product']['img_thumb'],$svshow->sku_product_link($vv['Product']['id'],$vv['ProductI18n']['name'],$vv['Product']['code'],$this->data['configs']['product_link_type']),array("alt"=>$vv['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image'],$vv['ProductI18n']['name']);?></p>
	<p class="info">
	<span class="name"><?php echo $html->link( $vv['ProductI18n']['name'],$svshow->sku_product_link($vv['Product']['id'],$vv['ProductI18n']['name'],$vv['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank",'title'=>$vv['ProductI18n']['name']),false,false);?></span>
	</p>
	</li>
<?php  if( $kk%5==4 && $kk<sizeof($b['recommand'])-1 ){?>
	<?php if($kk == 0){?>
	<?php }else{?>
	</ul>
	<ul class="home-products">
	<?php }?>
	<?php }else if($kk==sizeof($b['recommand'])-1){?>
	</ul><?php }else{?><?php }?>
<?php }?>
<div class="more"><?php echo $html->link($this->data['languages']['more'].">>",'/categories/'.$b['Category']['id'],array(),false,false)?></div>
</div>
<!--推荐 End-->
<?php }?>
</div>
<?php }}}?></cake:nocache>
<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>