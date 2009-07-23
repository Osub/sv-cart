<?php 
/*****************************************************************************
 * SV-Cart 更新订单
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: batch_add_products.ctp 2544 2009-07-03 05:55:59Z zhengli $
*****************************************************************************/
?>
<!--Main Start-->
 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' );">
<?php echo $form->create('products',array('action'=>'/batch_add_products/','name'=>"theForm"));?>
<input type="hidden" name="category_id" value="<?php echo $category_id?>" />
<ul class="product_llist users_title">
	<li class="number" style="text-align:center;width:10%"><input type="checkbox" name="chkall" value="checkbox" onclick="checkAll(this.form, this);" checked/>编号</li>
	<li class="name" style="text-align:center;width:15%">商品名称</li>
	<li class="grade" style="width:15%">商品货号</li>
	<li class="email" style="width:15%">商品品牌</li>
	<li class="date" style="width:10%">市场售价</li>
	<li class="date" style="width:10%">本店售价</li>
	<li class="hadle" style="width:15%">商品类别</li>
</ul>
	<?php if(isset($products_list) && sizeof($products_list)>0){?>
<?php foreach($products_list as $k=>$v){ if($k==0)continue;?>
<ul class="product_llist products users_title batchadd">
	<li class="number" style="text-align:center;width:10%"><input type="checkbox" name="checkbox[]"  value="<?php echo $k?>" checked /><?php echo $k;?></li>
	<li class="name" style="text-align:center;width:15%"><input class="text_input" type='text' name="data[<?php echo $k?>][name]" value="<?php echo $v['name']?>"/></li>
	<li class="grade" style="width:15%"><input class="text_input" type='text' name="data[<?php echo $k?>][code]" value="<?php echo $v['code']?>"/></li>
	<li class="email" style="width:15%"><input class="text_input" type='text' name="data[<?php echo $k?>][brand]" value="<?php echo $v['brand']?>"/></li>
	<li class="date" style="width:10%"><input class="text_input" type='text' name="data[<?php echo $k?>][market_price]" value="<?php echo $v['market_price']?>"/></li>
	<li class="date" style="width:10%"><input class="text_input" type='text' name="data[<?php echo $k?>][shop_price]" value="<?php echo $v['shop_price']?>"/></li>
	<li class="hadle" style="width:15%">
	<select name="data[<?php echo $k?>][extension_code]">
	<?php foreach($extension_code as $kk=>$vv){?>
		<option value="<?php echo $kk?>" <?php if($kk==$v['extension_code']) echo "selected";?>><?php echo $vv?></option>
	<?php }?>
	</select>
	
	<input type="hidden" name="data[<?php echo $k?>][provider]" value="<?php echo $v['provider']?>" />
	<input type="hidden" name="data[<?php echo $k?>][meta_keywords]" value="<?php echo $v['meta_keywords']?>" />
	<input type="hidden" name="data[<?php echo $k?>][meta_description]" value="<?php echo $v['meta_description']?>" />
	<input type="hidden" name="data[<?php echo $k?>][description]" value="<?php echo $v['description']?>" />
	<input type="hidden" name="data[<?php echo $k?>][weight]" value="<?php echo $v['weight']?>" />
	<input type="hidden" name="data[<?php echo $k?>][quantity]" value="<?php echo $v['quantity']?>" />
	<input type="hidden" name="data[<?php echo $k?>][recommand_flag]" value="<?php echo $v['recommand_flag']?>" />
	<input type="hidden" name="data[<?php echo $k?>][forsale]" value="<?php echo $v['forsale']?>" />
	<input type="hidden" name="data[<?php echo $k?>][alone]" value="<?php echo $v['alone']?>" />
	<input type="hidden" name="data[<?php echo $k?>][img_thumb]" value="<?php echo $v['img_thumb']?>" />
	<input type="hidden" name="data[<?php echo $k?>][img_detail]" value="<?php echo $v['img_detail']?>" />
	<input type="hidden" name="data[<?php echo $k?>][img_original]" value="<?php echo $v['img_original']?>" />
	<input type="hidden" name="data[<?php echo $k?>][min_buy]" value="<?php echo $v['min_buy']?>" />
	<input type="hidden" name="data[<?php echo $k?>][max_buy]" value="<?php echo $v['max_buy']?>" />
	<input type="hidden" name="data[<?php echo $k?>][point]" value="<?php echo $v['point']?>" />
	<input type="hidden" name="data[<?php echo $k?>][point_fee]" value="<?php echo $v['point_fee']?>" />
	</li>
	
</ul>
<?php }}?>

<p class="submit_btn"><input value="提交" type="submit" onfocus="this.blur()" /></p>

<?php $form->end();?>
</div>
<!--Main Start End-->
</div>