<?
	include "connection.php";
@mssql_select_db("ReportsDB", $qdb);

//-------------------------------------
$count=mssql_query("SELECT COUNT(*) AS R FROM SMC_Deployment_Service_TABLE",$qdb);
$count2=mssql_fetch_array($count);
$count3=$count2[R];
$count3perc=round($count3/$count3,4);
$MaxNT1=mssql_query("SELECT TOP 1 NT AS NT FROM SMC_Deployment_MAXVersions",$qdb);
$MaxNT2=mssql_fetch_array($MaxNT1);
$MaxNT3=$MaxNT2[NT];
$MaxAD1=mssql_query("SELECT TOP 1 AD AS AD FROM SMC_Deployment_MAXVersions",$qdb);
$MaxAD2=mssql_fetch_array($MaxAD1);
$MaxAD3=$MaxAD2[AD];
$MaxWTS1=mssql_query("SELECT TOP 1 WTS AS WTS FROM SMC_Deployment_MAXVersions",$qdb);
$MaxWTS2=mssql_fetch_array($MaxWTS1);
$MaxWTS3=$MaxWTS2[WTS];
$MaxCIM1=mssql_query("SELECT TOP 1 CIM AS CIM FROM SMC_Deployment_MAXVersions",$qdb);
$MaxCIM2=mssql_fetch_array($MaxCIM1);
$MaxCIM3=$MaxCIM2[CIM];
$MaxAgent1=mssql_query("SELECT TOP 1 AppManagerAgent AS Agent FROM SMC_Deployment_MAXVersions",$qdb);
$MaxAgent2=mssql_fetch_array($MaxAgent1);
$MaxAgent3=$MaxAgent2[Agent];
$MaxDELL1=mssql_query("SELECT TOP 1 DELL AS DELL FROM SMC_Deployment_MAXVersions",$qdb);
$MaxDELL2=mssql_fetch_array($MaxDELL1);
$MaxDELL3=$MaxDELL2[DELL];
//-------------------------------------
$Issued=mssql_query("SELECT COUNT(*) AS R FROM SMC_Deployment_Service_TABLE
WHERE DeploymentStatus_N NOT IN (0,1,10)",$qdb);
$Issued2=mssql_fetch_array($Issued);
$Issued3=$Issued2[R];
//-------------------------------------
$amountdone="SELECT COUNT(*) AS R FROM SMC_Deployment_Service_TABLE WHERE ServerName IN 
							(SELECT ServerName FROM dbo.SMC_Deployment_Service_TABLE
							WHERE System='WinNT' AND (CIM LIKE '".$MaxCIM3."%' OR 
							CIM LIKE '".$MaxDELL3."%' OR CIM LIKE 'Not Needed') AND (WinOS LIKE '".$MaxNT3."%')
							AND (WTS LIKE 'Not Needed' OR WTS LIKE '".$MaxWTS3."%') AND 
							Agent LIKE '".$MaxAgent3."%') OR DeploymentStatus_N=1 OR DeploymentStatus_N=10 OR DeploymentStatus_N<>0";
$done1=mssql_query($amountdone);
$done2=mssql_fetch_array($done1);
$done3=$done2[R];
$done3perc=round($done3/$count3,4);
//------------------------------------
$notdone="SELECT COUNT(*) AS R FROM SMC_Deployment_Service_TABLE WHERE ServerName NOT IN
(SELECT ServerName FROM dbo.SMC_Deployment_Service_TABLE WHERE System='WinNT' AND
(CIM LIKE '7.4.14.%' OR CIM LIKE '7.3.29.%' OR CIM LIKE 'Not Needed') AND (WinOS LIKE '7.5.198%') AND
(WTS LIKE 'Not Needed' OR WTS LIKE '7.1.25.%') AND Agent LIKE '7.0.112%' OR DeploymentStatus_N=1 OR DeploymentStatus_N=10 OR
DeploymentStatus_N<>0) AND System LIKE 'WinNT%'";
$notdone1=mssql_query($notdone);
$notdone2=mssql_fetch_array($notdone1);
$notdone3=$notdone2[R];
//------------------------------------
$zapytaniepracownicy="SELECT DISTINCT Responsible,
(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE SMC_Deployment_Service_TABLE.Responsible=A.Responsible) AS Assigned,
(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE SMC_Deployment_Service_TABLE.Responsible=A.Responsible AND DeploymentStatus LIKE '%ok%' AND (System='WinNT' AND (CIM LIKE '".$MaxCIM3."%' OR 
							CIM LIKE '".$MaxDELL3."%' OR CIM LIKE 'Not Needed') AND (WinOS LIKE '".$MaxNT3."%')
							AND (WTS LIKE 'Not Needed' OR WTS LIKE '".$MaxWTS3."%') AND 
							Agent LIKE '".$MaxAgent3."%')) AS Done,
SMC_Deployment_Login.Name AS ImieNazwisko,
round(convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE SMC_Deployment_Service_TABLE.Responsible=A.Responsible AND (System='WinNT' AND (CIM LIKE '".$MaxCIM3."%' OR 
							CIM LIKE '".$MaxDELL3."%' OR CIM LIKE 'Not Needed') AND (WinOS LIKE '".$MaxNT3."%')
							AND (WTS LIKE 'Not Needed' OR WTS LIKE '".$MaxWTS3."%') AND 
							Agent LIKE '".$MaxAgent3."%')))/convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE SMC_Deployment_Service_TABLE.Responsible=A.Responsible))*100,2) AS Percentage

FROM SMC_Deployment_Service_TABLE AS A
INNER JOIN SMC_Deployment_Login ON A.Responsible=SMC_Deployment_Login.ShortName
WHERE Responsible NOT LIKE '%None%' ORDER BY Responsible DESC
";
$res=mssql_query($zapytaniepracownicy);
//------------------------------------
$zapytanieweek="SELECT DISTINCT Week,Responsible,Login.Name,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE Responsible=A.Responsible AND Week=A.Week) AS Planned,
(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE Responsible=A.Responsible AND Week=A.Week AND DeploymentStatus LIKE '%ok%') AS StatusOK,
round(convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE Responsible=A.Responsible AND Week=A.Week AND DeploymentStatus LIKE '%ok%'))/convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE Responsible=A.Responsible AND Week=A.Week))*100,2) AS Percentage
FROM SMC_Deployment_Service_TABLE A
INNER JOIN SMC_Deployment_Login AS Login ON Login.ID=A.Responsible_N
WHERE Week<>0 AND Responsible NOT LIKE '%None%' GROUP BY Week,Responsible,Login.Name ORDER BY Week DESC";
$res2=mssql_query($zapytanieweek);
$iloscwierszy2=mssql_num_rows($res2);
//-------------------------------------
$zapytaniestatus="SELECT DISTINCT A.DeploymentStatus AS Status,
(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE DeploymentStatus=A.DeploymentStatus) AS Amount,
round((convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE DeploymentStatus=A.DeploymentStatus))/convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE)))*100,2) AS Percentage
FROM SMC_Deployment_Service_TABLE A ORDER BY DeploymentStatus ASC";
$res3=mssql_query($zapytaniestatus);
?>
<center>
<h1>General Statistics about Deployment:</h1>
<span style="color:#0f238c;">Overall amount of servers</span>
<br><br>
<table class="mainTable">
<tr>
<th style="width:200px;">Amount of Servers to Deploy:</th>
<td><?echo $count3;?> (<B><?echo $count3perc*100;?>%</B>)</td>

</tr>
<tr>
<th style="width:200px;">Done (Where All software versions are up to date and servers to Deployment with status OK):</th>
<td><?echo $done3;?> (<B><?echo $done3perc*100;?>%</B>)</td>
</tr>
<tr>
<th style="width:200px;">To Deploy (Only Windows):</th>
<td><?echo $notdone3;?> (<B><?echo round($notdone3/$count3,4)*100;?>%</B>)</td>
</tr>
<tr>
<th style="width:200px;">Issued Cases (Work In Progress):</th>
<td><?echo $Issued3;?></td>
</tr>
<tr>
<th style="width:200px;">Others:</th>
<td><?echo $count3-($notdone3+$done3);?> (<B><?echo round(($count3-($notdone3+$done3))/$count3,4)*100;?>%</B>)</td>
</tr>
</table>
<br>
<span style="color:#0f238c;">Overall amount by Employees</span>
<br><br>
<table class="mainTable">
<tr>
<th>Responsible</th>
<th>Number of Servers <br>Assigned</th>
<th>Number of Servers <br>Done</th>
<th>Percentage</th>
</tr>
<?
while ($row=mssql_fetch_array($res)){?>
<tr onmouseover="this.bgColor='#e9f2fb'" onmouseout="this.bgColor='#FFFFFF'">
<td><?=$row[ImieNazwisko];?></td>
<td><?=$row[Assigned];?></td>
<td><?=$row[Done];?></td>
<td><?=$row[Percentage];?>%</td>
</tr>
<?}?>
</table>
<br>
<span style="color:#0f238c;">Overall amount by Weeks</span>
<br><br>
<table class="mainTable">
<tr>
<th>Diagram</th>
<th>Week</th>
<th>Responsible</th>
<th>Amount of servers planned</th>
<th>Amount Deployed</th>
<th>Percentage</th>
</tr>
<td rowspan="<?=$iloscwierszy2+1;?>">
<script language="JavaScript" type="text/javascript">

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

</table>
<br><br>
<span style="color:#0f238c;">Overall amount by Status</span>
<br><br>
<table class="mainTable">
<tr>
<th>Diagram</th>
<th>Status</th>
<th>Amount</th>
<th>Percentage</th>
</tr>
<td rowspan="12">

<script language="JavaScript" type="text/javascript">

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
<?
while ($row3=mssql_fetch_array($res3)){?>
<tr onmouseover="this.bgColor='#e9f2fb'" onmouseout="this.bgColor='#FFFFFF'">
<td><?=$row3[Status];?></td>
<td><?=$row3[Amount];?></td>
<td><?echo $row3[Percentage];?>%</td>
</tr>
<?}?>
</table>