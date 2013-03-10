<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
// Disables IE caching - resolves errors caused by IE displaying Temp page instead of downloading updated version
ini_set('max_execution_time',90);

$mtime = explode(" ",microtime()); 
$starttime = $mtime[1] + $mtime[0]; 
// Script execution time part END 
 
ini_set('mssql.datetimeconvert', 0);

// Dolaczenie pliku zawierajacego wszystkie funkcje PHP
include ('../funkcje.php');
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Deployment Report - Dispatching and Reporting</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-2" />

<link rel="stylesheet" type="text/css" href="/monitoring/reports/admin/css/deployment.css" /> 
	<script type="text/javascript" src="js/jQuery.js"></script>
	<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript">AC_FL_RunContent = 0;</script>
<script type="text/javascript">DetectFlashVer = 0; </script>
<script src="AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
var requiredMajorVersion = 9;
var requiredMinorVersion = 0;
var requiredRevision = 45;
-->
</script>
<script type="text/javascript">
$(document).ready(function(){
$("#statsemployees").tablesorter({
	sortList: [[0,0]]
});
$("#statsweeks").tablesorter({
	sortList: [[0,0]]
});
$("#statsstatus").tablesorter({
	sortList: [[0,0]]
});
	
});
</script>
</head> 
<body>

<div id="main">
<?
include "connection.php";
@mssql_select_db("ReportsDB", $qdb);
$sqlLogin=mssql_query("SELECT Name FROM SMC_Deployment_Login WHERE Login='".substr($_SERVER[AUTH_USER],16,13)."'",$qdb);
$r=mssql_fetch_array($sqlLogin);
$isLogged=mssql_num_rows($sqlLogin);
?>
<div id="page">
<h3>You are here: Operational Reports <img src='img/right.gif' alt=''/> Deployment Statistics</h3><br/>
<?
if($isLogged>0){
echo "<h3>You are logged in as <B>".$r[Name]."</B>.</h3><br>";
}else{
echo "<h3>User <B>".$_SERVER[AUTH_USER]."</B> is unable to see detailes of this report.</h3><br>";
}
//-------------------------------------
$count=mssql_query("SELECT COUNT(*) AS R FROM SMC_Deployment_Service_TABLE",$qdb);
$count2=mssql_fetch_array($count);
$count3=$count2[R];
$count3perc=round($count3/$count3,4);
//-------------------------------------
$Issued=mssql_query("SELECT COUNT(*) AS R FROM SMC_Deployment_Service_TABLE
WHERE ServerName NOT IN(
(SELECT ServerName FROM SMC_Deployment_Service_TABLE
WHERE System='WinOS'
AND(WinOS=(SELECT WinOS FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS'))
AND(WTS=(SELECT WTS FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR WTS='NotNeeded')
AND (CIM=(SELECT CIM FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR CIM=(SELECT DELL FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR CIM='NotNeeded')
AND (AD=(SELECT AD FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR AD='NotNeeded')
AND (Agent=(SELECT Agent FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS'))
)
UNION
(SELECT ServerName FROM SMC_Deployment_Service_TABLE
WHERE System='UNIX'
AND(WinOS=(SELECT WinOS FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX'))
AND(WTS=(SELECT WTS FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR WTS='NotNeeded')
AND (CIM=(SELECT CIM FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR CIM=(SELECT DELL FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR CIM='NotNeeded')
AND (AD=(SELECT AD FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR AD='NotNeeded')
AND (Agent=(SELECT Agent FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX'))
)
) AND DeploymentStatus NOT IN ('Unknown','OK','Not_to_Deployment')",$qdb);
$Issued2=mssql_fetch_array($Issued);
$Issued3=$Issued2[R];
//-------------------------------------
$amountdone="SELECT COUNT(*) AS R FROM SMC_Deployment_Service_TABLE WHERE ServerName IN 
							(
(SELECT ServerName FROM SMC_Deployment_Service_TABLE
WHERE System='WinOS'
AND(WinOS=(SELECT WinOS FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS'))
AND(WTS=(SELECT WTS FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR WTS='NotNeeded')
AND (CIM=(SELECT CIM FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR CIM=(SELECT DELL FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR CIM='NotNeeded')
AND (AD=(SELECT AD FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR AD='NotNeeded')
AND (Agent=(SELECT Agent FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS'))
)
UNION
(SELECT ServerName FROM SMC_Deployment_Service_TABLE
WHERE System='UNIX'
AND(WinOS=(SELECT WinOS FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX'))
AND(WTS=(SELECT WTS FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR WTS='NotNeeded')
AND (CIM=(SELECT CIM FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR CIM=(SELECT DELL FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR CIM='NotNeeded')
AND (AD=(SELECT AD FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR AD='NotNeeded')
AND (Agent=(SELECT Agent FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX'))
)
) OR DeploymentStatus='OK'";
$done1=mssql_query($amountdone);
$done2=mssql_fetch_array($done1);
$done3=$done2[R];
$done3perc=round($done3/$count3,4);
//------------------------------------
$notdone="SELECT COUNT(*) AS R FROM SMC_Deployment_Service_TABLE WHERE ServerName NOT IN
(
(SELECT ServerName FROM SMC_Deployment_Service_TABLE
WHERE System='WinOS'
AND(WinOS=(SELECT WinOS FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS'))
AND(WTS=(SELECT WTS FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR WTS='NotNeeded')
AND (CIM=(SELECT CIM FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR CIM=(SELECT DELL FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR CIM='NotNeeded')
AND (AD=(SELECT AD FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR AD='NotNeeded')
AND (Agent=(SELECT Agent FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS'))
)
UNION
(SELECT ServerName FROM SMC_Deployment_Service_TABLE
WHERE System='UNIX'
AND(WinOS=(SELECT WinOS FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX'))
AND(WTS=(SELECT WTS FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR WTS='NotNeeded')
AND (CIM=(SELECT CIM FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR CIM=(SELECT DELL FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR CIM='NotNeeded')
AND (AD=(SELECT AD FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR AD='NotNeeded')
AND (Agent=(SELECT Agent FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX'))
)
)";
$notdone1=mssql_query($notdone);
$notdone2=mssql_fetch_array($notdone1);
$notdone3=$notdone2[R];
//------------------------------------
$zapytaniepracownicy="SELECT DISTINCT Responsible,
(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE SMC_Deployment_Service_TABLE.Responsible=A.Responsible) AS Assigned,
(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE SMC_Deployment_Service_TABLE.Responsible=A.Responsible AND 
ServerName IN (
(SELECT ServerName FROM SMC_Deployment_Service_TABLE
WHERE System='WinOS'
AND(WinOS=(SELECT WinOS FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS'))
AND(WTS=(SELECT WTS FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR WTS='NotNeeded')
AND (CIM=(SELECT CIM FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR CIM=(SELECT DELL FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR CIM='NotNeeded')
AND (AD=(SELECT AD FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR AD='NotNeeded')
AND (Agent=(SELECT Agent FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS'))
)
UNION
(SELECT ServerName FROM SMC_Deployment_Service_TABLE
WHERE System='UNIX'
AND(WinOS=(SELECT WinOS FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX'))
AND(WTS=(SELECT WTS FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR WTS='NotNeeded')
AND (CIM=(SELECT CIM FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR CIM=(SELECT DELL FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR CIM='NotNeeded')
AND (AD=(SELECT AD FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR AD='NotNeeded')
AND (Agent=(SELECT Agent FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX'))
)
)
) AS Done,
SMC_Deployment_Login.Name AS ImieNazwisko,
round(convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE SMC_Deployment_Service_TABLE.Responsible=A.Responsible AND ServerName IN (
(SELECT ServerName FROM SMC_Deployment_Service_TABLE
WHERE System='WinOS'
AND(WinOS=(SELECT WinOS FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS'))
AND(WTS=(SELECT WTS FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR WTS='NotNeeded')
AND (CIM=(SELECT CIM FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR CIM=(SELECT DELL FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR CIM='NotNeeded')
AND (AD=(SELECT AD FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR AD='NotNeeded')
AND (Agent=(SELECT Agent FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS'))
)
UNION
(SELECT ServerName FROM SMC_Deployment_Service_TABLE
WHERE System='UNIX'
AND(WinOS=(SELECT WinOS FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX'))
AND(WTS=(SELECT WTS FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR WTS='NotNeeded')
AND (CIM=(SELECT CIM FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR CIM=(SELECT DELL FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR CIM='NotNeeded')
AND (AD=(SELECT AD FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR AD='NotNeeded')
AND (Agent=(SELECT Agent FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX'))
)
)))/convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE SMC_Deployment_Service_TABLE.Responsible=A.Responsible)),3) AS Percentage

FROM SMC_Deployment_Service_TABLE AS A
INNER JOIN SMC_Deployment_Login ON A.Responsible=SMC_Deployment_Login.ShortName
WHERE Responsible NOT LIKE 'None%' ORDER BY Responsible DESC
";
$res=mssql_query($zapytaniepracownicy);
//------------------------------------
$zapytanieweek="SELECT DISTINCT Week,Responsible,Login.Name,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE Responsible=A.Responsible AND Week=A.Week) AS Planned,

(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE Responsible=A.Responsible AND Week=A.Week AND (DeploymentStatus LIKE 'OK'
OR ServerName IN (
(SELECT ServerName FROM SMC_Deployment_Service_TABLE
WHERE System='WinOS'
AND(WinOS=(SELECT WinOS FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS'))
AND(WTS=(SELECT WTS FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR WTS='NotNeeded')
AND (CIM=(SELECT CIM FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR CIM=(SELECT DELL FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR CIM='NotNeeded')
AND (AD=(SELECT AD FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR AD='NotNeeded')
AND (Agent=(SELECT Agent FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS'))
)
UNION
(SELECT ServerName FROM SMC_Deployment_Service_TABLE
WHERE System='UNIX'
AND(WinOS=(SELECT WinOS FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX'))
AND(WTS=(SELECT WTS FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR WTS='NotNeeded')
AND (CIM=(SELECT CIM FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR CIM=(SELECT DELL FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR CIM='NotNeeded')
AND (AD=(SELECT AD FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR AD='NotNeeded')
AND (Agent=(SELECT Agent FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX'))
)
)
)) AS StatusOK,
round(convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE Responsible=A.Responsible AND Week=A.Week AND (DeploymentStatus LIKE 'OK' OR
ServerName IN (
(SELECT ServerName FROM SMC_Deployment_Service_TABLE
WHERE System='WinOS'
AND(WinOS=(SELECT WinOS FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS'))
AND(WTS=(SELECT WTS FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR WTS='NotNeeded')
AND (CIM=(SELECT CIM FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR CIM=(SELECT DELL FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR CIM='NotNeeded')
AND (AD=(SELECT AD FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS') OR AD='NotNeeded')
AND (Agent=(SELECT Agent FROM dbo.SMC_Deployment_MaxVersion WHERE System='WinOS'))
)
UNION
(SELECT ServerName FROM SMC_Deployment_Service_TABLE
WHERE System='UNIX'
AND(WinOS=(SELECT WinOS FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX'))
AND(WTS=(SELECT WTS FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR WTS='NotNeeded')
AND (CIM=(SELECT CIM FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR CIM=(SELECT DELL FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR CIM='NotNeeded')
AND (AD=(SELECT AD FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX') OR AD='NotNeeded')
AND (Agent=(SELECT Agent FROM dbo.SMC_Deployment_MaxVersion WHERE System='UNIX'))
)
)
)))/convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE Responsible=A.Responsible AND Week=A.Week))*100,2) AS Percentage
FROM SMC_Deployment_Service_TABLE A
INNER JOIN SMC_Deployment_Login AS Login ON Login.ShortName=A.Responsible
WHERE Week<>0 AND Responsible NOT LIKE '%None%' GROUP BY Week,Responsible,Login.Name ORDER BY Week DESC";
$res2=mssql_query($zapytanieweek);
$iloscwierszy2=mssql_num_rows($res2);
//-------------------------------------
$zapytaniestatus="SELECT DISTINCT A.DeploymentStatus AS Status,
(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE DeploymentStatus=A.DeploymentStatus) AS Amount,
round((convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE DeploymentStatus=A.DeploymentStatus))/convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE)))*100,4) AS Percentage
FROM SMC_Deployment_Service_TABLE A ORDER BY DeploymentStatus ASC";
$res3=mssql_query($zapytaniestatus);
?>
<center>
<h1>General Statistics about Deployment:</h1>
<span style="color:#0f238c;">Overall amount of servers</span>
<br><br>
<table class="mainTable">
<tr>
<th style="width:200px;">Amount of Servers In Deployment:</th>
<td><?echo $count3;?> (<B><?echo $count3perc*100;?>%</B>)</td>

</tr>
<tr>
<th style="width:200px;">Done (Where All software versions are up to date and servers to Deployment or Status OK):</th>
<td><?echo $done3;?> (<B><?echo $done3perc;?>%</B>)</td>
</tr>
<tr>
<th style="width:200px;">To Deploy:</th>
<td><?echo $notdone3;?> (<B><?echo round($notdone3/$count3,4);?>%</B>)</td>
</tr>
<tr>
<th style="width:200px;">Issued Cases (Work In Progress):</th>
<td><?echo $Issued3;?></td>
</tr>
</table>
<br>
<span style="color:#0f238c;">Overall amount by Employees</span>
<br><br>
<table id="statsemployees" class="mainTable">
<thead>
<tr>
<th>Responsible</th>
<th>Number of Servers <br>Assigned</th>
<th>Number of Servers <br>Done</th>
<th>Percentage</th>
</tr>
</thead><tbody>
<?
while ($row=mssql_fetch_array($res)){?>
<tr onmouseover="this.bgColor='#e9f2fb'" onmouseout="this.bgColor='#FFFFFF'">
<td><?=$row[ImieNazwisko];?></td>
<td><?=$row[Assigned];?></td>
<td><?=$row[Done];?></td>
<td><?=$row[Percentage];?>%</td>
</tr>
<?}?>
</tbody>
</table>
<br>
<span style="color:#0f238c;">Overall amount by Weeks</span>
<br><br>
<table style="border:0;padding:0 0;">
<tr>
<td rowspan="<?=$iloscwierszy2+1;?>">
<script type="text/javascript">
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '400',
			'height', '250',
			'scale', 'noscale',
			'salign', 'TL',
			'bgcolor', '#FFFFFF',
			'wmode', 'opaque',
			'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=custom_graphs/deployment_week_graph.php', 
			'id', 'my_chart',
			'name', 'my_chart',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'quality', 'high',
			'align', 'middle',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'play', 'true',
			'devicefont', 'false'
			); 
	} else { 
		var alternateContent = 'This content requires the Adobe Flash Player. '
		+ '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
		document.write(alternateContent); 
	}
}

</script>
<noscript>
	<P>This content requires JavaScript.</P>
</noscript>
</td>
<td style="padding-left: 0px; padding-right: 0px;">
<table id="statsweeks" class="mainTable">
<thead>
<tr>
<th>Week</th>
<th>Responsible</th>
<th>Amount of servers planned</th>
<th>Amount Deployed</th>
<th>Percentage</th>
</tr>
</thead>
<tbody>

<?
while ($row2=mssql_fetch_array($res2)){?>
<tr onmouseover="this.bgColor='#e9f2fb'" onmouseout="this.bgColor='#FFFFFF'">
<td><?if($row2[Week]=="99"){echo "0";}else{echo $row2[Week];}?></td>
<td><?=$row2[Name];?></td>
<td><?=$row2[Planned];?></td>
<td><?=$row2[StatusOK];?></td>
<?if($row2[Percentage]==100){?>
<td style="text-align:center;color:green;"><B><?echo $row2[Percentage];?>%</B></td>
<?}else{?>
<td style="text-align:center;"><?echo $row2[Percentage];?>%</td>
<?}?>
</tr>
<?}?>
</tbody>
</table>
</td></tr></table>
<br><br>
<span style="color:#0f238c;">Overall amount by Status</span>
<br><br>
<table><tr>
<td><script type="text/javascript">
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '400',
			'height', '250',
			'scale', 'noscale',
			'salign', 'TL',
			'bgcolor', '#FFFFFF',
			'wmode', 'opaque',
			'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=custom_graphs/deployment_status_graph.php', 
			'id', 'my_chart',
			'name', 'my_chart',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'quality', 'high',
			'align', 'middle',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'play', 'true',
			'devicefont', 'false'
			); 
	} else { 
		var alternateContent = 'This content requires the Adobe Flash Player. '
		+ '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
		document.write(alternateContent); 
	}
}

</script>
<noscript>
	<P>This content requires JavaScript.</P>
</noscript></td>
<td style="padding-left: 0px; padding-right: 0px;">
<table id="statsstatus" class="mainTable">
<thead>
<tr>
<th>Status</th>
<th>Amount</th>
<th>Percentage</th>
</tr>
</thead><tbody>
<?
while ($row3=mssql_fetch_array($res3)){?>
<tr onmouseover="this.bgColor='#e9f2fb'" onmouseout="this.bgColor='#FFFFFF'">
<td><?=$row3[Status];?></td>
<td><?=$row3[Amount];?></td>
<td><?echo $row3[Percentage];?>%</td>
</tr>
<?}?>
</tbody>
</table>
</td></tr></table>
</center>
<?
/* Script execution time part 2 BEGIN*/
$mtime = explode(" ",microtime()); 
$endtime = $mtime[1] + $mtime[0]; 
$totaltime = ($endtime - $starttime); 
/* Script execution time part 2 END*/

echo "<h2>This page was created in ".round($totaltime,3)." seconds.";
echo '<a href="javascript:scroll(0,0);"><h2>Up page</h2></a>';
echo "<h2>Today is ".date("Y-m-d")."</h2>";
?>
</div><!-- page-->
</div><!-- main -->
</body>                    
</html>