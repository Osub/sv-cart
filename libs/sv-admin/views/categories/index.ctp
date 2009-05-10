<?php
/*****************************************************************************
 * SV-Cart 商品分类管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 899 2009-04-22 15:03:02Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<p class="add_categories">
<?php if($type == 'P'){echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增商品分类","/categories/add",array(),false,false);}?>
<?php if($type == 'A'){echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增文章分类","/categories/add/A",array(),false,false);}?>
</p>


<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<?php if($type == 'A'):?>
	      <div class="categories">
		  <ul class="product_llist commets_title">
		  <li class="name_a" style="width:35%;">分类名称</li>
		  <li class="item_number" style="width:10%;">文章数量</li>
	      <li class="block" style="width:15%;">状态</li>
		  <li class="taxis" style="width:10%;">排序</li>
		  <li class="hadle" style="width:25%;">操作</li>
		  </ul>
<!--Aticle Cat-->
	<?if(isset($categories_trees) && sizeof($categories_trees)>0){?>

		<?php foreach($categories_trees as $v) {?>
		  <ul class="cat_title cat_list">
	      <li class="name" style="width:34%;"><?=$html->image('menu_minus.gif')?>
	      <?php echo $html->link("{$v['CategoryI18n']['name']}","edit/A/{$v['Category']['id']}",array(),false,false);?>
	      </li>
	      <li class="item_number" style="width:10%;">
	      <?php if(isset($categories_articles_count[$v['Category']['id']]))
	      {?>
	      <?php echo $html->link($categories_articles_count[$v['Category']['id']],"../articles/?article_cat={$v['Category']['id']}",array(),false,false);?>
	      <?}else{?>0<?}?>
	      </li>
	      <li class="bloc" style="width:15%;"><? if($v['Category']['status']) {echo $html->image('yes.gif');}else{ echo $html->image('no.gif');}?></li>
	      <li class="taxi" style="width:10%;"><?php echo $v['Category']['orderby'];?></li>
	      <li class="hande" style="width:29%;">
	      
	      <?php echo $html->link("查看分类文章","/articles/?article_cat={$v['Category']['id']}",array(),false,false);?>
	    
		 | <?php echo $html->link("编辑","/categories/edit/A/{$v['Category']['id']}",array(),false,false);?>
	     | <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}categories/remove/A/{$v['Category']['id']}')"),false,false);?>
	      </li>
	      </ul>
<!--scoend cat-->	
          <?php if(isset($v['SubCategory'])&& sizeof($v['SubCategory'])>0){
           	     foreach($v['SubCategory'] as $kk=>$vv){?>	
		  <ul class="cat_title cat_list"><li class="name second_cat" style="width:34%;">
	  	  <span><?=$html->image('menu_minus.gif')?>
	      <?php echo $html->link("{$vv['CategoryI18n']['name']}","edit/A/{$vv['Category']['id']}",array(),false,false);?>
		  </span></li>
		  <li class="item_number" style="width:10%;">
		  <?php if(isset($categories_articles_count[$vv['Category']['id']]))
	      {?>
	      <?php echo $html->link($categories_articles_count[$vv['Category']['id']],"../articles/?article_cat={$vv['Category']['id']}",array(),false,false);?>
	      <?}else{?>0<?}?>
		  </li>
		  <li class="bloc" style="width:15%;"><? if($vv['Category']['status']) {echo $html->image('yes.gif');}else{ echo $html->image('no.gif');}?></li>
		  <li class="taxi" style="width:10%;"><?php echo $vv['Category']['orderby'];?></li>
		  <li class="hande" style="width:29%;">
		  <?php echo $html->link("查看分类文章","/articles/?article_cat={$vv['Category']['id']}",array(),false,false);?>

		 | <?php echo $html->link("编辑","/categories/edit/A/{$vv['Category']['id']}",array(),false,false);?>
	     | <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}categories/remove/A/{$vv['Category']['id']}')"),false,false);?></li></ul>
<!--three cat-->	
            <?php //pr($v);
           	     if(isset($vv['SubCategory'])&& sizeof($vv['SubCategory'])>0){
           	     foreach($vv['SubCategory'] as $kkk=>$vvv){		  
            ?>				
			<ul class="cat_title cat_list">
			<li class="name three">
				<span>
	        <?php echo $html->link("{$vvv['Category']['name']}","edit/A/{$vvv['Category']['id']}",array(),false,false);?>
				</span>
			</li>
			<li class="item_number"><?php echo (isset($categories_articles_count[$vvv['Category']['id']]))?$categories_articles_count[$vvv['Category']['id']]:0; ?></li><img src="" >
			<li class="block"><? if($vvv['Category']['status']) {echo $html->image('yes.gif',array("id"=>"status"));}else{ echo $html->image('no.gif',array("id"=>"status"));}?></li>
			<li class="taxis"><?php echo $vvv['Category']['orderby'];?></li>
			<li class="handel">
			<?php echo $html->link("编辑","/categories/edit/A/{$vvv['Category']['id']}",array(),false,false);?>
	        	  |<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}categories/remove/A/{$vvv['Category']['id']}')"),false,false);?>
		    </li></ul>
			
<?php } //three cat End
	}}}?>
	
	<?}?>
	<?}?>
		</div>
<?php endif;?>
<!--Aticle Cat End-->

<?php if($type == 'P'):?>
<!--Categories List-->
	    <div class="categories">
	    <ul class="product_llist commets_title">
	     <li class="name_a" style="width:35%;">分类名称</li>
		 <li class="item_number" style="width:10%;">商品数量</li>
	     <li class="block" style="width:15%;">状态</li>
		 <li class="taxis" style="width:10%;">排序</li>
		 <li class="hadle" style="width:25%;">操作</li>
	    </ul>

<!--Products Cat-->
<?php if(isset($categories_tree) && sizeof($categories_tree)>0){
	   foreach($categories_tree as $k=>$v){
				  ?>
	        <ul class="cat_title cat_list">
	        	  <li class="name" style="width:35%;padding-left:0;"><span style="margin-left:15px;"><?=$html->image('menu_minus.gif')?>
	      	<?php echo $html->link("{$v['CategoryI18n']['name']}","edit/P/{$v['Category']['id']}",array(),false,false);?>
	        	  </span></li>
	        	  <li class="item_numbe" style="width:10%;">

	        	  <?php if(isset($categories_products_count[$v['Category']['id']]))
			      {?>
			      <?php echo $html->link($categories_products_count[$v['Category']['id']],"../products/?category_id={$v['Category']['id']}",array(),false,false);?>
			      <?}else{?>0<?}?>
	        	  </li>
	        	  <li class="bloc" style="width:15%;"><? if($v['Category']['status']) {echo $html->image('yes.gif');}else{ echo $html->image('no.gif');}?></li>
	        	  <li class="taxi" style="width:10%;"><?php echo $v['Category']['orderby'];?></li>
	        	  <li class="hande" style="width:25%;border:0">
	        	  <?php echo $html->link("转移商品","move_to/{$v['Category']['id']}",array(),false,false);?>
	        	  |<?php echo $html->link("编辑","/categories/edit/P/{$v['Category']['id']}",array(),false,false);?>
	        	  |<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}categories/remove/P/{$v['Category']['id']}')"),false,false);?>
	        	  </li>
	        </ul>
<!--scoend cat-->	
           <?php if(isset($v['SubCategory']) && sizeof($v['SubCategory'])>0){
           	     foreach($v['SubCategory'] as $kk=>$vv){		  
            ?>	
			<ul class="cat_title cat_list"><li class="name second_cat" style="width:35%;padding-left:0;">
				<span style="margin-left:30px;"><?=$html->image('menu_minus.gif')?>
	        <?php echo $html->link("{$vv['CategoryI18n']['name']}","edit/P/{$vv['Category']['id']}",array(),false,false);?>
				</span></li>
			<li class="item_numbe" style="width:10%;">
	        <?php if(isset($categories_products_count[$vv['Category']['id']]))
			{?>
			<?php echo $html->link($categories_products_count[$vv['Category']['id']],"../products/?category_id={$vv['Category']['id']}",array(),false,false);?>
			<?}else{?>0<?}?>
			</li>
			<li class="bloc" style="width:15%;"><? if($vv['Category']['status']) {echo $html->image('yes.gif');}else{ echo $html->image('no.gif');}?></li>
			<li class="taxi" style="width:10%;"><?php echo $vv['Category']['orderby'];?></li>
			<li class="hande" style="width:25%;border:0;">
				 <?php echo $html->link("转移商品","move_to/{$vv['Category']['id']}",array(),false,false);?>
	        	  |<?php echo $html->link("编辑","/categories/edit/P/{$vv['Category']['id']}",array(),false,false);?>
	        	  |<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}categories/remove/P/{$vv['Category']['id']}')"),false,false);?></li></ul>
<!--three cat-->	
            <?php //pr($v);
           	     if(isset($vv['SubCategory']) && sizeof($vv['SubCategory'])>0){
           	     foreach($vv['SubCategory'] as $kkk=>$vvv){		  
            ?>				
			<ul class="cat_title cat_list"><li class="name three">
				<span>
	        <?php echo $html->link("{$vvv['Category']['name']}","edit/P/{$vvv['Category']['id']}",array(),false,false);?>
				</span></li>
			<li class="item_number"><?php echo (isset($categories_products_count[$vvv['Category']['id']]))?$categories_products_count[$vvv['Category']['id']]:0; ?></li><img src="" >
			<li class="block"><? if($vvv['Category']['status']) {echo $html->image('yes.gif',array("id"=>"status"));}else{ echo $html->image('no.gif',array("id"=>"status"));}?></li>
			<li class="taxis"><?php echo $vvv['Category']['orderby'];?></li>
			<li class="handel">
				 <?php echo $html->link("转移商品","move_to/{$vvv['Category']['id']}",array(),false,false);?>
	        	  |<?php echo $html->link("编辑","/categories/edit/P/{$vvv['Category']['id']}",array(),false,false);?>
	        	  |<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}categories/remove/P/{$vvv['Category']['id']}')"),false,false);?>
				</li></ul>
<?php } //three cat End
	}}}}}?>	

<!--scoend cat End-->
<!--Products Cat End-->
	    </div>
<!--Categories List End-->
<?php endif;?>
	    </div>
<!--Main Start End-->
</div>
	
