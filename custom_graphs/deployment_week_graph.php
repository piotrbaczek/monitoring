<?
include "../connection.php";
@mssql_select_db("ReportsDB", $qdb);
$week="SELECT DISTINCT Week
FROM SMC_Deployment_Service_TABLE 
ORDER BY Week DESC";
$res1=mssql_query($week);
$pracownicy="SELECT DISTINCT Responsible,Login.Name AS Name FROM SMC_Deployment_Service_TABLE A
LEFT JOIN dbo.SMC_Deployment_Login Login ON A.Responsible=Login.ShortName WHERE Responsible NOT LIKE '%None%' ORDER BY Responsible DESC";

$res2=mssql_query($pracownicy);

//--------------------------------------
echo "<chart>";

	echo "<axis_category shadow='low' size='10' color='000000' alpha='75' />";
	echo "<axis_ticks value_ticks='true' category_ticks='true' minor_count='1' />";
	echo "<axis_value shadow='low' size='10' color='000000' alpha='75' />";

	echo "<chart_border top_thickness='0' bottom_thickness='2' left_thickness='2' right_thickness='0' />";
	echo "<chart_data>";
		echo "<row>";
			echo "<null/>";
			while ($row1=mssql_fetch_array($res1)){
			if($row1[Week]=="99"){
			echo "<string>0</string>";
			}else{
			echo "<string>".$row1[Week]."</string>";
			}}
		echo "</row>";
		
		while($row2=mssql_fetch_array($res2)){
		echo "<row>";
		echo "<string>".$row2[Name]."</string>";
		$podzapytanie="DECLARE @responsible varchar(50)	
SET  @responsible = ''
DECLARE @string varchar(8000)	
SET  @string = ''
DECLARE c1 CURSOR READ_ONLY
FOR
SELECT distinct Responsible
FROM SMC_Deployment_Service_TABLE
WHERE Responsible != 'None' and Responsible is not null
OPEN c1
FETCH NEXT FROM c1
INTO @responsible
WHILE @@FETCH_STATUS = 0
BEGIN
	SET @string =  @string +', '+ rtrim(@responsible)
	FETCH NEXT FROM c1
	INTO @responsible	
END
CLOSE c1
DEALLOCATE c1
set @string = substring(@string,3,8000)
print @string
DECLARE @query VARCHAR(8000)	
SET @query='
select DISTINCT Week, '+@string+'
from (SELECT DISTINCT 
B.Week,C.Responsible,Login.Name,
	(SELECT COUNT(*) FROM SMC_Deployment_Service_TABLE WHERE Responsible=C.Responsible AND Week=B.Week) AS Amount
	FROM SMC_Deployment_Service_TABLE B
	CROSS JOIN (SELECT DISTINCT Responsible FROM SMC_Deployment_Service_TABLE
	WHERE Responsible NOT LIKE ''None''
	) AS C
	INNER JOIN SMC_Deployment_Login Login ON Login.ShortName=B.Responsible
	WHERE B.Week>0
	)
as p1
pivot
(
 sum(Amount)
 for Responsible
 in ('+@string+')
) as p2
ORDER BY Week DESC'
EXECUTE(@query)";
//echo "<pre>".$podzapytanie."</pre>";
$wynik=mssql_query($podzapytanie);
while($row3=mssql_fetch_array($wynik)){
echo "<number tooltip='".$row3[trim($row2[Responsible])]."'>".$row3[trim($row2[Responsible])]."</number>";
}
		echo "</row>";
		}
	echo "</chart_data>";
	echo "<chart_grid_h thickness='1' type='solid' />";
	echo "<chart_grid_v thickness='1' type='solid' />";
	echo "<chart_rect x='60' y='60' width='300' height='150' positive_color='FFFFFF' positive_alpha='50' />";
	echo "<chart_pref rotation_x='15' rotation_y='0' min_x='0' max_x='80' min_y='0' max_y='60' />";
	echo "<chart_type>stacked 3d column</chart_type>";

	echo "<filter>";
	echo "	<shadow id='high' distance='5' angle='45' alpha='35' blurX='15' blurY='15' />";
	echo "	<shadow id='low' distance='2' angle='45' alpha='50' blurX='5' blurY='5' />";
	echo "</filter>";

	echo "<legend shadow='high' x='25' y='-10' width='350' height='50' margin='20' fill_color='FFFFFF' fill_alpha='7' line_color='000000' line_alpha='0' line_thickness='0' layout='horizontal' size='12' color='000000' alpha='50' />";
	echo "<tooltip color='ffffcc' alpha='80' size='12' background_color='444488' background_alpha='75' shadow='low' />";

	echo "<series_color>";
		echo "<color>BFC6FF</color>";
		echo "<color>C9DAF6</color>";
		echo "<color>4A63A6</color>";
		echo "<color>031297</color>";
		echo "<color>8EA0FE</color>";
	echo "</series_color>";
	echo "<series bar_gap='0' set_gap='20' />";

echo "</chart>";
?>