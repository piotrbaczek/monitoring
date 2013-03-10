<?
include "../connection.php";
@mssql_select_db("ReportsDB", $qdb);
$zapytaniestatus="SELECT DISTINCT A.DeploymentStatus AS Status,
(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE DeploymentStatus=A.DeploymentStatus) AS Amount,
round((convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE DeploymentStatus=A.DeploymentStatus))/convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE)))*100,2) AS Percentage
FROM SMC_Deployment_Service_TABLE A ORDER BY DeploymentStatus ASC";
$res1=mssql_query($zapytaniestatus);
$res2=mssql_query($zapytaniestatus);
//--------------------------
echo "<chart>";

	echo "<chart_data>";
		echo "<row>";
			echo "<null/>";
while ($row1=mssql_fetch_array($res1)){
			echo "<string>".substr($row1[Status],0,25)."</string>";
			}
		echo "</row>";
		echo "<row>";
			echo "<string></string>";
while ($row2=mssql_fetch_array($res2)){		
			echo "<number>".$row2[Amount]."</number>";
			}
		echo "</row>";
	echo "</chart_data>";
	echo "<chart_label shadow='low' alpha='65' size='15' position='inside' as_percentage='true' />";
	echo "<chart_pref select='true' drag='true' rotation_x='50' />";
	echo "<chart_rect x='125' y='50' width='300' height='180' positive_alpha='0' />";
	echo "<chart_type>3d pie</chart_type>";
	
	echo "<draw>";
		echo "<rect bevel='bg' layer='background' x='0' y='0' width='400' height='300' fill_color='FFFFFF' line_thickness='0' />";
		echo "<text shadow='low' color='ffffff' alpha='10' rotation='-90' size='22' x='0' y='235' width='300' height='55' >Deployment Statuses</text>";
		
	echo "</draw>";
	echo "<filter>";
		echo "<shadow id='high' distance='3' angle='45' alpha='50' blurX='10' blurY='10' />";
		echo "<shadow id='low' distance='2' angle='45' alpha='60' blurX='10' blurY='10' />";
		echo "<bevel id='bg' angle='90' blurX='0' blurY='200' distance='50' highlightAlpha='15' shadowAlpha='15' type='inner' />";
	echo "</filter>";
	
	echo "<legend shadow='low' layout='horizontal' margin='20' x='20' y='-10' width='345' height='25' fill_alpha='0' color='000000' alpha='75' />";
	echo "<context_menu full_screen='false' />";
	
	echo "<series_color>";
		echo "<color>8EA0FE</color>";
		echo "<color>1221C8</color>";
		echo "<color>fc0e11</color>";
		echo "<color>1EA376</color>";
		echo "<color>031297</color>";
		echo "<color>4A63A6</color>";
		echo "<color>1658FF</color>";
		echo "<color>9BC8B9</color>";
		echo "<color>C9DAF6</color>";
		echo "<color>BFC6FF</color>";
	echo "</series_color>";
echo "</chart>";
?>