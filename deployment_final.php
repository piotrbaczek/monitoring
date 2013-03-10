<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
// Disables IE caching - resolves errors caused by IE displaying Temp page instead of downloading updated version
ini_set('max_execution_time', 90);
$mtime = explode(" ", microtime());
$starttime = $mtime[1] + $mtime[0];
// Script execution time part END 
ini_set('mssql.datetimeconvert', 0);
ini_set('mssql.textlimit', 32768);
ini_set('mssql.textsize', 32768);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Deployment Report - Dispatching and Reporting</title>
        <meta charset="utf-8" />
        <link rel="icon" type="image/png" href="img/alstom.png">
        <script src="js/jQuery.js"></script>
        <script src="js/jquery-ui-1.7.2.custom.js"></script>
        <script src="js/jquery.blockui.js"></script>
        <script src="js/jquery.tablesorter.mod.js"></script>
        <script src="js/nowefunkcje.js"></script>
        <link rel="stylesheet" href="css/deployment.css" /> 
        <link href="js/theme/ui.all.css" rel="stylesheet"/>
        <link rel="stylesheet" href="css/demo-menu-item.css" media="screen"/>
        <script src="js/menu-for-applications.js"></script>
        <script src="AC_RunActiveContent.js"></script>
        <script type="text/javascript">DetectFlashVer = 0;AC_FL_RunContent = 0;</script>
        <script src="AC_RunActiveContent.js"></script>
        <script>
            <!--
            var requiredMajorVersion = 9;
            var requiredMinorVersion = 0;
            var requiredRevision = 45;
            -->
        </script>
        <script type="text/javascript">
            $(document).ajaxStart(blokuj).ajaxSuccess(odblokuj).ready(function(){
                $("#statistics,#result").hide();
                //-------------
                $("#tabelka").load("deployment_table.php");
                //-------------
                $("#statsemployees").tablesorter();
                $("#statsweeks").tablesorter();
                $("#statsstatus").tablesorter();
            });
        </script>
    </head>
    <body>
        <div id="main">
            <?
            include "header.inc.php";
            ?>
            <div id="page">
                <h3>You are here: Operational Reports <img src='../img/right.gif' alt=''> Deployment</h3><br/>
                <?php
                include "connection.php";
                @mssql_select_db("msdb", $qdb);
                $job = "SELECT 
MAX((CONVERT(CHAR(10), CAST(STR(h.run_date,8, 0) AS dateTIME), 111)
 + ' ' +STUFF(STUFF(RIGHT('000000' + CAST ( h.run_time AS VARCHAR(6 ) ) ,6),5,0,':'),3,0,':')) )as date FROM sysjobhistory h inner join sysjobs j ON j.job_id = h.job_id WHERE h.run_status = 1 and j.name = 'SMC_QDBVersion' group by j.name";
                $jobresult = mssql_query($job);
                $job = mssql_fetch_array($jobresult);
//-----------------------------------------
                @mssql_select_db("ReportsDB", $qdb);
                $sqlLogin = mssql_query("SELECT Name FROM SMC_Deployment_Login WHERE Login='" . $currentuser . "'", $qdb);
                $r = mssql_fetch_array($sqlLogin);
                $isLogged = mssql_num_rows($sqlLogin);

                if ($isLogged > 0) {
                    echo "<h3>You are logged in as <B>" . $r[Name] . "</B>.</h3><br>";
                    echo '<h3>Last data collecting job run: ' . $job['date'] . '</h3><br>';
//moze zrobic tu ifa sprawdzajacego count(*) czyli czy job dziala - jak dziala to blokuj raport ?!?;
                    include "header_deployment.php";
//-------------------------------------
                    ?>
                    <fieldset>
                        <div id="deployment">
                            <div id="tabelka"></div>
                            <br>
                            <div id="result">
                                <h1>Deployment Result<br>
                                    This part will be available as soon as you query the database. Please go<br>
                                    to "View" submenu<br>and specify your query.</h1>
                            </div>
                        </div>
                        <div id="statistics">
                            <h1>Deployment Statistics</h1>
                            <?
//-------------------------------------
                            $count = mssql_query("SELECT COUNT(1) AS R FROM SMC_Deployment_Service_TABLE", $qdb);
                            $count2 = mssql_fetch_array($count);
                            $count3 = $count2[R];
                            $count3perc = round($count3 / $count3, 4);
//-------------------------------------
                            $Issued = mssql_query("SELECT COUNT(*) AS R FROM SMC_Deployment_Service_TABLE
WHERE IsADUp+IsAgentUp+IsCIMUp+IsWTSUp+IsWinUp<>10
AND DeploymentStatus NOT IN ('Unknown','OK','Not_to_Deployment')", $qdb);
                            $Issued2 = mssql_fetch_array($Issued);
                            $Issued3 = $Issued2[R];
//-------------------------------------
                            $amountdone = "SELECT COUNT(1) AS R FROM SMC_Deployment_Service_TABLE
WHERE IsADUp+IsAgentUp+IsCIMUp+IsWTSUp+IsWinUp=10 OR DeploymentStatus='OK'";
                            $done1 = mssql_query($amountdone);
                            $done2 = mssql_fetch_array($done1);
                            $done3 = $done2[R];
                            $done3perc = round($done3 / $count3, 4);
//------------------------------------
                            $notdone = "SELECT COUNT(1) AS R FROM SMC_Deployment_Service_TABLE
WHERE IsADUp+IsAgentUp+IsCIMUp+IsWTSUp+IsWinUp<>10";
                            $notdone1 = mssql_query($notdone);
                            $notdone2 = mssql_fetch_array($notdone1);
                            $notdone3 = $notdone2[R];
//------------------------------------
                            $zapytaniepracownicy = "SELECT DISTINCT Responsible,
(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE SMC_Deployment_Service_TABLE.Responsible=A.Responsible) AS Assigned,
(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE SMC_Deployment_Service_TABLE.Responsible=A.Responsible AND 
IsADUp+IsAgentUp+IsCIMUp+IsWTSUp+IsWinUp=10
) AS Done,
SMC_Deployment_Login.Name AS ImieNazwisko,
round(convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE SMC_Deployment_Service_TABLE.Responsible=A.Responsible AND IsADUp+IsAgentUp+IsCIMUp+IsWTSUp+IsWinUp=10))
/convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE SMC_Deployment_Service_TABLE.Responsible=A.Responsible)),3) AS Percentage

FROM SMC_Deployment_Service_TABLE AS A
INNER JOIN SMC_Deployment_Login ON A.Responsible=SMC_Deployment_Login.ShortName
WHERE Responsible NOT LIKE 'None%' ORDER BY Responsible DESC
";
                            $res = mssql_query($zapytaniepracownicy);
//------------------------------------
                            $zapytanieweek = "SELECT DISTINCT Week,Responsible,Login.Name,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE Responsible=A.Responsible AND Week=A.Week) AS Planned,

(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE Responsible=A.Responsible AND Week=A.Week AND (DeploymentStatus LIKE 'OK'
OR IsADUp+IsAgentUp+IsCIMUp+IsWTSUp+IsWinUp=10
)) AS StatusOK,
round(convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE Responsible=A.Responsible AND Week=A.Week AND (DeploymentStatus LIKE 'OK' OR
IsADUp+IsAgentUp+IsCIMUp+IsWTSUp+IsWinUp=10
)))/convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE Responsible=A.Responsible AND Week=A.Week))*100,2) AS Percentage
FROM SMC_Deployment_Service_TABLE A
INNER JOIN SMC_Deployment_Login AS Login ON Login.ShortName=A.Responsible
WHERE Week<>0 AND Responsible NOT LIKE '%None%' GROUP BY Week,Responsible,Login.Name ORDER BY Week DESC";
                            $res2 = mssql_query($zapytanieweek);
                            $iloscwierszy2 = mssql_num_rows($res2);
//-------------------------------------
                            $zapytaniestatus = "SELECT DISTINCT A.DeploymentStatus AS Status,
(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE DeploymentStatus=A.DeploymentStatus) AS Amount,
round((convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE DeploymentStatus=A.DeploymentStatus))/convert(float,(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE)))*100,4) AS Percentage
FROM SMC_Deployment_Service_TABLE A ORDER BY DeploymentStatus ASC";
                            $res3 = mssql_query($zapytaniestatus);
                            ?>
                            <center>
                                <span style="color:#0f238c;">Overall amount of servers</span>
                                <br><br>
                                <table class="mainTable">
                                    <tr>
                                        <th style="width:200px;">Amount of Servers In Deployment:</th>
                                        <td><? echo $count3; ?> (<B><? echo $count3perc * 100; ?>%</B>)</td>

                                    </tr>
                                    <tr>
                                        <th style="width:200px;">Done (Where All software versions are up to date and servers to Deployment or Status OK):</th>
                                        <td><? echo $done3; ?> (<B><? echo $done3perc; ?>%</B>)</td>
                                    </tr>
                                    <tr>
                                        <th style="width:200px;">To Deploy:</th>
                                        <td><? echo $notdone3; ?> (<B><? echo round($notdone3 / $count3, 4); ?>%</B>)</td>
                                    </tr>
                                    <tr>
                                        <th style="width:200px;">Issued Cases (Work In Progress):</th>
                                        <td><? echo $Issued3; ?></td>
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
                                        <? while ($row = mssql_fetch_array($res)) { ?>
                                            <tr onmouseover="this.bgColor='#e9f2fb'" onmouseout="this.bgColor='#FFFFFF'">
                                                <td><?= $row[ImieNazwisko]; ?></td>
                                                <td><?= $row[Assigned]; ?></td>
                                                <td><?= $row[Done]; ?></td>
                                                <td><?= $row[Percentage]; ?>%</td>
                                            </tr>
                                        <? } ?>
                                    </tbody>
                                </table>
                                <br>
                                <span style="color:#0f238c;">Overall amount by Weeks</span>
                                <br><br>
                                <table style="border:0;padding:0 0;">
                                    <tr>
                                        <td rowspan="<?= $iloscwierszy2 + 1; ?>">
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

                                                    <?php while ($row2 = mssql_fetch_array($res2)) { ?>
                                                        <tr onmouseover="this.bgColor='#e9f2fb'" onmouseout="this.bgColor='#FFFFFF'">
                                                            <td><?
                                                if ($row2[Week] == "99") {
                                                    echo "0";
                                                } else {
                                                    echo $row2[Week];
                                                }
                                                        ?></td>
                                                            <td><?= $row2[Name]; ?></td>
                                                            <td><?= $row2[Planned]; ?></td>
                                                            <td><?= $row2[StatusOK]; ?></td>
                                                            <?php if ($row2[Percentage] == 100) { ?>
                                                                <td style="text-align:center;color:green;"><B><? echo $row2[Percentage]; ?>%</B></td>
                                                            <?php } else { ?>
                                                                <td style="text-align:center;"><? echo $row2[Percentage]; ?>%</td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>
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
                                                    <?php while ($row3 = mssql_fetch_array($res3)) { ?>
                                                        <tr onmouseover="this.bgColor='#e9f2fb'" onmouseout="this.bgColor='#FFFFFF'">
                                                            <td><?php str_replace("_", " ", $row3[Status]); ?></td>
                                                            <td><?php $row3[Amount]; ?></td>
                                                            <td><?php echo $row3[Percentage]; ?>%</td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </td></tr></table>
                            </center>
                        </div>
                        <!--DOCUMENT BODY-->
                    </fieldset>
                    <!--BODY END-->
                    <?php
                    $mtime = explode(" ", microtime());
                    $endtime = $mtime[1] + $mtime[0];
                    $totaltime = ($endtime - $starttime);
                    echo "<h2>This page was created in " . round($totaltime, 3) . " seconds.</h2>";
                } else {
                    echo "<h3>User <B>" . $currentuser . "</B> is unable to see detailes of this report.<br>
Please authenticate using e_ or a_ ****** (6 char account) that is within SM&C or D&R group.</h3><br>";
                }
                ?>
            </div>
        </div>
    </body>
</html>