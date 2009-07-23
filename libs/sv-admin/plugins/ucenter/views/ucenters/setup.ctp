<?php
/*****************************************************************************
 * SV-Cart ucenter设置
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1393 2009-05-15 07:40:52Z zhengli $
*****************************************************************************/
?>
<?php echo $form->create('ucenters',array('action'=>'/setup/','id'=>'theform'));?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<br />
<div class="home_main" id="guides_1">
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	<?=$html->image('tab_left.gif',array('class'=>'left'))?>
	<?=$html->image('tab_right.gif',array('class'=>'right'))?>
	设置会员数据整合插件</h1></div>
	<div class="box">
	<div class="shop_config menus_configs guides" style="width:800px;">
	<br />
	
	<dl><dt style="width:150px;">UCenter 应用 ID: </dt>
	<dd>
		<input type="text" name="cfg[uc_id]" style="width:200px;border:1px solid #649776" value="<?=$integrate_config['uc_id']?>" />
		<p class="msg">该值为当前商店在 UCenter 的应用 ID，一般情况请不要改动</p>
	</dd></dl>
	<dl><dt style="width:150px;">UCenter 通信密钥: </dt>
	<dd>
		<input type="text" name="cfg[uc_key]" style="width:200px;border:1px solid #649776" value="<?=$integrate_config['uc_key']?>" />
		<p class="msg">通信密钥用于在 UCenter 和 SVcart 之间传输信息的加密，可包含任何字母及数字，请在 UCenter 与 SVcart <br />设置完全相同的通讯密钥，以确保两套系统能够正常通信</p>
	</dd></dl>
	<dl><dt style="width:150px;">UCenter 访问地址: </dt>
	<dd>
		<input type="text" name="cfg[uc_url]" style="width:200px;border:1px solid #649776" value="<?=$integrate_config['uc_url']?>" />
		<p class="msg">该值在您安装完 UCenter 后会被初始化，在您 UCenter 地址或者目录改变的情况下，修改此项，<br />一般情况请不要改动例如: http://www.sitename.com/uc_server (最后不要加"/")</p>
	</dd></dl>
	<dl><dt style="width:150px;">UCenter IP 地址: </dt>
	<dd>
		<input type="text" name="cfg[uc_ip]" style="width:200px;border:1px solid #649776" value="<?=$integrate_config['uc_ip']?>" />
		<p class="msg">如果您的服务器无法通过域名访问 UCenter，可以输入 UCenter 服务器的 IP 地址</p>
	</dd></dl>
	<dl><dt style="width:150px;">UCenter 连接方式: </dt>
	<dd style="padding-top:4px;">
		<input type="radio" class="radio" value="mysql" name="cfg[uc_connect]" <?if($integrate_config['uc_connect']!="post"){ echo "checked";}?>/>数据库方式
		<input type="radio" class="radio" value="post" name="cfg[uc_connect]" <?if($integrate_config['uc_connect']=="post"){ echo "checked";}?>/>接口方式
	<p class="msg">请根据您的服务器网络环境选择适当的连接方式</p>
	</dd></dl>
	<dl><dt style="width:150px;">UCenter 数据库服务器: </dt>
	<dd>
		<input type="text" name="cfg[db_host]" style="width:200px;border:1px solid #649776" value="<?=$integrate_config['db_host']?>"  />
		<p class="msg">可以是本地也可以是远程数据库服务器，如果 MySQL 端口不是默认的 3306，请填写如下形式：127.0.0.1:6033</P>
	</dd></dl>
	<dl><dt style="width:150px;">UCenter 数据库用户名: </dt>
	<dd><input type="text" name="cfg[db_user]" style="width:200px;border:1px solid #649776" value="<?=$integrate_config['db_user']?>" /></dd></dl>
	<dl><dt style="width:150px;">UCenter 数据库密码: </dt>
	<dd><input type="text" name="cfg[db_pass]" style="width:200px;border:1px solid #649776" value="<?=$integrate_config['db_pass']?>" /></dd></dl>
	<dl><dt style="width:150px;">UCenter 数据库名: </dt>
	<dd><input type="text" name="cfg[db_name]" style="width:200px;border:1px solid #649776" value="<?=$integrate_config['db_name']?>" /></dd></dl>
	<dl><dt style="width:150px;">UCenter 表前缀: </dt>
	<dd><input type="text" name="cfg[db_pre]" style="width:200px;border:1px solid #649776" value="<?=$integrate_config['db_pre']?>" /></dd></dl>
	<dl><dt style="width:150px;">等级积分名称: </dt>
	<dd><input type="text" name="cfg[uc_lang][credits][0][0]" style="width:200px;border:1px solid #649776" value="<?=$integrate_config['uc_lang']['credits']['0']['0']?>"  /></dd></dl>
	<dl><dt style="width:150px;">消费积分名称: </dt>
	<dd><input type="text" name="cfg[uc_lang][credits][1][0]" style="width:200px;border:1px solid #649776" value="<?=$integrate_config['uc_lang']['credits']['1']['0']?>"  /></dd></dl>
	<input type="hidden" name="cfg[db_charset]" value"<?=$integrate_config['db_charset']?>" />
	<input type="hidden" name="cfg[integrate_url]" value"<?=$integrate_config['integrate_url']?>" />
	<input type="hidden" name="cfg[cookie_domain]" value"<?=$integrate_config['cookie_domain']?>" />
	<input type="hidden" name="cfg[cookie_path]" value"<?=$integrate_config['cookie_path']?>" />
	
	
	</div>
	</div>
	<p class="submit_btn"><input type="submit" value="确定" onclick="save_uc_config()" /><input type="reset" value="重置"  /></p>
	</div>
</div>
<? echo $form->end();?>
