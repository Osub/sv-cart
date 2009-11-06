<?php 
/*****************************************************************************
 * SV-Cart 会员整合
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3673 2009-08-17 09:57:45Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations',$navigations));//pr($promotions);?>

<!--Main Start-->
<br />
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="6%">编号</th>
	<th>名称</th>
	<th>版本</th>
	<th>作者</th>
	<th>地址</th>
	<th width="8%">操作</th></tr>
<!--Promotions List-->
<?php $i=1;foreach( $modules as $k=>$v ){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td align="center"><?php echo $i?></td>
	<td align="center"><span><strong><?php echo $v['name']?></strong></span></td>
	<td align="center"><?php echo $v['version']?></td>
	<td align="center"><?php echo $v['author']?></td>
	<td align="center"><?php echo $v['website']?></td>
	<td align="center">

	<?php if($integrate_code!="ucenter"){?><?php echo $html->link("安装",$v['install']);?><?php }else{?><?php echo $html->link("设置",$v['setup']);?>|<?php echo $html->link("积分兑换设置",$v['points_set']);?><?php }?>
	</td></tr>	
<?php $i++;}?></table></div>
<!--Promotions List End-->	
  <div class="pagers" style="position:relative">
</div>
</div>
<!--Main Start End-->
</div>