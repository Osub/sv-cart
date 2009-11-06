<?php 
/*****************************************************************************
 * SV-Cart 提交评论
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: comment.ctp 2800 2009-07-13 07:42:54Z zhangshisong $
*****************************************************************************/
?>
<div id="my_photo" class="yui-overlay">
<div class="hd comment_title"><span class="l"></span><span class="r"></span>
<a href="javascript:close_my_photo();" class="float_r close"></a>
<div class="t"><?php echo $this->data['languages']['upload']?><?php echo $this->data['languages']['my_photos']?></div></div>
<div class="comment" style="width:424px;">
<div class="box" style="width:auto;">
<?php echo $form->create('commons',array('action'=>'upfile','name'=>'form_upfile','type'=>'post','enctype'=>'multipart/form-data'));?>
<div class="key_list">
<div class="user_comment">
	<dl>
	<dd>&nbsp;</dd>
	<dt>
		<input type="file" id="this_file" name="photo" size="45"/>
		<input type="hidden"  name="product_code" value="<?php echo $this->data['product_view']['Product']['code'];?>" />
		<input type="hidden"  name="product_id" value="<?php echo $this->data['product_view']['Product']['id'];?>" />
	</dt>
	</dl>
</div>
	<div class="comment_box"><div class="btn_liss commetn_btn"><font id="photo_button"><a href="javascript:product_upfile();" class="reset"><?php echo $SCLanguages['submit'];?></a></font></div></div>
</div>
<?php echo $form->end();?>
</div>
</div>
</div>
