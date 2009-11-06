<?php 
/*****************************************************************************
 * SV-Cart 缺货处理
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_point.ctp 4656 2009-09-28 03:26:06Z shenyunfeng $
*****************************************************************************/
?>
	<h5>
	<dl>
	<dt style="padding-top:3px;width:80px;"><strong><?php echo $SCLanguages['out_of_stock_process'];?>:</strong>&nbsp;&nbsp;</dt>

	<dd style="padding-right:4px;padding-top:3px;">
		<?php foreach($information_info['how_oos'] as $k=>$v){?>
			<?php if($k > 0){?>
				<input type="radio" name="how_oos" value="<?php echo $v;?>"  onclick="javascript:confirm_stock('<?php echo $v;?>');" />&nbsp;<?php echo $v;?> &nbsp;
			<?php }?>
		<?php }?>
	</dd>
	
	<dt class="over_cont" style="padding-top:3px;">&nbsp;</dt>
	</dl>
	</h5>

