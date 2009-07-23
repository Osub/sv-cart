	<div class="box">
	<span class="block_number">每页显示数<?php echo $paging['show']?></span>
	<p class="next">
	<?php if ($paging['page'] > 1){?>
	<a href="?<?php if(isset($_SESSION['is_select_locale'])){echo 'locale='.$_SESSION['is_select_locale'].'&';}?><?php if(isset($_SESSION['is_select_type'])){echo 'language_type='.$_SESSION['is_select_type'].'&';}?><?php if(isset($_SESSION['is_keywords'])){echo 'keywords='.$_SESSION['is_keywords'].'&';}?>page=1">
	<?php echo $html->image('back_icon.gif',array('align'=>'absmiddle','class'=>'left'))?>首页</a><?php }else{?><a ><?php echo $html->image('back_icon.gif',array('align'=>'absmiddle','class'=>'left'))?>首页</a><?php }?>
	<?php if ($paging['page'] > 1){?><a href="?<?php if(isset($_SESSION['is_select_locale'])){echo 'locale='.$_SESSION['is_select_locale'].'&';}?><?php if(isset($_SESSION['is_select_type'])){echo 'language_type='.$_SESSION['is_select_type'].'&';}?><?php if(isset($_SESSION['is_keywords'])){echo 'keywords='.$_SESSION['is_keywords'].'&';}?>page=<?php echo ($paging['page']-1);?>"><?php echo $html->image('back_icon.gif',array('align'=>'absmiddle','class'=>'left'))?>上页</a><?php }else{?><a ><?php echo $html->image('back_icon.gif',array('align'=>'absmiddle','class'=>'left'))?>上页</a>
	<?php }?>
	</p>
	<p class="pages">
	<?php echo $html->image('pages_left.gif',array('align'=>'absmiddle','class'=>'left'))?>
	<?php echo $html->image('pages_right.gif',array('align'=>'absmiddle','class'=>'right'))?>
	<?php 
    if($pagination->setPaging($paging)): 
    //pr($paging);
    $pages = $pagination->pageNumbers("  ");
    echo "$pages";
    endif;

?> 
</p>
	<p class="next last_page">
	<?php if ($paging['page'] < $paging['pageCount']){?><a href="?<?php if(isset($_SESSION['is_select_locale'])){echo 'locale='.$_SESSION['is_select_locale'].'&';}?><?php if(isset($_SESSION['is_select_type'])){echo 'language_type='.$_SESSION['is_select_type'].'&';}?><?php if(isset($_SESSION['is_keywords'])){echo 'keywords='.$_SESSION['is_keywords'].'&';}?>page=<?php echo ($paging['page']+1);?>"><?php echo $html->image('next_icon.gif',array('align'=>'absmiddle','class'=>'right'))?>下页</a><?php }else{?><a ><?php echo $html->image('next_icon.gif',array('align'=>'absmiddle','class'=>'right'))?>下页</a><?php }?>
	<?php if ($paging['page'] < $paging['pageCount']){?><a href="?<?php if(isset($_SESSION['is_select_locale'])){echo 'locale='.$_SESSION['is_select_locale'].'&';}?><?php if(isset($_SESSION['is_select_type'])){echo 'language_type='.$_SESSION['is_select_type'].'&';}?><?php if(isset($_SESSION['is_keywords'])){echo 'keywords='.$_SESSION['is_keywords'].'&';}?>page=<?php echo $paging['pageCount']?>"><?php echo $html->image('next_icon.gif',array('align'=>'absmiddle','class'=>'right'))?>末页</a><?php }else{?><a ><?php echo $html->image('next_icon.gif',array('align'=>'absmiddle','class'=>'right'))?>末页</a><?php }?>
	</p><span class="last">第 <?php echo $paging['page']?> 页，总页数： <?php echo $paging['pageCount']?></span>
	</div>