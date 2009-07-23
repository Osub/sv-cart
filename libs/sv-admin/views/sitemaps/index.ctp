<?php 
/*****************************************************************************
 * SV-Cart 站点地图
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($payments);?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增模块","add/",'',false,false);?></strong></p>
<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>模块名称</th>
	<th>URL</th>
	<th>优先级</th>
	<th>周期</li>
	<th>是否有效</th>
	<th>操作</th>
</tr>
<!--Payments List-->
<?php if(isset($sitemaps) && sizeof($sitemaps)>0){?>
<?php foreach($sitemaps as $v){?>
<tr>
	<td><?php echo $v['Sitemap']['name']?></td>
	<td><?php echo $v['Sitemap']['url']?></td>
	<td align="center"><?php echo $v['Sitemap']['orderby']?></td>
	<td align="center"><?php echo $v['Sitemap']['cycle']?></td>
	<td align="center"><?php if ($v['Sitemap']['status'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($v['Sitemap']['status'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?></td>
	<td align="center"><?php echo $html->link("编辑","/sitemaps/edit/{$v['Sitemap']['id']}");?>|<?php echo $html->link("移除","javascript:",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}sitemaps/remove/{$v['Sitemap']['id']}')"));?></li>
</tr>
<?php }}?>		
</table>

<!--Payments List End-->	
<br />
</div>
<!--Main Start End-->
</div>