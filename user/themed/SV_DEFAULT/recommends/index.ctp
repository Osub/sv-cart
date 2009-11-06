<?php 
/*****************************************************************************
 * SV-Cart 我的优惠券页
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1166 2009-04-30 14:05:59Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?><div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['my_recommend']?></b></h1>
     	<table cellpadding="5" cellspacing="1"  class="table_data" width="100%" style="margin-top:4px;">
        	<tr class="head">
			<td><strong><?php echo $SCLanguages['separation_details']?></strong></td>
			</tr>
			<tr class="rows">
    		<td width="35%"><?php echo $SCLanguages['carry_out_registration_separation_activities']?></td>
    		</tr>
			<tr class="rows">
    		<td width="35%"><?php echo $SCLanguages['separation_activities_process_1']?></td>
    		</tr>
			<tr class="rows">
    		<td width="35%"><?php echo $SCLanguages['separation_activities_process_2']?></td>
    		</tr>
			<tr class="rows">
    		<td width="35%"><?php printf($SCLanguages['separation_activities_process_3'],$affiliate_setting['expire'],$affiliate_setting['level_register_all'],$affiliate_setting['level_register_up']);?></td>
    		</tr>    			
			<tr class="rows">
    		<td width="35%"><?php printf($SCLanguages['separation_activities_process_4'],$affiliate_setting['level_money_all'],$affiliate_setting['level_point_all'])?></td>
    		</tr>        			
			<tr class="rows">
    		<td width="35%"><?php echo $SCLanguages['separation_activities_process_5']?></td>
    		</tr>        			
			<tr class="rows">
    		<td width="35%"><?php echo $SCLanguages['separation_activities_process_6']?></td>
    		</tr>        			
			</table>
<div class="height_4">&nbsp;</div>
        	<table cellpadding="5" cellspacing="1" class="table_data" width="100%">
        	<tr class="head">
			<td colspan="5"><strong><?php echo $SCLanguages['recommend_members']?></strong></td>
			</tr>
			<tr class="rows">
			<td width="15%"><?php echo $SCLanguages['grade']?></td>
			<td width="35%"><?php echo $SCLanguages['number_of_people']?></td>
    		<td width="15%"><?php echo $SCLanguages['percentage_of_point_separation']?></td>
    		<td width="35%"><?php echo $SCLanguages['percentage_of_cash_separation']?></td>
    		</tr>
			<?php 
				if(isset($affiliate_list) && sizeof($affiliate_list)>0){
					foreach($affiliate_list as $k=>$v){
			?>
					
					<tr class="rows">
					<td width="15%"><?php echo $k;?></td>
					<td width="35%"><?php echo $v['num'];?></td>
		    		<td width="15%"><?php echo $v['point'];?></td>
		    		<td width="35%"><?php echo $v['money'];?></td>
		    		</tr>					
			<?php 	}
				}
			?>
			</table>
    		<?php if(isset($user_affiliate) && sizeof($user_affiliate)>0){?>
        	<table cellpadding="5" cellspacing="1" class="table_data" width="100%">
        	<tr class="head">
			<td colspan="5"><strong><?php echo $SCLanguages['separation_rules']?></strong></td>
			</tr>
			<tr class="rows">
			<td width="20%"><?php echo $SCLanguages['order']?><?php echo $SCLanguages['code']?></td>
			<td width="20%"><?php echo $SCLanguages['cash_separation']?></td>
    		<td width="20%"><?php echo $SCLanguages['points_separation']?></td>
    		<td width="20%"><?php echo $SCLanguages['separation_model']?></td>
    		<td width="20%"><?php echo $SCLanguages['separation_status']?></td>
    		</tr>
    			<?php foreach($user_affiliate as $k=>$v){?>
    				<?php if(isset($order_list[$v['AffiliateLog']['order_id']])){?>
						<tr class="rows">
						<td width="20%"><?php echo $order_list[$v['AffiliateLog']['order_id']]['Order']['order_code']?></td>
						<td width="20%"><?php echo ($v['AffiliateLog']['money'] >0)?$v['AffiliateLog']['money']:'';?></td>
			    		<td width="20%"><?php echo ($v['AffiliateLog']['point'] >0)?$v['AffiliateLog']['point']:'';?></td>
			    		<td width="20%"><?php echo $systemresource_info['separate_type'][$v['AffiliateLog']['separate_type']]?></td>
			    		<td width="20%">
			    			<?php if($order_list[$v['AffiliateLog']['order_id']]['Order']['is_separate'] == 0){?>
			    				<?php echo $SCLanguages['waitting_for_check']?>
			    			<?php }elseif($order_list[$v['AffiliateLog']['order_id']]['Order']['is_separate'] == 1){?>
			    				<?php echo $SCLanguages['separated']?>
			    			<?php }?>
			    		</td>
			    		</tr>    				
    				<?php }?>
    			<?php }?>
    				<tr class="rows">
						<td colspan="5"><?php echo $this->element('pagers', array('cache'=>array('time'=> "+0 hour",'key'=>'pages'.$template_style)));?></td>
    				</tr>			
    		</table>
    		<?php }?>
<div class="height_4">&nbsp;</div>
        	<table cellpadding="5" cellspacing="1" class="table_data" width="100%">
        	<tr class="head">
			<td colspan="2"><strong><?php echo $SCLanguages['codes']?></strong></td>
			</tr><?php  $url = $this->data['server_host'].$this->data['cart_webroot'].'commons/save_value_u/'.$_SESSION['User']['User']['id']."/";?>
			<tr class="rows">
			<td width="30%"><?php echo $html->link('SV_CART',$this->data['server_host'].$this->data['cart_webroot']."commons/save_value_u/".$_SESSION['User']['User']['id']."/",array('target'=>'_blank'),false,false);?></td>
			<td width="70%"><input type="text" name="affiliate" size="50" value='<?php echo "<a href=\"".$url."\" >SV_CART</a>" ?>'> <?php echo $SCLanguages['signed_code_in_web_page']?></td>
    		</tr>
			<tr class="rows">
			<td width="30%"><?php echo $html->link($html->image((!empty($this->data['configs']['shop_logo']))?$this->data['configs']['shop_logo']:"logo.gif"),$this->data['server_host'].$this->data['cart_webroot']."commons/save_value_u/".$_SESSION['User']['User']['id']."/",array('target'=>'_blank'),false,false);?></td>
			<td width="70%"><input type="text" name="affiliate" size="50" value='<?php echo "<a href=\"".$url."\" ><img src=\"".$this->data['server_host'].$this->data['user_webroot']."themed/".$template_use."/logo.gif \" /></a>" ?>'> <?php echo $SCLanguages['signed_code_in_web_page']?></td>
    		</tr>    	
			</tr><?php  $url = $this->data['server_host'].$this->data['cart_webroot'].'commons/save_value_u/'.$_SESSION['User']['User']['id']."/";?>
			<tr class="rows">
			<td width="30%"><?php echo $html->link('SV_CART',$this->data['server_host'].$this->data['cart_webroot']."commons/save_value_u/".$_SESSION['User']['User']['id']."/",array('target'=>'_blank'),false,false);?></td>
			<td width="70%"><input type="text" name="affiliate" size="50" value='<?php echo "[url=\"".$url."\" ]SV_CART[/url]" ?>'> <?php echo $SCLanguages['signed_code_in_forum']?></td>
    		</tr>
			<tr class="rows">
			<td width="30%"><?php echo $html->link($html->image((!empty($this->data['configs']['shop_logo']))?$this->data['configs']['shop_logo']:"logo.gif"),$this->data['server_host'].$this->data['cart_webroot']."commons/save_value_u/".$_SESSION['User']['User']['id']."/",array('target'=>'_blank'),false,false);?></td>
			<td width="70%"><input type="text" name="affiliate" size="50" value='<?php echo "[url=".$url." ][img]".$this->data['server_host'].$this->data['user_webroot']."themed/".$template_use."/logo.gif [/img][/url]" ?>'> <?php echo $SCLanguages['signed_code_in_forum']?></td>
    		</tr>     			
    		</table>				


<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>
