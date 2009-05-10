<?php
/*****************************************************************************
 * SV-CART 电子优惠券管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 519 2009-04-14 01:23:01Z huangbo $
*****************************************************************************/
?>
<?=$html->css('colorpicker');?>
<?=$html->css('button');?>
<?=$html->css('slider');?>
<?=$html->css('color_font');?>
<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<?=$javascript->link('/../js/yui/dragdrop-min.js');?>
<?=$javascript->link('/../js/yui/button-min.js');?>
<?=$javascript->link('/../js/yui/slider-min.js');?>
<?=$javascript->link('/../js/yui/colorpicker-min.js');?>
<?=$javascript->link('/../js/yui/element-beta-min.js');?>
<?=$javascript->link('color_picker');?>	
<?=$javascript->link('product');?>	
<?=$javascript->link('coupon');?>	
<div class="content">
<?php  echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<br />	
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle')).'优惠券列表','/coupons/','',false,false)?> </strong></p>
<?if($coupontype['CouponType']['send_type'] == 0){?>
<!--用户送-->

<div class="home_main">
	<div class="order_stat properies">
	<?if(isset($user_ranks) && sizeof($user_ranks)>0){?>
		<div>
	  <?php echo $form->create('coupons',array('action'=>'send_by_user_rank','name'=>"send_by_form","id"=>"send_by_form",'type'=>'POST'));?>
			<p class="select_cat">
			<b>按用户等级发放优惠券:</b>
			<select id="user_rank" style="font-size:12px;" name="user_rank"  autocomplete="off">
			<option value='0' selected > 选择会员等级</option>
			<?foreach($user_ranks as $k=>$v){?>
			<option value="<?=$v['UserRank']['id']?>"> <?=$v['UserRankI18n']['name']?></option>
			<?}?>
			</select>
			<input type="hidden"  name="coupon_type_id" value="<?=$coupontype['CouponType']['id']?>" />
			<input type="button" value="确定发送"  class="search" onclick="send_by_user_rank();"/></p>
			<br /><br />
		</div><? echo $form->end();?>
	<?}?>
	  <div class="box">
		<p class="select_cat">
		<?=$html->image('serach_icon.gif',array('align'=>'absmiddle'))?>

		<input type="text" class="text_input" name="keywords" id="user_keywords"/>
		<input type="button" value="搜 索" class="search" onclick="searchUsers();"/></p>
		<table width="100%" class="relative_product">
			<tr>
				<td valign="top" width="40%">
				<p><strong>可选用户</strong></p>
				<p><select name="source_select1" id="source_select1" size="20" style="width:100%" ondblclick="addCoupon(this,'insert_link_users', <?=$coupontype['CouponType']['id']?>);"multiple="true"></p>
				</td>
				<td valign="top" width="12%" align="center">
				<p><strong>操作</strong></p>
				<p class="relative_radio">
				发放优惠券
				</p>
				<p class="direction">
				<input type="button" class="pointer" value=">" onclick="addCoupon(this.form.elements['source_select1'],'insert_link_users', <?=$coupontype['CouponType']['id']?>);"/><br /><br />
				</p>
				</td>
				<td valign="top" width="40%">
				<p><strong>给下列用户发放优惠券</strong></p>
				<div class="relativies_box" id="relativies_box">
               </div></td>
			</tr>
		</table>
	  </div>
	</div></div>
<!--用户送 End-->
<?}?>
<?if($coupontype['CouponType']['send_type'] == 1){?>
<!--商品送--><div class="home_main">
	  <?php echo $form->create('',array('action'=>'','name'=>"linkForm","id"=>"linkForm"));?>
			<input type="hidden" id="products_id" name="products_id" value="0" />
	<div class="order_stat properies">
	  <div class="box">
		<p class="select_cat">
		<?=$html->image('serach_icon.gif',array('align'=>'absmiddle'))?>
		<select name="category_id" id="category_id">
		<option value="0">所有分类</option>
		<?if(isset($categories_tree) && sizeof($categories_tree)>0){?><?foreach($categories_tree as $first_k=>$first_v){?>
		<option value="<?=$first_v['Category']['id'];?>"><?=$first_v['CategoryI18n']['name'];?></option>
		<?if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
		<option value="<?=$second_v['Category']['id'];?>">&nbsp;&nbsp;<?=$second_v['CategoryI18n']['name'];?></option>
		<?if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
		<option value="<?=$third_v['Category']['id'];?>">&nbsp;&nbsp;&nbsp;&nbsp;<?=$third_v['CategoryI18n']['name'];?></option>
		<?}}}}}}?>
		</select>
		<select name="brand_id" id="brand_id">
		<option value="0">所有品牌</option>
		<?if(isset($brands_tree) && sizeof($brands_tree)>0){?>
		<?foreach($brands_tree as $k=>$v){?>
	  <option value="<?echo $v['Brand']['id']?>"><?echo $v['BrandI18n']['name']?></option>
	<?}}?>
		</select>
		<input type="text" class="text_input" name="keywords" id="keywords"/>
		<input type="button" value="搜 索" class="search" onclick="searchProducts();"/></p>
		<table width="100%" class="relative_product">
			<tr>
				<td valign="top" width="40%">
				<p><strong>可选商品</strong></p>
				<p><select name="source_select1" id="source_select1" size="20" style="width:100%" ondblclick="addCoupon(this.form.elements['source_select1'],'insert_link_products', <?=$coupontype['CouponType']['id']?>);" multiple="true"></p>
				</td>
				<td valign="top" width="12%" align="center">
				<p><strong>操作</strong></p>
				<p class="relative_radio">
				发放优惠券
				<p class="direction">
				<input type="button" class="pointer" value=">" onclick="addCoupon(this.form.elements['source_select1'],'insert_link_products', <?=$coupontype['CouponType']['id']?>);"/><br /><br />
				</p>
				</td>
				<td valign="top" width="40%">
				<p><strong>跟该商品关联的商品</strong></p>
				<div class="relativies_box" id="relativies_box">
				<?if(isset($product_relations) && sizeof($product_relations)>0){?>
                      <?foreach($product_relations as $k=>$v){?>
                      	<?if (isset($v['Product'])){?>
						<div id="<?=$v['Product']['id']?>">
                           <p class="rel_list">
                           <span class="handle">
                           <input type="button" class="pointer" value="删除" onclick="dropCoupon(<?=$v['Product']['coupon_type_id']?>,'drop_link_products', <?=$v['Product']['id']?>);"/></span><?echo $v['ProductI18n']['name']?></p>
                      	</div>
                            <?}?>
                      <?}}?>
               </div></td>
			</tr>
		</table>
	  </div>
	</div></div><? echo $form->end();?>

<!--商品送 End-->
<?}?>
		
<?if($coupontype['CouponType']['send_type'] == 3){?>
<!--线下发放--><div class="home_main">

	<?php echo $form->create('Coupon',array('action'=>'send_print' ,'method'=>'POST' , 'onsubmit'=>'return num_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  &nbsp;&nbsp;线下发放&nbsp;&nbsp;</h1></div>
	  <div class="box">
	  <div class="shop_config menus_configs">
	  	<dl><dt>类型金额: </dt>
		<dd>
		<input type="text" style="width:290px;border:1px solid #649776"  name="coupontypename" value="<?=$coupontype['CouponTypeI18n']['name']?> [ ￥<?=$coupontype['CouponType']['money']?> 元]" readonly/>
		<input type="hidden" style="width:290px;border:1px solid #649776" name="coupon_type_id"  value="<?=$coupontype['CouponType']['id']?>"/>
		</dd></dl>
		<dl><dt>优惠券数量: </dt>
		<dd><input type="text" style="width:290px;border:1px solid #649776" name="num" id="num"  onKeyUp="is_int(this);"/></dd></dl>
	  	<dl><dt></dt>
		<dd>提示:优惠券序列号由二位前缀加上六位序列号种子加上四位随机数字组成</dd></dl>
		</div>		
	  </div>
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	</div>
<?php $form->end();?></div>
<!--线下发放 End-->
<?}?>		

<?if($coupontype['CouponType']['send_type'] == 5){?>
<!--Coupon发放--><div class="home_main">

	<?php echo $form->create('Coupon',array('action'=>'send_coupon' ,'method'=>'POST' , 'onsubmit'=>'return coupon_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  &nbsp;&nbsp;Coupon发放&nbsp;&nbsp;</h1></div>
	  <div class="box">
	  <div class="shop_config menus_configs">
	  	<dl><dt>类型金额: </dt>
		<dd>
		<input type="text" style="width:290px;border:1px solid #649776"  name="coupontypename" value="<?=$coupontype['CouponTypeI18n']['name']?> [ ￥<?=$coupontype['CouponType']['money']?> 元]" readonly/>
		<input type="hidden" style="width:290px;border:1px solid #649776" name="coupon_type_id"  value="<?=$coupontype['CouponType']['id']?>"/>
		</dd></dl>
		<dl><dt>优惠券可使用次数: </dt>
		<dd><input type="text" style="width:290px;border:1px solid #649776" name="max_buy_quantity" id="max_buy_quantity"  onKeyUp="is_int(this);"/></dd></dl>
		<dl><dt>优惠券折扣: </dt>
		<dd><input type="text" style="width:290px;border:1px solid #649776" name="order_amount_discount" id="order_amount_discount"  onKeyUp="is_int(this);"/>&nbsp;请填写0-100之间的数(100为不打折) </dd></dl>	  	
	  	
	  	<dl><dt></dt>
		<dd>提示:优惠券序列号由二位前缀加上六位序列号种子加上四位随机数字组成</dd></dl>
		</div>		
	  </div>
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	</div>
<?php $form->end();?></div>
<!--Coupon发放 End-->
<?}?>	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		</div>