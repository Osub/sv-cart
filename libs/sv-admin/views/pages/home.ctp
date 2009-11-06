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
 * $Id: home.ctp 5382 2009-10-23 03:59:18Z huangbo $
*****************************************************************************/
?>
<?php echo $minify->css(array('/css/Charts'));?>
<?php echo $javascript->link('FusionCharts');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div class="home_main" style="padding:1px;">
	<div class="home_box">
	<div class="main_left order_stat">
	<h1>七日成交额统计</h1>
    	<span id="chartdiv" style="overflow-y:auto;"></span>
      	<script type="text/javascript">
		   var chart = new FusionCharts(admin_webroot+"capability/Charts/FCF_Column2D.swf", "ChartId", "400", "250","10");
		   chart.setDataURL(admin_webroot+"capability/Data/Column2D.xml");
		   chart.addParam("wmode","Opaque");
		   chart.render("chartdiv");
		</script>
<!--Aticle List-->
		<h1>官方信息</h1>
		<div class="article_list">
	      <div class="article_box">
		    <div class="hdblock3_c" id="hdblock3_c21" style="display:block;">
	        <ul class="list" style='border:none'>
	          <span id="rss_load"></span>
			</ul>
		    </div>
		  </div>
	    </div>
<!--Aticle List End-->
	</div>
	
	<div class="main_right">
<!--Order Stat-->
	<div class="order_stat">
	<h1>待处理事务</h1>
	  <div class="box">
  	    <ul class="list">
			<li><span class="number"><strong><u><font color="red"><?php echo $wait_shipments_order_count?></font></u></strong>条</span><?php echo $html->link("待发货订单","/reports/shipments",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="#192E32"><?php echo $wait_pay_order_count?></font>条</span><?php echo $html->link("待支付订单","/orders/index?no_payment_status=1",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="#192E32"><?php echo $order_oos_count?></font>条</span><?php echo $html->link("订单缺货登记","/products/search/wanted",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="#192E32"><?php echo $not_confirm_order_count?></font>条</span><?php echo $html->link("未确认订单","/orders/index?order_status=0",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="#192E32"><?php echo $order_complete_count?></font>条</span><?php echo $html->link("已成交订单数","/orders/index?payment_status=2",array("target"=>"_blank"),false,false);?></li>
		</ul>
  	    <ul class="list list_2">
			<li><span class="number"><font color="#192E32"><?php echo $usermessage_complete_count?></font></span><?php echo $html->link("未回复商品咨询","/messages",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="#192E32"><?php echo $usermessage_order_complete_count?></font></span><?php echo $html->link("未查看订单留言","/messages",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="#192E32"><?php echo $usermessage_all_complete_count?></font></span><?php echo $html->link("未回复客户留言","/messages",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="#192E32"><?php echo $users_did_not_view_the_album?></font></span><?php echo $html->link("未查看用户相册","/user_product_galleries",array("target"=>"_blank"),false,false);?></li>
		</ul>
	  </div>
	  	
	</div>
<!--Order Stat End-->
<!--Order Stat-->
	<div class="order_stat">
	<h1>近两日业务量</h1>
	  <div class="box">
  	    <ul class="list">
			<li><span class="number"><strong><font color="red"><?php echo $this_order_complete_count?></font></strong>条</span><?php echo $html->link("今日成交订单","/orders/index?date=".date("Y-m-d")."&payment_status=2",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><strong><font color="red"><?php echo sprintf("%01.2f",$this_order_total);?></font></strong></span><?php echo $html->link("今日订单金额","/orders/index?date=".date("Y-m-d"),array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><strong><font color="red"><?php echo sprintf("%01.2f",$orderproduct_info);?></font></strong></span><?php echo $html->link("今日销售利润","/orders/index?date=".date("Y-m-d"),array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><strong><font color="red"><?php echo $this_user_count?></font></strong>位</span><?php echo $html->link("今日新增会员","/users/index?date=".date("Y-m-d"),array("target"=>"_blank"),false,false);?></li>
		</ul>
  	    <ul class="list list_2">
  	    	<li><span class="number"><font color="#192E32"><?php echo sprintf("%01.2f",$orderproduct_info1);?></font></span><?php echo $html->link("昨日销售利润","/orders/index?date=".date("Y-m-d",time()-24*60*60),array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="#192E32"><?php echo $this_order_complete_count1?></font>条</span><?php echo $html->link("昨日成交订单","/orders/index?date=".date("Y-m-d",time()-24*60*60)."&payment_status=2",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="#192E32"><?php echo sprintf("%01.2f",$this_order_total1);?></font></span><?php echo $html->link("昨日订单金额","/orders/index?date=".date("Y-m-d",time()-24*60*60),array("target"=>"_blank"),false,false);?></li>

		</ul>
	  </div>
	  	
	</div>
<!--Order Stat End-->

<!--product Stat-->
	<div class="order_stat">
	  <h1>实体商品统计信息</h1>
	  <div class="box">
  	    <ul class="list">
			<li><span class="number"><font color="#192E32"><?php echo $product_count?></font></span><?php echo $html->link("商品总数","/products/",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="#192E32"><?php echo $product_and_product_count?></font></span><?php echo $html->link("商品","/products/",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="#192E32"><?php echo $product_and_download_product_count?></font></span><?php echo $html->link("下载","/product_downloads/",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="#192E32"><?php echo $product_and_services_product_count?></font></span><?php echo $html->link("服务","/product_services/",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="#192E32"><?php echo $product_and_virtual_card_count?></font></span><?php echo $html->link("虚拟卡","/virtual_cards/",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="#192E32"><?php echo $product_and_recommend_count?></font></span><?php echo $html->link("商品推荐数","/products/index?is_recommond=1",array("target"=>"_blank"),false,false);?></li>
		</ul>
  	    <ul class="list list_2">
			<li><span class="number"><font color="#192E32"><?php echo $product_and_warn_quantity_count?></font></span><?php echo $html->link("库存警告商品数","/warn_quantity_products/",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="#192E32"><?php echo $product_and_forsale_count?></font></span><?php echo $html->link("促销商品数","/products/?promotion_status=1",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="red"><strong><?php echo $product_count_forsale?></strong></font>件</span><?php echo $html->link("出售中的商品","/products/",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="red"><strong><?php echo $product_and_trash_count?></strong></font>件</span><?php echo $html->link("回收站商品","/trash/",array("target"=>"_blank"),false,false);?></li>
			<li><span class="number"><font color="#6DCD6C"><strong><?php echo $SVConfigs['version']?></strong></font></span>当前版本</li>
		</ul>
	  </div>
	</div>
<!--product Stat End-->
	</div>
	<p class="clear">&nbsp;</p>
		<h1>官方推荐文章</h1>
		<div class="article_list recommend" style="width:836px;padding-right:8px;">
	      <div class="article_box">
		    <div class="hdblock3_c" id="hdblock3_c21" style="display:block;">
	        <ul class="list listLeft" style='border:none;' id="rss_recommend_article_load">
			</ul>
		    </div>
		  </div>
	    </div>
	<p class="clear">&nbsp;</p>&nbsp;
	</div>
</div>
</div>
<script type="text/javascript">
function rss_load(){
	var urlimg = webroot_dir+"pages/rss_str/";
	YAHOO.util.Connect.asyncRequest('POST', urlimg, rss_load_callback);
}
var rss_load_img_Success = function(oResponse){
	var oResults = eval("(" + oResponse.responseText + ")");
	var rss_load = document.getElementById('rss_load'); 
	rss_load.innerHTML = "";
	var url_str = "";
	for( var i=0;i<oResults.length;i++){
		if(oResults.length-1==i){
			url_str+="<li style='border:none'><span>"+oResults[i]+"</span></li>";
		}else{
			url_str+="<li><span>"+oResults[i]+"</span></li>";
		}
	}
	rss_load.innerHTML = url_str;
	//alert(oResponse.responseText);
}

var rss_load_img_Failure = function(o){
	//alert("异步请求失败");
}

var rss_load_callback ={
	success:rss_load_img_Success,
	failure:rss_load_img_Failure,
	timeout : 3000000,
	argument: {}
};		
rss_load();

function rss_recommend_article_load(){
	var urlimg = webroot_dir+"pages/rss_recommend_article/";
	YAHOO.util.Connect.asyncRequest('POST', urlimg, rss_recommend_article_load_callback);
}
var rss_recommend_article_load_img_Success = function(oResponse){
	var rss_recommend_article_load = document.getElementById('rss_recommend_article_load'); 
	rss_recommend_article_load.innerHTML = oResponse.responseText;
}

var rss_recommend_article_load_img_Failure = function(o){
	//alert("异步请求失败");
}

var rss_recommend_article_load_callback ={
	success:rss_recommend_article_load_img_Success,
	failure:rss_recommend_article_load_img_Failure,
	timeout : 3000000,
	argument: {}
};		
rss_recommend_article_load();

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

</script>


