<?php 
/*****************************************************************************
 * SV-Cart 编辑支付方式
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 4728 2009-09-29 03:50:40Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php  echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<?php echo $javascript->link('product');?>
<!--Main Start-->
<br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."支付方式列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>

<div class="home_main">
		
		
<?php echo $form->create('Payment',array('action'=>'edit/'.$payment['Payment']['id'],'onsubmit'=>'return payments_check()'));?>
	
	<input type="hidden" name="data[Payment][id]" value="<?php echo $payment['Payment']['id']?>"/>

	<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos department_config">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑支付方式</h1></div>
	  <div class="box" style="table-layout:fixed">
	  <br />
	    
  	    <dl><strong style="table-layout:fixed"> 支付方式名称:</strong>
			<dd></dd></dl>

<?php if(isset($languages) && sizeof($languages)>0){
 	foreach ($languages as $k => $v){?>
		 <dl><dt class="config_lang"><?php echo $html->image($v['Language']['img01'])?></dt>
			<dd><input type="text"  class="text_inputs" style="width:195px;" id="name<?php echo $v['Language']['locale']?>" name="data[PaymentI18n][<?php echo $k?>][name]" <?php if(isset($payment['PaymentI18n'][$v['Language']['locale']])){?>value="<?php echo  $payment['PaymentI18n'][$v['Language']['locale']]['name'];?>"<?php }else{?>value=""<?php }?>/> <font color="#ff0000">*</font></dd></dl>
<?php 
	}
}?>	
		

<dl><dt> 是否有效:</dt>
			<dd></dd></dl>
<?php if(isset($languages) && sizeof($languages)>0){
 	foreach ($languages as $k => $v){?>
		 <dl><dt class="config_lang"><?php echo $html->image($v['Language']['img01'])?></dt>
			<dd><input type="radio" name="data[PaymentI18n][<?php echo $k?>][status]"   value="1" <?php if( $payment['PaymentI18n'][$v['Language']['locale']]['status'] == 1 ){ echo "checked"; }  ?> /> 是 <input type="radio" name="data[PaymentI18n][<?php echo $k?>][status]" value="0" <?php if( $payment['PaymentI18n'][$v['Language']['locale']]['status'] == 0 ){ echo "checked"; }  ?> /> 否<font color="#ff0000">*</font></dd></dl>
<?php 
	}
}?>	
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="PaymentI18n<?php echo $k;?>Locale" name="data[PaymentI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
	   <?php if(isset($payment['PaymentI18n'][$v['Language']['locale']])){?>
	<input id="PaymentI18n<?php echo $k;?>Id" name="data[PaymentI18n][<?php echo $k;?>][id]" type="hidden" value="<?php echo  $payment['PaymentI18n'][$v['Language']['locale']]['id'];?>">
	   <?php }?>
	   	<input id="PaymentI18n<?php echo $k;?>PaymentId" name="data[PaymentI18n][<?php echo $k;?>][payment_id]" type="hidden" value="<?php echo  $payment['Payment']['id'];?>">
<?php 
	}
}?>

	
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Password-->
	<div class="order_stat athe_infos">
	  
	  <div class="box">
		<br />
		  <dl><dt>支付手续费：</dt>
			<dd><input type="text"  class="text_inputs" style="width:160px;" name="data[Payment][fee]" value="<?php echo $payment['Payment']['fee'] ?>"  /> </dd></dl>
		 <dl><dt class="config_lang">订单是否可用:</dt>
			<dd><input type="radio" name="data[Payment][order_use_flag]"   value="1" <?php if( $payment['Payment']['order_use_flag'] == 1 ){ echo "checked"; }  ?> />是<input type="radio" name="data[Payment][order_use_flag]" value="0" <?php if( $payment['Payment']['order_use_flag'] == 0 ){ echo "checked"; }  ?> />否<font color="#ff0000">*</font></dd></dl>
		 <dl><dt class="config_lang">充值是否可用:</dt>
			<dd><input type="radio" name="data[Payment][supply_use_flag]"   value="1" <?php if( $payment['Payment']['supply_use_flag'] == 1 ){ echo "checked"; }  ?> />是<input type="radio" name="data[Payment][supply_use_flag]" value="0" <?php if( $payment['Payment']['supply_use_flag'] == 0 ){ echo "checked"; }  ?> />否<font color="#ff0000">*</font></dd></dl>

		<dl><dt>货到付款?</dt>
			<dd><input type="radio" name="data[Payment][is_cod]" value="1" <?php if( $payment['Payment']['is_cod'] == 1 ){ echo "checked"; }  ?> />是<input type="radio" name="data[Payment][is_cod]" value="0" <?php if( $payment['Payment']['is_cod'] == 0 ){ echo "checked"; }  ?> />否</dd></dl>
		
		<dl><dt>在线支付?</dt>
			<dd><input type="radio" name="data[Payment][is_online]" value="1" <?php if( $payment['Payment']['is_online'] == 1 ){ echo "checked"; }  ?> />是<input type="radio" name="data[Payment][is_online]" value="0" <?php if( $payment['Payment']['is_online'] == 0 ){ echo "checked"; }  ?> />否</dd></dl>
			<?php if(isset($payment_arr) && count($payment_arr)>0){?>
	
			<?php foreach($payment_arr as $k=>$v){?>
				<dl><dt><?php echo $v['name']?>:</dt>
				<dd>
				<?php if($v['type'] == "select_currency" && isset($currency_list) && sizeof($currency_list)>0 && isset($currency_locale)){?>
					<select  name="payment_arr[<?php echo $k?>][value]">
					<option value="" <?php if(isset($v['value']) && $v['value'] == ""){?>selected<?php }?>>请选择</option>
					<?php foreach($currency_list as $cc=>$gg){?>
						<?php if($gg['CurrencyI18n']['locale'] == $currency_locale){?>
						<option value="<?php echo $gg['Currency']['code']?>" <?php if(isset($v['value']) && $gg['Currency']['code'] == $v['value']){?>selected<?php }?>><?php echo $gg['CurrencyI18n']['name']?></option>
						<?php }?>
					<?php }?>
					</select>
				<?php }?>
				<?php if(@$v['type']=="text"){?>
				<input type="text"  class="text_inputs" style="width:350px;" name="payment_arr[<?php echo $k?>][value]" <?php if(isset($v['value'])){?>value="<?php echo  $v['value'];?>"<?php }else{?>value=""<?php }?>/>
				<?php }?>
				<?php if(@$v['type']=="select"){?>
				<select name="payment_arr[<?php echo $k?>][value]">
				<?php  $num = 0;
				if(isset($v['select_value']) && sizeof($v['select_value'])>0){
					foreach($v['select_value'] as $kk=>$vv){?>
				<?php if(isset($v['value']) && $v['value'] == $vv){?>
				<option value="<?php echo $vv?>" selected>
				<?php }else{?>
				<option value="<?php echo $vv?>">
				<?php }?>
					<?php echo $kk?></option>
				<?php }}?>
				</select>
					
				<?php 
				if(isset($v['select_value']) && sizeof($v['select_value'])>0){
					foreach($v['select_value'] as $kk=>$vv){?>
					<?php $num++;?>
				<input type="hidden"  class="text_inputs" style="width:350px;" name="payment_arr[<?php echo $k?>][select_value][<?php echo $num?>][name]" value="<?php echo $kk?>"/>
				<input type="hidden"  class="text_inputs" style="width:350px;" name="payment_arr[<?php echo $k?>][select_value][<?php echo $num?>][value]" value="<?php echo $vv?>"/>				
				<?php }}?>
				<?php }?>
				<?php if(@$v['type']=="all_select"){?>
				<?php foreach($v['value'] as $kkk=>$vvv){?>
				</dl><dl><dt>	&nbsp; <?php echo $vvv['name']?>:  </dt><dd>
							<select name="payment_arr[<?php echo $k?>][sub][<?php echo $kkk?>][value]">
							<?php  $num = 0;
							if(isset($vvv['select_value']) && sizeof($vvv['select_value'])>0){
								foreach($vvv['select_value'] as $a=>$b){?>
							<?php if(isset($vvv['value']) && $vvv['value'] == $b){?>
							<option value="<?php echo $b?>" selected>
							<?php }else{?>
							<option value="<?php echo $b?>">
							<?php }?>
								<?php echo $a?></option>
							<?php }}?>
							</select></dd></dl>
				<input type="hidden"  class="text_inputs" style="width:350px;" name="payment_arr[<?php echo $k?>][sub][<?php echo $kkk?>][name]" value="<?php echo  $vvv['name'];?>"/>
					<?php }?>
				<?php }?>					
				<input type="hidden"  class="text_inputs" style="width:350px;" name="payment_arr[<?php echo $k?>][name]" <?php if(isset($v['name'])){?>value="<?php echo  $v['name'];?>"<?php }else{?>value=""<?php }?>/>
				<input type="hidden"  class="text_inputs" style="width:350px;" name="payment_arr[<?php echo $k?>][type]" <?php if(isset($v['type'])){?>value="<?php echo  $v['type'];?>"<?php }else{?>value=""<?php }?>/>
				</dd></dl>
			<?php }?>
		<?php }?>
		

		
	  </div>
	</div>
<!--Password End-->

</td>
</tr>
<tr><td colspan="2">
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  支付方式描述</h1></div>
	  <div class="box">
		<?php if($SVConfigs["select_editor"]=="2"||empty($SVConfigs["select_editor"])){?>
	  	<?php echo $javascript->link('tinymce/tiny_mce/tiny_mce'); ?>
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		<table><tr><td valign="top">
	  	<?php echo $html->image($v['Language']['img01'])?></td><td valign="top">
		<textarea id="11elm<?php echo $v['Language']['locale'];?>" name="data[PaymentI18n][<?php echo $k;?>][description]" rows="15" cols="80" style="width: 80%"><?php echo $payment['PaymentI18n'][$v["Language"]["locale"]]['description'];?></textarea>
		<?php  echo $tinymce->load("11elm".$v['Language']['locale'],$now_locale); ?><br /></td></tr>
		</table>
    	<?php }?></p>
		<?php }?><?php }?>
		<?php if($SVConfigs["select_editor"]=="1"){?>
			<?php echo $javascript->link('fckeditor/fckeditor'); ?>
		  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		  	<?php echo $html->image($v['Language']['img01'])?><br />
			<p class="profiles">
			<?php  if(isset($article['BrandI18n'][$k]['description'])){?>
	        <?php echo $form->textarea('ArticleI18n/content', array("cols" => "60","rows" => "20",'value'=>"{$payment['PaymentI18n'][$v['Language']['locale']]['description']}","name"=>"data[PaymentI18n][{$k}][description]","id"=>"ArticleI118n{$k}Content"));?>
	        <?php echo $fck->load("ArticleI118n{$k}/content"); ?>
	        
	    	<?php }else{?>
	       	<?php echo $form->textarea('ArticleI18n/content', array('cols' => '60', 'rows' => '20','value'=>"{$payment['PaymentI18n'][$v['Language']['locale']]['description']}","name"=>"data[PaymentI18n][{$k}][description]","id"=>"ArticleI118n{$k}Content"));?> 
	       	<?php echo $fck->load("ArticleI118n{$k}/content"); ?>
	    	<?php }?>
		    </p>
			<br /><br />
			<?php }}?>
		<?php }?>
		</div></div></td></tr>
<tr><td colspan="2"><p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p></td></tr>
</table>

<?php echo $form->end();?>

</div>
<!--Main Start End-->
<?php echo $html->image('content_left.gif',array('class'=>'content_left'))?><?php echo $html->image('content_right.gif',array('class'=>'content_right'))?>
</div>