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
 * $Id: index.ctp 517 2009-04-14 01:18:28Z huangbo $
*****************************************************************************/
?>


<?=$javascript->link('listtable');?>

<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."补货","card_add/{$product_id}/",'',false,false);?></strong></p>
<!--Main Start-->

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
		<ul class="product_llist messgaes_title">
	<li class="number">编号</li>
	<li class="username">卡片序号</li>
	<li class="msg_headers">卡片密码</li>
	<li class="type">截至使用日期</li>
	<li class="msg_time">订单号</li>
	<li class="writeback">是否已出售</li>
	<li class="hadle">操作</li></ul>

	<? if(isset($virtualcard_list) && sizeof($virtualcard_list)>0){?>
	<?php foreach($virtualcard_list as $k=>$v){ ?>
	<ul class="product_llist messgaes_title messgaes_list">
	<li class="number"><?=$v['VirtualCard']['id']?></li>
	<li class="username"><span><?=$v['VirtualCard']['card_sn']?></span></li>
	<li class="msg_headers"><span><?=$v['VirtualCard']['card_password']?></span></li>
	<li class="type"><?=$v['VirtualCard']['end_date']?></li>
	<li class="msg_time"><?=$v['VirtualCard']['order_id']?></li>
	<li class="writeback"><?if($v['VirtualCard']['is_saled'] == 1){?><?=$html->image('yes.gif')?><?}else{?><?=$html->image('no.gif')?><?}?></li>
	<li class="hadle">
	<?php echo $html->link("编辑","/virtual_cards/card_edit/{$v['VirtualCard']['id']}/{$product_id}");?>
	|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}virtual_cards/card_remove/{$v['VirtualCard']['id']}')"));?>
		</li></ul>
	<? }} ?>
  <div class="pagers" style="position:relative">

<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
</div>


