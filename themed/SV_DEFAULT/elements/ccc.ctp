<!-- 分类的筛选 -->
<div class="category_box brand_box">
<h3><span class="l"></span><span class="r"></span><?php echo $SCLanguages['filter'];?></h3>
<div class="category Help box">
<?if(isset($SVConfigs['screening_setting']) && $SVConfigs['screening_setting'] == 1){?>
<?php if((isset($brands) && sizeof($brands)) || (isset($price_arr) && sizeof($price_arr)>0) || (isset($product_types) && sizeof($product_types)>0)){?>
	<?
		if($SVConfigs['use_sku'] == 1){
			if(isset($parent)){
				$mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_parent']."/".$this->data['page_category_name'];
			}else{
				$mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_category_name']."/0";
			}
		}else{
			$mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/0/0";
		}
	
		$display_mode_url =$mode_url."/".$this->data['get_page']."/".$this->data['orderby']."/".$this->data['rownum']."/".$this->data['showtype']."/";
	//	pr($display_mode_url);
	?>
	<div class="screening color_5">
		<?if(isset($brands) && sizeof($brands)){?>
			<dl id="screening_brand">
				<dd class="lang"><strong><?=$SCLanguages['brand']?>: </strong></dd>
				<dd>
					<?if(sizeof($brands)>1){?>
						<?if($brand == 0){?>
							<span style="color:red"><?=$SCLanguages['all']?></span>
						<?}else{?>
						<?=$html->link($SCLanguages['all'],$display_mode_url."0/".$price_max."/".$price_min."/".$filters."/",array(),false,false)?> 
						<?}?>
					<?foreach($brands as $k=>$v){?>
						<?if($brand == $v['Brand']['id']){?>
							<span style="color:red"><?=$v['BrandI18n']['name']?></span>
						<?}else{?>						
							<?=$html->link($v['BrandI18n']['name'],$display_mode_url.$v['Brand']['id']."/".$price_max."/".$price_min."/".$filters."/",array(),false,false)?> 
						<?}?>
					<?}?>   							
					<?}else{?> 
					<?foreach($brands as $k=>$v){?>					
							<span style="color:red"><?=$v['BrandI18n']['name']?></span>
					<?}}?>    
				</dd>
			</dl>
		<?}?>
		<?if(isset($price_arr) && sizeof($price_arr)>0){?>
			<dl id="screening_brand">
				<dd class="lang"><strong><?=$SCLanguages['price']?>:</strong> </dd>
					<dd><?if(sizeof($price_arr)>1){?>
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
					</dd>
			</dl>
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
				<dl id="screening_brand">
					<dd class="lang"><strong><?=$v['ProductTypeI18n']['name']?>: </strong></dd>
						<dd><?if(sizeof($product_type_attributes_list[$v['ProductType']['id']])>1){?>
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
						</dd>
				</dl>
				<?}?>
			<?}?>
		<?}?>
	</div>
<div class="height_5">&nbsp;</div>
	<?}?>
<?}?>
</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."category_ulbt.gif":"category_ulbt.gif",array("alt"=>""))?></p>
</div>
<!-- 分类的筛选End -->
