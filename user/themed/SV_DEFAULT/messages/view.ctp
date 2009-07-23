<?php 
/*****************************************************************************
 * SV-CART 我的留言
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 609 2009-04-14 09:34:16Z zhangshisong $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?><h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['my_message']?></b></h1>
<div id="Edit_box">
  <div id="Edit_info">
  <p class="note"><?php printf($SCLanguages['totally_records_unpaid'],$total);?></p>
  <?php if(isset($my_messages) && sizeof($my_messages)>0){?>
  <?php foreach($my_messages as $k=>$v){?>
  <div id="user_msg">
  	<p class="msg_title"><span class="title"><?php echo $v['UserMessage']['type_name']?>： <?php echo $v['UserMessage']['msg_title']?>    
  	   <?if($v['UserMessage']['type'] == 'O' && isset($v['Order'])){?><?php echo $systemresource_info['type']['O']?>:<?php echo $html->link($v['Order']['Order']['order_code'],'/orders/'.$v['Order']['Order']['id'],array(),false,false)?><?}?> 
  	   <?if($v['UserMessage']['type'] == 'P' && isset($v['Product'])){?><?php echo $systemresource_info['type']['P']?>:<?php echo $html->link($v['Product']['ProductI18n']['name'],$server_host.$cart_webroot.'products/'.$v['Product']['Product']['id'],array(),false,false)?><?}?> 
  	      <font color="#A7A9A8"><?php echo $v['UserMessage']['created']?></font></span></p>
    <p class="msg_txt"><span><?php echo $v['UserMessage']['msg_content']?></span></p>
  </div>
  <?php if(isset($v['Reply']) && sizeof($v['Reply'])>0){?>
     <?php foreach($v['Reply'] as $key=>$val){?>
  <div id="user_msg">
  	<p class="msg_title"><span class="title"><?php echo $SCLanguages['reply'];?>：<?php echo $val['UserMessage']['msg_title']?> <font color="#A7A9A8"><?php echo $val['UserMessage']['created']?></font></span></p>
    <p class="msg_txt"><span><?php echo $val['UserMessage']['msg_content']?></span></p>
  </div>
  <?php }?>
  <?php }?>
  <?php }?>
  <?php }?>
  	  
  <?php if(!empty($my_messages)){?>
  <div id="pager" style="overflow:hidden;margin-top:-10px;height:100%;">
      <div class="nexit_page" style="margin-top:0;"><?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
  </div>
  <?php }?>
	<?php echo $form->create('messages',array('action'=>'/AddMessage','name'=>'form1','type'=>'post','enctype'=>'multipart/form-data'));?>
<ul style="margin-top:0;">
  <li>
  	<?php if(isset($order_info)){?>
  	<dd><?php echo $SCLanguages['order_code']?></dd>
  	<dt><?php echo $html->link($order_info['Order']['order_code'],'/orders/'.$order_info['Order']['id'],'',false,false)?></dt>
  		<input type="hidden" name="order_id" id="order_id" value="<?php echo $order_info['Order']['id']?>">
  		<input type="hidden" name="order_type" id="order_type" value="O">
  	<?php }else{?>
  	<dd><?php echo $SCLanguages['message'].$SCLanguages['type'];?>：</dd>
  	<dt><select name="message_type" id="message_type">
      <option value=0><?php echo $systemresource_info['msg_type']['0']?></option>
      <option value=1><?php echo $systemresource_info['msg_type']['1']?></option>
      <option value=2><?php echo $systemresource_info['msg_type']['2']?></option>
      <option value=3><?php echo $systemresource_info['msg_type']['3']?></option>
      <option value=4><?php echo $systemresource_info['msg_type']['4']?></option>
      <option value=5><?php echo $systemresource_info['msg_type']['5']?></option>
    </select></dt>
    <?php }?>
  </li>
  <li>
    <dd class="pass"><?php echo $SCLanguages['subject']?>：</dd>
    <dt><input size="30" name="title" id="title" type="text" />&nbsp;<font color="red" id="msg_title">*</font></dt>
  </li>
  <li style="vertical-align:top">
     <dd class="Email"><?php echo $SCLanguages['message'].$SCLanguages['content']?>：</dd>
     <dt class="msg_box"><textarea name="content" rows="3" style="overflow-y:scroll;width:250px;" id="content"></textarea>&nbsp;<font color="red" id="msg_content">*</font></dt>
  </li>

</ul>
<div class="ws_xx"></div>
<div class="y_but submits" style="padding-left:195px;">
	<li class="handel btn_list" style="background:#fff;">
	<a href="javascript:form1_onsubmit()" class="float_l"><span><?php echo $SCLanguages['confirm']?></span></a>
	</li>
</div>
<?php echo $form->end();?>
</div>
</div>

<?php echo $this->element('news', array('cache'=>array('time'=> "+24 hour",'key'=>'news'.$template_style)));?>
<script>
function form1_onsubmit(){
   var Title=document.getElementById('title').value;
   var Content=document.form1.content.value;
   //var MessageType=document.getElementById('message_type').value;
   document.getElementById('msg_content').innerHTML = "*";
       document.getElementById('msg_title').innerHTML = "*";
   var err = true;
   if(Title == ''){
       document.getElementById('msg_title').innerHTML = subject_is_blank;
       err = false;
   }
   if(Content == ''){
       document.getElementById('msg_content').innerHTML = content_empty;
       err = false;
   }
  
   if(err){
      document.forms['form1'].submit();
   }
}

</script>