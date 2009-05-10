<!--Product Photos-->
	<div class="order_stat properies"  >
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  当前模板</h1></div>
	  
	  <div class="box themes_backup" >
	  <p class="picture">
	<?=@$html->image("/../../{$curr_template['screenshot']}",array('height'=>'190'))?>
	</p>
		<ul class="bak_haddle">
		<li><?php if(isset($curr_template['name']))echo $curr_template['name'];?> &nbsp;<?php if(isset($curr_template['version']))echo $curr_template['version'];?></li>		
		<li><?php if(isset($curr_template['author']))echo $html->link($curr_template['author'],$curr_template['author_uri'],'',false,false);?></li>
		<li><?php if(isset($curr_template['desc']))echo $curr_template['desc']?></li> 		
		</ul>
	  </div>
	</div>
	
	
	<div class="order_stat properies" >
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  可用模板</h1></div>
	  <div class="box themes_box">
	    <?if(isset($available_templates) && sizeof($available_templates)>0){?>
	    <?php foreach($available_templates as $k=>$themed){?>
	  <div class="themes_show">
	  <p class="name"><?php if(isset($themed['name']))echo $html->link($themed['name'],$themed['uri'],'',false,false)."&nbsp;&nbsp;&nbsp;&nbsp;".$html->link("卸载","javascript:;",array("onclick"=>"deletethemed('{$themed['code']}')"),false,false)."&nbsp;&nbsp;&nbsp;&nbsp;"; if(isset($themed['flag'])&& $themed['flag']=="1")echo "是否可用： ".$html->link($html->image('yes.gif'),"javascript:;",array("onclick"=>"currencythemed('{$themed['code']}','no')"),false,false)."&nbsp;&nbsp;&nbsp;&nbsp;".$html->link("默认","javascript:;",array("onclick"=>"use_theme('{$themed['code']}')"),false,false); if(isset($themed['flag'])&& $themed['flag']=="" )echo "是否可用： ".$html->link($html->image('no.gif'),"javascript:;",array("onclick"=>"currencythemed('{$themed['code']}','yes')"),false,false);?> </p>
	  
	  
	  
	  <p class="picture"><?php if(isset($themed['screenshot'])&& $themed['flag']=="1"){echo $html->link($html->image('/../'.$themed['screenshot'],array("width"=>"190")),"javascript:;",array("onclick"=>"use_theme('{$themed['code']}')"),false,false); }else if(isset($themed['screenshot'])){echo "<img src='../$themed[screenshot]' width='190' alt='' />";}?></p>
	  <p><?php if(isset($themed['desc']))echo $themed['desc'];?></p> 
	</div>
		<?php }}?>

	  </div>
	</div>
	
<!--Product Photos End-->
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  可选模板</h1></div>
	  <div class="box themes_box">
	    <?if(isset($install_templates) && sizeof($install_templates)>0){?>
	    <?php foreach($install_templates as $k=>$themed){?>
	  <div class="themes_show">
	  <p class="name"><?php if(isset($themed['name']))echo $html->link($themed['name'],$themed['uri'],'',false,false); echo "&nbsp;&nbsp;&nbsp;&nbsp;";echo $html->link("安装","javascript:;",array("onclick"=>"installthemed('{$themed['code']}')"),false,false);?> </p>
	  <p class="picture"><?php if(isset($themed['screenshot'])){echo "<img src='../$themed[screenshot]' width='190' alt='' />";}?></p>
	  <p><?php if(isset($themed['desc']))echo $themed['desc'];?></p> 
	</div>
		<?php }}?>
	  </div>
	</div>