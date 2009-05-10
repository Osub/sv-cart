<?php
/*****************************************************************************
 * SV-Cart 帮助中心
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: help.ctp 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
?>
<?php
$navigations_help = $this->requestAction('commons/get_navigations/H'); 

//pr($navigations_help);

//	echo "<pre>";
//	print_r($navigations_help);
if($navigations_help)
{

?>
<div id="category_box" class="brand_box">
<!--帮助中心start-->
	<h3><?=$SCLanguages['help_center']?></h3>
	<div class="category Help">
		<ul>

<?if(isset($navigations_help) && sizeof($navigations_help)>0 ){?>
<?php foreach($navigations_help as $key=>$helps){ ?>
	<li><?=$html->image('ico_28.gif',array("alt"=>"SV-Cart"));?><?=$html->link($helps['NavigationI18n']['name']." <font face='宋体'>&gt;&gt;</font>","/../".$helps['NavigationI18n']['url'],"",false,false);?>
	</li>
<?}?>
<?}?>
		</ul>
	</div>
	<?=$html->link($html->image('category_ulbt.gif',array("alt"=>"SV-Cart","align"=>"absbottom")),"/","",false,false);?>
</div>
<!--帮助中心End-->

<?
}
?>
