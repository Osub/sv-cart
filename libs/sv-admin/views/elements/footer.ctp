<?php 
/*****************************************************************************
 * SV-Cart 底部
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: footer.ctp 3428 2009-07-31 11:48:18Z huangbo $
*****************************************************************************/
?>
<div id="footer">
	<p class="copyright">© 2009 上海实玮网络科技有限公司 版权所有</p>
	<p class="pwoered"><?php if(isset($SVConfigs['memory_useage'])&&$SVConfigs['memory_useage']=="1"){echo "占用内存 ".$memory_useage." MB";} ?>
	<?php echo round(getMicrotime() - $GLOBALS['TIME_START'], 4) . "s"?>  <?php if(isset($GLOBALS['SQL_TIME']) && isset($GLOBALS['SQL_COUNT'])){echo "(default) ".$GLOBALS['SQL_COUNT']." queries took ".$GLOBALS['SQL_TIME']. "ms";}?>
	 Gzip <?echo (isset($gzip_is_start) && $gzip_is_start == 1)?"已使用":"未使用";?> 
	<?php echo $html->link("Powered by SV-Cart ".$SVConfigs['version'],"http://www.seevia.cn",'',false,false);?></p>
</div>