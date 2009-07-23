<?php 
/*****************************************************************************
 * SV-Cart 广告位置管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 2796 2009-07-13 07:14:11Z wuchao $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增广告位","add/",'',false,false);?></strong></p>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="30%">广告位名称</th>
	<th width="10%">位置宽度</th>
	<th width="10%">位置高度</th>
	<th width="30%">广告位描述</th>
	<th width="16%">操作</th>
</td>
<!--Advertisement Position List-->
<?php if(isset($advertisement_positions) && sizeof($advertisement_positions)>0){?>
<?php foreach($advertisement_positions as $advertisement_position){?>
<tr>
	<td align="center" width="30%"><?php echo $advertisement_position['AdvertisementPosition']['name'];?></td>
	<td align="center" width="10%"><?php echo $advertisement_position['AdvertisementPosition']['ad_width'];?></td>
	<td align="center" width="10%"><?php echo $advertisement_position['AdvertisementPosition']['ad_height'];?></td>
	<td align="center" width="30%"><?php echo $advertisement_position['AdvertisementPosition']['position_desc'];?></td>
	<td align="center" width="16%">
    <?php echo $html->link("编辑","/advertisement_positions/edit/{$advertisement_position['AdvertisementPosition']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}advertisement_positions/remove/{$advertisement_position['AdvertisementPosition']['id']}')"));?>
	</td>
</tr>
<?php }?>
<?php }?>
</table>
<div class="pagers" style="position:relative"><?php echo $this->element('pagers',array('cache'=>'+0 hour'));?></div>
</div>
<!--Main Start End-->
</div>