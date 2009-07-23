<?php 
/*****************************************************************************
 * SV-Cart 商品分类
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: view.ctp 3225 2009-07-22 10:59:01Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<?php if(isset($flashes['FlashImage']) && sizeof($flashes['FlashImage'])>0){?>
<div id="Flash" style="margin-bottom:5px;">
<?php echo $flash->renderSwf('img/bcastr4.swf?xml='.$cart_webroot.'flashes/index/PC/'.$id,$flashes['Flash']['width'],$flashes['Flash']['height'],false,array('params' => array('movie'=>$cart_webroot.'img/bcastr4.swf?xml='.$cart_webroot.'flashes/index/PC/'.$id,'wmode'=>'Opaque')));?>
</div>
<?php }?>
<!-- 分类的筛选 -->
<?if(isset($SVConfigs['screening_setting']) && $SVConfigs['screening_setting'] == 1){?>
<div id="Item_ListBox"   ><!-- style="display:none;" -->
	<p class="View_item"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'view-left.gif':'view-left.gif',array('class'=>'view-left'))?>
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'view-right.gif':'view-right.gif',array('class'=>'view-right'))?>
	<span class="view">筛选:</span>
	</p>
	<?
		if($SVConfigs['use_sku'] == 1){
			if(isset($parent)){
				$mode_url="/".$this->params['controller']."/".$id."/".$parent."/".$CategoryI18n_name;
			}else{
				$mode_url="/".$this->params['controller']."/".$id."/".$CategoryI18n_name."/0";
			}
		}else{
			$mode_url="/".$this->params['controller']."/".$id."/0/0";
		}
	
		$display_mode_url =$mode_url."/".$orderby."/".$rownum."/".$showtype."/";
	//	pr($display_mode_url);
	?>
	<div class="header_right">
		<?if(isset($brands) && sizeof($brands)){?>
			<div id="screening_brand" class="header_navs color_5">
				<span class="nav"><?=$SCLanguages['brand']?>: 
					<?if(sizeof($brands)>1){?>
						<?if($brand == 0){?>
							<span style="color:red"><?=$SCLanguages['all']?></span>
						<?}else{?>
						<?=$html->link($SCLanguages['all'],$display_mode_url."0/".$price_max."/".$price_min."/".$filters."/",array(),false,false)?> 
						<?}?>
					<?}?> 
					<?foreach($brands as $k=>$v){?>
						<?if($brand == $v['Brand']['id']){?>
							<span style="color:red"><?=$v['BrandI18n']['name']?></span>
						<?}else{?>						
							<?=$html->link($v['BrandI18n']['name'],$display_mode_url.$v['Brand']['id']."/".$price_max."/".$price_min."/".$filters."/",array(),false,false)?> 
						<?}?>
					<?}?>    
				</span>
			</div>
		<?}?>
		<?if(isset($price_arr) && sizeof($price_arr)>0){?>
			<div id="screening_brand" class="header_navs color_5">
				<span class="nav"><?=$SCLanguages['price']?>: 
					<?if(sizeof($price_arr)>1){?>
						<?if($price_min."-".$price_max == "0-0"){?>
							<span style="color:red"><?=$SCLanguages['all']?></span>
						<?}else{?>
							<?=$html->link($SCLanguages['all'],$display_mode_url.$brand."/0/0/".$filters."/",array(),false,false)?> 
						<?}?>
						<?foreach($price_arr as $k=>$v){?>
							<?if($price_min."-".$price_max == $v){?>
								<span style="color:red"><?=$v?></span>
							<?}else{?>
								<?
									$this_price = explode('-',$v);
								?>
								<?=$html->link($v,$display_mode_url.$brand."/".$this_price[0]."/".$this_price[1]."/".$filters."/",array(),false,false)?> 
							<?}?>								
						<?}?>
					<?}?>
				</span>
			</div>
		<?}?>
		<?if(isset($product_types) && sizeof($product_types)>0){?>
			<? 
				$filter_arr = array();
				if($filters != ''){
					$filter_arr =  explode('.',$filters); 
				}	
			//	pr($filter_arr);pr($filters);
				$filter_url_arr = $filter_arr;
			?>
			<?foreach($product_types as $k=>$v){?>
				<?if(isset($product_type_attributes_list[$v['ProductType']['id']]) && sizeof($product_type_attributes_list[$v['ProductType']['id']])>0){?>
				<div id="screening_brand" class="header_navs color_5">
					<span class="nav"><?=$v['ProductTypeI18n']['name']?>: 
						<?if(sizeof($product_type_attributes_list[$v['ProductType']['id']])>1){?>
							<?if($filter_arr[$k] == "0"){?>
								<span style="color:red"><?=$SCLanguages['all']?></span>
							<?}else{?>
								<?	$filter_url_arr = $filter_arr;
								 $filter_url_arr[$k] = 0;
									$filter_url = implode('.',$filter_url_arr);
								?>
								<?=$html->link($SCLanguages['all'],$display_mode_url.$brand."/".$price_min."/".$price_max."/".$filter_url."/",array(),false,false)?> 
							<?}?>
							<?foreach($product_type_attributes_list[$v['ProductType']['id']] as $kk=>$vv){?>
								<?if(isset($filter_arr[$k]) && $filter_arr[$k] == $vv['ProductTypeAttribute']['id']){?>
									<span style="color:red"><?=$vv['ProductTypeAttributeI18n']['name']?></span>
								<?}else{?>
								<? 	$filter_url_arr = $filter_arr;
									$filter_url_arr[$k] =  $vv['ProductTypeAttribute']['id'];
									$filter_url = implode('.',$filter_url_arr);
									
								?>										
									<?=$html->link($vv['ProductTypeAttributeI18n']['name'],$display_mode_url.$brand."/".$price_min."/".$price_max."/".$filter_url."/",array(),false,false)?> 
								<?}?>								
							<?}?>
						<?}else{?>
							<?foreach($product_type_attributes_list[$v['ProductType']['id']] as $kk=>$vv){?>
								<span style="color:red"><?=$vv['ProductTypeAttributeI18n']['name']?></span>
							<?}?>
						<?}?>
					</span>
				</div>
				<?}?>
			<?}?>
		<?}?>
	</div>
</div>
<br/>
<?}?>
<!-- 分类的筛选End -->
<?php echo $this->element('products_list', array('cache'=>'+0 hour'));?>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
<br /> 
<?php echo $this->element('news', array('cache'=>array('time'=> "+24 hour",'key'=>'news'.$template_style)));?>
