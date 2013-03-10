<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
// Disables IE caching - resolves errors caused by IE displaying Temp page instead of downloading updated version
ini_set('max_execution_time',90);

$mtime = explode(" ",microtime()); 
$starttime = $mtime[1] + $mtime[0]; 
// Script execution time part END 
 
ini_set('mssql.datetimeconvert', 0);
ini_set('mssql.textlimit', '32768');
ini_set('mssql.textsize', '32768');
// Dolaczenie pliku zawierajacego wszystkie funkcje PHP
include ('js/funkcje.php');
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Deployment Report - Dispatching and Reporting</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-2" />

<link rel="stylesheet" type="text/css" href="css/deployment.css" /> 
<link rel="stylesheet" href="css/demo-menu-item.css" media="screen" type="text/css">

<script type="text/javascript" src="js/menu-for-applications.js"></script>
<script type="text/javascript" src="js/jQuery.js"></script>
<script type="text/javascript" src="js/starefunkcje.js"></script>
<style type="text/css">
#NOT{
}
.NOT{
}
</style>
</head> 
<body>
<Script language="JavaScript">

function otworz(stronka){
my_window=window.open(stronka);
}

window.onload = Laduj;
function Pokaz()
{
	var div = document.getElementById('wiecej');
	var odnosnik = document.getElementById('link');
 
	var view = div.style.display;
 
	if (view == "block")
	{
		odnosnik.innerHTML = '<img src="../img/save.gif" alt="Picked Save" title="Picked Save" border="0">';
		div.style.display = "none";
	}
 
	if (view == "none")
	{
		odnosnik.innerHTML = '<img src="../img/save.gif" alt="Picked Save" title="Picked Save" border="0">';
		div.style.display = "block";
	}
}
 
function Laduj()
{
	var odnosnik = document.getElementById('link');
	odnosnik.onclick = Pokaz;
}

function changecolor(thys){
id='z'+thys.id;
	if(thys.checked){
    document.getElementById(id).style.background='#0D97BF';
    }else{
    document.getElementById(id).style.background='';
	}}

function checkit(ajdi){
ajdi2='checkbox'+ajdi;
ajaxCheck(ajdi2);
}

function uncheckit(ajdi){
ajdi2='checkbox'+ajdi;
ajaxUnCheck(ajdi2);
}
	
</Script>
<div id="main">
<?php include "header.inc.php";?>
<div id="page">
<h3>You are here: Operational Reports <img src='../img/right.gif' alt='' /> Deployment</h3><br/>
<?
include "connection.php";
@mssql_select_db("ReportsDB", $qdb);

$sqlLogin=mssql_query("SELECT Name FROM SMC_Deployment_Login WHERE Login='".$currentuser."'",$qdb);
$r=mssql_fetch_array($sqlLogin);
$isLogged=mssql_num_rows($sqlLogin);
if($isLogged>0){
echo "<h3>You are logged in as <B>".$r[Name]."</B>.</h3><br>";
$login=true;
}else{
echo "<h3>User <B>".$_SERVER[AUTH_USER]."</B> is unable to see details of this report.</h3><br>";
$login=false;
}

$count=mssql_query("SELECT COUNT(*) AS R FROM SMC_Deployment_Service_TABLE WHERE System='WinOS'",$qdb);
$count2=mssql_fetch_array($count);
$count3=$count2[R];
$MaxNT1=mssql_query("SELECT TOP 1 NT AS NT FROM SMC_Deployment_MAXVersion WHERE System='WinOS'",$qdb);
$MaxNT2=mssql_fetch_array($MaxNT1);
$MaxNT3=$MaxNT2[NT];
$MaxAD1=mssql_query("SELECT TOP 1 AD AS AD FROM SMC_Deployment_MAXVersion WHERE System='WinOS'",$qdb);
$MaxAD2=mssql_fetch_array($MaxAD1);
$MaxAD3=$MaxAD2[AD];
$MaxWTS1=mssql_query("SELECT TOP 1 WTS AS WTS FROM SMC_Deployment_MAXVersion WHERE System='WinOS'",$qdb);
$MaxWTS2=mssql_fetch_array($MaxWTS1);
$MaxWTS3=$MaxWTS2[WTS];
$MaxCIM1=mssql_query("SELECT TOP 1 CIM AS CIM FROM SMC_Deployment_MAXVersion WHERE System='WinOS'",$qdb);
$MaxCIM2=mssql_fetch_array($MaxCIM1);
$MaxCIM3=$MaxCIM2[CIM];
$MaxAgent1=mssql_query("SELECT TOP 1 AppManagerAgent AS Agent FROM SMC_Deployment_MAXVersion WHERE System='WinOS'",$qdb);
$MaxAgent2=mssql_fetch_array($MaxAgent1);
$MaxAgent3=$MaxAgent2[Agent];
$MaxDELL1=mssql_query("SELECT TOP 1 DELL AS DELL FROM SMC_Deployment_MAXVersion WHERE System='WinOS'",$qdb);
$MaxDELL2=mssql_fetch_array($MaxDELL1);
$MaxDELL3=$MaxDELL2[DELL];

$system="";
$tablica=Array();


switch($_GET[Page]){
case 1:
$begin1=1;
$issorted=0;
$end1=ceil($count3/8);
break;
case 2:
$issorted=0;
$begin1=round($count3)/8;
$end1=2*round($count3)/8;
break;
case 3:
$issorted=0;
$begin1=2*round($count3)/8;
$end1=3*round($count3)/8;
break;
case 4:
$issorted=0;
$begin1=3*round($count3)/8;
$end1=4*round($count3)/8;
break;
case 5:
$issorted=0;
$begin1=4*round($count3)/8;
$end1=5*round($count3)/8;
break;
case 6:
$issorted=0;
$begin1=5*round($count3)/8;
$end1=6*round($count3)/8;
break;
case 7:
$issorted=0;
$begin1=6*round($count3)/8;
$end1=7*round($count3)/8;
break;
case 8:
$issorted=0;
$begin1=7*round($count3)/8;
$end1=$count3;
break;
default:
if($_GET[Page]=="" && ($_GET[ServerName]!="" || $_GET[WinOS]!="" || $_GET[Agent]!="" || $_GET[WTS]!="" || $_GET[CIM]!="" || $_GET[Week]!="" || $_GET[Responsible]!="" || $_GET[Dispatcher]!="" || $_GET[Status]!="" || $_GET[AlertingGroup]!="" || $_GET[QDB]!="" || $_GET[AD]!="" || $_GET[Comments]!="" || $_GET[RuleName]!="")){
$issorted=1;
$begin1=1;
$end1=$count3;
}else{
$issorted=0;
$begin1=1;
$end1=round($count3)/8;
}};
$c="AND A.Rownum>=".$begin1." AND A.Rownum<=".$end1;
$d="WHERE A.Rownum>=".$begin1." AND A.Rownum<=".$end1;
if($_GET['order']==""){$_GET['order']="ServerName ASC";}
if($_GET['System']==""){$_GET['System']="WinOS";$system="WinOS";}else{$system=$_GET['System'];}
$query="SELECT * FROM (SELECT ServerName,row_number() OVER (ORDER BY ServerName) AS Rownum,AlertingGroup,QDB,Agent, WinOS, WTS, CIM,AD,Responsible,Dispatcher,RuleName,
						Comments, date, DeploymentStatus,Week,System FROM SMC_Deployment_Service_TABLE) AS A
						WHERE A.ServerName ".$_GET['ServerNameN']." LIKE '".$_GET['ServerName']."%'
						AND A.WinOS ".$_GET['WinOSN']." LIKE '".$_GET['WinOS']."%'
						AND A.Agent ".$_GET['AgentN']." LIKE '".$_GET['Agent']."%'
						AND A.WTS ".$_GET['WTSN']." LIKE '".$_GET['WTS']."%'
						AND A.CIM ".$_GET['CIMN']." LIKE '".$_GET['CIM']."%'
						AND A.AD ".$_GET['ADN']." LIKE '".$_GET['AD']."%'
						AND A.Responsible ".$_GET['RespN']." LIKE '".$_GET['Responsible']."%'
						AND A.Week ".$_GET['WeekN']." LIKE '".$_GET['Week']."%'
						AND A.Comments ".$_GET['CommentsN']." LIKE '%".$_GET['Comments']."%'
						AND A.RuleName ".$_GET['RuleNameN']." LIKE '%".$_GET['RuleName']."%'
						AND A.DeploymentStatus ".$_GET['StatusN']." LIKE '".$_GET['Status']."%'
						AND A.AlertingGroup ".$_GET['GroupN']." LIKE '".$_GET['AlertingGroup']."%'
						AND A.QDB ".$_GET['QDBN']." LIKE '".$_GET['QDB']."%'
						AND A.System ".$_GET['SystemN']." LIKE '".$system."%'
						AND A.Dispatcher ".$_GET['DispN']." LIKE '".$_GET['Dispatcher']."%'
						".$c." ORDER BY ".$_GET['order'];
						
$res=mssql_query($query);
$iloscwierszy=mssql_num_rows($res);
//echo "<pre>".$query;
//echo "<br>";
//print_r($_SERVER);
//echo "</pre>";
?>
<div style="margin:0 auto; border:0;">

<a href="#"  onclick="$('#form_ServerName').val(this.value);$('#form_Agent').val(this.value);$('#form_WinOS').val(this.value);$('#form_WTS').val(this.value);$('#form_CIM').val(this.value);$('#form_Week').val(this.value);$('#form_Dispatcher').val(this.value);$('#form_Responsible').val(this.value);$('#form').submit();">
<img src="img/refresh.gif" alt="Refresh" border="0" style="width:15px;height:15px;" ></a>
<a href="report_deployment_admin_xls.php?order=<?=$order;?>&ServerName=<?=$_GET['ServerName'];?>&WinOS=<?=$_GET['WinOS'];?>&Agent=<?=$_GET['Agent'];?>&Status=<?=$_GET['Status'];?>&WTS=<?=$_GET['WTS'];?>&CIM=<?=$_GET['CIM'];?>&Week=<?=$_GET['Week'];?>&Responsible=<?=$_GET['Responsible'];?>&Dispatcher=<?=$_GET['Dispatcher'];?>&AD=<?=$_GET['AD'];?>&Comments=<?=$_GET[Comments];?>
&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>&From=<?=$begin1;?>&To=<?=$end1;?>"><img alt="Export to Excel" src="img/images.jpg" border="0" style="width:15px;height:15px;" /></a>


<a href="javascript:otworz('deployment__aN.php')"><img alt="Deployment Done" src="img/check.png" border="0" style="width:15px;height:15px;"/></a>
<a href="javascript:otworz('deployment.php')"><img alt="Show All" src="img/search.gif" border="0" style="width:15px;height:15px;" /></a><br>
<a href="#" id="link"><img src="../img/save.gif" alt="Picked Save" title="Picked Save" border="0" style="width:15px;height:15px;"></a>

<center>
<br>
<h1>Servers to Deploy.</h1>

<?if($issorted==0){?>
<a style="margin-top:50px;font-size:11px;color:#0f238c;font-family:Arial;" href="deployment_admin.php?Page=1&order=<?=$_GET['order'];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>
&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>&ServerNameN=<?=$_GET[ServerNameN];?>
&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&System=<?=$_GET[System]?>">[1]</a>
<a style="margin-top:50px;font-size:11px;color:#0f238c;font-family:Arial;" href="deployment_admin.php?Page=2&order=<?=$_GET['order'];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>&System=<?=$_GET[System]?>">[2]</a>
<a style="margin-top:50px;font-size:11px;color:#0f238c;font-family:Arial;" href="deployment_admin.php?Page=3&order=<?=$_GET['order'];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>&System=<?=$_GET[System]?>">[3]</a>
<a style="margin-top:50px;font-size:11px;color:#0f238c;font-family:Arial;" href="deployment_admin.php?Page=4&order=<?=$_GET['order'];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>&System=<?=$_GET[System]?>">[4]</a>
<a style="margin-top:50px;font-size:11px;color:#0f238c;font-family:Arial;" href="deployment_admin.php?Page=5&order=<?=$_GET['order'];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>&System=<?=$_GET[System]?>">[5]</a>
<a style="margin-top:50px;font-size:11px;color:#0f238c;font-family:Arial;" href="deployment_admin.php?Page=6&order=<?=$_GET['order'];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&WinOSN=<?=$_GET[WinOSN];?>&ServerNameN=<?=$_GET[ServerNameN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>&System=<?=$_GET[System]?>">[6]</a>
<a style="margin-top:50px;font-size:11px;color:#0f238c;font-family:Arial;" href="deployment_admin.php?Page=7&order=<?=$_GET['order'];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>&System=<?=$_GET[System]?>">[7]</a>
<a style="margin-top:50px;font-size:11px;color:#0f238c;font-family:Arial;" href="deployment_admin.php?Page=8&order=<?=$_GET['order'];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>&System=<?=$_GET[System]?>">[8]</a>
<?}?>


<p style="margin-top:20px;">Last update: <b><?echo $sqlT[date];?></b>. <br/>Report is being updated every 30 min.</p>
<!--custom message-->
</center>

<table class="mainTable" style="width:100%;">
<tr>
<th>ID</th>

<?if($_GET['order']=="ServerName ASC"){?>
<th><a href="deployment_admin.php?order=ServerName%20DESC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>
&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Server  </a><img src="../img/downLitleButton.gif" width="14" height="14"></th>
<?}else{if($_GET['order']=="ServerName DESC"){?>
<th><a href="deployment_admin.php?order=ServerName%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Server  </a><img src="../img/upLitleButton.gif" width="14" height="14"></th>
<?}else{?>
<th><a href="deployment_admin.php?order=ServerName%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Server</a></th>
<?}}?>

<?if($_GET['order']=="Agent ASC"){?>
	<th><a href="deployment_admin.php?order=Agent%20DESC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Agent  </a><img src="../img/downLitleButton.gif" width="14" height="14"></th>
<?}else{if($_GET['order']=="Agent DESC"){?>
	<th><a href="deployment_admin.php?order=Agent%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Agent  </a><img src="../img/upLitleButton.gif" width="14" height="14"></th>
<?}else{?>
	<th><a href="deployment_admin.php?order=Agent%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Agent</a></th>
<?}}?>
<?if($_GET['order']=="WinOS ASC"){?>
	<th><a href="deployment_admin.php?order=WinOS%20DESC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Windows  </a><img src="../img/downLitleButton.gif" width="14" height="14"></th>
<?}else{if($_GET['order']=="WinOS DESC"){?>
	<th><a href="deployment_admin.php?order=WinOS%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Windows  </a><img src="../img/upLitleButton.gif" width="14" height="14"></th>
<?}else{?>
	<th><a href="deployment_admin.php?order=WinOS%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Windows</a></th>
<?}}?>

<?if($_GET['order']=="WTS ASC"){?>
	<th><a href="deployment_admin.php?order=WTS%20DESC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">WTS  </a><img src="../img/downLitleButton.gif" width="14" height="14"></th>
<?}else{if($_GET['order']=="WTS DESC"){?>
	<th><a href="deployment_admin.php?order=WTS%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">WTS  </a><img src="../img/upLitleButton.gif" width="14" height="14"></th>
<?}else{?>
	<th><a href="deployment_admin.php?order=WTS%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">WTS</a></th>
<?}}?>

<?if($_GET['order']=="CIM ASC"){?>
<th><a href="deployment_admin.php?order=CIM%20DESC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">CIM / DELL  </a><img src="../img/downLitleButton.gif" width="14" height="14"></th>
<?}else{if($_GET['order']=="CIM DESC"){?>
<th><a href="deployment_admin.php?order=CIM%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">CIM / DELL  </a><img src="../img/upLitleButton.gif" width="14" height="14"></th>
<?}else{?>
<th><a href="deployment_admin.php?order=CIM%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">CIM / DELL</a></th>
<?}}?>
<?if($_GET['order']=="AD ASC"){?>
	<th><a href="deployment_admin.php?order=AD%20DESC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">AD  </a><img src="../img/downLitleButton.gif" width="14" height="14"></th>
<?}else{if($_GET['order']=="AD DESC"){?>
	<th><a href="deployment_admin.php?order=AD%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">AD  </a><img src="../img/upLitleButton.gif" width="14" height="14"></th>
<?}else{?>
	<th><a href="deployment_admin.php?order=AD%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">AD</a></th>
<?}}?>
<?if($_GET['order']=="Responsible ASC"){?>
	<th><a href="deployment_admin.php?order=Responsible%20DESC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Resp.  </a><img src="../img/downLitleButton.gif" width="14" height="14"></th>
<?}else{if($_GET['order']=="Responsible DESC"){?>
	<th><a href="deployment_admin.php?order=Responsible%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Resp.  </a><img src="../img/upLitleButton.gif" width="14" height="14"></th>
<?}else{?>
	<th><a href="deployment_admin.php?order=Responsible%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Resp.</a></th>
<?}}?>
<?if($_GET['order']=="Week ASC"){?>
	<th><a href="deployment_admin.php?order=Week%20DESC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Week  </a><img src="../img/downLitleButton.gif" width="14" height="14"></th>
<?}else{if($_GET['order']=="Week DESC"){?>
	<th><a href="deployment_admin.php?order=Week%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Week  </a><img src="../img/upLitleButton.gif" width="14" height="14"></th>
<?}else{?>
	<th><a href="deployment_admin.php?order=Week%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Week</a></th>
<?}}?>
<?if($_GET['order']=="RuleName ASC"){?>
	<th><a href="deployment_admin.php?order=RuleName%20DESC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Rule Name  </a><img src="../img/downLitleButton.gif" width="14" height="14"></th>
<?}else{if($_GET['order']=="RuleName DESC"){?>
	<th><a href="deployment_admin.php?order=RuleName%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Rule Name  </a><img src="../img/upLitleButton.gif" width="14" height="14"></th>
<?}else{?>
	<th><a href="deployment_admin.php?order=RuleName%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Rule Name</a></th>
<?}}?>
<?if($_GET['order']=="Comments ASC"){?>
<th><a href="deployment_admin.php?order=Comments%20DESC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Comments  </a><img src="../img/downLitleButton.gif" width="14" height="14"></th>
<?}else{if($_GET['order']=="Comments DESC"){?>
<th><a href="deployment_admin.php?order=Comments%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Comments  </a><img src="../img/upLitleButton.gif" width="14" height="14"></th>
<?}else{?>
<th><a href="deployment_admin.php?order=Comments%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Comments</a></th>
<?}}?>
<?if($_GET['order']=="date ASC"){?>
	<th><a href="deployment_admin.php?order=date%20DESC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Date  </a><img src="../img/downLitleButton.gif" width="14" height="14"></th>
<?}else{if($_GET['order']=="date DESC"){?>
	<th><a href="deployment_admin.php?order=date%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Date  </a><img src="../img/upLitleButton.gif" width="14" height="14"></th>
<?}else{?>
	<th><a href="deployment_admin.php?order=date%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Date</a></th>
<?}}?>	
<?if($_GET['order']=="DeploymentStatus ASC"){?>
	<th><a href="deployment_admin.php?order=DeploymentStatus%20DESC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Status  </a><img src="../img/downLitleButton.gif" width="14" height="14"></th>
<?}else{if($_GET['order']=="DeploymentStatus DESC"){?>
	<th><a href="deployment_admin.php?order=DeploymentStatus%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Status  </a><img src="../img/upLitleButton.gif" width="14" height="14"></th>
<?}else{?>
	<th><a href="deployment_admin.php?order=DeploymentStatus%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Status</a></th>
<?}}?>

<?
//if($login == true)
//{
?>
<th><a href="javascript:cos()">Save</a></th>
<?
//}
if($_GET['order']=="AlertingGroup ASC"){?>
<th><a href="deployment_admin.php?order=AlertingGroup%20DESC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Group  </a><img src="../img/downLitleButton.gif" width="14" height="14"></th>
<?}else{if($_GET['order']=="AlertingGroup DESC"){?>
<th><a href="deployment_admin.php?order=AlertingGroup%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Group  </a><img src="../img/upLitleButton.gif" width="14" height="14"></th>
<?}else{?>
<th><a href="deployment_admin.php?order=AlertingGroup%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Group</a></th>
<?}}?>
<?if($_GET['order']=="QDB ASC"){?>
<th><a href="deployment_admin.php?order=QDB%20DESC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">QDB  </a><img src="../img/downLitleButton.gif" width="14" height="14"></th>
<?}else{if($_GET['order']=="QDB DESC"){?>
<th><a href="deployment_admin.php?order=QDB%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">QDB  </a><img src="../img/upLitleButton.gif" width="14" height="14"></th>
<?}else{?>
<th><a href="deployment_admin.php?order=QDB%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">QDB</a></th>
<?}}?>
<?if($_GET['order']=="Dispatcher ASC"){?>
<th><a href="deployment_admin.php?order=Dispatcher%20DESC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Disp.  </a><img src="../img/downLitleButton.gif" width="14" height="14"></th>
<?}else{if($_GET['order']=="Dispatcher DESC"){?>
<th><a href="deployment_admin.php?order=Dispatcher%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Disp.  </a><img src="../img/upLitleButton.gif" width="14" height="14"></th>
<?}else{?>
<th><a href="deployment_admin.php?order=Dispatcher%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">Disp.</a></th>
<?}}?>
<?if($_GET['order']=="System ASC"){?>
<th><a href="deployment_admin.php?order=System%20DESC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">System  </a><img src="../img/downLitleButton.gif" width="14" height="14"></th>
<?}else{if($_GET['order']=="System DESC"){?>
<th><a href="deployment_admin.php?order=System%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">System  </a><img src="../img/upLitleButton.gif" width="14" height="14"></th>
<?}else{?>
<th><a href="deployment_admin.php?order=System%20ASC&Page=<?=$_GET[Page];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?=$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>
&System=<?=$_GET[System];?>">System</a></th>
<?}}?>

</tr>
<tr>
<td style="text-align:center;"></td>
<td style="text-align:center;"><span class="NOT" id="<?=$_GET[ServerNameN]?>" onclick="$('#ServerNameN').val('<?if(empty($_GET[ServerNameN])) echo "NOT"; else echo "";?>');$('#form').submit();"><B><?if($_GET[ServerNameN]!="NOT"){echo '<img src="img/rowny.gif" style="height:20px;">';}else{echo '<img src="img/nierowny.jpg" style="height:20px;">';}?></B></span>
<form name="server" action="<?=$_SERVER['PHP_SELF']?>" style="padding:0; margin:0;" id="form" method="get">
<input type="text" class="textInInput" style="color:red;border:1px solid #c0cae4;width:90px;" id="ServerName" name="ServerName" value="<?=addslashes($_GET['ServerName']);?>"/>
<input type="hidden" id="form_Agent" name="Agent"  value="<?if(!empty($_GET['Agent'])) echo $_GET['Agent'];?>" />
<input type="hidden" id="form_WinOS" name="WinOS"  value="<?if(!empty($_GET['WinOS'])) echo $_GET['WinOS'];?>" />
<input type="hidden" id="form_WTS" name="WTS"  value="<?if(!empty($_GET['WTS'])) echo $_GET['WTS'];?>" />
<input type="hidden" id="form_CIM" name="CIM"  value="<?if(!empty($_GET['CIM'])) echo $_GET['CIM'];?>" />
<input type="hidden" id="form_AD" name="AD"  value="<?if(!empty($_GET['AD'])) echo $_GET['AD'];?>" />
<input type="hidden" id="form_Responsible" name="Responsible"  value="<?if(!empty($_GET['Responsible'])) echo $_GET['Responsible'];?>" />
<input type="hidden" id="form_Dispatcher" name="Dispatcher"  value="<?if(!empty($_GET['Dispatcher'])) echo $_GET['Dispatcher'];?>" />
<input type="hidden" id="form_QDB" name="QDB"  value="<?if(!empty($_GET['QDB'])) echo $_GET['QDB'];?>" />
<input type="hidden" id="form_AlertingGroup" name="AlertingGroup"  value="<?if(!empty($_GET['AlertingGroup'])) echo $_GET['AlertingGroup'];?>" />
<input type="hidden" id="form_Status" name="Status"  value="<?if(!empty($_GET['Status'])) echo $_GET['Status'];?>" />
<input type="hidden" id="form_Comments" name="Comments"  value="<?if(!empty($_GET['Comments'])) echo $_GET['Comments'];?>" />
<input type="hidden" id="form_RuleName" name="RuleName"  value="<?if(!empty($_GET['RuleName'])) echo $_GET['RuleName'];?>" />
<input type="hidden" id="form_Week" name="Week"  value="<?if(!empty($_GET['Week'])) echo $_GET['Week'];?>" />
<input type="hidden" id="form_System" name="System"  value="<?if(!empty($_GET['System'])) echo $_GET['System'];?>" />
<input type="hidden" id="ServerNameN" name="ServerNameN"  value="<?if(!empty($_GET['ServerNameN'])) echo $_GET['ServerNameN'];?>" />
<input type="hidden" id="AgentN" name="AgentN"  value="<?if(!empty($_GET['AgentN'])) echo $_GET['AgentN'];?>" />
<input type="hidden" id="WinOSN" name="WinOSN"  value="<?if(!empty($_GET['WinOSN'])) echo $_GET['WinOSN'];?>" />
<input type="hidden" id="WTSN" name="WTSN"  value="<?if(!empty($_GET['WTSN'])) echo $_GET['WTSN'];?>" />
<input type="hidden" id="CIMN" name="CIMN"  value="<?if(!empty($_GET['CIMN'])) echo $_GET['CIMN'];?>" />
<input type="hidden" id="ADN" name="ADN"  value="<?if(!empty($_GET['ADN'])) echo $_GET['ADN'];?>" />
<input type="hidden" id="RespN" name="RespN"  value="<?if(!empty($_GET['RespN'])) echo $_GET['RespN'];?>" />
<input type="hidden" id="WeekN" name="WeekN"  value="<?if(!empty($_GET['WeekN'])) echo $_GET['WeekN'];?>" />
<input type="hidden" id="StatusN" name="StatusN"  value="<?if(!empty($_GET['StatusN'])) echo $_GET['StatusN'];?>" />
<input type="hidden" id="DispN" name="DispN"  value="<?if(!empty($_GET['DispN'])) echo $_GET['DispN'];?>" />
<input type="hidden" id="QDBN" name="QDBN"  value="<?if(!empty($_GET['QDBN'])) echo $_GET['QDBN'];?>" />
<input type="hidden" id="SystemN" name="SystemN"  value="<?if(!empty($_GET['SystemN'])) echo $_GET['SystemN'];?>" />
<input type="hidden" id="GroupN" name="GroupN"  value="<?if(!empty($_GET['GroupN'])) echo $_GET['GroupN'];?>" />
<input type="hidden" id="RuleNameN" name="RuleNameN"  value="<?if(!empty($_GET['RuleNameN'])) echo $_GET['RuleNameN'];?>" />
<input type="hidden" id="CommentsN" name="CommentsN"  value="<?if(!empty($_GET['CommentsN'])) echo $_GET['CommentsN'];?>" />
<input type="hidden" id="order" name="order"  value="<?if(!empty($_GET['order'])) echo $_GET['order'];?>" />
</form></td>
<td style="text-align:center;"><span class="NOT" id="<?=$_GET[AgentN]?>" onclick="$('#AgentN').val('<?if(empty($_GET[AgentN])) echo "NOT"; else echo "";?>');$('#form').submit();"><B><?if($_GET[AgentN]!="NOT"){echo '<img src="img/rowny.gif" style="height:20px;">';}else{echo '<img src="img/nierowny.jpg" style="height:20px;">';}?></B></span><br><select style="width:65px;" name="form_Agent" onchange="$('#form_Agent').val(this.value);$('#form').submit();">
				<option value="" <?if(empty($_GET['Agent']) || $_GET['Agent']=='') echo 'SELECTED'?>>All</option>
				<?$query="SELECT DISTINCT Agent FROM (SELECT DISTINCT Agent FROM SMC_Deployment_Service_TABLE
								WHERE ServerName NOT IN 
							(SELECT ServerName FROM dbo.SMC_Deployment_Service_TABLE
							WHERE System='WinOS' AND (CIM LIKE '".$MaxCIM3."%' OR 
							CIM LIKE '".$MaxDELL3."%' OR CIM LIKE 'Not Needed') AND (WinOS LIKE '".$MaxNT3."%'
							) AND (WTS LIKE 'Not Needed' OR WTS LIKE '".$MaxWTS3."%') AND 
							Agent LIKE '".$MaxAgent3."%')
						AND ServerName ".$_GET['ServerNameN']." LIKE '".$_GET['ServerName']."%'
						AND WinOS ".$_GET['WinOSN']." LIKE '".$_GET['WinOS']."%'
						AND WTS ".$_GET['WTSN']." LIKE '".$_GET['WTS']."%'
						AND CIM ".$_GET['CIMN']." LIKE '".$_GET['CIM']."%'
						AND AD ".$_GET['ADN']." LIKE '".$_GET['AD']."%'
						AND Responsible ".$_GET['RespN']." LIKE '".$_GET['Responsible']."%'
						AND Week ".$_GET['WeekN']." LIKE '".$_GET['Week']."%'
						AND Comments ".$_GET['CommentsN']." LIKE '%".$_GET['Comments']."%'
						AND RuleName ".$_GET['RuleNameN']." LIKE '%".$_GET['RuleName']."%'
						AND DeploymentStatus ".$_GET['StatusN']." LIKE '".$_GET['Status']."%'
						AND AlertingGroup ".$_GET['GroupN']." LIKE '".$_GET['AlertingGroup']."%'
						AND QDB ".$_GET['QDBN']." LIKE '".$_GET['QDB']."%'
						AND System ".$_GET['SystemN']." LIKE '".$system."%'
						AND Dispatcher ".$_GET['DispN']." LIKE '".$_GET['Dispatcher']."%') AS A 
						ORDER BY Agent DESC
							";
								$x=mssql_query($query,$qdb);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option style="text-align:center;color:red;" value="<?=$lista['Agent']?>" <?if(!empty($_GET['Agent']) && $_GET['Agent']== $lista['Agent']) echo 'SELECTED'?>><B><?=$lista['Agent']?></B></option><?
				}?>
			</select></td>
<td style="text-align:center;"><span class="NOT" id="<?=$_GET[WinOSN]?>" onclick="$('#WinOSN').val('<?if(empty($_GET[WinOSN])) echo "NOT"; else echo "";?>');$('#form').submit();"><B><?if($_GET[WinOSN]!="NOT"){echo '<img src="img/rowny.gif" style="height:20px;">';}else{echo '<img src="img/nierowny.jpg" style="height:20px;">';}?></B></span><br><select style="width:65px;" name="form_WinOS" onchange="$('#form_WinOS').val(this.value);$('#form').submit();">
				<option value="" <?if(empty($_GET['WinOS']) || $_GET['WinOS']=='') echo 'SELECTED'?>>All</option>
				<?$query="SELECT DISTINCT WinOS FROM (SELECT WinOS FROM SMC_Deployment_Service_TABLE
								WHERE ServerName ".$_GET['ServerNameN']." LIKE '".$_GET['ServerName']."%'
						AND Agent ".$_GET['AgentN']." LIKE '".$_GET['Agent']."%'
						AND WTS ".$_GET['WTSN']." LIKE '".$_GET['WTS']."%'
						AND CIM ".$_GET['CIMN']." LIKE '".$_GET['CIM']."%'
						AND AD ".$_GET['ADN']." LIKE '".$_GET['AD']."%'
						AND Responsible ".$_GET['RespN']." LIKE '".$_GET['Responsible']."%'
						AND Week ".$_GET['WeekN']." LIKE '".$_GET['Week']."%'
						AND Comments ".$_GET['CommentsN']." LIKE '%".$_GET['Comments']."%'
						AND RuleName ".$_GET['RuleNameN']." LIKE '%".$_GET['RuleName']."%'
						AND DeploymentStatus ".$_GET['StatusN']." LIKE '".$_GET['Status']."%'
						AND AlertingGroup ".$_GET['GroupN']." LIKE '".$_GET['AlertingGroup']."%'
						AND QDB ".$_GET['QDBN']." LIKE '".$_GET['QDB']."%'
						AND System ".$_GET['SystemN']." LIKE '".$system."%'
						AND Dispatcher ".$_GET['DispN']." LIKE '".$_GET['Dispatcher']."%') AS A 
						ORDER BY WinOS DESC
							";
								$x=mssql_query($query,$qdb);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option style="text-align:center;color:red;" value="<?=$lista['WinOS']?>" <?if(!empty($_GET['WinOS']) && $_GET['WinOS']== $lista['WinOS']) echo 'SELECTED'?>><B><?=$lista['WinOS']?></B></option><?
				}?>
			</select></td>
<td style="text-align:center;"><span class="NOT" id="<?=$_GET[WTSN]?>" onclick="$('#WTSN').val('<?if(empty($_GET[WTSN])) echo "NOT"; else echo "";?>');$('#form').submit();"><B><?if($_GET[WTSN]!="NOT"){echo '<img src="img/rowny.gif" style="height:20px;">';}else{echo '<img src="img/nierowny.jpg" style="height:20px;">';}?></B></span><br><select style="width:70px;" name="form_WTS" onchange="$('#form_WTS').val(this.value);$('#form').submit();">
				<option value="" <?if(empty($_GET['WTS']) || $_GET['WTS']=='') echo 'SELECTED'?>>All</option>
				<?$query="SELECT DISTINCT WTS FROM (SELECT WTS FROM SMC_Deployment_Service_TABLE
								WHERE ServerName NOT IN 
							(SELECT ServerName FROM dbo.SMC_Deployment_Service_TABLE
							WHERE System='WinOS' AND (CIM LIKE '".$MaxCIM3."%' OR 
							CIM LIKE '".$MaxDELL3."%' OR CIM LIKE 'Not Needed') AND (WinOS LIKE '".$MaxNT3."%'
							) AND (WTS LIKE 'Not Needed' OR WTS LIKE '".$MaxWTS3."%') AND 
							Agent LIKE '".$MaxAgent3."%')
						AND ServerName ".$_GET['ServerNameN']." LIKE '".$_GET['ServerName']."%'
						AND WinOS ".$_GET['WinOSN']." LIKE '".$_GET['WinOS']."%'
						AND Agent ".$_GET['AgentN']." LIKE '".$_GET['Agent']."%'
						AND CIM ".$_GET['CIMN']." LIKE '".$_GET['CIM']."%'
						AND AD ".$_GET['ADN']." LIKE '".$_GET['AD']."%'
						AND Responsible ".$_GET['RespN']." LIKE '".$_GET['Responsible']."%'
						AND Week ".$_GET['WeekN']." LIKE '".$_GET['Week']."%'
						AND Comments ".$_GET['CommentsN']." LIKE '%".$_GET['Comments']."%'
						AND RuleName ".$_GET['RuleNameN']." LIKE '%".$_GET['RuleName']."%'
						AND DeploymentStatus ".$_GET['StatusN']." LIKE '".$_GET['Status']."%'
						AND AlertingGroup ".$_GET['GroupN']." LIKE '".$_GET['AlertingGroup']."%'
						AND QDB ".$_GET['QDBN']." LIKE '".$_GET['QDB']."%'
						AND System ".$_GET['SystemN']." LIKE '".$system."%'
						AND Dispatcher ".$_GET['DispN']." LIKE '".$_GET['Dispatcher']."%') AS A 
						ORDER BY WTS DESC
							";
								$x=mssql_query($query,$qdb);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option style="text-align:center;color:red;" value="<?=$lista['WTS']?>" <?if(!empty($_GET['WTS']) && $_GET['WTS']== $lista['WTS']) echo 'SELECTED'?>><B><?=$lista['WTS']?></B></option><?
				}?>
			</select></td>
<td style="text-align:center;"><span class="NOT" id="<?=$_GET[CIMN]?>" onclick="$('#CIMN').val('<?if(empty($_GET[CIMN])) echo "NOT"; else echo "";?>');$('#form').submit();"><B><?if($_GET[CIMN]!="NOT"){echo '<img src="img/rowny.gif" style="height:20px;">';}else{echo '<img src="img/nierowny.jpg" style="height:20px;">';}?></B></span><br><select style="width:70px;" name="form_CIM" onchange="$('#form_CIM').val(this.value);$('#form').submit();">
				<option value="" <?if(empty($_GET['CIM']) || $_GET['CIM']=='') echo 'SELECTED'?>>All</option>
				<?$query="SELECT DISTINCT CIM FROM (SELECT CIM FROM SMC_Deployment_Service_TABLE
								WHERE ServerName NOT IN 
							(SELECT ServerName FROM dbo.SMC_Deployment_Service_TABLE
							WHERE System='WinOS' AND (CIM LIKE '".$MaxCIM3."%' OR 
							CIM LIKE '".$MaxDELL3."%' OR CIM LIKE 'Not Needed') AND (WinOS LIKE '".$MaxNT3."%'
							) AND (WTS LIKE 'Not Needed' OR WTS LIKE '".$MaxWTS3."%') AND 
							Agent LIKE '".$MaxAgent3."%')
						AND ServerName ".$_GET['ServerNameN']." LIKE '".$_GET['ServerName']."%'
						AND WinOS ".$_GET['WinOSN']." LIKE '".$_GET['WinOS']."%'
						AND Agent ".$_GET['AgentN']." LIKE '".$_GET['Agent']."%'
						AND WTS ".$_GET['WTSN']." LIKE '".$_GET['WTS']."%'
						AND AD ".$_GET['ADN']." LIKE '".$_GET['AD']."%'
						AND Responsible ".$_GET['RespN']." LIKE '".$_GET['Responsible']."%'
						AND Week ".$_GET['WeekN']." LIKE '".$_GET['Week']."%'
						AND Comments ".$_GET['CommentsN']." LIKE '%".$_GET['Comments']."%'
						AND RuleName ".$_GET['RuleNameN']." LIKE '%".$_GET['RuleName']."%'
						AND DeploymentStatus ".$_GET['StatusN']." LIKE '".$_GET['Status']."%'
						AND AlertingGroup ".$_GET['GroupN']." LIKE '".$_GET['AlertingGroup']."%'
						AND QDB ".$_GET['QDBN']." LIKE '".$_GET['QDB']."%'
						AND System ".$_GET['SystemN']." LIKE '".$system."%'
						AND Dispatcher ".$_GET['DispN']." LIKE '".$_GET['Dispatcher']."%') AS A 
						ORDER BY CIM DESC
							";
								$x=mssql_query($query,$qdb);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option style="text-align:center;color:red;" value="<?=$lista['CIM']?>" <?if(!empty($_GET['CIM']) && $_GET['CIM']== $lista['CIM']) echo 'SELECTED'?>><B><?=$lista['CIM']?></B></option><?
				}?>
			</select></td>
<td style="text-align:center;"><span class="NOT" id="<?=$_GET[ADN]?>" onclick="$('#ADN').val('<?if(empty($_GET[ADN])) echo "NOT"; else echo "";?>');$('#form').submit();"><B><?if($_GET[ADN]!="NOT"){echo '<img src="img/rowny.gif" style="height:20px;">';}else{echo '<img src="img/nierowny.jpg" style="height:20px;">';}?></B></span><br><select style="width:70px;" name="form_AD" onchange="$('#form_AD').val(this.value);$('#form').submit();">
				<option value="" <?if(empty($_GET['AD']) || $_GET['AD']=='') echo 'SELECTED'?>>All</option>
				<?$query="SELECT DISTINCT AD FROM (SELECT AD FROM SMC_Deployment_Service_TABLE
								WHERE ServerName NOT IN 
							(SELECT ServerName FROM dbo.SMC_Deployment_Service_TABLE
							WHERE System='WinOS' AND (CIM LIKE '".$MaxCIM3."%' OR 
							CIM LIKE '".$MaxDELL3."%' OR CIM LIKE 'Not Needed') AND (WinOS LIKE '".$MaxNT3."%'
							) AND (WTS LIKE 'Not Needed' OR WTS LIKE '".$MaxWTS3."%') AND 
							Agent LIKE '".$MaxAgent3."%')
						AND ServerName ".$_GET['ServerNameN']." LIKE '".$_GET['ServerName']."%'
						AND WinOS ".$_GET['WinOSN']." LIKE '".$_GET['WinOS']."%'
						AND Agent ".$_GET['AgentN']." LIKE '".$_GET['Agent']."%'
						AND WTS ".$_GET['WTSN']." LIKE '".$_GET['WTS']."%'
						AND CIM ".$_GET['CIMN']." LIKE '".$_GET['CIM']."%'
						AND Responsible ".$_GET['RespN']." LIKE '".$_GET['Responsible']."%'
						AND Week ".$_GET['WeekN']." LIKE '".$_GET['Week']."%'
						AND Comments ".$_GET['CommentsN']." LIKE '%".$_GET['Comments']."%'
						AND RuleName ".$_GET['RuleNameN']." LIKE '%".$_GET['RuleName']."%'
						AND DeploymentStatus ".$_GET['StatusN']." LIKE '".$_GET['Status']."%'
						AND AlertingGroup ".$_GET['GroupN']." LIKE '".$_GET['AlertingGroup']."%'
						AND QDB ".$_GET['QDBN']." LIKE '".$_GET['QDB']."%'
						AND System ".$_GET['SystemN']." LIKE '".$system."%'
						AND Dispatcher ".$_GET['DispN']." LIKE '".$_GET['Dispatcher']."%') AS A 
						ORDER BY AD DESC
							";
								$x=mssql_query($query,$qdb);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option style="text-align:center;color:red;" value="<?=$lista['AD']?>" <?if(!empty($_GET['AD']) && $_GET['AD']== $lista['AD']) echo 'SELECTED'?>><B><?=$lista['AD']?></B></option><?
				}?>
			</select></td>
<td style="text-align:center;"><span class="NOT" id="<?=$_GET[RespN]?>" onclick="$('#RespN').val('<?if(empty($_GET[RespN])) echo "NOT"; else echo "";?>');$('#form').submit();"><B><?if($_GET[RespN]!="NOT"){echo '<img src="img/rowny.gif" style="height:20px;">';}else{echo '<img src="img/nierowny.jpg" style="height:20px;">';}?></B></span><br><select style="width:55px;" name="form_Responsible" onchange="$('#form_Responsible').val(this.value);$('#form').submit();">
				<option value="" <?if(empty($_GET['Responsible']) || $_GET['Responsible']=='') echo 'SELECTED'?>>All</option>
				<?$query="SELECT DISTINCT Responsible FROM (SELECT Responsible FROM SMC_Deployment_Service_TABLE
								WHERE ServerName NOT IN 
							(SELECT ServerName FROM dbo.SMC_Deployment_Service_TABLE
							WHERE System='WinOS' AND (CIM LIKE '".$MaxCIM3."%' OR 
							CIM LIKE '".$MaxDELL3."%' OR CIM LIKE 'Not Needed') AND (WinOS LIKE '".$MaxNT3."%'
							) AND (WTS LIKE 'Not Needed' OR WTS LIKE '".$MaxWTS3."%') AND 
							Agent LIKE '".$MaxAgent3."%')
						AND ServerName ".$_GET['ServerNameN']." LIKE '".$_GET['ServerName']."%'
						AND WinOS ".$_GET['WinOSN']." LIKE '".$_GET['WinOS']."%'
						AND Agent ".$_GET['AgentN']." LIKE '".$_GET['Agent']."%'
						AND WTS ".$_GET['WTSN']." LIKE '".$_GET['WTS']."%'
						AND CIM ".$_GET['CIMN']." LIKE '".$_GET['CIM']."%'
						AND AD ".$_GET['ADN']." LIKE '".$_GET['AD']."%'
						AND Week ".$_GET['WeekN']." LIKE '".$_GET['Week']."%'
						AND Comments ".$_GET['CommentsN']." LIKE '%".$_GET['Comments']."%'
						AND RuleName ".$_GET['RuleNameN']." LIKE '%".$_GET['RuleName']."%'
						AND DeploymentStatus ".$_GET['StatusN']." LIKE '".$_GET['Status']."%'
						AND AlertingGroup ".$_GET['GroupN']." LIKE '".$_GET['AlertingGroup']."%'
						AND QDB ".$_GET['QDBN']." LIKE '".$_GET['QDB']."%'
						AND System ".$_GET['SystemN']." LIKE '".$system."%'
						AND Dispatcher ".$_GET['DispN']." LIKE '".$_GET['Dispatcher']."%') AS A 
						ORDER BY Responsible DESC
							";
								$x=mssql_query($query,$qdb);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option style="text-align:center;color:red;" value="<?=$lista['Responsible']?>" <?if(!empty($_GET['Responsible']) && $_GET['Responsible']== $lista['Responsible']) echo 'SELECTED'?>><B><?=$lista['Responsible']?></B></option><?
				}?>
</select></td>
<td style="text-align:center;"><span class="NOT" id="<?=$_GET[WeekN]?>" onclick="$('#WeekN').val('<?if(empty($_GET[WeekN])) echo "NOT"; else echo "";?>');$('#form').submit();"><B><?if($_GET[WeekN]!="NOT"){echo '<img src="img/rowny.gif" style="height:20px;">';}else{echo '<img src="img/nierowny.jpg" style="height:20px;">';}?></B></span><br><select name="form_Week" onchange="$('#form_Week').val(this.value);$('#form').submit();">
				<option value="" <?if(empty($_GET['Week']) || $_GET['Week']==='') echo 'SELECTED'?>>All</option>
				<option value="99" <?if($_GET['Week']==='0' || $_GET['Week']==='99') echo 'SELECTED'?> style="text-align:center;color:red;">0</option>
				<?$query="SELECT DISTINCT Week FROM (SELECT Week FROM SMC_Deployment_Service_TABLE
								WHERE Week>0 AND Week<>99 AND ServerName NOT IN 
							(SELECT ServerName FROM dbo.SMC_Deployment_Service_TABLE
							WHERE System='WinOS' AND (CIM LIKE '".$MaxCIM3."%' OR 
							CIM LIKE '".$MaxDELL3."%' OR CIM LIKE 'Not Needed') AND (WinOS LIKE '".$MaxNT3."%'
							) AND (WTS LIKE 'Not Needed' OR WTS LIKE '".$MaxWTS3."%') AND 
							Agent LIKE '".$MaxAgent3."%')
						AND ServerName ".$_GET['ServerNameN']." LIKE '".$_GET['ServerName']."%'
						AND WinOS ".$_GET['WinOSN']." LIKE '".$_GET['WinOS']."%'
						AND Agent ".$_GET['AgentN']." LIKE '".$_GET['Agent']."%'
						AND WTS ".$_GET['WTSN']." LIKE '".$_GET['WTS']."%'
						AND CIM ".$_GET['CIMN']." LIKE '".$_GET['CIM']."%'
						AND AD ".$_GET['ADN']." LIKE '".$_GET['AD']."%'
						AND Responsible ".$_GET['RespN']." LIKE '".$_GET['Responsible']."%'
						AND Comments ".$_GET['CommentsN']." LIKE '%".$_GET['Comments']."%'
						AND RuleName ".$_GET['RuleNameN']." LIKE '%".$_GET['RuleName']."%'
						AND DeploymentStatus ".$_GET['StatusN']." LIKE '".$_GET['Status']."%'
						AND AlertingGroup ".$_GET['GroupN']." LIKE '".$_GET['AlertingGroup']."%'
						AND QDB ".$_GET['QDBN']." LIKE '".$_GET['QDB']."%'
						AND System ".$_GET['SystemN']." LIKE '".$system."%'
						AND Dispatcher ".$_GET['DispN']." LIKE '".$_GET['Dispatcher']."%') AS A 
						ORDER BY Week DESC
							";
								$x=mssql_query($query,$qdb);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option style="text-align:center;color:red;" value="<?=$lista['Week']?>" <?if(!empty($_GET['Week']) && $_GET['Week']== $lista['Week']) echo 'SELECTED'?>><B><?=$lista['Week']?></B></option><?
				}?>
			</select></td>
<td style="text-align:center;"><span class="NOT" id="<?=$_GET[RuleNameN]?>" onclick="$('#RuleNameN').val('<?if(empty($_GET[RuleNameN])) echo "NOT"; else echo "";?>');$('#form').submit();"><B><?if($_GET[RuleNameN]!="NOT"){echo '<img src="img/rowny.gif" style="height:20px;">';}else{echo '<img src="img/nierowny.jpg" style="height:20px;">';}?></B></span>
<form name="server" action="<?=$_SERVER['PHP_SELF']?>" style="padding:0; margin:0;" id="form" method="get">
<input type="text" class="textInInput" style="color:red;border:1px solid #c0cae4;" id="form_RuleName" name="RuleName" value="<?=addslashes($_GET['RuleName']);?>"><input type="hidden" id="ServerName" name="ServerName"  value="<?if(!empty($_GET['ServerName'])) echo $_GET['ServerName'];?>">
<input type="hidden" id="ServerNameN" name="ServerNameN"  value="<?if(!empty($_GET['ServerNameN'])) echo $_GET['ServerNameN'];?>" />
<input type="hidden" id="form_WinOS" name="WinOS"  value="<?if(!empty($_GET['WinOS'])) echo $_GET['WinOS'];?>" />
<input type="hidden" id="form_WTS" name="WTS"  value="<?if(!empty($_GET['WTS'])) echo $_GET['WTS'];?>" />
<input type="hidden" id="form_CIM" name="CIM"  value="<?if(!empty($_GET['CIM'])) echo $_GET['CIM'];?>" />
<input type="hidden" id="form_AD" name="AD"  value="<?if(!empty($_GET['AD'])) echo $_GET['AD'];?>" />
<input type="hidden" id="form_Responsible" name="Responsible"  value="<?if(!empty($_GET['Responsible'])) echo $_GET['Responsible'];?>" />
<input type="hidden" id="form_Dispatcher" name="Dispatcher"  value="<?if(!empty($_GET['Dispatcher'])) echo $_GET['Dispatcher'];?>" />
<input type="hidden" id="form_QDB" name="QDB"  value="<?if(!empty($_GET['QDB'])) echo $_GET['QDB'];?>" />
<input type="hidden" id="form_AlertingGroup" name="AlertingGroup"  value="<?if(!empty($_GET['AlertingGroup'])) echo $_GET['AlertingGroup'];?>" />
<input type="hidden" id="form_Status" name="Status"  value="<?if(!empty($_GET['Status'])) echo $_GET['Status'];?>" />
<input type="hidden" id="form_Comments" name="Comments"  value="<?if(!empty($_GET['Comments'])) echo $_GET['Comments'];?>" />
<input type="hidden" id="form_Week" name="Week"  value="<?if(!empty($_GET['Week'])) echo $_GET['Week'];?>" />
<input type="hidden" id="form_System" name="System"  value="<?if(!empty($_GET['System'])) echo $_GET['System'];?>" />
<input type="hidden" id="AgentN" name="AgentN"  value="<?if(!empty($_GET['AgentN'])) echo $_GET['AgentN'];?>" />
<input type="hidden" id="WinOSN" name="WinOSN"  value="<?if(!empty($_GET['WinOSN'])) echo $_GET['WinOSN'];?>" />
<input type="hidden" id="WTSN" name="WTSN"  value="<?if(!empty($_GET['WTSN'])) echo $_GET['WTSN'];?>" />
<input type="hidden" id="CIMN" name="CIMN"  value="<?if(!empty($_GET['CIMN'])) echo $_GET['CIMN'];?>" />
<input type="hidden" id="ADN" name="ADN"  value="<?if(!empty($_GET['ADN'])) echo $_GET['ADN'];?>" />
<input type="hidden" id="RespN" name="RespN"  value="<?if(!empty($_GET['RespN'])) echo $_GET['RespN'];?>" />
<input type="hidden" id="WeekN" name="WeekN"  value="<?if(!empty($_GET['WeekN'])) echo $_GET['WeekN'];?>" />
<input type="hidden" id="StatusN" name="StatusN"  value="<?if(!empty($_GET['StatusN'])) echo $_GET['StatusN'];?>" />
<input type="hidden" id="DispN" name="DispN"  value="<?if(!empty($_GET['DispN'])) echo $_GET['DispN'];?>" />
<input type="hidden" id="QDBN" name="QDBN"  value="<?if(!empty($_GET['QDBN'])) echo $_GET['QDBN'];?>" />
<input type="hidden" id="SystemN" name="SystemN"  value="<?if(!empty($_GET['SystemN'])) echo $_GET['SystemN'];?>" />
<input type="hidden" id="RuleNameN" name="RuleNameN"  value="<?if(!empty($_GET['RuleNameN'])) echo $_GET['RuleNameN'];?>" />
<input type="hidden" id="CommentsN" name="CommentsN"  value="<?if(!empty($_GET['CommentsN'])) echo $_GET['CommentsN'];?>" />
<input type="hidden" id="GroupN" name="GroupN"  value="<?if(!empty($_GET['GroupN'])) echo $_GET['GroupN'];?>" />
<input type="hidden" id="order" name="order"  value="<?if(!empty($_GET['order'])) echo $_GET['order'];?>" />
</form></td>
<td style="text-align:center;"><span class="NOT" id="<?=$_GET[CommentsN]?>" onclick="$('#CommentsN').val('<?if(empty($_GET[CommentsN])) echo "NOT"; else echo "";?>');$('#form').submit();"><B><?if($_GET[CommentsN]!="NOT"){echo '<img src="img/rowny.gif" style="height:20px;">';}else{echo '<img src="img/nierowny.jpg" style="height:20px;">';}?></B></span>
<form name="server" action="<?=$_SERVER['PHP_SELF']?>" style="padding:0; margin:0;" id="form" method="get"><input type="text" class="textInInput" style="color:red;border:1px solid #c0cae4;" id="form_Comments" name="Comments" value="<?=addslashes($_GET['Comments']);?>">
<input type="hidden" id="form_Agent" name="Agent"  value="<?if(!empty($_GET['Agent'])) echo $_GET['Agent'];?>" />
<input type="hidden" id="ServerName" name="ServerName"  value="<?if(!empty($_GET['ServerName'])) echo $_GET['ServerName'];?>" />
<input type="hidden" id="ServerNameN" name="ServerNameN"  value="<?if(!empty($_GET['ServerNameN'])) echo $_GET['ServerNameN'];?>" />
<input type="hidden" id="form_WinOS" name="WinOS"  value="<?if(!empty($_GET['WinOS'])) echo $_GET['WinOS'];?>" />
<input type="hidden" id="form_WTS" name="WTS"  value="<?if(!empty($_GET['WTS'])) echo $_GET['WTS'];?>" />
<input type="hidden" id="form_CIM" name="CIM"  value="<?if(!empty($_GET['CIM'])) echo $_GET['CIM'];?>" />
<input type="hidden" id="form_AD" name="AD"  value="<?if(!empty($_GET['AD'])) echo $_GET['AD'];?>" />
<input type="hidden" id="form_Responsible" name="Responsible"  value="<?if(!empty($_GET['Responsible'])) echo $_GET['Responsible'];?>" />
<input type="hidden" id="form_Dispatcher" name="Dispatcher"  value="<?if(!empty($_GET['Dispatcher'])) echo $_GET['Dispatcher'];?>" />
<input type="hidden" id="form_QDB" name="QDB"  value="<?if(!empty($_GET['QDB'])) echo $_GET['QDB'];?>" />
<input type="hidden" id="form_AlertingGroup" name="AlertingGroup"  value="<?if(!empty($_GET['AlertingGroup'])) echo $_GET['AlertingGroup'];?>" />
<input type="hidden" id="form_Status" name="Status"  value="<?if(!empty($_GET['Status'])) echo $_GET['Status'];?>" />
<input type="hidden" id="form_RuleName" name="RuleName"  value="<?if(!empty($_GET['RuleName'])) echo $_GET['RuleName'];?>" />
<input type="hidden" id="form_Week" name="Week"  value="<?if(!empty($_GET['Week'])) echo $_GET['Week'];?>" />
<input type="hidden" id="form_System" name="System"  value="<?if(!empty($_GET['System'])) echo $_GET['System'];?>" />
<input type="hidden" id="AgentN" name="AgentN"  value="<?if(!empty($_GET['AgentN'])) echo $_GET['AgentN'];?>" />
<input type="hidden" id="WinOSN" name="WinOSN"  value="<?if(!empty($_GET['WinOSN'])) echo $_GET['WinOSN'];?>" />
<input type="hidden" id="WTSN" name="WTSN"  value="<?if(!empty($_GET['WTSN'])) echo $_GET['WTSN'];?>" />
<input type="hidden" id="CIMN" name="CIMN"  value="<?if(!empty($_GET['CIMN'])) echo $_GET['CIMN'];?>" />
<input type="hidden" id="ADN" name="ADN"  value="<?if(!empty($_GET['ADN'])) echo $_GET['ADN'];?>" />
<input type="hidden" id="RespN" name="RespN"  value="<?if(!empty($_GET['RespN'])) echo $_GET['RespN'];?>" />
<input type="hidden" id="WeekN" name="WeekN"  value="<?if(!empty($_GET['WeekN'])) echo $_GET['WeekN'];?>" />
<input type="hidden" id="StatusN" name="StatusN"  value="<?if(!empty($_GET['StatusN'])) echo $_GET['StatusN'];?>" />
<input type="hidden" id="DispN" name="DispN"  value="<?if(!empty($_GET['DispN'])) echo $_GET['DispN'];?>" />
<input type="hidden" id="QDBN" name="QDBN"  value="<?if(!empty($_GET['QDBN'])) echo $_GET['QDBN'];?>" />
<input type="hidden" id="SystemN" name="SystemN"  value="<?if(!empty($_GET['SystemN'])) echo $_GET['SystemN'];?>" />
<input type="hidden" id="GroupN" name="GroupN"  value="<?if(!empty($_GET['GroupN'])) echo $_GET['GroupN'];?>" />
<input type="hidden" id="RuleNameN" name="RuleNameN"  value="<?if(!empty($_GET['RuleNameN'])) echo $_GET['RuleNameN'];?>" />
<input type="hidden" id="CommentsN" name="CommentsN"  value="<?if(!empty($_GET['CommentsN'])) echo $_GET['CommentsN'];?>" />
<input type="hidden" id="order" name="order"  value="<?if(!empty($_GET['order'])) echo $_GET['order'];?>" />
</form></td>
<td style="text-align:center;"><!--Date--></td>
<td style="text-align:center;"><span class="NOT" id="<?=$_GET[StatusN]?>" onclick="$('#StatusN').val('<?if(empty($_GET[StatusN])) echo "NOT"; else echo "";?>');$('#form').submit();"><B><?if($_GET[StatusN]!="NOT"){echo '<img src="img/rowny.gif" style="height:20px;">';}else{echo '<img src="img/nierowny.jpg" style="height:20px;">';}?></B></span><br><select style="width:110px;" name="form_Status" onchange="$('#form_Status').val(this.value);$('#form').submit();">
				<option value="" <?if(empty($_GET['Status']) || $_GET['Status']=='') echo 'SELECTED'?>>All</option>
				<?$query="SELECT DISTINCT Status FROM (SELECT DeploymentStatus AS Status FROM SMC_Deployment_Service_TABLE
								WHERE ServerName NOT IN 
							(SELECT ServerName FROM dbo.SMC_Deployment_Service_TABLE
							WHERE System='WinOS' AND (CIM LIKE '".$MaxCIM3."%' OR 
							CIM LIKE '".$MaxDELL3."%' OR CIM LIKE 'Not Needed') AND (WinOS LIKE '".$MaxNT3."%'
							) AND (WTS LIKE 'Not Needed' OR WTS LIKE '".$MaxWTS3."%') AND 
							Agent LIKE '".$MaxAgent3."%')
						AND ServerName ".$_GET['ServerNameN']." LIKE '".$_GET['ServerName']."%'
						AND WinOS ".$_GET['WinOSN']." LIKE '".$_GET['WinOS']."%'
						AND Agent ".$_GET['AgentN']." LIKE '".$_GET['Agent']."%'
						AND WTS ".$_GET['WTSN']." LIKE '".$_GET['WTS']."%'
						AND CIM ".$_GET['CIMN']." LIKE '".$_GET['CIM']."%'
						AND AD ".$_GET['ADN']." LIKE '".$_GET['AD']."%'
						AND Responsible ".$_GET['RespN']." LIKE '".$_GET['Responsible']."%'
						AND Week ".$_GET['WeekN']." LIKE '".$_GET['Week']."%'
						AND Comments ".$_GET['CommentsN']." LIKE '%".$_GET['Comments']."%'
						AND RuleName ".$_GET['RuleNameN']." LIKE '%".$_GET['RuleName']."%'
						AND AlertingGroup ".$_GET['GroupN']." LIKE '".$_GET['AlertingGroup']."%'
						AND QDB ".$_GET['QDBN']." LIKE '".$_GET['QDB']."%'
						AND System ".$_GET['SystemN']." LIKE '".$system."%'
						AND Dispatcher ".$_GET['DispN']." LIKE '".$_GET['Dispatcher']."%') AS A 
						ORDER BY Status ASC
							";
								$x=mssql_query($query,$qdb);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option style="text-align:center;color:red;" value="<?=$lista['Status']?>" <?if(!empty($_GET['Status']) && $_GET['Status']== $lista['Status']) echo 'SELECTED'?>><B><?=$lista['Status']?></B></option><?
				}?>
			</select></td>

<?
//if($login == true)
//{
?>
<td style="text-align:center;">
<input type="submit" onclick="checkall()" value="Check" style="background-color:#FFFFFF;"><br>
<input type="submit" onclick="uncheckall()" value="Uncheck" style="background-color:#FFFFFF;"></td>
<?
//}
?>
<td style="text-align:center;"><span class="NOT" id="<?=$_GET[GroupN]?>" onclick="$('#GroupN').val('<?if(empty($_GET[GroupN])) echo "NOT"; else echo "";?>');$('#form').submit();"><B><?if($_GET[GroupN]!="NOT"){echo '<img src="img/rowny.gif" style="height:20px;">';}else{echo '<img src="img/nierowny.jpg" style="height:20px;">';}?></B></span><br><select style="width:100px;" name="form_AlertingGroup" onchange="$('#form_AlertingGroup').val(this.value);$('#form').submit();">
				<option value="" <?if(empty($_GET['AlertingGroup']) || $_GET['AlertingGroup']=='') echo 'SELECTED'?>>All</option>
				<?$query="SELECT DISTINCT AlertingGroup FROM (SELECT AlertingGroup FROM SMC_Deployment_Service_TABLE
								WHERE ServerName NOT IN 
							(SELECT ServerName FROM dbo.SMC_Deployment_Service_TABLE
							WHERE System='WinOS' AND (CIM LIKE '".$MaxCIM3."%' OR 
							CIM LIKE '".$MaxDELL3."%' OR CIM LIKE 'Not Needed') AND (WinOS LIKE '".$MaxNT3."%'
							) AND (WTS LIKE 'Not Needed' OR WTS LIKE '".$MaxWTS3."%') AND 
							Agent LIKE '".$MaxAgent3."%')
						AND ServerName ".$_GET['ServerNameN']." LIKE '".$_GET['ServerName']."%'
						AND WinOS ".$_GET['WinOSN']." LIKE '".$_GET['WinOS']."%'
						AND Agent ".$_GET['AgentN']." LIKE '".$_GET['Agent']."%'
						AND WTS ".$_GET['WTSN']." LIKE '".$_GET['WTS']."%'
						AND CIM ".$_GET['CIMN']." LIKE '".$_GET['CIM']."%'
						AND AD ".$_GET['ADN']." LIKE '".$_GET['AD']."%'
						AND Responsible ".$_GET['RespN']." LIKE '".$_GET['Responsible']."%'
						AND Week ".$_GET['WeekN']." LIKE '".$_GET['Week']."%'
						AND Comments ".$_GET['CommentsN']." LIKE '%".$_GET['Comments']."%'
						AND RuleName ".$_GET['RuleNameN']." LIKE '%".$_GET['RuleName']."%'
						AND DeploymentStatus ".$_GET['StatusN']." LIKE '".$_GET['Status']."%'
						AND QDB ".$_GET['QDBN']." LIKE '".$_GET['QDB']."%'
						AND System ".$_GET['SystemN']." LIKE '".$system."%'
						AND Dispatcher ".$_GET['DispN']." LIKE '".$_GET['Dispatcher']."%') AS A 
						ORDER BY AlertingGroup ASC
							";
								$x=mssql_query($query,$qdb);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option style="text-align:center;color:red;" value="<?=$lista['AlertingGroup']?>" <?if(!empty($_GET['AlertingGroup']) && $_GET['AlertingGroup']== $lista['AlertingGroup']) echo 'SELECTED'?>><B><?=$lista['AlertingGroup']?></B></option><?
				}?>
			</select></td>
<td style="text-align:center;"><span class="NOT" id="<?=$_GET[QDBN]?>" onclick="$('#QDBN').val('<?if(empty($_GET[QDBN])) echo "NOT"; else echo "";?>');$('#form').submit();"><B><?if($_GET[QDBN]!="NOT"){echo '<img src="img/rowny.gif" style="height:20px;">';}else{echo '<img src="img/nierowny.jpg" style="height:20px;">';}?></B></span><br><select style="width:60px;" name="form_QDB" onchange="$('#form_QDB').val(this.value);$('#form').submit();">
				<option value="" <?if(empty($_GET['QDB']) || $_GET['QDB']=='') echo 'SELECTED'?>>All</option>
				<?$query="SELECT DISTINCT QDB FROM (SELECT QDB FROM SMC_Deployment_Service_TABLE
								WHERE ServerName NOT IN 
							(SELECT ServerName FROM dbo.SMC_Deployment_Service_TABLE
							WHERE System='WinOS' AND (CIM LIKE '".$MaxCIM3."%' OR 
							CIM LIKE '".$MaxDELL3."%' OR CIM LIKE 'Not Needed') AND (WinOS LIKE '".$MaxNT3."%'
							) AND (WTS LIKE 'Not Needed' OR WTS LIKE '".$MaxWTS3."%') AND 
							Agent LIKE '".$MaxAgent3."%')
						AND ServerName ".$_GET['ServerNameN']." LIKE '".$_GET['ServerName']."%'
						AND WinOS ".$_GET['WinOSN']." LIKE '".$_GET['WinOS']."%'
						AND Agent ".$_GET['AgentN']." LIKE '".$_GET['Agent']."%'
						AND WTS ".$_GET['WTSN']." LIKE '".$_GET['WTS']."%'
						AND CIM ".$_GET['CIMN']." LIKE '".$_GET['CIM']."%'
						AND AD ".$_GET['ADN']." LIKE '".$_GET['AD']."%'
						AND Responsible ".$_GET['RespN']." LIKE '".$_GET['Responsible']."%'
						AND Week ".$_GET['WeekN']." LIKE '".$_GET['Week']."%'
						AND Comments ".$_GET['CommentsN']." LIKE '%".$_GET['Comments']."%'
						AND RuleName ".$_GET['RuleNameN']." LIKE '%".$_GET['RuleName']."%'
						AND DeploymentStatus ".$_GET['StatusN']." LIKE '".$_GET['Status']."%'
						AND AlertingGroup ".$_GET['GroupN']." LIKE '".$_GET['AlertingGroup']."%'
						AND System ".$_GET['SystemN']." LIKE '".$system."%'
						AND Dispatcher ".$_GET['DispN']." LIKE '".$_GET['Dispatcher']."%') AS A 
						ORDER BY QDB ASC
							";
								$x=mssql_query($query,$qdb);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option style="text-align:center;color:red;" value="<?=$lista['QDB']?>" <?if(!empty($_GET['QDB']) && $_GET['QDB']== $lista['QDB']) echo 'SELECTED'?>><B><?=$lista['QDB']?></B></option><?
				}?>
			</select></td>
<td style="text-align:center;"><span class="NOT" id="<?=$_GET[DispN]?>" onclick="$('#DispN').val('<?if(empty($_GET[DispN])) echo "NOT"; else echo "";?>');$('#form').submit();"><B><?if($_GET[DispN]!="NOT"){echo '<img src="img/rowny.gif" style="height:20px;">';}else{echo '<img src="img/nierowny.jpg" style="height:20px;">';}?></B></span><br><select style="width:55px;" name="form_Dispatcher" onchange="$('#form_Dispatcher').val(this.value);$('#form').submit();">
				<option value="" <?if(empty($_GET['Dispatcher']) || $_GET['Dispatcher']=='') echo 'SELECTED'?>>All</option>
				<?$query="SELECT DISTINCT Dispatcher FROM (SELECT Dispatcher FROM SMC_Deployment_Service_TABLE
								WHERE ServerName NOT IN 
							(SELECT ServerName FROM dbo.SMC_Deployment_Service_TABLE
							WHERE System='WinOS' AND (CIM LIKE '".$MaxCIM3."%' OR 
							CIM LIKE '".$MaxDELL3."%' OR CIM LIKE 'Not Needed') AND (WinOS LIKE '".$MaxNT3."%'
							) AND (WTS LIKE 'Not Needed' OR WTS LIKE '".$MaxWTS3."%') AND 
							Agent LIKE '".$MaxAgent3."%')
						AND ServerName ".$_GET['ServerNameN']." LIKE '".$_GET['ServerName']."%'
						AND WinOS ".$_GET['WinOSN']." LIKE '".$_GET['WinOS']."%'
						AND Agent ".$_GET['AgentN']." LIKE '".$_GET['Agent']."%'
						AND WTS ".$_GET['WTSN']." LIKE '".$_GET['WTS']."%'
						AND CIM ".$_GET['CIMN']." LIKE '".$_GET['CIM']."%'
						AND AD ".$_GET['ADN']." LIKE '".$_GET['AD']."%'
						AND Responsible ".$_GET['RespN']." LIKE '".$_GET['Responsible']."%'
						AND Week ".$_GET['WeekN']." LIKE '".$_GET['Week']."%'
						AND Comments ".$_GET['CommentsN']." LIKE '%".$_GET['Comments']."%'
						AND RuleName ".$_GET['RuleNameN']." LIKE '%".$_GET['RuleName']."%'
						AND DeploymentStatus ".$_GET['StatusN']." LIKE '".$_GET['Status']."%'
						AND AlertingGroup ".$_GET['GroupN']." LIKE '".$_GET['AlertingGroup']."%'
						AND QDB ".$_GET['QDBN']." LIKE '".$_GET['QDB']."%'
						AND System ".$_GET['SystemN']." LIKE '".$system."%') AS A 
						ORDER BY Dispatcher ASC
							";
								$x=mssql_query($query,$qdb);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option style="text-align:center;color:red;" value="<?=$lista['Dispatcher']?>" <?if(!empty($_GET['Dispatcher']) && $_GET['Dispatcher']== $lista['Dispatcher']) echo 'SELECTED'?>><B><?=$lista['Dispatcher']?></B></option><?
				}?>
</select></td>
<td style="text-align:center;"><span class="NOT" id="<?=$_GET[SystemN]?>" onclick="$('#SystemN').val('<?if(empty($_GET[SystemN])) echo "NOT"; else echo "";?>');$('#form').submit();"><B><?if($_GET[SystemN]!="NOT"){echo '<img src="img/rowny.gif" style="height:20px;">';}else{echo '<img src="img/nierowny.jpg" style="height:20px;">';}?></B></span><br><select style="width:65px;" name="form_System" onchange="$('#form_System').val(this.value);$('#form').submit();">
				<option value="" <?if(empty($_GET['System']) || $_GET['System']=='') echo 'SELECTED'?>>All</option>
				<?$query="SELECT DISTINCT System FROM (SELECT System FROM SMC_Deployment_Service_TABLE
								WHERE ServerName NOT IN 
							(SELECT ServerName FROM dbo.SMC_Deployment_Service_TABLE
							WHERE System='WinOS' AND (CIM LIKE '".$MaxCIM3."%' OR 
							CIM LIKE '".$MaxDELL3."%' OR CIM LIKE 'Not Needed') AND (WinOS LIKE '".$MaxNT3."%'
							) AND (WTS LIKE 'Not Needed' OR WTS LIKE '".$MaxWTS3."%') AND 
							Agent LIKE '".$MaxAgent3."%')
						AND ServerName ".$_GET['ServerNameN']." LIKE '".$_GET['ServerName']."%'
						AND WinOS ".$_GET['WinOSN']." LIKE '".$_GET['WinOS']."%'
						AND Agent ".$_GET['AgentN']." LIKE '".$_GET['Agent']."%'
						AND WTS ".$_GET['WTSN']." LIKE '".$_GET['WTS']."%'
						AND CIM ".$_GET['CIMN']." LIKE '".$_GET['CIM']."%'
						AND AD ".$_GET['ADN']." LIKE '".$_GET['AD']."%'
						AND Responsible ".$_GET['RespN']." LIKE '".$_GET['Responsible']."%'
						AND Week ".$_GET['WeekN']." LIKE '".$_GET['Week']."%'
						AND Comments ".$_GET['CommentsN']." LIKE '%".$_GET['Comments']."%'
						AND RuleName ".$_GET['RuleNameN']." LIKE '%".$_GET['RuleName']."%'
						AND DeploymentStatus ".$_GET['StatusN']." LIKE '".$_GET['Status']."%'
						AND AlertingGroup ".$_GET['GroupN']." LIKE '".$_GET['AlertingGroup']."%'
						AND QDB ".$_GET['QDBN']." LIKE '".$_GET['QDB']."%'
						AND Dispatcher ".$_GET['DispN']." LIKE '".$_GET['Dispatcher']."%') AS A 
						ORDER BY System DESC
							";
								$x=mssql_query($query,$qdb);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option style="text-align:center;color:red;" value="<?=$lista['System']?>" <?if(!empty($_GET['System']) && $_GET['System']== $lista['System']) echo 'SELECTED'?>><B><?=$lista['System']?></B></option><?
				}?>
</select></td>
</tr>
<tr id="wiecej" style="display:none;" bgcolor="#e9f2fb" height="100">
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"><select id="D0000001">
				<option value="24">None</option>
				<option value="2">SB</option>
				<option value="15">LG</option>
				<option value="11">PG</option>
				<option value="13">LH</option>
				<option value="16">MH</option>
				<option value="8">MJ</option>
				<option value="3">WK</option>
				<option value="7">MM</option>
				<option value="10">PN</option>
				<option value="17">KP</option>
				<option value="21">MW</option>
				<option value="20">MZ</option>
	</select></td>
<td align="center"><select id="C0000001">
				<option value="99">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				<option value="31">31</option>
				<option value="32">32</option>
				<option value="33">33</option>
				<option value="34">34</option>
				<option value="35">35</option>
				<option value="36">36</option>
				<option value="37">37</option>
				<option value="38">38</option>
				<option value="39">39</option>
				<option value="40">40</option>
				<option value="41">41</option>
				<option value="42">42</option>
				<option value="43">43</option>
				<option value="44">44</option>
				<option value="45">45</option>
				<option value="46">46</option>
				<option value="47">47</option>
				<option value="48">48</option>
				<option value="49">49</option>
				<option value="50">50</option>
				<option value="51">51</option>
				<option value="52">52</option>
				<option value="53">53</option>
				</select></td>
<td align="center"><textarea id="B0000001" rows="" style="border:0; overflow:auto;width:97%;height:70px;" cols="" ></textarea></td>
<td align="center"><textarea id="A0000001" rows="" style="border:0; overflow:auto;width:97%;height:70px;" cols="" ></textarea></td>
<td align="center"></td>
<td align="center"><select id="W0000001">
	<?$query="SELECT ID,Status FROM SMC_Deployment_State
							";
								$x=mssql_query($query,$qdb);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option value="<?=$lista['ID']?>"><?=$lista['Status']?></option><?
				}?>
			</select></td>
<td align="center"><img src="../img/save.gif" alt="" title="Save" onclick="javascript:cos2()"/></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
</tr>
<?

while ($row=mssql_fetch_array($res))
{
$tablica[$row[Rownum]]['SN']=$row[ServerName];
$tablica[$row[Rownum]]['ID']=$row[Rownum];
?>
 <tr id="zcheckbox<?=$row[ServerName];?>" onmouseover="this.bgColor='#e9f2fb'" onmouseout="this.bgColor='#FFFFFF'" />
 <td><?=$row[Rownum];?></td>
	<td style="text-align:center;"><?=$row[ServerName];?></td>
	<?if($row[Agent]==$MaxAgent3){?>
	<td style="text-align:center;"><?=$row[Agent];?></td>
	<?}else{?>
	<td style="text-align:center;color:red;"><B><?=$row[Agent];?></B></td>
	<?}?>
	<? if($row[System] == "UNIX"){?>
		<td style="text-align:center;background:silver;"><B><font color="#121212">Unknown(Not available for UNIX systems)</B></font></td>
		<?}else{
		if($row[WinOS]==$MaxNT3){?>
		<td style="text-align:center;"><?=$row[WinOS]; ?></td>
		<?}else{
		?>
		<td style="text-align:center;color:red;"><B><?=$row[WinOS]; ?></B></td>
		<?}}?>
	<?
	if($row[WTS]==$MaxWTS3 || $row[WTS]=="NotNeeded"){?>
	<td style="text-align:center;"><?=$row[WTS];?></td>
	<?}else{?>
	<td style="text-align:center;color:red;"><B><?=$row[WTS];?></B></td>
	<?}
	?>
	<?if ($row[CIM]==$MaxDELL3 || $row[CIM]==$MaxCIM3 || $row[CIM]=="NotNeeded"){?>
	<td style="text-align:center;"><?=$row[CIM]; ?></td>
	<?}else{?>
	<td style="text-align:center;color:red;"><B><?=$row[CIM]; ?></B></td>
	<?}?>
	<?if($row[AD]==$MaxAD3 || $row[AD]=="NotNeeded"){?>
	<td style="text-align:center;"><?=$row[AD]; ?></td>
	<?}else{?>
	<td style="text-align:center;color:red;"><B><?=$row[AD]; ?></B></td>
	<?}
	?>
	<td style="text-align:center;">
				<select style="width:55px;" id="Responsible_N<?=trim($row[ServerName]); ?>">
				<option value="24" <?if(trim($row[Responsible_N])=='24') echo 'SELECTED'?>>None</option>
				<option value="2" <?if(trim($row[Responsible_N])=='1' || trim($row[Responsible_N])=='2' || trim($row[Responsible_N])=='4' || trim($row[Responsible])=='6') echo 'SELECTED'?>>SB</option>
				<option value="15" <?if(trim($row[Responsible_N])=='15') echo 'SELECTED'?>>LG</option>
				<option value="11" <?if(trim($row[Responsible_N])=='11' || trim($row[Responsible_N])=='14') echo 'SELECTED'?>>PG</option>
				<option value="13" <?if(trim($row[Responsible_N])=='13') echo 'SELECTED'?>>LH</option>
				<option value="16" <?if(trim($row[Responsible_N])=='16') echo 'SELECTED'?>>MH</option>
				<option value="8" <?if(trim($row[Responsible_N])=='8' || trim($row[Responsible_N])=='12') echo 'SELECTED'?>>MJ</option>
				<option value="3" <?if(trim($row[Responsible_N])=='3' || trim($row[Responsible_N])=='9') echo 'SELECTED'?>>WK</option>
				<option value="7" <?if(trim($row[Responsible_N])=='7') echo 'SELECTED'?>>MM</option>
				<option value="10" <?if(trim($row[Responsible_N])=='10') echo 'SELECTED'?>>PN</option>
				<option value="17" <?if(trim($row[Responsible_N])=='17') echo 'SELECTED'?>>KP</option>
				<option value="21" <?if(trim($row[Responsible_N])=='21' || trim($row[Responsible_N])=='22') echo 'SELECTED'?>>MW</option>
				<option value="20" <?if(trim($row[Responsible_N])=='20' || trim($row[Responsible_N])=='23') echo 'SELECTED'?>>MZ</option>
	</select></td>
	<td style="text-align:center;"><select id="Week<?=trim($row[ServerName]); ?>">
				<option value="99" <?if(trim($row[Week])=='0' || trim($row[Week])=='99') echo 'SELECTED'?>>0</option>
				<option value="1" <?if(trim($row[Week])=='1') echo 'SELECTED'?>>1</option>
				<option value="2" <?if(trim($row[Week])=='2') echo 'SELECTED'?>>2</option>
				<option value="3" <?if(trim($row[Week])=='3') echo 'SELECTED'?>>3</option>
				<option value="4" <?if(trim($row[Week])=='4') echo 'SELECTED'?>>4</option>
				<option value="5" <?if(trim($row[Week])=='5') echo 'SELECTED'?>>5</option>
				<option value="6" <?if(trim($row[Week])=='6') echo 'SELECTED'?>>6</option>
				<option value="7" <?if(trim($row[Week])=='7') echo 'SELECTED'?>>7</option>
				<option value="8" <?if(trim($row[Week])=='8') echo 'SELECTED'?>>8</option>
				<option value="9" <?if(trim($row[Week])=='9') echo 'SELECTED'?>>9</option>
				<option value="10" <?if(trim($row[Week])=='10') echo 'SELECTED'?>>10</option>
				<option value="11" <?if(trim($row[Week])=='11') echo 'SELECTED'?>>11</option>
				<option value="12" <?if(trim($row[Week])=='12') echo 'SELECTED'?>>12</option>
				<option value="13" <?if(trim($row[Week])=='13') echo 'SELECTED'?>>13</option>
				<option value="14" <?if(trim($row[Week])=='14') echo 'SELECTED'?>>14</option>
				<option value="15" <?if(trim($row[Week])=='15') echo 'SELECTED'?>>15</option>
				<option value="16" <?if(trim($row[Week])=='16') echo 'SELECTED'?>>16</option>
				<option value="17" <?if(trim($row[Week])=='17') echo 'SELECTED'?>>17</option>
				<option value="18" <?if(trim($row[Week])=='18') echo 'SELECTED'?>>18</option>
				<option value="19" <?if(trim($row[Week])=='19') echo 'SELECTED'?>>19</option>
				<option value="20" <?if(trim($row[Week])=='20') echo 'SELECTED'?>>20</option>
				<option value="21" <?if(trim($row[Week])=='21') echo 'SELECTED'?>>21</option>
				<option value="22" <?if(trim($row[Week])=='22') echo 'SELECTED'?>>22</option>
				<option value="23" <?if(trim($row[Week])=='23') echo 'SELECTED'?>>23</option>
				<option value="24" <?if(trim($row[Week])=='24') echo 'SELECTED'?>>24</option>
				<option value="25" <?if(trim($row[Week])=='25') echo 'SELECTED'?>>25</option>
				<option value="26" <?if(trim($row[Week])=='26') echo 'SELECTED'?>>26</option>
				<option value="27" <?if(trim($row[Week])=='27') echo 'SELECTED'?>>27</option>
				<option value="28" <?if(trim($row[Week])=='28') echo 'SELECTED'?>>28</option>
				<option value="29" <?if(trim($row[Week])=='29') echo 'SELECTED'?>>29</option>
				<option value="30" <?if(trim($row[Week])=='30') echo 'SELECTED'?>>30</option>
				<option value="31" <?if(trim($row[Week])=='31') echo 'SELECTED'?>>31</option>
				<option value="32" <?if(trim($row[Week])=='32') echo 'SELECTED'?>>32</option>
				<option value="33" <?if(trim($row[Week])=='33') echo 'SELECTED'?>>33</option>
				<option value="34" <?if(trim($row[Week])=='34') echo 'SELECTED'?>>34</option>
				<option value="35" <?if(trim($row[Week])=='35') echo 'SELECTED'?>>35</option>
				<option value="36" <?if(trim($row[Week])=='36') echo 'SELECTED'?>>36</option>
				<option value="37" <?if(trim($row[Week])=='37') echo 'SELECTED'?>>37</option>
				<option value="38" <?if(trim($row[Week])=='38') echo 'SELECTED'?>>38</option>
				<option value="39" <?if(trim($row[Week])=='39') echo 'SELECTED'?>>39</option>
				<option value="40" <?if(trim($row[Week])=='40') echo 'SELECTED'?>>40</option>
				<option value="41" <?if(trim($row[Week])=='41') echo 'SELECTED'?>>41</option>
				<option value="42" <?if(trim($row[Week])=='42') echo 'SELECTED'?>>42</option>
				<option value="43" <?if(trim($row[Week])=='43') echo 'SELECTED'?>>43</option>
				<option value="44" <?if(trim($row[Week])=='44') echo 'SELECTED'?>>44</option>
				<option value="45" <?if(trim($row[Week])=='45') echo 'SELECTED'?>>45</option>
				<option value="46" <?if(trim($row[Week])=='46') echo 'SELECTED'?>>46</option>
				<option value="47" <?if(trim($row[Week])=='47') echo 'SELECTED'?>>47</option>
				<option value="48" <?if(trim($row[Week])=='48') echo 'SELECTED'?>>48</option>
				<option value="49" <?if(trim($row[Week])=='49') echo 'SELECTED'?>>49</option>
				<option value="50" <?if(trim($row[Week])=='50') echo 'SELECTED'?>>50</option>
				<option value="51" <?if(trim($row[Week])=='51') echo 'SELECTED'?>>51</option>
				<option value="52" <?if(trim($row[Week])=='52') echo 'SELECTED'?>>52</option>
				<option value="53" <?if(trim($row[Week])=='53') echo 'SELECTED'?>>53</option>
				</select>
				</td>
				<td style="width:190px;">
<textarea id="RuleName<?=trim($row[ServerName]); ?>" rows="" style="border:0;overflow:auto;height:70px;width:190px;" cols="" ><?=trim($row[RuleName]); ?></textarea></td>
<td style="text-align:center;width:190px;"><textarea id="Comments<?=trim($row[ServerName]); ?>" rows="" style="border:0; overflow:auto;height:70px;width:190px;" cols="" ><?=trim($row[Comments]); ?></textarea></td>
<td style="text-align:center;width:50px;"><div class="date<?=trim($row[ServerName])?>"><?echo $row[date];?></div></td>
<td style="text-align:center;">
	<select style="width:110px" id="DeploymentStatus<?=$row[ServerName]; ?>">
				<?$query="SELECT ID,Status FROM SMC_Deployment_State
							";
								$x=mssql_query($query,$qdb);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option value="<?=$lista['ID']?>" <?if($row['DeploymentStatus_N']==$lista['ID']) echo 'SELECTED'?>><?=$lista['Status']?></option><?
				}?>
			</select></td>
<?
//if($login == true)
//{?>
	<td align="center" valign="top" style="padding-top:20px;"><input type="checkbox" name="checkbox<?=trim($row[ServerName])?>" id="checkbox<?=trim($row[ServerName])?>" onclick="changecolor(this)"><br><br>
	<img src="../img/save.gif" alt="" title="Save" onclick="javascript:ajaxDeployment('<?=trim($row[ServerName]); ?>')"/>    
				<div class="saveOn<?=trim($row[ServerName]); ?>" style="display:none;">Save..</div></td>
<?//}?>
<td style="text-align:center;width:130px;"><?=$row[AlertingGroup];?></td>
<td style="text-align:center;"><?=$row['QDB']; ?></td>
<td style="text-align:center;"><?=$row['Dispatcher']; ?></td>
<td style="text-align:center;"><?=$row['System']; ?></td>			
</tr><?
}
if($iloscwierszy==0){?>
<tr>
<td colspan="18" ><center><B>Query returned no values. Possible reasons: Server has the newest software, Monitoring not set to Standard or you made a spelling mistake.</B><br><B> Check this server on 'Show All' list.</B></center></td>
</tr>
<?}?>

</table><br/><center>
<?if($issorted==0){?>
<a style="margin-top:50px;font-size:11px;color:#0f238c;font-family:Arial;" href="deployment_admin.php?Page=1&order=<?=$_GET['order'];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>
&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>&ServerNameN=<?=$_GET[ServerNameN];?>
&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&System=<?=$_GET[System]?>">[1]</a>
<a style="margin-top:50px;font-size:11px;color:#0f238c;font-family:Arial;" href="deployment_admin.php?Page=2&order=<?=$_GET['order'];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>&System=<?=$_GET[System]?>">[2]</a>
<a style="margin-top:50px;font-size:11px;color:#0f238c;font-family:Arial;" href="deployment_admin.php?Page=3&order=<?=$_GET['order'];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>&System=<?=$_GET[System]?>">[3]</a>
<a style="margin-top:50px;font-size:11px;color:#0f238c;font-family:Arial;" href="deployment_admin.php?Page=4&order=<?=$_GET['order'];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>&System=<?=$_GET[System]?>">[4]</a>
<a style="margin-top:50px;font-size:11px;color:#0f238c;font-family:Arial;" href="deployment_admin.php?Page=5&order=<?=$_GET['order'];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>&System=<?=$_GET[System]?>">[5]</a>
<a style="margin-top:50px;font-size:11px;color:#0f238c;font-family:Arial;" href="deployment_admin.php?Page=6&order=<?=$_GET['order'];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&WinOSN=<?=$_GET[WinOSN];?>&ServerNameN=<?=$_GET[ServerNameN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>&System=<?=$_GET[System]?>">[6]</a>
<a style="margin-top:50px;font-size:11px;color:#0f238c;font-family:Arial;" href="deployment_admin.php?Page=7&order=<?=$_GET['order'];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>&System=<?=$_GET[System]?>">[7]</a>
<a style="margin-top:50px;font-size:11px;color:#0f238c;font-family:Arial;" href="deployment_admin.php?Page=8&order=<?=$_GET['order'];?>&ServerName=<?=$_GET[ServerName];?>&Agent=<?=$_GET[Agent];?>
&WinOS=<?=$_GET[WinOS];?>&WTS=<?=$_GET[WTS];?>&CIM=<?=$_GET[CIM];?>
&QDB=<?=$_GET[QDB];?>&AlertingGroup=<?=$_GET[AlertingGroup];?>
&Status=<?=$_GET[Status];?>&Comments=<?=$_GET[Comments];?>&RuleName=<?=$_GET[RuleName];?>&ServerNameN=<?=$_GET[ServerNameN];?>&WinOSN=<?=$_GET[WinOSN];?>&AgentN=<?=$_GET[AgentN];?>&WTSN=<?=$_GET[WTSN];?>&CIMN=<?=$_GET[CIMN];?>&ADN=<?=$_GET[ADN];?>&RespN=<?=$_GET[RespN];?>&WeekN=<?=$_GET[WeekN];?>
&StatusN=<?=$_GET[StatusN];?>&GroupN=<?=$_GET[GroupN];?>&SystemN=<?=$_GET[SystemN];?>&DispN=<?=$_GET[DispN];?>&CommentsN=<?=$_GET[CommentsN];?>&RuleNameN=<?=$_GET[RuleNameN];?>
&Week=<?=$_GET[Week];?>&Responsible=<?$_GET[Responsible];?>&Dispatcher=<?=$_GET[Dispatcher];?>&AD=<?=$_GET[AD];?>&System=<?=$_GET[System]?>">[8]</a>
<?}?>
</div></center>
<?

echo '<script type="text/javascript">
	function cos(){';
	foreach($tablica as $a => $v){
		echo 'ajaxDeploymentMass(\''.$v['SN'].'\');';
	};
	echo 'setTimeout("location.reload()","0");';
	echo '};';
	echo '</script>';

echo '<script type="text/javascript">
	function cos2(){';
	foreach($tablica as $a => $v){
		echo 'ajaxDeploymentPicked(\''.'0000001'.'\',\''.$v['SN'].'\');';
	};
	echo 'setTimeout("location.reload()","0");';
	echo '};';
	echo '</script>';

echo '<script type="text/javascript">
	function checkall(){';
	foreach($tablica as $a => $v){
		echo 'checkit(\''.$v['SN'].'\');';
	};
	echo '};';
	echo '</script>';
	
echo '<script type="text/javascript">
	function uncheckall(){';
	foreach($tablica as $a => $v){
		echo 'uncheckit(\''.$v['SN'].'\');';
	};
	echo '};';
	echo '</script>';

//echo "<pre>";
//print_r($tablica);
//echo "</pre>";

/* Script execution time part 2 BEGIN*/
$mtime = explode(" ",microtime()); 
$endtime = $mtime[1] + $mtime[0]; 
$totaltime = ($endtime - $starttime); 
/* Script execution time part 2 END*/

echo "<h2>This page was created in ".round($totaltime,3)." seconds. Amount of rows taken from database: ".$iloscwierszy."</h2>";
echo '<a href="javascript:scroll(0,0);"><h2>Up page</h2></a>';
echo "<h2>Today is ".date("Y-m-d")."</h2>";
?>
</div><!-- page-->
</div><!-- main -->
</body>                    
</html>