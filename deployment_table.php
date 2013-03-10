
<script type="text/javascript">
$(document).ready(function(){
//
});
</script>
<?
include "connection.php";
@mssql_select_db("ReportsDB", $qdb);
?>
<center>
<h1>Deployment</h1>
<table>
<tr>
<th>ServerName:</th>
<td><select id="ServerNameN" class="rownasie" onchange="javascript:tabelka('deployment')">
<option value="" <?if($_GET['ServerNameN']=="" || empty($_GET['ServerNameN'])) echo "SELECTED";?>>=</option>
<option value="NOT" <?if($_GET['ServerNameN']=="NOT") echo "SELECTED";?>>&ne;</option>
</select></td>
<td>
<input class="tekst" type="text" id="ServerName" value="<?=htmlentities(strip_tags($_GET['ServerName']));?>" onchange="javascript:tabelka('deployment')">
</td>
<th>QDB:</th>
<td>
<select id="QDBN" class="rownasie" onchange="javascript:tabelka('deployment')">
<option value="" <?if($_GET['QDBN']=="" || empty($_GET['QDBN'])) echo "SELECTED";?>>=</option>
<option value="NOT" <?if($_GET['QDBN']=="NOT") echo "SELECTED";?>>&ne;</option>
</select></td>
<td>
<input id="QDB" class="tekst" type="text" value="<?=strip_tags($_GET['QDB']);?>" onchange="javascript:tabelka('deployment')">
</td>
</tr>
<tr>
<th>Agent:</th>
<td>
<select id="AgentN" class="rownasie" onchange="javascript:tabelka('deployment')">
<option value="" <?if($_GET['AgentN']=="" || empty($_GET['AgentN'])) echo "SELECTED";?>>=</option>
<option value="NOT" <?if($_GET['AgentN']=="NOT") echo "SELECTED";?>>&ne;</option>
</select></td>
<td>
<select id="Agent" class="wartosc" onchange="javascript:tabelka('deployment')">
<option value="" <?if(empty($_GET['Agent']) || $_GET['Agent']=='') echo 'SELECTED'?>>All</option>
<?
$query="EXEC dbo.Deployment_tabelka
@element='Agent',
@servername='".htmlentities(strip_tags($_GET['ServerName']))."',
@alerting='".$_GET['AGroup']."%',
@agent='%',
@qdb='".htmlentities(strip_tags($_GET['QDB']))."',
@winos='".$_GET['WinOS']."%',
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
@notagent='',
@notalerting='".$_GET['AGroupN']."',
@notqdb='".$_GET['QDBN']."',
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
				$x=mssql_query($query);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option value="<?=$lista['Agent']?>" <?if(!empty($_GET['Agent']) && $_GET['Agent']== $lista['Agent']) echo 'SELECTED'?>><B><?=$lista['Agent']?></B></option><?
				}?>
</select>
</td>
<th>Status:</th>
<td>
<select id="StatusN" class="rownasie" onchange="javascript:tabelka('deployment')">
<option value="" <?if($_GET['StatusN']=="" || empty($_GET['StatusN'])) echo "SELECTED";?>>=</option>
<option value="NOT" <?if($_GET['StatusN']=="NOT") echo "SELECTED";?>>&ne;</option>
</select></td>
<td>
<select id="Status" class="wartosc" onchange="javascript:tabelka('deployment')">
<option value="" <?if(empty($_GET['Status']) || $_GET['Status']=='') echo 'SELECTED'?>>All</option>
<?
$query="EXEC dbo.Deployment_tabelka
@element='DeploymentStatus',
@servername='".htmlentities(strip_tags($_GET['ServerName']))."',
@alerting='".$_GET['AGroup']."%',
@agent='".$_GET['Agent']."%',
@notagent='".$_GET['AgentN']."',
@qdb='".htmlentities(strip_tags($_GET['QDB']))."',
@winos='".$_GET['WinOS']."%',
@wts='".$_GET['WTS']."%',
@cim='".$_GET['CIM']."%',
@ad='".$_GET['AD']."%',
@responsible='".$_GET['Resp']."%',
@dispatcher='".$_GET['Disp']."%',
@rulename='".htmlentities(strip_tags($_GET['RuleName']))."%',
@comments='".htmlentities(strip_tags($_GET['Comments']))."%',
@deploymentstatus='%',
@week='".$_GET['Week']."',
@system='".$_GET['System']."%',
@notservername='".$_GET['ServerNameN']."',
@notalerting='".$_GET['AGroupN']."',
@notqdb='".$_GET['QDBN']."',
@notwinos='".$_GET['WinOSN']."',
@notwts='".$_GET['WTSN']."',
@notcim='".$_GET['CIMN']."',
@notad='".$_GET['ADN']."',
@notresponsible='".$_GET['RespN']."',
@notdispatcher='".$_GET['DispN']."',
@notrulename='".$_GET['RuleNameN']."',
@notcomments='".$_GET['CommentsN']."',
@notdeploymentstatus='',
@notweek='".$_GET['WeekN']."',
@notsystem='".$_GET['SystemN']."'";
								$x=mssql_query($query);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option value="<?=$lista['DeploymentStatus']?>" <?if(!empty($_GET['Status']) && $_GET['Status']== $lista['DeploymentStatus']) echo 'SELECTED'?>><B><?=$lista['DeploymentStatus']?></B></option><?
				}?>v
</select>
</td>
</tr>
<tr>
<th>Windows:</th>
<td>
<select id="WinOSN" class="rownasie" onchange="javascript:tabelka('deployment')">
<option value="" <?if($_GET['WinOSN']=="" || empty($_GET['WinOSN'])) echo "SELECTED";?>>=</option>
<option value="NOT" <?if($_GET['WinOSN']=="NOT") echo "SELECTED";?>>&ne;</option>
</select></td>
<td>
<select id="WinOS" class="wartosc" onchange="javascript:tabelka('deployment')">
<option value="" <?if(empty($_GET['WinOS']) || $_GET['WinOS']=='') echo 'SELECTED'?>>All</option>
<?
$query="EXEC dbo.Deployment_tabelka
@element='WinOS',
@servername='".htmlentities(strip_tags($_GET['ServerName']))."',
@alerting='".$_GET['AGroup']."%',
@agent='".$_GET['Agent']."%',
@notagent='".$_GET['AgentN']."',
@qdb='".htmlentities(strip_tags($_GET['QDB']))."',
@winos='%',
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
@notwinos='',
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
								$x=mssql_query($query);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option value="<?=$lista['WinOS']?>" <?if(!empty($_GET['WinOS']) && $_GET['WinOS']== $lista['WinOS']) echo 'SELECTED'?>><B><?=$lista['WinOS']?></B></option><?
				}?>
</select>
</td>
<th>Group:</th>
<td>
<select id="AGroupN" class="rownasie" onchange="javascript:tabelka('deployment')">
<option value="" <?if($_GET['AGroupN']=="" || empty($_GET['AGroupN'])) echo "SELECTED";?>>=</option>
<option value="NOT" <?if($_GET['AGroupN']=="NOT") echo "SELECTED";?>>&ne;</option>
</select></td>
<td>
<select id="AGroup" class="wartosc" onchange="javascript:tabelka('deployment')">
<option value="" <?if(empty($_GET['AGroup']) || $_GET['AGroup']=='') echo 'SELECTED'?>>All</option>
<?
$query="EXEC dbo.Deployment_tabelka
@element='AlertingGroup',
@servername='".htmlentities(strip_tags($_GET['ServerName']))."',
@alerting='%',
@agent='".$_GET['Agent']."%',
@notagent='".$_GET['AgentN']."',
@qdb='".htmlentities(strip_tags($_GET['QDB']))."',
@winos='".$_GET['WinOS']."%',
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
@notalerting='',
@notqdb='".$_GET['QDBN']."',
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
								$x=mssql_query($query);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option value="<?=$lista['AlertingGroup']?>" <?if(!empty($_GET['AGroup']) && $_GET['AGroup']== $lista['AlertingGroup']) echo 'SELECTED'?>><B><?=$lista['AlertingGroup']?></B></option><?
				}?>
</select>
</td>
</tr>
<tr>
<th>WTS:</th>
<td>
<select id="WTSN" class="rownasie" onchange="javascript:tabelka('deployment')">
<option value="" <?if($_GET['WTSN']=="" || empty($_GET['WTSN'])) echo "SELECTED";?>>=</option>
<option value="NOT" <?if($_GET['WTSN']=="NOT") echo "SELECTED";?>>&ne;</option>
</select></td>
<td>
<select id="WTS" class="wartosc" onchange="javascript:tabelka('deployment')">
<option value="" <?if(empty($_GET['WTS']) || $_GET['WTS']=='') echo 'SELECTED'?>>All</option>
<?
$query="EXEC dbo.Deployment_tabelka
@element='WTS',
@servername='".htmlentities(strip_tags($_GET['ServerName']))."',
@alerting='".$_GET['AGroup']."%',
@agent='".$_GET['Agent']."%',
@notagent='".$_GET['AgentN']."',
@qdb='".htmlentities(strip_tags($_GET['QDB']))."',
@winos='".$_GET['WinOS']."%',
@wts='%',
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
@notwinos='".$_GET['WinOSN']."',
@notwts='',
@notcim='".$_GET['CIMN']."',
@notad='".$_GET['ADN']."',
@notresponsible='".$_GET['RespN']."',
@notdispatcher='".$_GET['DispN']."',
@notrulename='".$_GET['RuleNameN']."',
@notcomments='".$_GET['CommentsN']."',
@notdeploymentstatus='".$_GET['StatusN']."',
@notweek='".$_GET['WeekN']."',
@notsystem='".$_GET['SystemN']."'";
								$x=mssql_query($query);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option value="<?=$lista['WTS'];?>" <?if(!empty($_GET['WTS']) && $_GET['WTS']==$lista['WTS']) echo 'SELECTED'?>><B><?=$lista['WTS']?></B></option><?
				}?>
</select>
</td>
<th>Week:</th>
<td>
<select id="WeekN" class="rownasie" onchange="javascript:tabelka('deployment')">
<option value="" <?if($_GET['WeekN']=="" || empty($_GET['WeekN'])) echo "SELECTED";?>>=</option>
<option value="NOT" <?if($_GET['WeekN']=="NOT") echo "SELECTED";?>>&ne;</option>
</select></td>
<td>
<select id="Week" class="wartosc" onchange="javascript:tabelka('deployment')">
<option value="" <?if(empty($_GET['Week']) || $_GET['Week']=='') echo 'SELECTED'?>>All</option>
<?
$query1="EXEC dbo.Deployment_tabelka
@element='Week',
@servername='".htmlentities(strip_tags($_GET['ServerName']))."',
@alerting='".$_GET['AGroup']."%',
@agent='".$_GET['Agent']."%',
@notagent='".$_GET['AgentN']."',
@qdb='".htmlentities(strip_tags($_GET['QDB']))."',
@winos='".$_GET['WinOS']."%',
@wts='".$_GET['WTS']."%',
@cim='".$_GET['CIM']."%',
@ad='".$_GET['AD']."%',
@responsible='".$_GET['Resp']."%',
@dispatcher='".$_GET['Disp']."%',
@rulename='".htmlentities(strip_tags($_GET['RuleName']))."%',
@comments='".htmlentities(strip_tags($_GET['Comments']))."%',
@deploymentstatus='".$_GET['Status']."%',
@week='%',
@system='".$_GET['System']."%',
@notservername='".$_GET['ServerNameN']."',
@notalerting='".$_GET['AGroupN']."',
@notqdb='".$_GET['QDBN']."',
@notwinos='".$_GET['WinOSN']."',
@notwts='".$_GET['WTSN']."',
@notcim='".$_GET['CIMN']."',
@notad='".$_GET['ADN']."',
@notresponsible='".$_GET['RespN']."',
@notdispatcher='".$_GET['DispN']."',
@notrulename='".$_GET['RuleNameN']."',
@notcomments='".$_GET['CommentsN']."',
@notdeploymentstatus='".$_GET['StatusN']."',
@notweek='',
@notsystem='".$_GET['SystemN']."'";
								$x=mssql_query($query1);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option value="<?=$lista['Week']?>" <?if(!empty($_GET['Week']) && $_GET['Week']== $lista['Week']) echo 'SELECTED'?>><B><?=$lista['Week']?></B></option><?
				}?>
</select>
</td>

</tr>
<tr>
<th>CIM/DELL:</th>
<td>
<select id="CIMN" class="rownasie" onchange="javascript:tabelka('deployment')">
<option value="" <?if($_GET['CIMN']=="" || empty($_GET['CIMN'])) echo "SELECTED";?>>=</option>
<option value="NOT" <?if($_GET['CIMN']=="NOT") echo "SELECTED";?>>&ne;</option>
</select></td>
<td>
<select id="CIM" class="wartosc" onchange="javascript:tabelka('deployment')">
<option value="" <?if(empty($_GET['CIM']) || $_GET['CIM']=='') echo 'SELECTED'?>>All</option>
				<?$query="EXEC dbo.Deployment_tabelka
@element='CIM',
@servername='".htmlentities(strip_tags($_GET['ServerName']))."',
@alerting='".$_GET['AGroup']."%',
@agent='".$_GET['Agent']."%',
@notagent='".$_GET['AgentN']."',
@qdb='".htmlentities(strip_tags($_GET['QDB']))."',
@winos='".$_GET['WinOS']."%',
@wts='".$_GET['WTS']."%',
@cim='%',
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
@notwinos='".$_GET['WinOSN']."',
@notwts='".$_GET['WTSN']."',
@notcim='',
@notad='".$_GET['ADN']."',
@notresponsible='".$_GET['RespN']."',
@notdispatcher='".$_GET['DispN']."',
@notrulename='".$_GET['RuleNameN']."',
@notcomments='".$_GET['CommentsN']."',
@notdeploymentstatus='".$_GET['StatusN']."',
@notweek='".$_GET['WeekN']."',
@notsystem='".$_GET['SystemN']."'";
								$x=mssql_query($query);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option value="<?=$lista['CIM']?>" <?if(!empty($_GET['CIM']) && $_GET['CIM']== $lista['CIM']) echo 'SELECTED'?>><B><?=$lista['CIM']?></B></option><?
				}?>
</select>
</td>
<th>System:</th>
<td>
<select id="SystemN" class="rownasie" onchange="javascript:tabelka('deployment')">
<option value="" <?if($_GET['SystemN']=="" || empty($_GET['SystemN'])) echo "SELECTED";?>>=</option>
<option value="NOT" <?if($_GET['SystemN']=="NOT") echo "SELECTED";?>>&ne;</option>
</select></td>
<td>
<select id="System" class="wartosc" onchange="javascript:tabelka('deployment')">
<option value="" <?if(empty($_GET['System']) || $_GET['System']=='') echo 'SELECTED'?>>All</option>
				<?$query="EXEC dbo.Deployment_tabelka
@element='System',
@servername='".htmlentities(strip_tags($_GET['ServerName']))."',
@alerting='".$_GET['AGroup']."%',
@agent='".$_GET['Agent']."%',
@notagent='".$_GET['AgentN']."',
@qdb='".htmlentities(strip_tags($_GET['QDB']))."',
@winos='".$_GET['WinOS']."%',
@wts='".$_GET['WTS']."%',
@cim='".$_GET['CIM']."%',
@ad='".$_GET['AD']."%',
@responsible='".$_GET['Resp']."%',
@dispatcher='".$_GET['Disp']."%',
@rulename='".htmlentities(strip_tags($_GET['RuleName']))."%',
@comments='".htmlentities(strip_tags($_GET['Comments']))."%',
@deploymentstatus='".$_GET['Status']."%',
@week='".$_GET['Week']."',
@system='%',
@notservername='".$_GET['ServerNameN']."',
@notalerting='".$_GET['AGroupN']."',
@notqdb='".$_GET['QDBN']."',
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
@notsystem=''";
								$x=mssql_query($query);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option value="<?=$lista['System']?>" <?if(!empty($_GET['System']) && $_GET['System']== $lista['System']) echo 'SELECTED'?>><B><?=$lista['System']?></B></option><?
				}?>
</select>
</td>
</tr>
<tr>
<th>AD:</th>
<td>
<select id="ADN" class="rownasie" onchange="javascript:tabelka('deployment')">
<option value="" <?if($_GET['ADN']=="" || empty($_GET['ADN'])) echo "SELECTED";?>>=</option>
<option value="NOT" <?if($_GET['ADN']=="NOT") echo "SELECTED";?>>&ne;</option>
</select></td>
<td>
<select id="AD" class="wartosc" onchange="javascript:tabelka('deployment')">
<option value="" <?if(empty($_GET['AD']) || $_GET['AD']=='') echo 'SELECTED'?>>All</option>
<?
$query="EXEC dbo.Deployment_tabelka
@element='AD',
@servername='".htmlentities(strip_tags($_GET['ServerName']))."',
@alerting='".$_GET['AGroup']."%',
@agent='".$_GET['Agent']."%',
@notagent='".$_GET['AgentN']."',
@qdb='".htmlentities(strip_tags($_GET['QDB']))."',
@winos='".$_GET['WinOS']."%',
@wts='".$_GET['WTS']."%',
@cim='".$_GET['CIM']."%',
@ad='%',
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
@notwinos='".$_GET['WinOSN']."',
@notwts='".$_GET['WTSN']."',
@notcim='".$_GET['CIMN']."',
@notad='',
@notresponsible='".$_GET['RespN']."',
@notdispatcher='".$_GET['DispN']."',
@notrulename='".$_GET['RuleNameN']."',
@notcomments='".$_GET['CommentsN']."',
@notdeploymentstatus='".$_GET['StatusN']."',
@notweek='".$_GET['WeekN']."',
@notsystem='".$_GET['SystemN']."'";
								$x=mssql_query($query);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option value="<?=$lista['AD']?>" <?if(!empty($_GET['AD']) && $_GET['AD']== $lista['AD']) echo 'SELECTED'?>><B><?=$lista['AD']?></B></option><?
				}?>
</select>
</td>
<th>RuleName:</th>
<td>
<select id="RuleNameN" class="rownasie" onchange="javascript:tabelka('deployment')">
<option value="" <?if($_GET['RuleNameN']=="" || empty($_GET['RuleNameN'])) echo "SELECTED";?>>=</option>
<option value="NOT" <?if($_GET['RuleNameN']=="NOT") echo "SELECTED";?>>&ne;</option>
</select></td>
<td>
<input id="RuleName" class="tekst" type="text" value="<?=strip_tags($_GET['RuleName']);?>" onchange="javascript:tabelka('deployment')">
</td>
</tr>
<tr>
<th>Resp.:</th>
<td>
<select id="RespN" class="rownasie" onchange="javascript:tabelka('deployment')">
<option value="" <?if($_GET['RespN']=="" || empty($_GET['RespN'])) echo "SELECTED";?>>=</option>
<option value="NOT" <?if($_GET['RespN']=="NOT") echo "SELECTED";?>>&ne;</option>
</select></td>
<td>
<select id="Resp" class="wartosc" onchange="javascript:tabelka('deployment')">
<option value="" <?if(empty($_GET['Resp']) || $_GET['Resp']=='') echo 'SELECTED'?>>All</option>
<?
$query="EXEC dbo.Deployment_tabelka
@element='Responsible',
@servername='".htmlentities(strip_tags($_GET['ServerName']))."',
@alerting='".$_GET['AGroup']."%',
@agent='".$_GET['Agent']."%',
@notagent='".$_GET['AgentN']."',
@qdb='".htmlentities(strip_tags($_GET['QDB']))."',
@winos='".$_GET['WinOS']."%',
@wts='".$_GET['WTS']."%',
@cim='".$_GET['CIM']."%',
@ad='".$_GET['AD']."%',
@responsible='%',
@dispatcher='".$_GET['Disp']."%',
@rulename='".htmlentities(strip_tags($_GET['RuleName']))."%',
@comments='".htmlentities(strip_tags($_GET['Comments']))."%',
@deploymentstatus='".$_GET['Status']."%',
@week='".$_GET['Week']."',
@system='".$_GET['System']."%',
@notservername='".$_GET['ServerNameN']."',
@notalerting='".$_GET['AGroupN']."',
@notqdb='".$_GET['QDBN']."',
@notwinos='".$_GET['WinOSN']."',
@notwts='".$_GET['WTSN']."',
@notcim='".$_GET['CIMN']."',
@notad='".$_GET['ADN']."',
@notresponsible='',
@notdispatcher='".$_GET['DispN']."',
@notrulename='".$_GET['RuleNameN']."',
@notcomments='".$_GET['CommentsN']."',
@notdeploymentstatus='".$_GET['StatusN']."',
@notweek='".$_GET['WeekN']."',
@notsystem='".$_GET['SystemN']."'";
								$x=mssql_query($query);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option value="<?=$lista['Responsible']?>" <?if(!empty($_GET['Resp']) && $_GET['Resp']== $lista['Responsible']) echo 'SELECTED'?>><B><?=$lista['Responsible']?></B></option><?
				}?>
</select>
</td>
<th>Comments:</th>
<td>
<select id="CommentsN" class="rownasie" onchange="javascript:tabelka('deployment')">
<option value="" <?if($_GET['CommentsN']=="" || empty($_GET['CommentsN'])) echo "SELECTED";?>>=</option>
<option value="NOT" <?if($_GET['CommentsN']=="NOT") echo "SELECTED";?>>&ne;</option>
</select></td>
<td>
<input id="Comments" class="tekst" type="text" value="<?=htmlentities(strip_tags($_GET['Comments']));?>" onchange="javascript:tabelka('deployment')">
</td>
</tr>
<tr>
<th>Disp.:</th>
<td>
<select id="DispN" class="rownasie" onchange="javascript:tabelka('deployment')">
<option value="" <?if($_GET['DispN']=="" || empty($_GET['DispN'])) echo "SELECTED";?>>=</option>
<option value="NOT" <?if($_GET['DispN']=="NOT") echo "SELECTED";?>>&ne;</option>
</select></td>
<td>
<select id="Disp" class="wartosc" onchange="javascript:tabelka('deployment')">
<option value="" <?if(empty($_GET['Disp']) || $_GET['Disp']=='') echo 'SELECTED'?>>All</option>
<?
$query="EXEC dbo.Deployment_tabelka
@element='Dispatcher',
@servername='".htmlentities(strip_tags($_GET['ServerName']))."',
@alerting='".$_GET['AGroup']."%',
@agent='".$_GET['Agent']."%',
@notagent='".$_GET['AgentN']."',
@qdb='".htmlentities(strip_tags($_GET['QDB']))."',
@winos='".$_GET['WinOS']."%',
@wts='".$_GET['WTS']."%',
@cim='".$_GET['CIM']."%',
@ad='".$_GET['AD']."%',
@responsible='".$_GET['Resp']."%',
@dispatcher='%',
@rulename='".htmlentities(strip_tags($_GET['RuleName']))."%',
@comments='".htmlentities(strip_tags($_GET['Comments']))."%',
@deploymentstatus='".$_GET['Status']."%',
@week='".$_GET['Week']."',
@system='".$_GET['System']."%',
@notservername='".$_GET['ServerNameN']."',
@notalerting='".$_GET['AGroupN']."',
@notqdb='".$_GET['QDBN']."',
@notwinos='".$_GET['WinOSN']."',
@notwts='".$_GET['WTSN']."',
@notcim='".$_GET['CIMN']."',
@notad='".$_GET['ADN']."',
@notresponsible='".$_GET['RespN']."',
@notdispatcher='',
@notrulename='".$_GET['RuleNameN']."',
@notcomments='".$_GET['CommentsN']."',
@notdeploymentstatus='".$_GET['StatusN']."',
@notweek='".$_GET['WeekN']."',
@notsystem='".$_GET['SystemN']."'";
				$x=mssql_query($query);
				while ($lista=mssql_fetch_array($x))
				{?>
				<option value="<?=$lista['Dispatcher']?>" <?if(!empty($_GET['Disp']) && $_GET['Disp']== $lista['Dispatcher']) echo 'SELECTED'?>><B><?=$lista['Dispatcher']?></B></option><?
				}?>
</select>
</td>
<th>Rows returned</th>
<td colspan="2" style="color:red;text-align:center;">
<?
$query="EXEC dbo.DeploymentIlosc
@servername='".htmlentities(strip_tags($_GET['ServerName']))."',
@alerting='".$_GET['AGroup']."%',
@agent='".$_GET['Agent']."%',
@notagent='".$_GET['AgentN']."',
@qdb='".htmlentities(strip_tags($_GET['QDB']))."',
@winos='".$_GET['WinOS']."%',
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
$res2=mssql_query($query);
$row2=mssql_fetch_array($res2);
$wynik=$row2['Amount'];
$eta=4+($wynik*0.05);
echo $wynik." (ETA: ".$eta."s)";
?>
</td>
</tr>
</table>
<input type="submit" value="Go!" class="ui-state-default ui-corner-all" onclick="javascript:wykonaj('deployment')">
</center>
<?
/*echo "<pre>";
print_r($_GET);
echo "$query1";
echo "</pre>";*/
?>