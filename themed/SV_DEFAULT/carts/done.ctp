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
 * $Id: done.ctp 3225 2009-07-22 10:59:01Z huangbo $
*****************************************************************************/
?>
<div class="Balance_alltitle">
	<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['checkout_center'];?></b></h1>
</div>
    <!--您购买的商品-->
	<div id="globalBalance">
	<?php if(isset($fail)){?>
	<br /><br /><br />
	<p class="succeed">
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."warning_img.gif":"warning_img.gif",array("alt"=>$SCLanguages['order_generated'].$SCLanguages['failed']))?>
	<b><?php echo $SCLanguages['order_generated'].$SCLanguages['failed']?></b></p>
	
	<?php if(isset($error_arr)){?>
	<br /><br />
	<p class="order_description">
	<?php echo $SCLanguages['notice'];?>：
	
	<?php if(sizeof($error_arr)>0){?>	
		<?php foreach($error_arr as $error){?>
			<?php echo $error?>
		<?php }?>
	<?php }?>
	</p>
	<?php }?>
	<br /><br /><br />
	<p class="back_home">
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['previous'].$SCLanguages['page'],"/carts/",array('class'=>'color_4'),false,false);?>
	&nbsp;&nbsp;
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>	
	&nbsp;&nbsp;
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['user_center'],$server_host.$user_webroot,array('class'=>'color_4'),false,false);?>	
    </p>
	<?php }else{?>
    <br /><br /><br />
    <p class="succeed"> 
    <?php echo $html->image(isset($img_style_url)?$img_style_url."/"."icon-10.gif":"icon-10.gif",array("align"=>"middle","alt"=>$SCLanguages['order_generated'].$SCLanguages['successfully']))?><?php echo $html->link($order_code,$server_host.$user_webroot.'orders/'.$order_id,array("target"=>"_blank"),false,false)?>
    <b><?php echo $SCLanguages['order_generated'].$SCLanguages['successfully'];?></b><br/><br/>
   <?php if(isset($is_show_virtual_msg) && $is_show_virtual_msg == 1){?>
     <b><?php echo $SCLanguages['no_stock']?>,<?php echo $SCLanguages['send_after_products_arrived']?> <b>
    <?php }?></p>
    <div class="order_description">
	<?php if(isset($pay_message)){?>
	<?php echo $pay_message;?>
	<br /><br/><br/>
	<div id='order_back'>
	<p class="back_home"><?php echo $html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>	
	&nbsp;&nbsp;&nbsp;&nbsp;
    <?php echo $html->link($SCLanguages['return'].$SCLanguages['user_center'],$server_host.$user_webroot ,array('class'=>'color_4'),false,false);?>	
</p></div>
	<?php }elseif(isset($pay_button)){?>
	<br />
	<input type="button" style="font-size:15px;width:140;height:50" onclick="window.open('<?php echo $pay_button; ?>')" value="<?php echo $SCLanguages['alipay_pay_immedia']?>" /><br /><br /><br/>
	<div id='order_back'>
	<p class="back_home"><?php echo $html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>	
	&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo $html->link($SCLanguages['return'].$SCLanguages['user_center'],$server_host.$user_webroot,array('class'=>'color_4'),false,false);?>	
</p></div>
	<?php }elseif(isset($pay_form)){?>
	<br />
	<?php echo $pay_form;?>
	<br/><br/><br/>
	<div id='order_back'>
	<p class="back_home"><?php echo $html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>	
	&nbsp;&nbsp;&nbsp;&nbsp;
    <?php echo $html->link($SCLanguages['return'].$SCLanguages['user_center'],$server_host.$user_webroot,array('class'=>'color_4'),false,false);?>	
	</p></div>
	<?php }else{?>
	<div id='order_back'>
	<p class="back_home"><?php echo $html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>	
	&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo $html->link($SCLanguages['return'].$SCLanguages['user_center'],$server_host.$user_webroot,array('class'=>'color_4'),false,false);?>	
	</p></div>
	    <?php }?>
    </div>	
    <?php }?>
    <br />
    <p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."succeed02_img.gif":"succeed02_img.gif")?></p>
</div>
<!--您购买的商品End-->