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
 * $Id: newsletter.ctp 2923 2009-07-16 06:25:53Z zhangshisong $
*****************************************************************************/
?>
<div id="vote">
<?php echo $form->create('commons',array('action'=>'/view_order','name'=>'view_order','type'=>'POST'));?>
<div class="category_box brand_box">
<h3><span class="l"></span><span class="r"></span><?=$SCLanguages['subscribe']?></h3>
<div class="category homeorderlist box green_3">
<ul>
<li><?=$SCLanguages['email']?>: </li>
<li><input type="text" name="news_letter" id="news_letter" value="" size="22"/></li>
<li class="query"><span class="find-btns"><input type="button" class="find" onclick="javascript:subscribe();" value="<?=$SCLanguages['subscribe']?>" /></span></li>
<div id="order_callback_div">

</div>
</ul>
</div><p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'category_ulbt.gif':'category_ulbt.gif',array("alt"=>""))?></p>
</div>
<?php echo $form->end();?></div>
