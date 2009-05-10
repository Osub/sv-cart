<?php
/*****************************************************************************
 * SV-Cart 待处理冲值
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: search.ctp 1283 2009-05-10 13:48:29Z huangbo $
*****************************************************************************/
?> 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>

<!--Main Start-->
<br />
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist products_processing">
	<li class="membername">会员名称</li>
	<li class="handel_time">操作日期</li>
	<li class="money">金额</li>
	<li class="payment">支付方式</li>
	<li class="remark">备注</li>
	<li class="hadle">操作</li></ul>
<!--Products Processing List-->
<?if(isset($UserAccount_list) && sizeof($UserAccount_list)>0){?>
<? foreach( $UserAccount_list as $k=>$v ){ ?>
	<ul class="product_llist products_processing products_processing_list">
	<li class="membername"><span><?=$v['UserAccount']['name']?></span></li>
	<li class="handel_time"><?=$v['UserAccount']['created']?></li>
	<li class="money"><span><?=$v['UserAccount']['amount']?></span></li>
	<li class="payment"><?=$v['UserAccount']['payment_name']?></li>
	<li class="remark"><span><?if( $v['UserAccount']['status']==1 ){ echo "已确认"; }else{ echo "待处理";}?></span></li>
	<li class="hadle"><?=$html->link("确认","/balances/search_verify/{$v['UserAccount']['id']}",'',false,false);?>|<?=$html->link("取消","/balances/search_cancel/{$v['UserAccount']['id']}",'',false,false);?></li></ul>

<?}?><?}?>

<!--Products Processing List End-->
<div class="pagers" style="position:relative">
    <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>

</div>
<!--Main Start End-->
</div>