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
 * $Id: history.ctp 1162 2009-04-30 11:17:42Z huangbo $
*****************************************************************************/
?>
<?if(isset($_SESSION['cookie_product']) && sizeof($_SESSION['cookie_product'])>0){?>
<div id="history_box">
<div class="category_box" style="margin-top:5px;"><!--浏览历史start-->
 <h3><?php echo $SCLanguages['view_history'];?>&nbsp;|&nbsp;<a href="javascript:del_history();" onfocus="blur()" class='fff'><?php echo $SCLanguages['clear_view_history'];?></a></h3>
 <div class="history" id='history'>
        <ul>
        <?foreach($_SESSION['cookie_product'] as $k=>$v){?>
        <li>
         <p class="pic">
        <?if(isset($v['Product']['img_thumb']) && $v['Product']['img_thumb'] != ""){?>
		<?=$html->link($html->image("{$v['Product']['img_thumb']}",array("width"=>"65","height"=>"65","onmouseover"=>"this.className='hover'","onmouseout"=>"this.className='normal'")),"/products/".$v['Product']['id'],array(),false,false);?>
		<?}else{?>
		<?=$html->link($html->image("/img/product_default.jpg",array("width"=>"65","height"=>"65","onmouseover"=>"this.className='hover'","onmouseout"=>"this.className='normal'")),"/products/".$v['Product']['id'],array(),false,false);?>
		<?}?>
		</p>
        <p class="name">
        <?=$html->link(("{$v['ProductI18n']['name']}"),"/products/{$v['Product']['id']}","",false,false)?>
        </p>
        <p class="price">
        <?if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0 && isset($_SESSION['User']['User'])){?>	
		<?=$svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
		<?}else{?>
		<?=$svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
		<?}?>
        </p></li>    
		<?}?>
        </ul>
 </div>       
 <?=$html->image("category_ulbt.gif",array("align"=>"absbottom"))?>
</div><!--浏览历史End--></div>
 <?}?>