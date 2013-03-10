<?

header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="report_deployment_admin.xls"');

include "connection.php";
@mssql_select_db("ReportsDB", $db); 
$zapytanie="EXEC dbo.Deployment
@servername='".htmlentities(strip_tags($_GET['ServerName']))."',
@alerting='".$_GET['AGroup']."%',
@qdb='".htmlentities(strip_tags($_GET['QDB']))."',
@winos='".$_GET['WinOS']."%',
@agent='".$_GET['Agent']."%',
@wts='".$_GET['WTS']."%',
@cim='".$_GET['CIM']."%',
@ad='".$_GET['AD']."%',
@responsible='".$_GET['Resp']."%',
@dispatcher='".$_GET['Disp']."%',
@rulename='".htmlentities(strip_tags($_GET['RuleName']))."%',
@comments='".htmlentities(strip_tags($_GET['Comments']))."%',
@deploymentstatus='".$_GET['Status']."%',
@week='".$_GET['Week']."',
@system='".$_GET['System']."%',
@notservername='".$_GET['ServerNameN']."',
@notalerting='".$_GET['AGroupN']."',
@notqdb='".$_GET['QDBN']."',
@notagent='".$_GET['AgentN']."',
@notwinos='".$_GET['WinOSN']."',
@notwts='".$_GET['WTSN']."',
@notcim='".$_GET['CIMN']."',
@notad='".$_GET['ADN']."',
@notresponsible='".$_GET['RespN']."',
@notdispatcher='".$_GET['DispN']."',
@notrulename='".$_GET['RuleNameN']."',
@notcomments='".$_GET['CommentsN']."',
@notdeploymentstatus='".$_GET['StatusN']."',
@notweek='".$_GET['WeekN']."',
@notsystem='".$_GET['SystemN']."'";
$res=mssql_query($zapytanie,$qdb);
//print_r($_GET);
//echo $q;
 ?>
<table align="center"  width="100%" border="1">
 <tr>
  <th style="background: #4a63a6;color: #fff;width:105px;">ServerName</th>
  <th style="background: #4a63a6;color: #fff;width:85px;">Agent</th>
  <th style="background: #4a63a6;color: #fff;width:85px;">Windows OS</th>
  <th style="background: #4a63a6;color: #fff;width:85px;">WTS</th>
  <th style="background: #4a63a6;color: #fff;width:85px;">CIM/DELL</th>
  <th style="background: #4a63a6;color: #fff;width:85px;">AD</th>
  <th style="background: #4a63a6;color: #fff;width:55px;">Responsible</th>
  <th style="background: #4a63a6;color: #fff;width:170px;">Rule Name</th>
  <th style="background: #4a63a6;color: #fff;width:170px;">Comments</th>
  <th style="background: #4a63a6;color: #fff;width:125px;">Date</th>
  <th style="background: #4a63a6;color: #fff;width:85px;">Deployment Status</th>
  <th style="background: #4a63a6;color: #fff;width:85px;">Week</th>
  <th style="background: #4a63a6;color: #fff;width:85px;">Group</th>
  <th style="background: #4a63a6;color: #fff;width:85px;">QDB</th>
  <th style="background: #4a63a6;color: #fff;width:55px;">Dispatcher</th>
  <th style="background: #4a63a6;color: #fff;width:85px;">System</th>
</tr>
<?
	$i=0;
	while ($row=mssql_fetch_array($res))
	  {
	  ?>
	  <tr>
		<td style="color:#0f238c;text-align:center;"><?=$row['ServerName'];?></td>
		<td style="color:#0f238c;text-align:center;"><?=$row['Agent'];?></td>
		<td style="color:#0f238c;text-align:center;"><?=$row['WinOS']; ?></td>
		<td style="color:#0f238c;text-align:center;"><?=$row['WTS']; ?></td>
		<td style="color:#0f238c;text-align:center;"><?=$row['CIM']; ?></td>
		<td style="color:#0f238c;text-align:center;"><?=$row['AD']; ?></td>
		<td style="color:#0f238c;text-align:center;"><?=$row['Responsible'];?></td>
		<td style="color:#0f238c;text-align:center;width:170px;"><?=$row['RuleName'];?></td>
		<td style="color:#0f238c;text-align:center;width:170px;"><?=$row['Comments'];?></td>
		<td style="color:#0f238c;text-align:center;"><?=$row['Date']; ?></td>
		<td style="color:#0f238c;text-align:center;"><?=str_replace("_"," ",$row['DeploymentStatus']);?></td>
		<td style="color:#0f238c;text-align:center;"><?if($row['Week']=="99"){echo "0";}else{echo $row['Week'];}?></td>
		<td style="color:#0f238c;text-align:center;"><?=$row['AlertingGroup']; ?></td>
		<td style="color:#0f238c;text-align:center;"><?=$row['QDB']; ?></td>
		<td style="color:#0f238c;text-align:center;"><?=$row['Dispatcher'];?></td>
		<td style="color:#0f238c;text-align:center;"><?=$row['System']; ?></td>
	  </tr>
	<?}?>
</table>
<?
echo '<br><be>Report was generated on '.Date("Y-m-d").' by '.$currentuser;
?>
