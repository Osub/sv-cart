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
 * $Id: index.ctp 2649 2009-07-07 09:07:22Z wuchao $
*****************************************************************************/
?>
<?php //pr($advertisements);?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增广告","add/",'',false,false);?></strong></p>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>广告名称</th>
	<th>广告位置</th>
	<th>媒介类型</th>
	<th>开始日期</th>
	<th>结束日期</th>
	<th>点击次数</th>
	<th>排序</th>
	<th>操作</th>
</tr>
<!--Advertisement List-->

<?php if(isset($advertisements) && sizeof($advertisements)>0){?>
<?php foreach($advertisements as $advertisement){?>
<tr>
	<td><?php echo $advertisement['AdvertisementI18n']['name'];?></td>
	<td><?php echo $advertisement['AdvertisementPosition']['name'];?></td>
	<td align="center">
		<?php if($advertisement['Advertisement']['media_type']==0) echo "图片"; ?>
		<?php if($advertisement['Advertisement']['media_type']==1) echo "Flash"; ?>
		<?php if($advertisement['Advertisement']['media_type']==2) echo "代码"; ?>
		<?php if($advertisement['Advertisement']['media_type']==3) echo "文字"; ?>
	</td>
	<td align="center"><?php echo $advertisement['AdvertisementI18n']['start_time'];?></td>
	<td align="center"><?php echo $advertisement['AdvertisementI18n']['end_time'];?></td>
	<td align="center"><?php echo $advertisement['Advertisement']['click_count'];?></td>
	<td align="center"><?php echo $advertisement['Advertisement']['orderby'];?></td>
	<td align="center">
	<?php echo $html->link("编辑","/advertisements/edit/{$advertisement['Advertisement']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}advertisements/remove/{$advertisement['Advertisement']['id']}')"));?>
	</td>
</tr>
<?php }?>
<?php }?>
</table>
<div class="pagers" style="position:relative"><?php echo $this->element('pagers',array('cache'=>'+0 hour'));?></div>
</div>
<!--Main Start End-->
</div>