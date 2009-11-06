<?php 
/*****************************************************************************
 * SV-Cart 货币管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3304 2009-07-24 09:18:00Z zhangshisong $
*****************************************************************************/
?>

<p class="none"><span id="show3">&nbsp;eee</span><span id="show4">&nbsp;</span></p>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>

<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增货币","add",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">

<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th  width="120px">编号</th>
	<th width="140px" >货币名称</th>
	<th>货币代码</th>
	<th width="150px">货币格式</th>
	<th width="110px">汇率</th>
	<th width="80px">是否有效</th>
	<th width="70px" >操作</th>
</tr>
<!--List Start-->
<?php if(isset($currency_list) && sizeof($currency_list)>0){?> 
<?php foreach( $currency_list as $k=>$v ){?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
<td align="center"><?php echo $v["Currency"]["id"]?></td>
<td align="center"><?php echo $v["CurrencyI18n"]["name"]?></td>
<td align="center"><?php echo $v["Currency"]["code"]?></td>
<td align="center"><?php echo $v["CurrencyI18n"]["format"]?></td>
<td align="center"><?php echo $v["Currency"]["rate"]?></td>
<td align="center"><?php if($v["CurrencyI18n"]["status"]==1)echo $html->image('yes.gif',array('align'=>'absmiddle'));else echo $html->image('no.gif',array('align'=>'absmiddle')) ?></td>
<td align="center"><?php echo $html->link("编辑","/currencies/edit/".$v["Currency"]["id"]);?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}currencies/remove/{$v['Currency']['id']}')"));?></td>
</tr>
<?php }}?>
</table></div>
<!--List End-->
<div class="pagers" style="position:relative">
<?php //echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>

</div>
</div>
