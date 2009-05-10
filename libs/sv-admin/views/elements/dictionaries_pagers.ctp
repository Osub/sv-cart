	<div class="box">
	<span class="block_number">每页显示数<?echo $paging['show']?></span>
	<p class="next">
	<?if ($paging['page'] > 1){?>
	<a href="?<?if(isset($_SESSION['is_select_locale'])){echo 'locale='.$_SESSION['is_select_locale'].'&';}?><?if(isset($_SESSION['is_select_type'])){echo 'language_type='.$_SESSION['is_select_type'].'&';}?><?if(isset($_SESSION['is_keywords'])){echo 'keywords='.$_SESSION['is_keywords'].'&';}?>page=1">
	<?=$html->image('back_icon.gif',array('align'=>'absmiddle','class'=>'left'))?>首页</a><?}else{?><a ><?=$html->image('back_icon.gif',array('align'=>'absmiddle','class'=>'left'))?>首页</a><?}?>
	<?if ($paging['page'] > 1){?><a href="?<?if(isset($_SESSION['is_select_locale'])){echo 'locale='.$_SESSION['is_select_locale'].'&';}?><?if(isset($_SESSION['is_select_type'])){echo 'language_type='.$_SESSION['is_select_type'].'&';}?><?if(isset($_SESSION['is_keywords'])){echo 'keywords='.$_SESSION['is_keywords'].'&';}?>page=<?echo ($paging['page']-1);?>"><?=$html->image('back_icon.gif',array('align'=>'absmiddle','class'=>'left'))?>上页</a><?}else{?><a ><?=$html->image('back_icon.gif',array('align'=>'absmiddle','class'=>'left'))?>上页</a>
	<?}?>
	</p>
	<p class="pages">
	<?=$html->image('pages_left.gif',array('align'=>'absmiddle','class'=>'left'))?>
	<?=$html->image('pages_right.gif',array('align'=>'absmiddle','class'=>'right'))?>
	<?php 
    if($pagination->setPaging($paging)): 
    //pr($paging);
    $pages = $pagination->pageNumbers("  ");
    echo "$pages";
    endif;

?> 
</p>
	<p class="next last_page">
	<?if ($paging['page'] < $paging['pageCount']){?><a href="?<?if(isset($_SESSION['is_select_locale'])){echo 'locale='.$_SESSION['is_select_locale'].'&';}?><?if(isset($_SESSION['is_select_type'])){echo 'language_type='.$_SESSION['is_select_type'].'&';}?><?if(isset($_SESSION['is_keywords'])){echo 'keywords='.$_SESSION['is_keywords'].'&';}?>page=<?echo ($paging['page']+1);?>"><?=$html->image('next_icon.gif',array('align'=>'absmiddle','class'=>'right'))?>下页</a><?}else{?><a ><?=$html->image('next_icon.gif',array('align'=>'absmiddle','class'=>'right'))?>下页</a><?}?>
	<?if ($paging['page'] < $paging['pageCount']){?><a href="?<?if(isset($_SESSION['is_select_locale'])){echo 'locale='.$_SESSION['is_select_locale'].'&';}?><?if(isset($_SESSION['is_select_type'])){echo 'language_type='.$_SESSION['is_select_type'].'&';}?><?if(isset($_SESSION['is_keywords'])){echo 'keywords='.$_SESSION['is_keywords'].'&';}?>page=<?echo $paging['pageCount']?>"><?=$html->image('next_icon.gif',array('align'=>'absmiddle','class'=>'right'))?>末页</a><?}else{?><a ><?=$html->image('next_icon.gif',array('align'=>'absmiddle','class'=>'right'))?>末页</a><?}?>
	</p><span class="last">第 <?echo $paging['page']?> 页，总页数： <?echo $paging['pageCount']?></span>
	</div>