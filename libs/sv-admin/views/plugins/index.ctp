<?php 
/*****************************************************************************
 * SV-Cart 插件管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3214 2009-07-22 09:06:32Z huangbo $
*****************************************************************************/
?>

<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle')).'新增插件','/plugins/add',array(),false,false);?></strong></p>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>插件名称</th>
	<th>插件描述</th>
	<th>作者</th>
	<th>插件版本</th>
	<th>版权信息</th>
	<th>是否有效</th>
	<th>操作</th>
</tr>
<!--Products Processing List-->
<?php if(isset($plugin_list) && sizeof($plugin_list)>0){?>
<?php foreach($plugin_list as $v){?>
<tr>
	<td><?php echo $v["name"]?></td>
	<td><?php echo $v["directory"]?></td>
	<td><?php echo $v["author"]?></td>
	<td align="center"><?php echo $v["version"]?></td>
	<td><?php echo $v["copyright"]?></td>
	<td align="center"><?php if($v["status"]==1)echo $html->image('yes.gif',array('align'=>'absmiddle'));else echo $html->image('no.gif',array('align'=>'absmiddle')) ?></td>
	<td align="center">
	<?php if($v["status"] == "0"){ echo $html->link("安装","install/".$v["plugin_randme"]);echo " | ".$html->link("移除","delete_plugin/".$v["plugin_randme"]);}?>
	<?php if($v["status"] == "1"){ 
		echo $html->link("卸载","uninstall/".$v["plugin_randme"]);
		$v["operation"] = isset($v["operation"])?$v["operation"]:array();
	foreach( $v["operation"] as $kk=>$vv){
		echo " | ".$html->link($kk,$vv,array("target"=>"_blank"));
	}
	
	}?>
	
	</td></tr>
<?php }}?>
</table>
<!--Products Processing List End-->
<div class="pagers" style="position:relative">
<?php //echo $this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
</div>
	
<!--Main Start End-->
</div>