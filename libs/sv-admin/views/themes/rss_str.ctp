
	    <?php if(isset($templates) && sizeof($templates)>0){?>
	    <?php foreach($templates as $k=>$themed){if($k%4==0)echo "<div  class='box themes_box'>";?>

	  <div class="themes_show">
		  <p class="name"><?php if(isset($themed['title'])) echo $html->link($themed['title'].$k,$themed['link'],'',false,false);?> </p>
		  <p class="picture"> <?php if(isset($themed['img_thumb'])) echo $html->link($html->image($themed['img_thumb'],array("width"=>"190")),$themed['link'],'',false,false); ?> </p>
		  <p><?php if(isset($themed['shop_price']))echo $themed['shop_price'];?>元</p> 
	  </div>
		<?php if($k%4==3 || $k==sizeof($templates)-1)echo "</div>";}}?>
		  
