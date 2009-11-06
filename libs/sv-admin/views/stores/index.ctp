<?php 
/*****************************************************************************
 * SV-Cart 店铺列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3949 2009-08-31 07:34:05Z huangbo $
*****************************************************************************/
?> 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增店铺","add/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">

	
<!--Stores List-->
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
  <tr>
  	<th width="14%" height="31">店铺名称</th><th width="10%">经理人</th><th width="9%">联系电话</th><th width="27%">地址</th><th width="12%">地图</th><th width="16%">交通</th><th width="10%">操作</th></tr>
<?php if(isset($store_list) && sizeof($store_list)>0){?>
<?php foreach($store_list as $k=>$v){?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?>>

  	<td width="14%" align="center"><strong><?php echo $v['StoreI18n']['name'];?></strong></td>
	<td width="10%" align="center"><?php echo $v['Store']['contact_name'];?></td>
	<td width="9%"><?php echo $v['Store']['contact_tele'];?></td>
	<td width="27%"><?php echo $v['StoreI18n']['address'];?></td>
	<td width="12%" align="center"><?php if($v['StoreI18n']['map']!=""){echo $html->image($server_host.$v['StoreI18n']['map']);}?></td>
	<td width="16%"><?php echo $v['StoreI18n']['transport'];?></td>
	<td width="10%" align="center" class="hadle"><span><?php echo $html->link("编辑","/stores/edit/{$v['Store']['id']}");?>
|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}stores/remove/{$v['Store']['id']}')"));?></span></td>
</tr>
<?php }} ?>
</table>
<!--Stores List End-->	
<div class="pagers">
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
<!--Main Start End-->
</div>