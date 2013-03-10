<script type="text/javascript">
$(document).ready(function(){
	$("#tabelkazwynikiem").tablesorter({
	headers: { 6: { sorter: false}, 7: { sorter: false},  12: { sorter: false}}
	});

$("#St000001").change(function(){
$("select[id*='Status'].aktywny").val($(this).val());
});
$("#W000001").change(function(){
$("select[id*='Week'].aktywny").val($(this).val());
});
$("#Rs000001").change(function(){
$("select[id*='Responsible'].aktywny").val($(this).val());
});
});
</script>
<?
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
$res=mssql_query($zapytanie);
$count=mssql_num_rows($res);
if($count==0){?>
<center>
<div class="ui-state-error ui-corner-all">Your query returned no values. This may occur due to collecting data job<br>currently running or spelling mistake. Please revise your query.<br>
If you see this error repeatedly please contact adminstrator.</div>
<br><input type="submit" value="Back" onclick="javascript:pokaz('deployment')" class="ui-state-default ui-corner-all"></center>
<?}else{?>
<center>
<input type="text" value="Servers to Deploy" disabled="true" id="identyfikator">
<table id="tabelkazwynikiem">
<thead>
<input type="submit" value="Back" onclick="$('#result').hide();$('#tabelka').show();" class="ui-state-default ui-corner-all">
<tr>
<th style="width:100px;">Server</th>
<th>Agent</th>
<th>WinOS</th>
<th>WTS</th>
<th>CIM</th>
<th>AD</th>
<th>RuleName</th>
<th>Comments</th>
<th>Disp.</th>
<th>Resp.</th>
<th>Week</th>
<th>Status</th>
<th onclick="javascript:ajaxMassSave()">Save</th>
</tr>
<tr id="pickedsave" style="display:none;height:80px;background-color:#e9f2fb;">
<td colspan="6" align="center"><input class="ui-state-default ui-corner-all" type="submit" id="action000001" value="Replace" onclick="javascript:pickedsavebutton('action000001')"><input class="ui-state-default ui-corner-all" type="submit" id="action000002" value="Add" onclick="javascript:pickedsavebutton('action000002')"></td>
<td style="text-align:center;"><textarea id="RN000001" onfocus="javascript:zaznacz('000001','RN')" onblur="javascript:odznacz('000001','RN')"></textarea></td>
<td style="text-align:center;"><textarea id="Cm000001" onfocus="javascript:zaznacz('000001','Cm')" onblur="javascript:odznacz('000001','Cm')"></textarea></td>
<td></td>
<td style="text-align:center;"><select id="Rs000001">
<?
$query="SELECT DISTINCT ID,ShortName FROM SMC_Deployment_Login";
$res5=mssql_query($query);
while($row5=mssql_fetch_array($res5)){?>
<option value="<?=$row5['ID'];?>"><?=$row5['ShortName'];?></option>
<?}
?>
</select></td>
<td style="text-align:center;">
<select id="W000001">
<option value="99">0</option>
<?
$i=1;
for($i;$i<54;$i++){?>
<option value="<?=$i;?>"><?=$i;?></option>
<?}?>
</select></td>
<td style="text-align:center;"><select id="St000001">
<?
$query="SELECT DISTINCT ID,Status FROM SMC_Deployment_State";
$res6=mssql_query($query);
while($row6=mssql_fetch_array($res6)){?>
<option value="<?=$row6['ID'];?>"><?=str_replace("_"," ",$row6['Status']);?></option>
<?}
?>
</select></td>
<td style="text-align:center;"><input type="checkbox" id="ch000001"><br><br><img src="../img/save.gif" onclick="javascript:ajaxPickedSave()"></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td><input type="checkbox" id="selectallcheckbox" onclick="javascript:selectall()"></td>
</tr>
</thead>
<tbody>
<?
while($row=mssql_fetch_array($res)){?>
<tr id="trow<?=$row['ServerName'];?>" style="height:80px;" class="niezaznaczony">
<td><?=$row['ServerName'];?><div style="float:right;"><span title="Show Serman Information" class="ui-icon ui-icon-triangle-1-ne" onclick="javascript:serman('<?=$row['ServerName'];?>')"></span><br><span class="ui-icon ui-icon-triangle-1-s" title="Show Extended Information" onclick="showAddon('<?=$row['ServerName'];?>')"></span></div><br><?=$row['Ticket'];?></td>
<?
if($row['IsAgentUp']==2){?>
<td style="color:green;font-weight:bold;"><?=$row['Agent'];?></td>
<?}else{?>
<td style="color:red;font-weight:bold;"><?=$row['Agent'];?></td>
<?}
if($row['IsWinUp']==2){?>
<td style="color:green;font-weight:bold;"><?=$row['WinOS'];?></td>
<?}else{?>
<td style="color:red;font-weight:bold;"><?=$row['WinOS'];?></td>
<?}
if($row['IsWTSUp']==2){?>
<td style="color:green;font-weight:bold;"><?=$row['WTS'];?></td>
<?}else{?>
<td style="color:red;font-weight:bold;"><?=$row['WTS'];?></td>
<?}
if($row['IsCIMUp']==2){?>
<td style="color:green;font-weight:bold;"><?=$row['CIM'];?></td>
<?}else{?>
<td style="color:red;font-weight:bold;"><?=$row['CIM'];?></td>
<?}
if($row['IsADUp']==2){?>
<td style="color:green;font-weight:bold;"><?=$row['AD'];?></td>
<?}else{?>
<td style="color:red;font-weight:bold;"><?=$row['AD'];?></td>
<?}
?>
<td><textarea class="niezaznaczony" id="RuleName<?=$row['ServerName'];?>" style="border:0;overflow:auto;height:80px;width:100%;opacity:0.85;" onfocus="javascript:zaznacz('<?=$row['ServerName'];?>','RuleName')" onblur="javascript:odznacz('<?=$row['ServerName'];?>','RuleName')"><?=$row['RuleName'];?></textarea></td>
<td><textarea class="niezaznaczony" id="Comments<?=$row['ServerName'];?>" style="border:0;overflow:auto;height:80px;width:100%;opacity:0.85;" onfocus="javascript:zaznacz('<?=$row['ServerName'];?>','Comments')" onblur="javascript:odznacz('<?=$row['ServerName'];?>','Comments')"><?=$row['Comments'];?></textarea></td>
<td><?=$row['Dispatcher'];?></td>
<td><select class="niezaznaczony" id="Responsible<?=$row['ServerName'];?>">
<?
$query="SELECT DISTINCT ID,ShortName FROM SMC_Deployment_Login";
$res4=mssql_query($query);
while($row4=mssql_fetch_array($res4)){?>
<option value="<?=$row4['ID'];?>" <?if($row4['ShortName']==$row['Responsible']){echo "SELECTED";}?>><?=$row4['ShortName'];?></option>
<?}?>
</select>
</td>
<td style="text-align:center;"><select class="niezaznaczony" id="Week<?=$row['ServerName'];?>">
<?
if($row['Week']=="99" || $row['Week']=="0"){?>
<option value="99" <?echo "SELECTED";?>>0</option>
<?
$i=1;
for($i;$i<54;$i++){?>
<option value="<?=$i;?>"><?=$i;?></option>
<?}}else{?>
<option value="99>">0</option>
<?$i=1;
for($i;$i<54;$i++){?>
<option value="<?=$i;?>" <?if($row['Week']==$i){echo "SELECTED";}?>><?=$i;?></option>
<?}}?>
</select></td>
<td style="text-align:center;"><select class="niezaznaczony" id="Status<?=$row['ServerName'];?>">
<?
$query="SELECT DISTINCT ID,Status FROM SMC_Deployment_State";
$res3=mssql_query($query);
while($row3=mssql_fetch_array($res3)){?>
<option value="<?=$row3['ID'];?>" <?if($row3['Status']==$row['DeploymentStatus']){echo "SELECTED";}?>><?=str_replace("_"," ",$row3['Status']);?></option>
<?}
?>
</select></td>
<td style="text-align:center;"><input type="checkbox" id="<?=$row['ServerName'];?>" onclick="javascript:koloruj('<?=$row['ServerName'];?>')"><br><br><img src="../img/save.gif" onclick="javascript:ajaxDeployment('<?=$row['ServerName'];?>')"></td>
</tr>
<tr id="extended<?=$row['ServerName'];?>" class="expand-child" style="display:none;">
<td colspan="13">
Last Save Date: <input type="text" id="Date<?=$row['ServerName'];?>" value="<?=$row['Date'];?>"><br>
Alerting Group: <?=$row['AlertingGroup'];?><br>
QDB: <?=$row['QDB'];?><br>
System: <?=$row['System'];?><br>
</td>
</tr>
<?}}?>
</tbody>
</table>
</center>