<?php 
/*****************************************************************************
 * SV-Cart 分页
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: pagers.ctp 2485 2009-06-30 11:33:00Z huangbo $
*****************************************************************************/
?>
<?php if($paging['page']>0){?>
	<div class="box">
	<span class="block_number">每页显示数:<input type="text" style="width:20px;border:1px solid #649776" value="<?php echo trim($paging['show'])?>" onkeydown="pagers_onkeypress(this,event)" /></span>
	<p class="next">
	<?php if ($paging['page'] > 1){?><a href="?page=1"><?php echo $html->image('next_icon.gif',array('align'=>'absmiddle','class'=>'left'))?>首页</a><?php }else{?><a ><?php echo $html->image('back_icon.gif',array('align'=>'absmiddle','class'=>'left'))?>首页</a><?php }?>
	<?php if ($paging['page'] > 1){?><a href="?page=<?php echo ($paging['page']-1);?>"><?php echo $html->image('next_icon.gif',array('align'=>'absmiddle','class'=>'left'))?>上页</a><?php }else{?><a ><?php echo $html->image('back_icon.gif',array('align'=>'absmiddle','class'=>'left'))?>上页</a>
	<?php }?>
	</p>
	<p class="pages">
	<?php echo $html->image('pages_left.gif',array('align'=>'absmiddle','class'=>'left'))?>
	<?php echo $html->image('pages_right.gif',array('align'=>'absmiddle','class'=>'right'))?>
	<?php 
    if($pagination->setPaging($paging)): 
    //pr($paging);
    $pages = $pagination->pageNumbers("");
    echo "$pages";
    endif;

?> 
</p>
	<p class="next last_page">
	<?php if ($paging['page'] < $paging['pageCount']){?><a href="?page=<?php echo ($paging['page']+1);?>"><?php echo $html->image('next_icon.gif',array('align'=>'absmiddle','class'=>'right'))?>下页</a><?php }else{?><a ><?php echo $html->image('back_icon.gif',array('align'=>'absmiddle','class'=>'right'))?>下页</a><?php }?>
	<?php if ($paging['page'] < $paging['pageCount']){?><a href="?page=<?php echo $paging['pageCount']?>"><?php echo $html->image('next_icon.gif',array('align'=>'absmiddle','class'=>'right'))?>末页</a><?php }else{?><a ><?php echo $html->image('back_icon.gif',array('align'=>'absmiddle','class'=>'right'))?>末页</a><?php }?>
	</p><span class="last">第 <?php echo $paging['page']?> 页，总页数： <?php echo $paging['pageCount']?></span>
	</div>
<?php }?>