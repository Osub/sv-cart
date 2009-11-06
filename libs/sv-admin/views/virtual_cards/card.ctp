<?php 
/*****************************************************************************
 * SV-Cart 虚拟卡补货
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: card.ctp 3673 2009-08-17 09:57:45Z huangbo $
*****************************************************************************/
?>


 

<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."补货","card_add/{$product_id}/",'',false,false);?></strong></p>
<!--Main Start-->

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>编号</th>
	<th>卡片序号</th>
	<th>卡片密码</th>
	<th width="140px">截至使用日期</th>
	<th>订单号</th>
	<th width="80px">是否已出售</th>
	<th width="80px">操作</th>
</tr>
	<?php if(isset($virtualcard_list) && sizeof($virtualcard_list)>0){?>
	<?php foreach($virtualcard_list as $k=>$v){ ?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td align="center"><?php echo $v['VirtualCard']['id']?></td>
	<td align="center"><span><?php echo $v['VirtualCard']['card_sn']?></span></td>
	<td align="center"><span><?php echo $v['VirtualCard']['card_password']?></span></td>
	<td align="center"><?php echo $v['VirtualCard']['end_date']?></td>
	<td align="center"><?php echo $v['VirtualCard']['order_id']?></td>
	<td align="center"><?php if($v['VirtualCard']['is_saled'] == 1){?><?php echo $html->image('yes.gif')?><?php }else{?><?php echo $html->image('no.gif')?><?php }?></td>
	<td align="center">
	<?php echo $html->link("编辑","/virtual_cards/card_edit/{$v['VirtualCard']['id']}/{$product_id}");?>
	|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}virtual_cards/card_remove/{$v['VirtualCard']['id']}')"));?>
		</td></tr>
	<?php }} ?>
</table></div>
  <div class="pagers" style="position:relative">

<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
</div>


