<?php 
/*****************************************************************************
 * SV-Cart 底部文件
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: footer.ctp 2011 2009-06-04 09:32:52Z shenyunfeng $
*****************************************************************************/
?>
<div id="footer">
<?php if(isset($navigations_footer) && sizeof($navigations_footer)>0){?>
<p class="link">
<?php foreach($navigations_footer as $k => $navigation){?><?php if($k !=0){?> |　<?php }?><?php echo $html->link($navigation['NavigationI18n']['name'],$navigation['NavigationI18n']['url'],"",false,false);?>
<?php }?></p><?php }?>
<p><font face="Arial">&copy;</font>2009 <?php printf($SCLanguages['copyright'],$SVConfigs['shop_name']);?></p>
<p>
<?php if(isset($SVConfigs['memory_useage']) && $SVConfigs['memory_useage']=="1"){?>
	<?php echo($SCLanguages['memory']." ".$memory_useage);?>MB
	<?php } ?>
	 Gzip <?echo (isset($gzip_is_start) && $gzip_is_start == 1)?$SCLanguages['enabled']:$SCLanguages['unused'];?> 
	<?if($SVConfigs['icp_number'] !=""){?>
 	<?php echo $SVConfigs['icp_number'];?>
 	<?}?>	 		
<?php echo $html->link(" <span class='number'>Powered by SV-Cart</span>","http://www.seevia.cn",array("target"=>"_blank"),false,false);?>
</p>

<?php echo $SVConfigs['statistic_code']?>
<?php echo $SVConfigs['service_code']?>
</div>