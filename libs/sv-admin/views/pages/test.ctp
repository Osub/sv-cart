<?php echo $minify->css(array('/css/Charts'));?>
<?php echo $javascript->link('FusionCharts');?>

<table width="98%" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr> 
    <td valign="top" class="text" align="center"> 
    	<div id="chartdiv" align="center">七日成交额统计</div>
      	<script type="text/javascript">
		   var chart = new FusionCharts("/sv-admin/capability/Charts/FCF_Column2D.swf", "ChartId", "400", "250");
		   chart.setDataURL("/sv-admin/capability/Data/Column2D.xml");
		   chart.render("chartdiv");
		</script>
	</td>
  </tr>
  <tr>
    <td valign="top" class="text" align="center">&nbsp;</td>
  </tr>

</table>
