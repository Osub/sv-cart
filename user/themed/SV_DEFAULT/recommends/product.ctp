<?php 
/*****************************************************************************
 * SV-Cart 我的优惠券页
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1166 2009-04-30 14:05:59Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?><div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['my_recommend']?></b></h1>
<div class="infos">				
        <table cellpadding="5" cellspacing="1" class="table_data" width="100%">
        	<tr>
			<td><strong><?php echo $SCLanguages['codes']?></strong></td>
			</tr><?php  $url = $this->data['server_host'].$this->data['cart_webroot'].'?u='.$_SESSION['User']['User']['id'];?>
			<tr class="rows">
			<td width="30%"><?php echo $SCLanguages['effect']?></td>
			<td width="70%"><?php echo $SCLanguages['codes']?></td>
    		</tr>	
    		<?php foreach($type as $k=>$v){?>
			<tr class="rows">
			<td width="30%"><script src= '<?php echo $this->data['server_host'].$this->data['user_webroot']."recommends/affiliate/?charset=utf-8&method=javascript&pid=".$pid."&u=".$uid."&type=".$v?>'></script></td>
			<td width="70%">
            <textarea cols=30 rows=2 id="txt_<?php echo $v?>" style="border:1px solid #ccc;width:290px;"><script src='<?php echo $this->data['server_host'].$this->data['user_webroot']."recommends/affiliate/?charset=utf-8&method=javascript&pid=".$pid."&u=".$uid."&type=".$v?>'></script></textarea>
[<a href="#" title="Copy To Clipboard" onClick="Javascript:copyToClipboard(document.getElementById('txt_<?php echo $v?>').value);copy_success();"  class="f6">^</a>]					javascript <?php echo $SCLanguages['format']?>
				<br />
                  <textarea cols=30 rows=2 id="txt_iframe_<?php echo $v?>"  style="border:1px solid #ccc;width:290px;"><iframe width="250" height="270" src= '<?php echo $this->data['server_host'].$this->data['user_webroot']."recommends/affiliate/?charset=utf-8&method=iframe&pid=".$pid."&u=".$uid."&type=".$v?>' frameborder="0" scrolling="no"></iframe>
          		  </textarea>	
[<a href="#" title="Copy To Clipboard" onClick="Javascript:copyToClipboard(document.getElementById('txt_iframe_<?php echo $v?>').value);copy_success();"  class="f6">^</a>]	
								 iframe <?php echo $SCLanguages['format']?>				
				</td>
    		</tr>

    		<?php }?>
    		</table>				
　</div>


<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>
            <script language="Javascript">
    
    		copy_success = function(){
				  layer_dialog_show('1',copied_to_clipboard,2,page_confirm,"");
    		}
              
              copyToClipboard = function(txt)
              {
               if(window.clipboardData)
               {
                  window.clipboardData.clearData();
                  window.clipboardData.setData("Text", txt);
               }
               else if(navigator.userAgent.indexOf("Opera") != -1)
               {
                 //暂时无方法:-(
               }
               else if (window.netscape)
               {
                try
                {
                  netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
                }
                catch (e)
                {
                  //alert("failure");
                  return false;
                }
                var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
                if (!clip)
                  return;
                var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
                if (!trans)
                  return;
                trans.addDataFlavor('text/unicode');
                var str = new Object();
                var len = new Object();
                var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
                var copytext = txt;
                str.data = copytext;
                trans.setTransferData("text/unicode",str,copytext.length*2);
                var clipid = Components.interfaces.nsIClipboard;
                if (!clip)
                return false;
                clip.setData(trans,null,clipid.kGlobalClipboard);
               }
              }
            </script>
