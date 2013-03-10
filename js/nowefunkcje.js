function laduj(div,el){
$("#"+div).load(el);
}

function blokuj(){
$.blockUI({message: '<center><img src="img/alstomlogo.jpg" style="width:85%;height:85%;"><br><img src="img/loader4.gif"></center>'});
}

function odblokuj(){
$.unblockUI();
}

function pokaz(element){
//funkcja juz zaimplementowana w menu w naglowku
switch(element){
case "deployment":
	$("#statistics").hide();
	$("#tabelka").empty().load("deployment_table.php",function(){
	$("#deployment").show();
	$("#result").hide().empty();
	$("#tabelka").fadeIn("fast");
	});
break;
case "done":
	$("#statistics").hide();
	$("#tabelka").empty().load("deployment_table_done.php",function(){
	$("#deployment").show();
	$("#result").hide().empty();
	$("#tabelka").fadeIn("fast");
	});
break;
case "statistics":
	$("#deployment").hide();
	$("#statistics").fadeIn("fast");
break;
case "result":
	$("#statistics").hide();
	$("#tabelka").hide();
	$("#deployment").show();
	$("#result").fadeIn("fast");
break;
default:
alert("Unknown command");
}
}

function wykonaj(element){
//funkcja wykonujaca glowne zapytanie o serwery
if(element=="deployment"){
$("#result").load("deployment_result.php?ServerName="+$("#ServerName").val()+"&ServerNameN="+$("#ServerNameN").val()+"&QDB="+$("#QDB").val()+
"&QDBN="+$("#QDBN").val()+"&Agent="+$("#Agent").val()+"&AgentN="+$("#AgentN").val()+"&Status="+$("#Status").val()+"&StatusN="+$("#StatusN").val()+
"&WinOS="+$("#WinOS").val()+"&WinOSN="+$("#WinOSN").val()+"&AGroup="+$("#AGroup").val()+"&AGroupN="+$("#AGroupN").val()+"&WTS="+$("#WTS").val()+
"&WTSN="+$("#WTSN").val()+"&Week="+$("#Week").val()+"&WeekN="+$("#WeekN").val()+"&CIM="+$("#CIM").val()+"&CIMN="+$("#CIMN").val()+"&System="+
$("#System").val()+"&SystemN="+$("#SystemN").val()+"&AD="+$("#AD").val()+"&ADN="+$("#ADN").val()+"&Resp="+$("#Resp").val()+"&RespN="+
$("#RespN").val()+"&RuleName="+$("#RuleName").val()+"&RuleNameN="+$("#RuleNameN").val()+"&Disp="+$("#Disp").val()+"&DispN="+$("#DispN").val()+
"&Comments="+$("#Comments").val()+"&CommentsN="+$("#CommentsN").val(),function(){
$("#tabelka").hide();
$("#result").fadeIn("slow");
});
}else{
$("#result").load("deployment_result_done.php?ServerName="+$("#ServerName").val()+"&ServerNameN="+$("#ServerNameN").val()+"&QDB="+$("#QDB").val()+
"&QDBN="+$("#QDBN").val()+"&Agent="+$("#Agent").val()+"&AgentN="+$("#AgentN").val()+"&Status="+$("#Status").val()+"&StatusN="+$("#StatusN").val()+
"&WinOS="+$("#WinOS").val()+"&WinOSN="+$("#WinOSN").val()+"&AGroup="+$("#AGroup").val()+"&AGroupN="+$("#AGroupN").val()+"&WTS="+$("#WTS").val()+
"&WTSN="+$("#WTSN").val()+"&Week="+$("#Week").val()+"&WeekN="+$("#WeekN").val()+"&CIM="+$("#CIM").val()+"&CIMN="+$("#CIMN").val()+"&System="+
$("#System").val()+"&SystemN="+$("#SystemN").val()+"&AD="+$("#AD").val()+"&ADN="+$("#ADN").val()+"&Resp="+$("#Resp").val()+"&RespN="+
$("#RespN").val()+"&RuleName="+$("#RuleName").val()+"&RuleNameN="+$("#RuleNameN").val()+"&Disp="+$("#Disp").val()+"&DispN="+$("#DispN").val()+
"&Comments="+$("#Comments").val()+"&CommentsN="+$("#CommentsN").val(),function(){
$("#tabelka").hide();
$("#result").fadeIn("slow");
});
}
}

function tabelka(element){
//funkcja ladujaca tabelke w deployment
if(element=="deployment"){
$("#tabelka").load("deployment_table.php?ServerName="+$("#ServerName").val()+"&ServerNameN="+$("#ServerNameN").val()+"&QDB="+$("#QDB").val()+
"&QDBN="+$("#QDBN").val()+"&Agent="+$("#Agent").val()+"&AgentN="+$("#AgentN").val()+"&Status="+$("#Status").val()+"&StatusN="+$("#StatusN").val()+
"&WinOS="+$("#WinOS").val()+"&WinOSN="+$("#WinOSN").val()+"&AGroup="+$("#AGroup").val()+"&AGroupN="+$("#AGroupN").val()+"&WTS="+$("#WTS").val()+
"&WTSN="+$("#WTSN").val()+"&Week="+$("#Week").val()+"&WeekN="+$("#WeekN").val()+"&CIM="+$("#CIM").val()+"&CIMN="+$("#CIMN").val()+"&System="+
$("#System").val()+"&SystemN="+$("#SystemN").val()+"&AD="+$("#AD").val()+"&ADN="+$("#ADN").val()+"&Resp="+$("#Resp").val()+"&RespN="+
$("#RespN").val()+"&RuleName="+$("#RuleName").val()+"&RuleNameN="+$("#RuleNameN").val()+"&Disp="+$("#Disp").val()+"&DispN="+$("#DispN").val()+
"&Comments="+$("#Comments").val()+"&CommentsN="+$("#CommentsN").val(),function(){
});
}else{
$("#tabelka").load("deployment_table_done.php?ServerName="+$("#ServerName").val()+"&ServerNameN="+$("#ServerNameN").val()+"&QDB="+$("#QDB").val()+
"&QDBN="+$("#QDBN").val()+"&Agent="+$("#Agent").val()+"&AgentN="+$("#AgentN").val()+"&Status="+$("#Status").val()+"&StatusN="+$("#StatusN").val()+
"&WinOS="+$("#WinOS").val()+"&WinOSN="+$("#WinOSN").val()+"&AGroup="+$("#AGroup").val()+"&AGroupN="+$("#AGroupN").val()+"&WTS="+$("#WTS").val()+
"&WTSN="+$("#WTSN").val()+"&Week="+$("#Week").val()+"&WeekN="+$("#WeekN").val()+"&CIM="+$("#CIM").val()+"&CIMN="+$("#CIMN").val()+"&System="+
$("#System").val()+"&SystemN="+$("#SystemN").val()+"&AD="+$("#AD").val()+"&ADN="+$("#ADN").val()+"&Resp="+$("#Resp").val()+"&RespN="+
$("#RespN").val()+"&RuleName="+$("#RuleName").val()+"&RuleNameN="+$("#RuleNameN").val()+"&Disp="+$("#Disp").val()+"&DispN="+$("#DispN").val()+
"&Comments="+$("#Comments").val()+"&CommentsN="+$("#CommentsN").val(),function(){
});
}
}

function serman(element){
my_window=window.open("serman.php?servers="+element);
}

function xlsexport(){
if($("#identyfikator").val()=="Deployment - Done"){
my_window=window.open("report_deployment_admin_done_xls.php?ServerName="+$("#ServerName").val()+"&ServerNameN="+$("#ServerNameN").val()+"&QDB="+$("#QDB").val()+
"&QDBN="+$("#QDBN").val()+"&Agent="+$("#Agent").val()+"&AgentN="+$("#AgentN").val()+"&Status="+$("#Status").val()+"&StatusN="+$("#StatusN").val()+
"&WinOS="+$("#WinOS").val()+"&WinOSN="+$("#WinOSN").val()+"&AGroup="+$("#AGroup").val()+"&AGroupN="+$("#AGroupN").val()+"&WTS="+$("#WTS").val()+
"&WTSN="+$("#WTSN").val()+"&Week="+$("#Week").val()+"&WeekN="+$("#WeekN").val()+"&CIM="+$("#CIM").val()+"&CIMN="+$("#CIMN").val()+"&System="+
$("#System").val()+"&SystemN="+$("#SystemN").val()+"&AD="+$("#AD").val()+"&ADN="+$("#ADN").val()+"&Resp="+$("#Resp").val()+"&RespN="+
$("#RespN").val()+"&RuleName="+$("#RuleName").val()+"&RuleNameN="+$("#RuleNameN").val()+"&Disp="+$("#Disp").val()+"&DispN="+$("#DispN").val()+
"&Comments="+$("#Comments").val()+"&CommentsN="+$("#CommentsN").val());
}else{
my_window=window.open("report_deployment_admin_xls.php?ServerName="+$("#ServerName").val()+"&ServerNameN="+$("#ServerNameN").val()+"&QDB="+$("#QDB").val()+
"&QDBN="+$("#QDBN").val()+"&Agent="+$("#Agent").val()+"&AgentN="+$("#AgentN").val()+"&Status="+$("#Status").val()+"&StatusN="+$("#StatusN").val()+
"&WinOS="+$("#WinOS").val()+"&WinOSN="+$("#WinOSN").val()+"&AGroup="+$("#AGroup").val()+"&AGroupN="+$("#AGroupN").val()+"&WTS="+$("#WTS").val()+
"&WTSN="+$("#WTSN").val()+"&Week="+$("#Week").val()+"&WeekN="+$("#WeekN").val()+"&CIM="+$("#CIM").val()+"&CIMN="+$("#CIMN").val()+"&System="+
$("#System").val()+"&SystemN="+$("#SystemN").val()+"&AD="+$("#AD").val()+"&ADN="+$("#ADN").val()+"&Resp="+$("#Resp").val()+"&RespN="+
$("#RespN").val()+"&RuleName="+$("#RuleName").val()+"&RuleNameN="+$("#RuleNameN").val()+"&Disp="+$("#Disp").val()+"&DispN="+$("#DispN").val()+
"&Comments="+$("#Comments").val()+"&CommentsN="+$("#CommentsN").val());
}
}

function xlsexportall(param){
if(param=="done"){
my_window=window.open("report_deployment_admin_done_xls.php");
}else{
my_window=window.open("report_deployment_admin_xls.php");
}
}

function xmlexport(){
if($("#identyfikator").val()=="Deployment - Done"){
my_window=window.open("report_deployment_done_xml.php?ServerName="+$("#ServerName").val()+"&ServerNameN="+$("#ServerNameN").val()+"&QDB="+$("#QDB").val()+
"&QDBN="+$("#QDBN").val()+"&Agent="+$("#Agent").val()+"&AgentN="+$("#AgentN").val()+"&Status="+$("#Status").val()+"&StatusN="+$("#StatusN").val()+
"&WinOS="+$("#WinOS").val()+"&WinOSN="+$("#WinOSN").val()+"&AGroup="+$("#AGroup").val()+"&AGroupN="+$("#AGroupN").val()+"&WTS="+$("#WTS").val()+
"&WTSN="+$("#WTSN").val()+"&Week="+$("#Week").val()+"&WeekN="+$("#WeekN").val()+"&CIM="+$("#CIM").val()+"&CIMN="+$("#CIMN").val()+"&System="+
$("#System").val()+"&SystemN="+$("#SystemN").val()+"&AD="+$("#AD").val()+"&ADN="+$("#ADN").val()+"&Resp="+$("#Resp").val()+"&RespN="+
$("#RespN").val()+"&RuleName="+$("#RuleName").val()+"&RuleNameN="+$("#RuleNameN").val()+"&Disp="+$("#Disp").val()+"&DispN="+$("#DispN").val()+
"&Comments="+$("#Comments").val()+"&CommentsN="+$("#CommentsN").val());
}else{
my_window=window.open("report_deployment_xml.php?ServerName="+$("#ServerName").val()+"&ServerNameN="+$("#ServerNameN").val()+"&QDB="+$("#QDB").val()+
"&QDBN="+$("#QDBN").val()+"&Agent="+$("#Agent").val()+"&AgentN="+$("#AgentN").val()+"&Status="+$("#Status").val()+"&StatusN="+$("#StatusN").val()+
"&WinOS="+$("#WinOS").val()+"&WinOSN="+$("#WinOSN").val()+"&AGroup="+$("#AGroup").val()+"&AGroupN="+$("#AGroupN").val()+"&WTS="+$("#WTS").val()+
"&WTSN="+$("#WTSN").val()+"&Week="+$("#Week").val()+"&WeekN="+$("#WeekN").val()+"&CIM="+$("#CIM").val()+"&CIMN="+$("#CIMN").val()+"&System="+
$("#System").val()+"&SystemN="+$("#SystemN").val()+"&AD="+$("#AD").val()+"&ADN="+$("#ADN").val()+"&Resp="+$("#Resp").val()+"&RespN="+
$("#RespN").val()+"&RuleName="+$("#RuleName").val()+"&RuleNameN="+$("#RuleNameN").val()+"&Disp="+$("#Disp").val()+"&DispN="+$("#DispN").val()+
"&Comments="+$("#Comments").val()+"&CommentsN="+$("#CommentsN").val());
}
}

function xmlexportall(param){
if(param=="done"){
my_window=window.open("report_deployment_done_xml.php");
}else{
my_window=window.open("report_deployment_xml.php");
}
}

function koloruj(id){
//juz zaimplementowana w result
if($("#"+id+":checked").val()=="on"){
$("#trow"+id+",#RuleName"+id+",#Comments"+id+",#Status"+id+",#Week"+id+",#Responsible"+id).removeClass("niezaznaczony").addClass("aktywny");
}else{
$("#trow"+id+",#RuleName"+id+",#Comments"+id+",#Status"+id+",#Week"+id+",#Responsible"+id).removeClass("aktywny").addClass("niezaznaczony");
}}

function ajaxDeployment(id){
$.ajax({
			type: "POST",
			url: "deployment_send.php",
			data: "servername="+id+"&rulename="+$("#RuleName"+id).val()+"&comments="+$("#Comments"+id).val()+"&responsiblen="+$("#Responsible"+id+" :selected").val()+"&week="+$("#Week"+id+" :selected").val()+"&statusn="+$("#Status"+id+" :selected").val(),
			success: function(data){
			$("#Date"+id).val(data);
			$("#"+id).attr('checked',false);
			$("#trow"+id+",#RuleName"+id+",#Comments"+id+",#Status"+id+",#Week"+id+",#Responsible"+id).removeClass("aktywny").addClass("niezaznaczony");
			},
			error:function(){
			$.unblockUI();
			alert("Save Failed. Please check database status.");
			}
		});
}

function selectall(){
	if($("#selectallcheckbox:checked").val()=="on"){
		$(".niezaznaczony").each(function(i){
		$(this).removeClass("niezaznaczony").addClass("aktywny");
		});
		$("input:checkbox:gt(1)").each(function(i){
		$(this).attr('checked',true);
		});
	}else{
		$(".aktywny").each(function(i){
		$(this).removeClass("aktywny").addClass("niezaznaczony");
		});
		$("input:checkbox:gt(1)").each(function(i){
		$(this).attr('checked',false);
		});
	}
}

function picked_save(){
	pokaz('result');
		if($("#pickedsave").is(':hidden')==true){
			$("#pickedsave").fadeIn("slow");
		}else{
			$("#pickedsave").fadeOut("slow");
		}
}

function ajaxPickedSave(){
if($("#ch000001").is(":checked")){
$("input:checkbox:gt(1)").each(function(i){
		if($(this).is(':checked')==true){
		ajaxDeployment($(this).attr("id"));
		}
		});
}else{
alert("Please select the \"Picked Save\" checkbox to confirm this operation.");
}
}

function ajaxMassSave(){
	$("input:checkbox:gt(1)").each(function(){
		if($(this).is(':checked')==true){
		ajaxDeployment($(this).attr("id"));
		}
	});
}

function zaznacz(id,pole){
  $("#"+pole+id).animate({width: "400px",height: "150px",opacity:1.0,borderWidth:"6px"},"fast" );
}
function odznacz(id,pole){
  $("#"+pole+id).animate({width: "100%",height: "80px",opacity: 0.85,borderWidth:"2px"},"fast" );
}
function pickedsaveaction(){
if($("#action000001").val()=="REPLACE"){
$("#RN000001,#Cm000001").removeClass("dodajaca").addClass("nadpisujaca");
}else{
if($("#action000001").val()=="ADD"){
$("#RN000001,#Cm000001").removeClass("nadpisujaca").addClass("dodajaca");
}else{
$("#RN000001,#Cm000001").removeClass("nadpisujaca").removeClass("dodajaca");
}
}
}

function pickedsavebutton(button){
if(button=="action000001"){
$("#action000001").removeClass("ui-state-default").addClass("ui-state-error");
$("#action000002").removeClass("ui-state-error").addClass("ui-state-default");
$("#Cm000001,#RN000001").unbind('keyup');
$("#Cm000001").bind('keyup',function(){
$("textarea[id*='Comments'].aktywny").val($(this).val());
});
$("#RN000001").bind('keyup',function(){
$("textarea[id*='RuleName'].aktywny").val($(this).val());
});
}else{
$("#action000002").removeClass("ui-state-default").addClass("ui-state-error");
$("#action000001").removeClass("ui-state-error").addClass("ui-state-default");
$("#Cm000001,#RN000001").unbind('keyup');
$("#Cm000001").bind('keyup',function(){
$("textarea[id*='Comments'].aktywny").each(function(){
$(this).val(document.getElementById($(this).attr("id")).defaultValue+$("#Cm000001").val());
});
});
$("#RN000001").bind('keyup',function(){
$("textarea[id*='RuleName'].aktywny").each(function(){
$(this).val(document.getElementById($(this).attr("id")).defaultValue+$("#RN000001").val());
});
});
}
}
function showAddon(param){
if($("#extended"+param).is(":visible")){
$("#extended"+param).fadeOut("slow");
}else{
$("#extended"+param).fadeIn("slow");
}
}