<?php

include "connection.php";
@mssql_select_db("ReportsDB", $qdb);
//----------------------------------
$subq="SELECT ID AS R FROM SMC_Deployment_Login WHERE Login='".$currentuser."'";
$res1=mssql_query($subq);
$a=mssql_fetch_array($res1);
//----------------------------------
$subq="SELECT ShortName AS R FROM SMC_Deployment_Login WHERE Login='".$currentuser."'";
$res2=mssql_query($subq);
$b=mssql_fetch_array($res2);
//---------------------------------
$subq="SELECT ShortName AS R FROM SMC_Deployment_Login WHERE ID='".$_POST['responsiblen']."'";
$res3=mssql_query($subq);
$c=mssql_fetch_array($res3);
//---------------------------------
$subq="SELECT Status AS R FROM SMC_Deployment_State WHERE ID='".$_POST['statusn']."'";
$res4=mssql_query($subq);
$d=mssql_fetch_array($res4);
//---------------------------------
$zapytanie='BEGIN TRANSACTION UPDATE SMC_Deployment_Service_TABLE SET Comments =\''.htmlspecialchars(strip_tags($_POST['comments'])).'\', date = CURRENT_TIMESTAMP
,Dispatcher = \''.$b['R'].'\',Responsible = \''.$c['R'].'\', Week = \''.$_POST['week'].'\',
DeploymentStatus = \''.$d['R'].'\', RuleName = \''.htmlspecialchars(strip_tags($_POST['rulename'])).'\' WHERE ServerName=\''.$_POST['servername'].'\'
UPDATE SMC_Deployment_Service2 SET Comments =\''.htmlspecialchars(strip_tags($_POST['comments'])).'\', date = CURRENT_TIMESTAMP, Responsible = \''.$_POST['responsiblen'].'\',
Dispatcher = \''.$a['R'].'\',  Week = \''.$_POST['week'].'\',
DeploymentStatus =\''.$_POST['statusn'].'\', RuleName = \''.htmlspecialchars(strip_tags($_POST['rulename'])).'\' WHERE ServerName=\''.$_POST['servername'].'\' COMMIT';
//echo "<pre>".$zapytanie."</pre>";
$res3=mssql_query($zapytanie) or die("Failed");
echo date("d/m/Y H:i:s");
?>