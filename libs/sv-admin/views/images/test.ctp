<?php echo $javascript->link('clearbox');?>
<div align="left" style="width:360px;margin:20px">
<table style=" padding-left: 30px; border-collapse: collapse; font-family: 宋体" border="1" bordercolor="#C4F9A4">
<?php $ij = 1;foreach( $results["list_img"] as $k=>$v ){?>
	<?php if($ij==1){?><tr><?php }?>
	<td>
		<table style=" padding-left: 30px; border-collapse: collapse; font-family: 宋体" border="1" bordercolor="#C4F9A4">
		<tr>
		<td colspan="2"><div class="box"  ><a href="/..<?=$v?>" rel="clearbox[test1]"><img src="/..<?=$v?>"></a></div></td>
		<tr><td valign="top"  width="70%"><a href="javascript:" ondblclick="mkname(this)" name="<?php echo $v;?>" ><?php echo $results['list_img_name'][$k];?></a></td><td  width="30%"><input type="image"  src="<?php echo $hosts;?>/sv-admin/img/no.gif" onclick="remove_img(this)" value="<?=$v?>"  /></td></tr>
</tr>
		</table>
	</td>
	<?php $ij++;if($ij==7){?></tr><?php $ij=1;}?>	
<?php }?>
</table>

</div>
<style>

td{font-family:verdana;font-size:11px;color:000000}
.bold{font:900}
<!--
.box{ 
		
		*display: block;
		*font-size: 85px;
		*font-family:Arial;
}
.box img{ padding:4px; border:1px #E3E3DF solid; vertical-align:middle;
width:120px;height:100px;
}
-->
</style>

<style>
#CB_ShowTh {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_Thumbs2 {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_Thumbs {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
.CB_RoundPixBugFix {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_Padding {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_ImgContainer {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_PrevNext {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_ContentHide {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_LoadingImage {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_Text {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_Window {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_Image {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_TopLeft {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_Top {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_TopRight {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_Left {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_Content {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_Right {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_BtmLeft {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_Btm {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_BtmRight {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_Prev {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_Next {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_Prev:hover {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_Next:hover {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_CloseWindow {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_SlideShowS {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_SlideShowP {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_SlideShowBar {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_Email {
	BORDER-TOP-WIDTH: 0px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; BACKGROUND-COLOR: transparent; BORDER-RIGHT-WIDTH: 0px
}
#CB_ImgHide {
	Z-INDEX: 1098; LEFT: 0px; VISIBILITY: hidden; POSITION: absolute
}
#CB_ShowTh {
	Z-INDEX: 1097; LEFT: 0px; VISIBILITY: hidden; WIDTH: 100%; BOTTOM: 0px; POSITION: absolute; HEIGHT: 15%
}
#CB_Thumbs {
	DISPLAY: none; Z-INDEX: 1100; LEFT: 0px; OVERFLOW: hidden; BOTTOM: 10px; PADDING-TOP: 10px; POSITION: absolute; HEIGHT: 60px; BACKGROUND-COLOR: #fff
}
#CB_Thumbs2 {
	MARGIN: auto 0px; POSITION: absolute; HEIGHT: 50px
}
.CB_ThumbsImg {
	POSITION: absolute
}
.CB_RoundPixBugFix {
	DISPLAY: block; FONT-SIZE: 1pt; VISIBILITY: hidden; FONT-FAMILY: arial
}
#CB_ImgContainer {
	WIDTH: 100%; POSITION: relative
}
#CB_PrevNext {
	Z-INDEX: 1002; LEFT: 0px; WIDTH: 100%; POSITION: absolute; TOP: 0px; HEIGHT: 100%
}
#CB_ContentHide {
	Z-INDEX: 1000; LEFT: 0px; POSITION: absolute; TOP: 0px
}
#CB_LoadingImage {
	MARGIN-TOP: -12px; LEFT: 50%; VISIBILITY: hidden; MARGIN-LEFT: -12px; POSITION: absolute; TOP: 50%
}
#CB_Text {
	TEXT-ALIGN: center
}
#CB_Window {
	Z-INDEX: 1100; LEFT: 50%; VISIBILITY: hidden; POSITION: absolute; TOP: 50%; BORDER-COLLAPSE: separate
}
#CB_Image {
	POSITION: relative
}
#CB_iFrame {
	Z-INDEX: 1003; WIDTH: 0px; POSITION: absolute; HEIGHT: 0px
}
#CB_TopLeft {
	BACKGROUND-POSITION: right bottom; BACKGROUND-IMAGE: url(../pic/s_topleft.png)
}
#CB_Top {
	BACKGROUND-POSITION: left bottom; BACKGROUND-IMAGE: url(../pic/s_top.png)
}
#CB_TopRight {
	BACKGROUND-POSITION: left bottom; BACKGROUND-IMAGE: url(../pic/s_topright.png)
}
#CB_Left {
	BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(../pic/s_left.png)
}
#CB_Content {
	BACKGROUND-COLOR: #ffffff
}
#CB_Right {
	BACKGROUND-POSITION: left top; BACKGROUND-IMAGE: url(../pic/s_right.png)
}
#CB_BtmLeft {
	BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(../pic/s_btmleft.png)
}
#CB_Btm {
	BACKGROUND-POSITION: left top; BACKGROUND-IMAGE: url(../pic/s_btm.png)
}
#CB_BtmRight {
	BACKGROUND-POSITION: left top; BACKGROUND-IMAGE: url(../pic/s_btmright.png)
}
#CB_Prev {
	DISPLAY: block; Z-INDEX: 1102; BACKGROUND: url(../pic/blank.gif) no-repeat 0% 50%; WIDTH: 49%; CURSOR: pointer; outline-style: none
}
#CB_Next {
	DISPLAY: block; Z-INDEX: 1102; BACKGROUND: url(../pic/blank.gif) no-repeat 0% 50%; WIDTH: 49%; CURSOR: pointer; outline-style: none
}
.CB_TextNav {
	COLOR: #aaa; TEXT-DECORATION: underline
}
.CB_TextNav:hover {
	COLOR: #ff7700; TEXT-DECORATION: none
}
#CB_Prev {
	LEFT: 0px; FLOAT: left
}
#CB_Next {
	LEFT: 0px; FLOAT: right
}
#CB_Prev:hover {
	BACKGROUND: url(../pic/prev.gif) no-repeat left 50%
}
#CB_Next:hover {
	BACKGROUND: url(../pic/next.gif) no-repeat right 50%
}
#CB_CloseWindow {
	Z-INDEX: 1104; RIGHT: -1px; CURSOR: pointer; POSITION: absolute; TOP: 0px
}
#CB_SlideShowS {
	Z-INDEX: 1104; LEFT: -1px; CURSOR: pointer; POSITION: absolute; TOP: 0px
}
#CB_SlideShowP {
	Z-INDEX: 1104; LEFT: -1px; CURSOR: pointer; POSITION: absolute; TOP: 0px
}
#CB_SlideShowBar {
	DISPLAY: none; LEFT: 22px; WIDTH: 0px; POSITION: absolute; TOP: 5px; HEIGHT: 5px
}
#CB_Email {
	RIGHT: 15px; POSITION: absolute
}

</style>