<?php 
/*****************************************************************************
 * SV-Cart 网站导航
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3949 2009-08-31 07:34:05Z huangbo $
*****************************************************************************/
?>
<div id="globalRight" style="width:926px;margin:0 auto;">
<!--当前位置-->
	<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--End-->
<?php   	if(isset($product_cat) && sizeof($product_cat)>0 ){
?>
    <div id="navigation"><h1 class="headers"><span class="l"></span><span class="r"></span></h1>
    <ul><li><span><b><?php echo $SCLanguages['products'];?><?php echo $SCLanguages['classificatory'];?></b></span></li></ul>
    <div class="list_box">
<!--商品类目-->
<?php 
	   	foreach($product_cat as $key=>$v){ 
 ?>
<div class="sorts">
<h2><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'right_icon02.gif':'right_icon02.gif',array("alt"=>' '))?><span><?php echo $html->link("{$v['CategoryI18n']['name']}","/categories/{$v['Category']['id']}",array(),false,false);?></span></h2>
<p>
<?php 
	 $first=1; 
	 if(isset($v['SubCategory']) && count($v['SubCategory'])>0){
	 foreach($v['SubCategory'] as $k=>$val){
	 	 ?>
	 	 
<?php if(!$first){ ?> <span>|</span><?php }?>
            <?php echo $html->link("{$val['CategoryI18n']['name']}","/categories/{$val['Category']['id']}","",false,false);?>
<?php 
	$first=0;
	}}?>
	</p>
        </div>
<?php }?> 
<!--商品类目end-->
    </div>
</div>
<?php }?>
<?php 		   	if(isset($brands) && sizeof($brands)>0 ){
?>
<div id="navigation"><h1 class="headers"><span class="l"></span><span class="r"></span></h1>
<ul><li><span><b><?php echo $SCLanguages['brand'];?></b></span></li></ul>
    <div class="list_box">
 <!--品牌类目--> 
		<div class="sorts brand_sorts">
		<p>	
		<?php 
		   		$first=1; 
			   	foreach($brands as $key=>$v){ 
		?>
			   <?php if(!$first&&$v){ ?> <span>|</span><?php }?>
			
		<?php 
			   	echo $html->link("{$v['BrandI18n']['name']}","/brands/{$v['Brand']['id']}");
		        $first=0;
		 ?>
		 
		 <?php }?>

		</p>
		</div>
	</div>
</div>
				<?php }?>
<?php   	if(isset($article_cat) && sizeof($article_cat)>0 ){
?>
    <div id="navigation"><h1 class="headers"><span class="l"></span><span class="r"></span></h1>
    <ul><li><span><b><?php echo $SCLanguages['article'];?><?php echo $SCLanguages['classificatory'];?></b></span></li></ul>
    <div class="list_box">
<?php 
	   	foreach($article_cat as $key=>$v){ 
 ?>
    	<div class="sorts">
        	<h2><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'right_icon02.gif':'right_icon02.gif',array("alt"=>' '))?><span>
            <?php echo $html->link("{$v['CategoryI18n']['name']}","/category_articles/{$v['Category']['id']}",array(),false,false);?>
     </span></h2>
     <p>
<?php 
	 $first=1; 
	 if(isset($v['SubCategory']) && count($v['SubCategory'])>0){
	 foreach($v['SubCategory'] as $k=>$val){
	 	 ?>
	 	 
<?php if(!$first){ ?> <span>|</span><?php }?>
            <?php echo $html->link("{$val['CategoryI18n']['name']}","/category_articles/{$val['Category']['id']}","",false,false);?>
<?php 
	$first=0;
	}}?>
	</p>
        </div>
<?php }?> 
       <!--商品类目end-->
    </div>
</div><?php }?>

</div>