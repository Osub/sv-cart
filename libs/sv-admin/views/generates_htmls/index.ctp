<?php 
/*****************************************************************************
 * SV-Cart 编辑菜单
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 4361 2009-09-18 09:10:55Z zhengli $
*****************************************************************************/
?>
<div class="content">
	<?php //pr($this->data);pr($parentmenu);?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<p class="add_categories"><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."菜单列表","/menus/",array(),false,false);?></p>

<div class="home_main">
<!--ConfigValues-->
<?php echo $form->create('Menu',array('action'=>'edit/'.$this->data['Operator_menu']['id'],'onsubmit'=>'return menus_check()'));?>
	<input id="Operator_emnuId" name="data[Operator_menu][id]" type="hidden" value="<?php echo  $this->data['Operator_menu']['id'];?>">
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  &nbsp;生成HTML&nbsp;</h1></div>
	  <div class="box">
	  
<!--Menus_Config-->
	  <div class="shop_config menus_configs">
		

		<dl><dt>选择分类: </dt>
		<dd>
			<select style="width:355px;height:260px;border:1px solid #649776;overflow-y:scroll" multiple="true" id="selectType">
			<option value="all">所有分类</option>
			<?php if(isset($article_cat) && sizeof($article_cat)>0){?><?php foreach($article_cat as $first_k=>$first_v){?>
			<option value="<?php echo $first_v['Category']['id'];?>"  ><?php echo $first_v['CategoryI18n']['name'];?></option>
			<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
			<option value="<?php echo $second_v['Category']['id'];?>"  >|--<?php echo $second_v['CategoryI18n']['name'];?></option>
			<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
			<option value="<?php echo $third_v['Category']['id'];?>" >|----<?php echo $third_v['CategoryI18n']['name'];?></option>
			<?php }}}}}}?>
			</select>
		</dd></dl>

		<br />
		
		</div>
<!--Menus_Config End-->
		
	  </div>
	  <p class="submit_btn"><input type="button" value="确定" onclick="update_cat_art()" /><input type="reset" value="重置" /></p>
	</div>
<?php echo $form->end();?>
<!--ConfigValues End-->


</div>
<!--Main End-->
</div>

<script type="text/javascript">

function update_cat_art(){
	YAHOO.example.container.wait.show();
    var select = document.getElementById("selectType");
	var value = "";
    for(var i=0;i<select.length;i++){
    	if(select.options[i].selected){
    		if(value==""){
    			value+= select.options[i].value; 
			}
			else{
				value+= "-"+select.options[i].value; 
			}
		}
	}
	var sUrl = webroot_dir+"generates_htmls/update_html/"+value;
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl,back_update_cat_art);
}
var update_cat_art_success = function(o){
	if( o.responseText == 1 ){
		layer_dialog();
		layer_dialog_show("更新成功!","",3);
	}
	YAHOO.example.container.wait.hide();
}
var update_cat_art_failure = function(o){
	YAHOO.example.container.wait.hide();
}
var back_update_cat_art ={
	success:update_cat_art_success,
	failure:update_cat_art_failure,
	timeout : 300000,
	argument: {}
};
</script>