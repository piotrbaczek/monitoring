<?php 
//print_r($_POST);
$mtime = explode(" ",microtime()); 
$starttime = $mtime[1] + $mtime[0]; 
// Script execution time part END 
 
ini_set('mssql.datetimeconvert', 0);

// Dolaczenie pliku zawierajacego wszystkie funkcje PHP
include ('../funkcje.php');

// Zapisanie do zmiennej Post zmiennej Get przeslanej z innej strony 
if(!empty($_GET['OpenOrDeleted']))
{
 	$_POST['OpenOrDeleted'] = $_GET['OpenOrDeleted'];
}
// Kod do obslugi sortowania kolumn na stronie
if(!empty($_POST['sort']))
{
	 if ((substr($_POST['sort'], -1) != '0' ) && (substr($_POST['sort'], -1) != '1' ))
	 {
		$_POST['sort'] = $_POST['sort'].'1';
	 }
 }
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Dispatching and Reporting</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-2" />

<link rel="stylesheet" type="text/css" href="../css/style.css" /> 
<link rel="stylesheet" href="../css/demo-menu-item.css" media="screen" type="text/css">

<script type="text/javascript" src="../js/menu-for-applications.js"></script>
<script type="text/javascript" src="../js/jQuery.js"></script>
<script type="text/javascript" src="../js/funkcje.js"></script>


<style type="text/css">
.hasColor_on 
{ 
	background: #e9f2fb;
} 
.hasColor 
{ 
	background: #ffede8;
}
.hasColor_off 
{ 
	background: #ffffff;
}
.container 
{ 
	margin:0; 
	padding: 0 20px 0 20px; 
	width:900px;
}
.divZZakladkami
{
	width: 100%;
	margin-top: 10px;
	overflow: hidden;
}
.zakladka
{
	margin-right:7px;
	background: url('../img/z.gif') no-repeat;
	width: 110px;
	height: 24px;
	float: left;
	display: block;
	padding-top: 5px;
	text-align: center;
}
.zakladkaGlowna
{
	margin-right:7px;
	background: url('../img/z2.gif') no-repeat;
	width: 110px;
	height: 24px;
	float: left;
	display: block;
	font-weight:bold;
	padding-top: 5px;
	text-align: center;
}
.description, .summary, .worklog, .notice
{ 
	padding: 2px 5px 2px 5px; 
	margin-bottom:20px; 
	background: #fff; 
	border-style : solid;
	border-color : #c0cae4;
	border-collapse : collapse;
	border-width : 1px;
}
.description 
{ 
	display: block; 
}
</style>
	


</head> 
<body> 
<div id="main">

<?php include "header.inc.php";?>
	
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" id="form" style="margin:0; padding:0;">
	<input type="hidden" name="urgency" id="form_urgency" value="<?if(!empty($_POST['urgency'])) echo $_POST['urgency'];?>" />
	<input type="hidden" name="status" id="form_status" value="<?if(!empty($_POST['status'])) echo $_POST['status'];?>" />
	<input type="hidden" name="summary" id="form_summary" value="<?if(!empty($_POST['summary'])) echo $_POST['summary'];?>" />		
	<input type="hidden" name="country" id="form_country" value="<?if(!empty($_POST['country'])) echo $_POST['country'];?>" />	
	<input type="hidden" name="OpenOrDeleted" id="form_OpenOrDeleted" value="<?if(!empty($_POST['OpenOrDeleted'])) echo $_POST['OpenOrDeleted'];?>" />	
	<input type="hidden" name="sort" id="form_sort" value="<?if(!empty($_POST['sort'])) echo $_POST['sort'];?>" />	
</form>		
	
<div id="page">
<h3>You are here: Tickets </h3>
<?php
include "connection.php";
@mssql_select_db("SupervisionLog", $qdb); 
if(!$qdb) die( '<h2>No database connection</h2>');
/* Tworzenie zapytan
   sql - zapytanie SQL, które wyswietla wyniki w tabeli. 
   sql2 - zapytanie SQL, które wyswietla wynik w liscie rozwijanej*/ 		 
$sql2="SELECT DISTINCT wynik = 
		CASE 
			WHEN  SUBSTRING(Group_ ,1,2) = 'IC'  
				THEN 'Global'
			WHEN  SUBSTRING(Group_ ,1,3) = 'WSR'  
				THEN 'Global'
			WHEN  SUBSTRING(Group_ ,1,3) = 'WDE'  
				THEN 'Global'
			WHEN  SUBSTRING(Group_ ,1,5) = 'OPSEC'  
				THEN 'Global'
			WHEN  SUBSTRING(Group_ ,1,3) = 'APC'  
				THEN 'CH'
			ELSE SUBSTRING(Group_ ,1,2)
		END
		FROM SupervisionLog 
		WHERE ";
$sql="SELECT sl.* , s.sDescription
FROM SupervisionLog sl LEFT OUTER JOIN (select * from ReportsDB.dbo.serman2 where sServerName not in (	
	select x1.sServerName from (
		select count(sServerName) as 'ilosc', sServerName from ReportsDB.dbo.Serman2 
		where bisdeleted = 0
		group by sServerName
		having count(sServerName)>1) x1)
and bisdeleted = 0 
union all
select * from ReportsDB.dbo.serman2 where sServerName in (	
	select x1.sServerName from (
		select count(sServerName) as 'ilosc', sServerName from ReportsDB.dbo.Serman2 
		where bisdeleted = 0
		group by sServerName
		having count(sServerName)>1) x1)
and bisdeleted = 0 and sAdditionalCategoryName = 'Active') s
ON sl.Asset_assigned_to_Request=s.sServerName WHERE ";
if ($_POST['OpenOrDeleted'] == 0)
{	
	echo "<h3><img src='../img/right.gif' alt='' /> Open</h3><br/>";
	$sql.=' Status_Integer !=5 AND Hidden = 0 ';
	$sql2.=' Status_Integer !=5 AND Hidden = 0 ';
}
					 
if ($_POST['OpenOrDeleted'] == 1)
{
	echo "<h3><img src='../img/right.gif' alt='' /> Marked as deleted</h3><br/>";
	$sql.=' Hidden = 1 ';
	$sql2.=' Hidden = 1 ';
}
					 
if ($_POST['OpenOrDeleted'] == 2)
{
	echo "<h3><img src='../img/right.gif' alt='' /> Last week</h3><br/>";
	$sql.=" First_Assigned_Time > '".date("Y-m-d", (strtotime( date("Y-m-d")) - 604800))."' AND First_Assigned_Time <= '".date("Y-m-d")." 23:59:59' AND Hidden = 0 " ;
	$sql2.=" First_Assigned_Time > '".date("Y-m-d", (strtotime( date("Y-m-d")) - 604800))."' AND First_Assigned_Time <= '".date("Y-m-d")." 23:59:59' AND Hidden = 0 " ;
}
					
if ($_POST['OpenOrDeleted'] == 3)
{
	echo "<h3><img src='../img/right.gif' alt='' /> Not assigned</h3><br/>";
	$sql.=" Status_Integer != 5 AND(Individual = '' OR Individual IS NULL) AND Hidden = 0 " ;
	$sql2.="Status_Integer != 5 AND(Individual = '' OR Individual IS NULL) AND Hidden = 0" ;
}
				
if(!empty($_POST['urgency'])) 
{
	if(in_array($_POST['urgency'], array('Low', 'Medium', 'High', 'Urgent'))) 
	{
	$sql.=' AND Urgency =\''.$_POST['urgency'].'\'';
	}
}
if(!empty($_POST['status'])) 
{
	if(in_array($_POST['status'], array('1', '2', '3', '4', '5'))) 
	{
		$sql.=' AND Status_Integer =\''.$_POST['status'].'\'';
	}
}
				 	
if(!empty($_POST['summary'])) 
{
	$sql.=' AND Summary LIKE \'%'.$_POST['summary'].'%\'';
}
					
if(!empty($_POST['country'])) 
{
	if($_POST['country'] == 'CH')
		$sql.=" AND (SUBSTRING(Group_ ,1,2) ='".$_POST['country']."' OR SUBSTRING(Group_ ,1,3) ='APC')";
	else if($_POST['country'] == 'Global')
		$sql.=" AND (SUBSTRING(Group_ ,1,2) ='IC' OR SUBSTRING(Group_ ,1,3) ='WSR' OR SUBSTRING(Group_ ,1,3) ='WDE' OR SUBSTRING(Group_ ,1,5) ='OPSEC')";
	else if($_POST['country'] == 'All')
		$sql.=" ";
	else
	$sql.=" AND SUBSTRING(Group_ ,1,2) ='".$_POST['country']."' " ;
}
					
if(!empty($_POST['sort'])) 
{		
	if (substr($_POST['sort'], -1) == 0)
	{
		$sql.='  ORDER BY '.substr($_POST['sort'], 0, -1).' DESC';
		$s=1;
	}
	else
	{
	$sql.='  ORDER BY '.substr($_POST['sort'], 0, -1).' ASC';
	$s=0;
	}
}

if(empty($_POST['sort'])) 
{
	$sql.=' ORDER BY Record_Entry_ID DESC';
}
		
$r=mssql_query($sql2,$qdbpl);
$a=0;
while ($l=mssql_fetch_array($r))
{
	$countrytable[$a] =  $l['wynik'];
	$a++;
}
//	echo $sql;		
$res=mssql_query($sql,$qdbpl);
$i=1;
if (mssql_num_rows($res) == 0)
{
	if ($_POST['OpenOrDeleted'] == 0){?><h1 style="margin-top:19px;">There are no open tickets</h1><?}
	if ($_POST['OpenOrDeleted'] == 1){?><h1 style="margin-top:19px;">There are no tickets marked as deleted</h1><?}
	if ($_POST['OpenOrDeleted'] == 2){?><h1 style="margin-top:19px;">There are no tickets last week</h1><?}
	if ($_POST['OpenOrDeleted'] == 3){?><h1 style="margin-top:19px;">There are no tickets</h1><?}
}
else
{?>

	<p><h1><a  href="#" onclick="$('#form_sort').val('');$('#form_urgency').val('');$('#form_country').val('');$('#form_status').val('');$('#form_c').val('');$('#form_summary').val('');$('#form').submit();" >
		 <img src="../img/refresh.gif" alt="Refresh" border="0" align="right" style="position:fix; padding-right:75px"></a>
	Tickets</h1>


<table class="mainTable" style="border:1; width:90%; margin: 0 auto; z-index:1">
	<tr>
		<th style=" width:15px;">No</th>
		<th onclick="$('#form_sort').val('Record_Entry_ID<?=$s?>');$('#form').submit();" style=" width:115px;">Ticket No.</th>
		<th onclick="$('#form_sort').val('Requester<?=$s?>');$('#form').submit();" style=" width:120px;">Requester</th>
		<th style=" width:25px;" title="Escalated">E</th>
		<th style=" width:25px;" title="Phone">P</th>
		<th style=" width:25px;" title="Mail">M</th>
		<th onclick="$('#form_sort').val('Status<?=$s?>');$('#form').submit();" style=" width:120px;">Status</th>
		<th onclick="$('#form_sort').val('Group_<?=$s?>');$('#form').submit();" style=" width:200px;">Group</th>
		<th onclick="$('#form_sort').val('Urgency<?=$s?>');$('#form').submit();" style=" width:70px;">Urgency</th>
		<th >Summary</th> 
		<th style=" width:60px;">Option</th></tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	    <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center">
			<select id="select_status" name="form_status" onchange="$('#form_status').val(this.value);$('#form').submit();">
				<option value="1" <?if(!empty($_POST['status']) && $_POST['status']=='1') echo 'SELECTED'?>>Assigned</option>
				<option value="2" <?if(!empty($_POST['status']) && $_POST['status']=='2') echo 'SELECTED'?>>Work In Progress</option>
				<option value="3" <?if(!empty($_POST['status']) && $_POST['status']=='3') echo 'SELECTED'?>>Pending</option>
				<option value="4" <?if(!empty($_POST['status']) && $_POST['status']=='4') echo 'SELECTED'?>>Resolved</option>
				<option value="5" <?if(!empty($_POST['status']) && $_POST['status']=='5') echo 'SELECTED'?>>Closed</option>
				<option value="All" <?if(empty($_POST['status']) || $_POST['status']=='All') echo 'SELECTED'?>>All</option>
			</select>
		</td>
		<td align="center">
			<select id="select_country" name="form_country" onchange="$('#form_country').val(this.value);$('#form').submit();">
				<option value="All" <?if(empty($_POST['country']) || $_POST['country']=='All') echo 'SELECTED'?>>All</option><?
				$a=0;
				while (count($countrytable) > $a)
				{?>
					<option value="<?=$countrytable[$a]; ?>" <?if( $_POST['country']==$countrytable[$a]) echo 'SELECTED'?>><?echo countryName($countrytable[$a]);?></option><?;
					$a++;
				}?>
			</select>
		</td>
		<td align="center">
			<select id="select_urgency" name="form_urgency" onchange="$('#form_urgency').val(this.value);$('#form').submit();">
				<option value="Low" <?if(!empty($_POST['urgency']) && $_POST['urgency']=='Low') echo 'SELECTED'?>>Low</option>
				<option value="Medium" <?if(!empty($_POST['urgency']) && $_POST['urgency']=='Medium') echo 'SELECTED'?>>Medium</option>
				<option value="High" <?if(!empty($_POST['urgency']) && $_POST['urgency']=='High') echo 'SELECTED'?>>High</option>
				<option value="Urgent" <?if(!empty($_POST['urgency']) && $_POST['urgency']=='Urgent') echo 'SELECTED'?>>Urgent</option>
				<option value="All" <?if(empty($_POST['urgency']) || $_POST['urgency']=='All') echo 'SELECTED'?>>All</option>
			</select>
		</td>
		<td>
			<input type="text" id="ta_summary" style="width: 70%; margin: 0; border:1px solid #c0cae4; height: 19px;"/>
			<img src="../img/search.gif" onclick="$('#form_summary').val($('#ta_summary').val());$('#form').submit();" title="Search" alt="" style="margin: 3px 0 0 5px"/>
		</td>
		<td></td>
	</tr>
<?while ($lista=mssql_fetch_array($res)) 
{
	if(($lista["ChangeColor"]) == 0)
	{?>
		<tr id="dane<?=$i?>" class="<?=$lista["Record_Entry_ID"]?> " onmouseover="this.bgColor='#e9f2fb'" onmouseout="this.bgColor='#FFFFFF'" ><?
	}
	else
	{?>
		<tr id="dane<?=$i?>" class="<?=$lista["Record_Entry_ID"]?> hasColor" onmouseover="this.bgColor='#e9f2fb'" onmouseout="this.bgColor='#FFFFFF'" ><?
	}?>
	<td><?=$i?></td>
	<td onclick="javascript:OpenRow(<?=$i?>)" style=" text-align: center;"><?=$lista["Record_Entry_ID"]?></td>
	<td onclick="javascript:OpenRow(<?=$i?>)" ><nobr><?=$lista["Requester"]?></nobr></td>
	<td><div class="Escalated_Int<?=trim($lista["Record_Entry_ID"])?>"  style="float:left;"><?=$lista["Escalated_Int"]?></div>
		<div style="float:right; margin-right:2px;">
			<img src="../img/upLitleButton.gif" alt="" onclick="javascript:ajaxUp('<?=trim($lista["Record_Entry_ID"])?>', '<?echo "Escalated_Int"?>' )" style="margin:0; padding:0;"/><br/>
			<img src="../img/downLitleButton.gif" alt="" onclick="javascript:ajaxDown('<?=trim($lista["Record_Entry_ID"])?>', '<?echo "Escalated_Int"?>' )" style="margin:0; padding:0;"/>
		</div>
	</td>
	<td><div class="Phone<?=trim($lista["Record_Entry_ID"])?>"  style="float:left;"><?=$lista["Phone"]?></div>
		<div style="float:right; margin-right:2px;">
			<img src="../img/upLitleButton.gif" alt="" onclick="javascript:ajaxUp('<?=trim($lista["Record_Entry_ID"])?>', '<?echo "Phone"?>' )" style="margin:0; padding:0;"/><br/>
			<img src="../img/downLitleButton.gif" alt="" onclick="javascript:ajaxDown('<?=trim($lista["Record_Entry_ID"])?>', '<?echo "Phone"?>' )" style="margin:0; padding:0;"/>
		</div>
	</td>
	<td><div class="Mail<?=trim($lista["Record_Entry_ID"])?>"  style="float:left;"><?=$lista["Mail"]?></div>
		<div style="float:right; margin-right:2px;">
			<img src="../img/upLitleButton.gif" alt="" onclick="javascript:ajaxUp('<?=trim($lista["Record_Entry_ID"])?>', '<?echo "Mail"?>' )" style="margin:0; padding:0;"/><br/>
			<img src="../img/downLitleButton.gif" alt="" onclick="javascript:ajaxDown('<?=trim($lista["Record_Entry_ID"])?>', '<?echo "Mail"?>' )" style="margin:0; padding:0;"/>
		</div>
	</td>
	<td onclick="javascript:OpenRow(<?=$i?>)" style=" text-align: center;"><?=$lista["Status"]?></td>
	<td onclick="javascript:OpenRow(<?=$i?>)" ><?=$lista["Group_"]?></td>
	<td onclick="javascript:OpenRow(<?=$i?>)" style=" text-align: center;"><?=$lista["Urgency"]?></td>
	<td onclick="javascript:OpenRow(<?=$i?>)" ><?echo substr(htmlspecialchars_decode($lista["Summary"]), 0, 50)." ..."?></td>
	<td style=" text-align: center;">
		<img src="../img/color.gif" title="Change color" onclick="if(confirm('Mark as MAJOR INCIDENT?')) changeColor('<?=$lista["Record_Entry_ID"]?>'); " alt="" style="margin: 3px 0 0 5px"/>

		<?if (preg_match("/Hidden = 1/i", $sql)) 
		{?>
			<img src="../img/close.gif" title="Close" onclick="if(confirm('UNHIDE case?'))uncover('<?=$lista["Record_Entry_ID"]?>', '<?=$i?>');" alt=""/><?
		} 
		else 
		{?>
			<img src="../img/close.gif" title="Close" onclick="if(confirm('HIDE case?'))covered('<?=$lista["Record_Entry_ID"]?>', '<?=$i?>');" alt=""/><?
		}?>
	</td>
	</tr>
	<tr id="dane_<?=$i;?>" class="hasColor_on" style="display:none;" >
	<td colspan="11">
	<table style="margin-top: 5px; text-align:center">
	<tr style="background-color:#ffffff; border: 1px solid #c0cae4">
		<td class="notTable" rowspan="2" style="width:190px; border: 1px solid #c0cae4"><b>First assigned time</b><br/>
			<b><?=$lista["First_Assigned_Time"]?></b>
		</td>
		<td class="notTable" style="width:190px; border: 1px solid #c0cae4;"><b>Fix 80 target</b><br/><?
		if (!empty($lista["Fix_80__Target"]))
		{
			if ($lista["Fix_80__Target"] < date("Y-m-d H:i:s"))
			{?>
				<span class="dateColorRed"><?echo $lista["Fix_80__Target"]."<br/>";?></span><?
			}
			else
			{?>
				<b><?echo $lista["Fix_80__Target"]."<br/>";?></b><?
			}
		}
		else
		{?>
			<b><?echo "No SLA <br/>";?></b><?
		}
		if (!empty($lista["SLA_Target_TimeFix1"]))
		{?>
			<br/><span style="color:red; margin:0 0 0 10px;" title="SLA target time Fix 1"><?
			if ($lista["Status"] == 'Closed')
			{
				if(strstr(roznicaDat($lista["SLA_Target_TimeFix1"], $lista["Resolved_End"]), "-") == false) 
				echo roznicaDat($lista["SLA_Target_TimeFix1"], $lista["Resolved_End"]); echo '</span>';
				
			}
			else 
			{
				if(strstr(roznicaDat($lista["SLA_Target_TimeFix1"], null), "-") == false) 
				echo roznicaDat($lista["SLA_Target_TimeFix1"], null); echo '</span>';
			}
		}																				
		if (!empty($lista["SLA_Target_TimeFix2"]))
		{?>
			<span style="color:red; margin:0 0 0 25px;" title="SLA target time Fix 2"><?
		if ($lista["Status"] == 'Closed')
			{
				if(strstr(roznicaDat($lista["SLA_Target_TimeFix2"], $lista["Resolved_End"]), "-") == false) 
				echo roznicaDat($lista["SLA_Target_TimeFix2"], $lista["Resolved_End"]); echo '</span>';
				
			}
			else 
			{
				if(strstr(roznicaDat($lista["SLA_Target_TimeFix2"], null), "-") == false) 
				echo roznicaDat($lista["SLA_Target_TimeFix2"], null); echo '</span>';
			}
		}?>
		</td>								
		<td class="notTable" rowspan="2" style="width:190px; border: 1px solid #c0cae4"><b>SLA target time response</b><br/><?
		if (!empty($lista["SLA_Target_TimeResponse"]))
		{
			if ($lista["SLA_Target_TimeResponse"] > date("Y-m-d H:i:s"))
			{?>
			<span class="dateColorRed"><?echo $lista["SLA_Target_TimeResponse"];?></span><?
			}
			else
			{?>
				<b><?echo $lista["SLA_Target_TimeResponse"];?></b><?
			}
		}
		else
		{?>&nbsp;<?}?>
		</td>
		<td class="notTable" rowspan="2" style="width:190px; border: 1px solid #c0cae4"><?
		if(!empty($lista["Resolved_End"]) && ($lista["Status"]) == "Closed")
		 {?>
			<b>Closed</b><br/><b><?echo $lista["Resolved_End"];?></b><?
		 }
		 else
		 {?>
			<b><?echo "Not closed";?></b><?
		 }?>
		</td>
	</tr>
	</table>
	
	<table>
	<tr>
		<td class="notTable" style="">Case ID+ <br /></td>
		<td class="notTable" style=""><b><?=$lista["Record_Entry_ID"]?></b></td>
		<td class="notTable" style="">Source</td>
		<td class="notTable" style=""><b><?=$lista["Source"]?></b></td>
		<td class="notTable" style="">Status</td>
		<td class="notTable" style=""><b><?=$lista["Status"]?></b></td></tr>
	<tr>
		<td class="notTable">Case type</td>
		<td class="notTable"><b><?=$lista["Case_Type"]?></b></td>
		<td class="notTable">Classification</td>
		<td class="notTable"><b><?=$lista["Classification"]?></b></td>
		<td class="notTable">SD Region</td>
		<td class="notTable"><b><?=$lista["SD_Region"]?></b><br /></td></tr>
	<tr>
		<td class="notTable">Category</td>
		<td class="notTable"><b><?=$lista["Category"]?></b></td>
		<td class="notTable">Urgency</td>
		<td class="notTable"><b><?=$lista["Urgency"]?></b></td>
		<td class="notTable"></td>
		<td class="notTable"></td></tr>
	<tr>
		<td class="notTable">Type</td>
		<td class="notTable"><b><?=$lista["Type"]?></b></td>
		<td class="notTable">Impact</td>
		<td class="notTable"><b><?=$lista["Impact"]?></b></td>
		<td class="notTable"></td>
		<td class="notTable"></td></tr>
	<tr>
		<td class="notTable">Item</td>
		<td class="notTable"><b><?=$lista["Item"]?></b></td>
		<td class="notTable">Group+</td>
		<td class="notTable"><b><?=$lista["Group_"]?></b></td>
		<td class="notTable">SD Region</td>
		<td class="notTable"><b><?=$lista["SD_Region"]?></b></td></tr>
	<tr>
		<td class="notTable">SubItem</td>
		<td class="notTable"><b><?=$lista["SubItem"]?></b></td>
		<td class="notTable">Individual+</td>
		<td class="notTable"><b><?=$lista["Individual"]?></b></td>
		<td class="notTable">SD Site</td>
		<td class="notTable"><b><?=$lista["SD_Site"]?></b></td></tr>
	<tr>
		<td class="notTable"></td>
		<td class="notTable"></td>
		<td class="notTable">Requester</td>
		<td class="notTable"><b><?=$lista["Requester"]?></b></td>
		<td class="notTable">Req. Phone</td>
		<td class="notTable"><b><?=$lista["Req_Phone"]?></b></td></tr>
	<tr>
		<td class="notTable">Server description</td>
		<td class="notTable" colspan="5"><b><?=$lista["sDescription"]?></b></td></tr>
	</table>								
	
	<div class="container">
		<div class="divZZakladkami">
			<div onclick="javascript:showDescription(<?=$i?>)" class="zakladkaGlowna" id="d<?=$i?>">Description</div>
			<div onclick="javascript:showSummary(<?=$i?>)" class="zakladka" id="s<?=$i?>">Summary</div>
			<div onclick="javascript:showWorklog(<?=$i?>)" class="zakladka" id="w<?=$i?>">Worklog</div>
			<?if(!empty($lista["Notice"])) echo "<b>";?><div onclick="javascript:showNotice(<?=$i?>)" class="zakladka" id="n<?=$i?>">Notice</div><?if(!empty($lista["Notice"])) echo "</b>";?>
		</div>
		<div class="content">
			<div id="description<?=$i?>" class="description" ><?=str_replace("\n", "<br />", $lista["Description"])?></div>
			<div id="summary<?=$i?>" class="summary"><?=$lista["Summary"]?></div>
			<div id="worklog<?=$i?>" class="worklog"><?=str_replace("\n", "<br />", $lista["Work_Log"])?></div>
			<div id="notice<?=$i?>" class="notice">
				<textarea class="noticeDispatchingConsole" rows="" cols="" name="note" id="<?=trim($lista["Record_Entry_ID"])?>"><?=$lista["Notice"]?></textarea>
				<img src="../img/save.gif" title="Save" style="float:left; padding: 7px 0px 0px 5px;" alt="" onclick="javascript:ajax('<?=trim($lista["Record_Entry_ID"])?>')"/>    
				<div class="saveOn<?=trim($lista["Record_Entry_ID"])?>" style="display:none; float:left; padding: 8px 0px 0px 20px;">Save...</div>									
			</div>
		</div>
	</div>
	</td>
	</tr><?
	$i++;
}
}?>
</table><?
/*Script execution time part 2 BEGIN*/
$mtime = explode(" ",microtime()); 
$endtime = $mtime[1] + $mtime[0]; 
$totaltime = ($endtime - $starttime); 
/*Script execution time part 2 END*/
echo "<br /><h2>This page was created in ".round($totaltime,3)." seconds</h2>";
?>
</div> <!-- page-->
</div> <!-- main -->
</body>                    
</html>