<?php 
/*****************************************************************************
 * SV-Cart 编辑广告
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: show.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<html><head>
<meta http-equiv="Content-type" content="text/html; charset=gb2312">
<title>广告</title>
</head>
<body bgcolor=#ffffff topmargin=0 marginheight=0 leftmargin=0 marginwidth=0>
<?php if(isset($advertisement) && $advertisement['Advertisement']['is_showimg']=='1'&& !empty($advertisement['AdvertisementI18n']['img01'])){?>
	<?php echo $html->link($html->image($advertisement['AdvertisementI18n']['img01']),$advertisement['AdvertisementI18n']['url'],array("target"=>"_blank"),false,false);?>

<?php }?>
</center>
</body></html>