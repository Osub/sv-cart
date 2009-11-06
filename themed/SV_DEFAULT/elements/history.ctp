<?php 
/*****************************************************************************
 * SV-CART 浏览历史
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: history.ctp 4433 2009-09-22 10:08:09Z huangbo $
*****************************************************************************/
?>
<cake:nocache>
<?php if($session->check('cookie_product') && isset($this->data['languages'])){ //if(isset($_SESSION['cookie_product']) && sizeof($_SESSION['cookie_product'])>0){?>
<div id="history_box">
<div class="category_box" style="margin-top:5px;">
<!--浏览历史start-->
<h3><span class="l"></span><span class="r"></span>
<a href="javascript:del_history();" onfocus="blur()" class='fff underline clearstatcache' ><?php echo $this->data['languages']['clear_view_history'];?></a>
<?php echo $this->data['languages']['view_history'];?></h3>
<div class="history box" id='history'>
	<ul>
	<?php foreach($_SESSION['cookie_product'] as $k=>$v){?>
	<li>
	<p class="pic">
	<?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("alt"=>$v['ProductI18n']['name'],"width"=>"65","height"=>"65","onmouseover"=>"this.className='hover'","onmouseout"=>"this.className='normal'"),$this->data['configs']['products_default_image'],$v['ProductI18n']['name']);?>
	</p>
	<p class="name"><?php echo $html->link(("{$v['ProductI18n']['sub_name']}"),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank",'title'=>$v['ProductI18n']['name']),false,false)?></p>
	<p class="price">&nbsp;</p>
	</li>    
	<?php }?>
	</ul>
</div>       
<p><?php echo $html->image(isset($this->data['img_style_url'])?$this->data['img_style_url']."/"."category_ulbt.gif":"category_ulbt.gif",array("alt"=>""))?></p>
</div>
<!--浏览历史End-->
</div>
 <?php }?>
 </cake:nocache>
