<?php
/*****************************************************************************
 * SV-Cart 广告管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 899 2009-04-22 15:03:02Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增广告","add/",'',false,false);?></strong></p>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist advertisement">
	<li class="ad_name">广告名称<?=$html->image('sort_desc.gif')?></li>
	<li class="ad_position">广告位置</li>
	<li class="type">媒介类型</li>
	<li class="start_time">开始日期</li>
	<li class="end_time">结束日期</li>
	<li class="click">点击次数</li>
	<li class="order">生成订单</li>
	<li class="hadle">操作</li>
	</ul>
<!--Advertisement List-->

<?if(isset($advertisements) && sizeof($advertisements)>0){?>
<? foreach($advertisements as $advertisement){?>
	<ul class="product_llist advertisement advertisement_list">
	<li class="ad_name"><span><strong><?php echo $advertisement['AdvertisementI18n']['name'];?></strong></span></li>
	<li class="ad_position"><span><?php echo $advertisement['AdvertisementI18n']['url'];?></span></li>
	<li class="type"><span><?php echo $advertisement['Advertisement']['media_type'];?></span></li>
	<li class="start_time"><?php echo $advertisement['AdvertisementI18n']['start_time'];?></li>
	<li class="end_time"><?php echo $advertisement['AdvertisementI18n']['end_time'];?></li>
	<li class="click"><?php echo $advertisement['Advertisement']['click_count'];?></li>
	<li class="order"><?php echo $advertisement['Advertisement']['orderby'];?></li>
	<li class="hadle">
	<?php echo $html->link("编辑","/advertisements/edit/{$advertisement['Advertisement']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}advertisements/remove/{$advertisement['Advertisement']['id']}')"));?>
	</li>
	</ul>
<?}?>
<?}?>
<div class="pagers" style="position:relative"><?php echo $this->element('pagers',array('cache'=>'+0 hour'));?></div>
</div>
<!--Main Start End-->
</div>