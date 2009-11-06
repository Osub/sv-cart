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
 * $Id: newsletter.ctp 3729 2009-08-18 11:57:34Z zhangshisong $
*****************************************************************************/
?>
<div id="newsletter" style="background:#fff;width:auto;">
<?php echo $form->create('commons',array('action'=>'view_newsletter','name'=>'view_newsletter','type'=>'POST'));?>
<div class="category_box brand_box">
<div class="category homeorderlist box green_3">
<ul>
<li><?=$SCLanguages['email']?>: </li>
<li><input type="text" name="news_letter" id="news_letter" value="" size="22" style="width:145px" /></li>
<li class="query"><span class="find-btns"><input type="button" class="find" onclick="javascript:subscribe();" value="<?=$SCLanguages['subscribe']?>" /></span></li>

</ul>
</div><p></p>
</div>
<?php echo $form->end();?></div>
