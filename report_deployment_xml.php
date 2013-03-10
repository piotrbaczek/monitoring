<?
header("Content-type: text/xml"); 
header('Content-Disposition: attachment; filename="deployment.xml"');
include "connection.php";
@mssql_select_db("ReportsDB", $qdb); 
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
echo '<xml version="1.0" encoding="UTF-8">';
while($row=mssql_fetch_array($res)){
echo '<Server ServerName="'.$row['ServerName'].'" Ticket="'.$row['Ticket'].'" Agent="'.$row['Agent'].'" WinOS="'.$row['WinOS'].'" AD="'.$row['AD'].'" WTS="'.$row['WTS'].'" CIM="'.$row['CIM'].'" System="'.$row['System'].'" />';
}
echo '</xml>';
?>
