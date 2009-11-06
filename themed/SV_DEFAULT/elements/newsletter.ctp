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
 * $Id: newsletter.ctp 5195 2009-10-20 05:29:32Z huangbo $
*****************************************************************************/
?>
<?php echo $form->create('commons',array('action'=>'view_newsletter','name'=>'view_newsletter','type'=>'POST'));?>
<dl class="newsletter">
<dt><?=$SCLanguages['email']?>: </dt>
<dd><input type="text" name="news_letter" id="news_letter" value="" size="22" style="width:145px" />&nbsp;</dd>
<dd class="action"><span class="button_2"><input type="button" class="find" onclick="javascript:subscribe();" value="<?=$SCLanguages['subscribe']?>" /></span></dd>
</dl>
<?php echo $form->end();?>
