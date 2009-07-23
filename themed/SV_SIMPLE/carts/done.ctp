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
 * $Id: done.ctp 2989 2009-07-17 02:03:04Z huangbo $
*****************************************************************************/
?>
<div class="content">
    <!--您购买的商品-->
	<div class="tips">
	<h4><?php echo $SCLanguages['current_location_system_remind']?></h4>
	<p>
	<?php if(isset($fail)){?>
	<br /><br /><br />
	<p class="succeed">
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."warning_img.gif":"warning_img.gif",array("alt"=>$SCLanguages['order_generated'].$SCLanguages['failed']))?>
	<b class="succeed"><?php echo $SCLanguages['order_generated'].$SCLanguages['failed']?></b></p>
	<?php if(isset($error_arr)){?>
	<p class="succeed">
	<?php echo $SCLanguages['notice'];?>：
	
	<?php if(sizeof($error_arr)>0){?>	
		<?php foreach($error_arr as $error){?>
			<?php echo $error?>
		<?php }?>
	<?php }?>
	</p>
	<?php }?>
	<br />
	<p class="back_home"><span style="font-size:14px">
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['previous'].$SCLanguages['page'],"/carts/",array('class'=>'color_4'),false,false);?>
	</span>&nbsp;&nbsp;
	<span style="font-size:14px">
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>	
	</span>&nbsp;&nbsp;
    <span style="font-size:14px">
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['user_center'],$server_host.$user_webroot,array('class'=>'color_4'),false,false);?>	
    </span></p>
	<?php }else{?>
    <br /><br /><br />
    <p class="succeed"> 
    <?php echo $html->image(isset($img_style_url)?$img_style_url."/"."icon-10.gif":"icon-10.gif",array("align"=>"middle","alt"=>$SCLanguages['order_generated'].$SCLanguages['successfully']))?>
    <?php echo $html->link($order_code,$server_host.$user_webroot.'orders/'.$order_id,array("target"=>"_blank"),false,false)?>
    <b><?php echo $SCLanguages['order_generated'].$SCLanguages['successfully'];?></b><br/><br/>
   <?php if(isset($is_show_virtual_msg) && $is_show_virtual_msg == 1){?>
     <b>	<?php echo $SCLanguages['no_stock']?>,<?php echo $SCLanguages['send_after_products_arrived']?> <b>
    <?php }?></p>
    <p class="back_home">
	<?php if(isset($pay_message)){?>
	<?php echo $pay_message;?>
		<br />
	<div id='order_back'>
	<p class="back_home"><span style="font-size:14px">	<?php echo $html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>	
	&nbsp;&nbsp;&nbsp;&nbsp;
    <?php echo $html->link($SCLanguages['return'].$SCLanguages['user_center'],$server_host.$user_webroot,array('class'=>'color_4'),false,false);?>	
</span></p></div>
	<?php }elseif(isset($pay_button)){?>
	<br />
	<p class="back_home"><input type="button" style="font-size:15px;width:140;height:50" onclick="window.open('<?php echo $pay_button; ?>')" value="<?php echo $SCLanguages['alipay_pay_immedia']?>" /></p><br /><br />
	<div id='order_back'>
	<p class="back_home"><span style="font-size:14px">	<?php echo $html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>	
	&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo $html->link($SCLanguages['return'].$SCLanguages['user_center'],$server_host.$user_webroot,array('class'=>'color_4'),false,false);?>	
</span></p></div>
	<?php }elseif(isset($pay_form)){?>
	<br />
	<?php echo $pay_form;?>
	<div id='order_back'>
	<p class="back_home"><span style="font-size:14px">	<?php echo $html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>	
	&nbsp;&nbsp;&nbsp;&nbsp;
    <?php echo $html->link($SCLanguages['return'].$SCLanguages['user_center'],$server_host.$user_webroot,array('class'=>'color_4'),false,false);?>	
	</span></p></div>
	<?php }else{?>
	<div id='order_back'>
	<p class="back_home"><span style="font-size:14px">	<?php echo $html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>	
	&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo $html->link($SCLanguages['return'].$SCLanguages['user_center'],$server_host.$user_webroot,array('class'=>'color_4'),false,false);?>	
	</span></p></div>
	    <?php }?>
    <?php }?>
    </p>	
    <br />
    <p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."succeed02_img.gif":"succeed02_img.gif")?></p></p>
</div>
</div>
<!--您购买的商品End-->