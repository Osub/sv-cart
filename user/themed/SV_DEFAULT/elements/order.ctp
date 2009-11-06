<?php 
/*****************************************************************************
 * SV-Cart 站内调查
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: order.ctp 3729 2009-08-18 11:57:34Z zhangshisong $
*****************************************************************************/
?>
<div id="load_order"  style="background:#fff;width:auto;">
<?php echo $form->create('commons',array('action'=>'view_order','name'=>'view_order','type'=>'POST'));?>
<div class="category_box brand_box">
<div class="category homeorderlist box green_3">
<ul>
<li><?=$SCLanguages['order']?><?=$SCLanguages['code']?>: </li>
<li><input type="text" name="order_code" id="order_code" value="" style="width:145px" /></li>
<li class="query"><span class="find-btns"><input type="button" class="find" onclick="javascript:get_order();" value="<?=$SCLanguages['search']?>" /></span></li>
<li><div id="order_callback_div">

</div></li>
</ul>
</div>
<p></p>
</div>
<?php echo $form->end();?></div>
