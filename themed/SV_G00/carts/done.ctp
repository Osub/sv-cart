<?php
/*****************************************************************************
 * SV-Cart 结算
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: done.ctp 1232 2009-05-06 12:14:41Z huangbo $
*****************************************************************************/
?>
<div class="Balance_alltitle"><h1 class="headers"><span class="l"></span><span class="r"></span><b><?=$SCLanguages['checkout_center'];?></b></h1></div>
    <!--您购买的商品-->
	<div id="globalBalance">
	<?if(isset($fail)){?>
	<br /><br /><br />
	<p class="succeed">
	<?=$html->image("warning_img.gif",array("alt"=>$SCLanguages['order_generated'].$SCLanguages['failed']))?>
	<b class="succeed"><?=$SCLanguages['order_generated'].$SCLanguages['failed']?></b></p>
	<?if(isset($error_arr)){?>
	<p class="succeed">
	<?=$SCLanguages['notice'];?>：
	
	<?if(sizeof($error_arr)>0){?>	
		<?foreach($error_arr as $error){?>
			<?=$error?>
		<?}?>
	<?}?>
	</p>
	<?}?>
	<br />
	<p class="back_home"><span style="font-size:14px">
	<?=$html->link($SCLanguages['return'].$SCLanguages['previous'].$SCLanguages['page'],"/carts/",array('class'=>'color_4'),false,false);?>
	</span>&nbsp;&nbsp;
	<span style="font-size:14px">
	<?=$html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>	
	</span>&nbsp;&nbsp;
    <span style="font-size:14px">
	<?=$html->link($SCLanguages['return'].$SCLanguages['user_center'],"/user",array('class'=>'color_4'),false,false);?>	
    </span></p>
	<?}else{?>
    <br /><br /><br />
    <p class="succeed"> 
    <?=$html->image("icon-10.gif",array("align"=>"middle","alt"=>$SCLanguages['order_generated'].$SCLanguages['successfully']))?>
    <?=$html->link($order_code,'/user/orders/'.$order_id,array(),false,false)?>
    <b><?=$SCLanguages['order_generated'].$SCLanguages['successfully'];?></b><br/><br/>
   <?if(isset($is_show_virtual_msg) && $is_show_virtual_msg == 1){?>
     <b>	<?=$SCLanguages['no_stock']?>,<?=$SCLanguages['send_after_products_arrived']?> <b>
    <?}?></p>
    <p class="back_home">
	<? if(isset($pay_message)){?>
	<br />
	<?=$pay_message;?>
	<div id='order_back'>
	<p class="back_home"><span style="font-size:14px">	<?=$html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>	
	&nbsp;&nbsp;&nbsp;&nbsp;
    <?=$html->link($SCLanguages['return'].$SCLanguages['user_center'],"/user",array('class'=>'color_4'),false,false);?>	
</span></p></div>
	<?}elseif(isset($pay_button)){?>
	<br />
	<p class="back_home"><input type="button" style="font-size:15px;width:140;height:50" onclick="window.open('<?=$pay_button; ?>')" value="<?=$SCLanguages['alipay_pay_immedia']?>" /></p><br /><br />
	<div id='order_back'>
	<p class="back_home"><span style="font-size:14px">	<?=$html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>	
	&nbsp;&nbsp;&nbsp;&nbsp;
<?=$html->link($SCLanguages['return'].$SCLanguages['user_center'],"/user",array('class'=>'color_4'),false,false);?>	
</span></p></div>
	<?}elseif(isset($pay_form)){?>
	<br />
	<?=$pay_form;?>
	<div id='order_back'>
	<p class="back_home"><span style="font-size:14px">	<?=$html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>	
	&nbsp;&nbsp;&nbsp;&nbsp;
    <?=$html->link($SCLanguages['return'].$SCLanguages['user_center'],"/user",array('class'=>'color_4'),false,false);?>	
	</span></p></div>
	<?}else{?>
	<div id='order_back'>
	<p class="back_home"><span style="font-size:14px">	<?=$html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>	
	&nbsp;&nbsp;&nbsp;&nbsp;
<?=$html->link($SCLanguages['return'].$SCLanguages['user_center'],"/user",array('class'=>'color_4'),false,false);?>	
	</span></p></div>
	    <?}?>
    <?}?>
    </p>	
    <br />
    <p><?=$html->image("succeed02_img.gif")?></p>
</div>
<!--您购买的商品End-->