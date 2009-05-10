<?php
/*****************************************************************************
 * SV-Cart 后台首页
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: home.ctp 1250 2009-05-07 13:59:20Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div class="home_main">
<table class="main_left" width="50%">
<tr>
<td align="left">
<!--Order Stat-->
	<div class="order_stat" style="width:97.5%">
	  <div class="title">
	  <h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  订单统计信息</h1></div>
	  <div class="box" id="l">
  	    <ul class="list">
			<li><span class="number"><font color="red"><?=$wait_shipments_order_count?></font></span><?=$html->link("待发货订单:","/orders/?shipping_status=3",'',false,false);?>&nbsp;</li>
			<li><span class="number"><font color="#192E32"><?=$wait_pay_order_count?></font></span><?=$html->link("待支付订单:","/orders/?payment_status=0",'',false,false);?>&nbsp;</li>
			<li><span class="number"><font color="red"><?=$order_oos_count?></font></span><?=$html->link("订单缺货登记:","/products/search/wanted",'',false,false);?>&nbsp;</li>
			<li><span class="number"><font color="#192E32"><?=$not_confirm_order_count?></font></span><?=$html->link("未确认订单:","/orders/?order_status=0",'',false,false);?>&nbsp;</li>
			<li><span class="number"><font color="#192E32"><?=$order_complete_count?></font></span><?=$html->link("已成交订单数:","/orders/?shipping_status=2",'',false,false);?>&nbsp;</li>
		<!--	<li><span class="number"><font color="red">没做</font></span><a class="" href="#" title="" target="_blank">退款申请:</a>&nbsp;</li>
		-->
		</ul>
	  </div>
	</div>
<!--Order Stat End-->
</td>
<td>
<!--product Stat-->
	<div class="order_stat">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  实体商品统计信息
	  </h1></div>
	  <div class="box" id="m">
  	    <ul class="list">
			<li><span class="number"><font color="#192E32"><?=$product_count?></font></span><?=$html->link("商品总数:","/products",'',false,false);?>&nbsp;</li>
			<li><span class="number"><font color="#192E32"><?=$product_recommend_count?></font></span><?=$html->link("商品推荐数:","/products/?is_recommond=1",'',false,false);?>&nbsp;</li>
		<!--	<li><span class="number"><font color="#192E32">没做</font></span><a class="" href="#" title="" target="_blank">热销商品数:</a>&nbsp;</li>-->
			<li><span class="number"><font color="#192E32"><?=$product_quantity_count?></font></span><?=$html->link("库存警告商品数:","/products/?quantity=3",'',false,false);?>&nbsp;</li>
		<!--	<li><span class="number"><font color="#192E32">没做</font></span><a class="" href="#" title="" target="_blank">精品推荐数:</a>&nbsp;</li>
		--> <li><span class="number"><font color="#192E32"><?=$product_promotion_count?></font></span><?=$html->link("促销商品数:","/products/?promotion_status=1",'',false,false);?>&nbsp;</li>
		</ul>
	  </div>
	</div>
<!--product Stat End-->
</td>
</tr>
<tr>
<td>
<!--Order Stat-->
	<!--<div class="order_stat">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  虚拟卡商品统计</h1></div>
	  <div class="box">
  	    <ul class="list">
			<li><span class="number"><font color="#192E32">0</font></span><a class="" href="#" title="" target="_blank">商品总数:</a>&nbsp;</li>
			<li><span class="number"><font color="#192E32">0</font></span><a class="" href="#" title="" target="_blank">新品推荐数:</a>&nbsp;</li>
			<li><span class="number"><font color="#192E32">0</font></span><a class="" href="#" title="" target="_blank">热销商品数:</a>&nbsp;</li>
			<li><span class="number"><font color="#192E32">0</font></span><a class="" href="#" title="" target="_blank">库存警告商品数:</a>&nbsp;</li>
			<li><span class="number"><font color="#192E32">0</font></span><a class="" href="#" title="" target="_blank">精品推荐数:</a>&nbsp;</li>
			<li><span class="number"><font color="#192E32">0</font></span><a class="" href="#" title="" target="_blank">促销商品数:</a>&nbsp;</li>
		</ul>
	  </div>
	</div>-->
<!--Order Stat End-->
<!--</td>
<td>-->
<!--product Stat-->
	<!--<div class="order_stat">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  访问统计</h1></div>
	  <div class="box">
  	    <ul class="list">
			<li><span class="number"><font color="red">0</font></span><a class="" href="#" title="" target="_blank">今日访问:</a>&nbsp;</li>
			<li><span class="number"><font color="red">0</font></span><a class="" href="#" title="" target="_blank">在线人数:</a>&nbsp;</li>
			<li><span class="number"><font color="red">0</font></span><a class="" href="#" title="" target="_blank">今日访问:</a>&nbsp;</li>
			<li><span class="number"><font color="red">0</font></span><a class="" href="#" title="" target="_blank">在线人数:</a>&nbsp;</li>
			<li><span class="number"><font color="red">0</font></span><a class="" href="#" title="" target="_blank">今日点击:</a>&nbsp;</li>
			<li><span class="number"><font color="red">0</font></span><a class="" href="#" title="" target="_blank">浏览量:</a>&nbsp;</li>
		</ul>
	  </div>
	</div>-->
<!--product Stat End-->
</td>
</tr>
</table>
<table class="main_right" width="50%">
	<tr>
		<td>

<!--Aticle List-->
		<div class="article_list">
	      <div class="box">
	        <ul>
	        <li class="hdblock3_on">
			  文章列表</li>
			  <!--
	          <li class="hdblock3_on" id="hdblock3_t21" onmouseover="show_intro('hdblock3_c2','hdblock3_t2',2,1,'hdblock3')">
			  文章列表</li>
		      <li class="hdblock3_off" id="hdblock3_t22" onmouseover="show_intro('hdblock3_c2','hdblock3_t2',2,2,'hdblock3')">
			  <a href="#">未知</a></li>
			  -->
	        </ul>
	      </div>
	      		
	      <div class="article_box" id="r">
		    <div class="hdblock3_c" id="hdblock3_c21" style="display:block;">
	        <ul class="list">
	        	<?if(isset($rss_str) && sizeof($rss_str)>0){?>
	        	<?foreach( $rss_str as $k=>$v ){?>
					<li>
					<!--
					<span class="title"><a href="#"></a></span>
					-->
					<span>.<?=$v;?></span></li>
				<?}}?>
			</ul>
		    </div>
			
			<div class="hdblock3_c" id="hdblock3_c22" style="display:none;">
	        <ul class="list">
					<li><span class="title"></span><span class="number"></span></li>
		
			</ul>
		    </div>
		  </div>
	    </div>
<!--Aticle List End-->
		</td>
	</tr>
</table>
</div>
</div>
<script type="text/javascript">
/*文章列表的切换Tab
	function show_intro(pre,pree, n, select_n,css) {
	for (i = 1; i <= n; i++) {
	var intro = document.getElementById(pre + i);
	var cha = document.getElementById(pree + i);
	intro.style.display = "none";
	cha.className=css + "_off";
	if (i == select_n) {
	intro.style.display = "block";
	cha.className=css + "_on";
	}
	}
	}
*/
//三栏自动等高
    function autoHeight() {
     if (arguments.length > 1) {
      var x = arguments.length;
      var elements=[];
      for (i=0; i<x; i++) {
       elements.push(document.getElementById(arguments[i]).offsetHeight);
      }
      var max = elements[0];
      for(i=0; i<x; i++) {
       if(max < elements[i]) {
        max = elements[i];
       }
      }
      for (i=0; i<x; i++) {
       document.getElementById(arguments[i]).style.height = max+"px";
      }
     }
    }
window.onload = function() {
autoHeight("r","m","l");//alert(document.getElementById("l").offsetHeight);
}
</script>


