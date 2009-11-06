<?php 
/*****************************************************************************
 * SV-Cart 结算页使用积分
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_point.ctp 4661 2009-09-28 05:31:13Z huangbo $
*****************************************************************************/
?>
<h5>
<dl>
<dt style="padding-top:3px;width:80px;"><strong><?php echo $SCLanguages['use'].$SCLanguages['point'];?>:</strong>&nbsp;&nbsp;</dt>

<dd style="padding-right:4px;"><input type="text" name="use_point" id="use_point" onKeyUp="is_int(this);" value="" onblur="javascript:usepoint(<?php echo $user_info['User']['point']?>,<?php echo $can_use_point?>);" /></dd>
<dd class="btn_list" style="margin-top:-1px;*margin-top:0;"><div style="display:none;"><a href="javascript:usepoint(<?php echo $user_info['User']['point']?>,<?php echo $can_use_point?>)" class="float_l"><span><?php echo $SCLanguages['confirm']?></span></a></div><span class="float_l" style="padding:2px 0 0 4px;"><font color="red" id='point_error_msg'></font></span></dd>

<dt class="over_cont" style="padding-top:3px;">&nbsp;
<?php printf($SCLanguages['can_use_point'],$user_info['User']['point']);?> |
	
<?php printf($SCLanguages['order_max_point'],$can_use_point);?>，
	<?//php printf($SCLanguages['hundred_point'],$SVConfigs['conversion_ratio_point']);?>
	<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
		<?php printf($SCLanguages['hundred_point'],$svshow->price_format(round($SVConfigs['conversion_ratio_point']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],2),$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']));?>
	<?php }else{?>
		<?php printf($SCLanguages['hundred_point'],$svshow->price_format($SVConfigs['conversion_ratio_point'],$this->data['configs']['price_format']));?>
	<?php }?></dt>
	</dl>
</h5>
