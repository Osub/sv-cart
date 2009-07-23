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
 * $Id: send.ctp 2926 2009-07-16 06:45:45Z zhengli $
*****************************************************************************/
?>
<?php echo $html->css('colorpicker');?>
<?php echo $html->css('button');?>
<?php echo $html->css('slider');?>
<?php echo $html->css('color_font');?>
<?php echo $javascript->link('/../js/yui/dragdrop-min.js');?>
<?php echo $javascript->link('/../js/yui/button-min.js');?>
<?php echo $javascript->link('/../js/yui/slider-min.js');?>
<?php echo $javascript->link('/../js/yui/colorpicker-min.js');?>
<?php echo $javascript->link('color_picker');?>	
<?php echo $javascript->link('product');?>	
<?php echo $javascript->link('coupon');?>	
<div class="content">
<?php  echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<br />	
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle')).'优惠券列表','/coupons/','',false,false)?> </strong></p>
<?php if($coupontype['CouponType']['send_type'] == 0){?>
<!--用户送-->

<div class="home_main">
	<div class="order_stat properies">
	<?php if(isset($user_ranks) && sizeof($user_ranks)>0){?>
		<div>
	  <?php echo $form->create('coupons',array('action'=>'send_by_user_rank','name'=>"user_rank","id"=>"user_rank",'type'=>'POST'));?>
			<p class="select_cat">
			<b>按用户等级发放优惠券:</b>
			<select id="user_rank" style="font-size:12px;" name="user_rank"  autocomplete="off">
			<option value='0' selected > 选择会员等级</option>
			<?php foreach($user_ranks as $k=>$v){?>
			<option value="<?php echo $v['UserRank']['id']?>"> <?php echo $v['UserRankI18n']['name']?></option>
			<?php }?>
			</select>
			<input type="hidden"  name="coupon_type_id" value="<?php echo $coupontype['CouponType']['id']?>" />
			<input type="button" value="确定发送"  class="search" onclick="send_by_user_rank();"/></p>
			<br /><br />
		</div><?php echo $form->end();?>
	<?php }?>
	  <div class="box">
		<p class="select_cat">
		<?php echo $html->image('serach_icon.gif',array('align'=>'absmiddle'))?>
	  <?php echo $form->create('coupons',array('action'=>'send_by_user_rank','name'=>"send_by_form","id"=>"send_by_form",'type'=>'POST'));?>
		<input type="text" class="text_input" name="keywords" id="user_keywords"/>
		<input type="button" value="搜 索" class="search" onclick="searchUsers();"/></p>
		<table width="100%" class="relative_product">
			<tr>
				<td valign="top" width="40%">
				<p><strong>可选用户</strong></p>
				<p><select name="source_select1" id="source_select1" size="20" style="width:100%" ondblclick="addCoupon(this,'insert_link_users', <?php echo $coupontype['CouponType']['id']?>);"multiple="true"></p>
				</td>
				<td valign="top" width="12%" align="center">
				<p><strong>操作</strong></p>
				<p class="relative_radio">
				发放优惠券
				</p>
				<p class="direction">
				<input type="button" class="pointer" value=">" onclick="addCoupon(this.form.elements['source_select1'],'insert_link_users', <?php echo $coupontype['CouponType']['id']?>);"/><br /><br />
				</p>
				</td>
				<td valign="top" width="40%">
				<p><strong>给下列用户发放优惠券</strong></p>
				<div class="relativies_box" id="relativies_box">
               </div></td>
			</tr>
		</table><?php echo $form->end();?>
	  </div>
	</div></div>
<!--用户送 End-->
<?php }?>
<?php if($coupontype['CouponType']['send_type'] == 1){?>
<!--商品送--><div class="home_main">
	  <?php echo $form->create('',array('action'=>'','name'=>"linkForm","id"=>"linkForm"));?>
			<input type="hidden" id="products_id" name="products_id" value="0" />
	<div class="order_stat properies">
	  <div class="box">
		<p class="select_cat">
		<?php echo $html->image('serach_icon.gif',array('align'=>'absmiddle'))?>
		<select name="category_id" id="category_id">
		<option value="0">所有分类</option>
		<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?><?php foreach($categories_tree as $first_k=>$first_v){?>
		<option value="<?php echo $first_v['Category']['id'];?>"><?php echo $first_v['CategoryI18n']['name'];?></option>
		<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
		<option value="<?php echo $second_v['Category']['id'];?>">&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
		<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
		<option value="<?php echo $third_v['Category']['id'];?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
		<?php }}}}}}?>
		</select>
		<select name="brand_id" id="brand_id">
		<option value="0">所有品牌</option>
		<?php if(isset($brands_tree) && sizeof($brands_tree)>0){?>
		<?php foreach($brands_tree as $k=>$v){?>
	  <option value="<?php echo $v['Brand']['id']?>"><?php echo $v['BrandI18n']['name']?></option>
	<?php }}?>
		</select>
		<input type="text" class="text_input" name="keywords" id="keywords"/>
		<input type="button" value="搜 索" class="search" onclick="searchProducts();"/></p>
		<table width="100%" class="relative_product">
			<tr>
				<td valign="top" width="40%">
				<p><strong>可选商品</strong></p>
				<p><select name="source_select1" id="source_select1" size="20" style="width:100%" ondblclick="addCoupon(this.form.elements['source_select1'],'insert_link_products', <?php echo $coupontype['CouponType']['id']?>);" multiple="true"></p>
				</td>
				<td valign="top" width="12%" align="center">
				<p><strong>操作</strong></p>
				<p class="relative_radio">
				发放优惠券
				<p class="direction">
				<input type="button" class="pointer" value=">" onclick="addCoupon(this.form.elements['source_select1'],'insert_link_products', <?php echo $coupontype['CouponType']['id']?>);"/><br /><br />
				</p>
				</td>
				<td valign="top" width="40%">
				<p><strong>跟该优惠券关联的商品</strong></p>
				<div class="relativies_box" id="relativies_box"><div class="target_select1">
				<?php if(isset($product_relations) && sizeof($product_relations)>0){?>
                      <?php foreach($product_relations as $k=>$v){?>
                      	<?php if (isset($v['Product'])){?>
						<div id="<?php echo $v['Product']['id']?>">
                           <p class="rel_list">
                           <span class="handle">
                           <?php echo $html->image('delete1.gif',array('align'=>'absmiddle','style'=>'margin:5px 0px 0px 0px;',"onMouseout"=>"onMouseout_deleteimg(this)","onmouseover"=>"onmouseover_deleteimg(this)","onclick"=>"dropCoupon(".$v['Product']['coupon_type_id'].",'drop_link_products',".$v['Product']['id'].");"));?>
                            </span>
                            
                            <?php echo $v['ProductI18n']['name']?></p>
                      	</div>
                            <?php }?>
                      <?php }}?>
             </div>  </div></td>
			</tr>
		</table>
	  </div>
	</div></div><?php echo $form->end();?>

<!--商品送 End-->
<?php }?>
		
<?php if($coupontype['CouponType']['send_type'] == 3){?>
<!--线下发放--><div class="home_main">

	<?php echo $form->create('Coupon',array('action'=>'send_print' ,'method'=>'POST' , 'onsubmit'=>'return num_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  &nbsp;&nbsp;线下发放&nbsp;&nbsp;</h1></div>
	  <div class="box">
	  <div class="shop_config menus_configs">
	  	<dl><dt>类型金额: </dt>
		<dd>
		<input type="text" style="width:290px;border:1px solid #649776"  name="coupontypename" value="<?php echo $coupontype['CouponTypeI18n']['name']?> [ ￥<?php echo $coupontype['CouponType']['money']?> 元]" readonly/>
		<input type="hidden" style="width:290px;border:1px solid #649776" name="coupon_type_id"  value="<?php echo $coupontype['CouponType']['id']?>"/>
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
<?php }?>		

<?php if($coupontype['CouponType']['send_type'] == 5){?>
<!--Coupon发放--><div class="home_main">

	<?php echo $form->create('Coupon',array('action'=>'send_coupon' ,'method'=>'POST' , 'onsubmit'=>'return coupon_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  &nbsp;&nbsp;Coupon发放&nbsp;&nbsp;</h1></div>
	  <div class="box">
	  <div class="shop_config menus_configs">
	  	<dl><dt>类型金额: </dt>
		<dd>
		<input type="text" style="width:290px;border:1px solid #649776"  name="coupontypename" value="<?php echo $coupontype['CouponTypeI18n']['name']?> [ ￥<?php echo $coupontype['CouponType']['money']?> 元]" readonly/>
		<input type="hidden" style="width:290px;border:1px solid #649776" name="coupon_type_id"  value="<?php echo $coupontype['CouponType']['id']?>"/>
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
<?php }?>	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		</div>