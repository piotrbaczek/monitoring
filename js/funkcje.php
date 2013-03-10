<?php
	function convertTime ($time){
		$zakres = array(
				1440 => 'd ',
				60   => 'h ',
				1    => 'min ',
			);
			$sString = '';
			foreach( $zakres As $iTime => $sTime ) {
				$iDiv = $time/$iTime;
				if( $iDiv >= 1 ) {
					$x = floor( $iDiv );
					$sString .= $x.''.$sTime;
					$time-= $x*$iTime;
				}
			}
			if (substr($sString, -1) == ":")
			{
				$sString = str_replace(":", ":00", $sString);
			}
			if (count($sString == 2))
			{

			}
			return $sString;
		}
	$d = Array('Wintel Operations', 'Unix Operations', 'Storage and Backup Operations', 'Software Basis Administration', 'DC LAN', 'Critical Applications', 'Other', 'Global', 'Monitoring', 'Active Directory');

	function roznica_czasu($min)
	{
		if($min >= 1440){
			$a = floor($min / 1440);
			$min = $min%1440;
			if($a = 1)
				$string = $a." day ";
			else
				$string = $a." days ";
		}
	
		$a = floor($min/60);
		$b = $min%60;
		if(strlen($b) == 1)
			$b = "0".$b;
		
		return $string."".$a.":".$b;
	}
	
 	function selectDomain ($questionSQL)
 	{
	 	switch($questionSQL)
			{
				case "Wintel Operations": $questionSQL = "AND (Group_ = 'GB_ITC_CC_Windows' OR Group_ = 'CH_BAD_2nd_ITC_Server' OR Group_ = 'PL_ITC_Server')";
					break;
				case "Unix Operations": $questionSQL = "AND (Group_ = 'GB_ITC_CC_UNIX' OR Group_ = 'CH_BAD_3rd_UNIX')";
					break;
				case "Storage and Backup Operations": $questionSQL = "AND (Group_ = 'GB_ITC_CC_Storage' OR Group_ = 'CH_BAD_3rd_Storage')";
					break;
				case "Software Basis Administration": $questionSQL = "AND (Group_ = 'CH_BAD_3rd_Database' OR Category = 'Transverse Applications') AND Group_ != 'IC_ITC_NER_NetIQ'";
					break;
				case "DC LAN": $questionSQL = "AND (Group_ = 'GB_ITC_CC_Networking' OR Group_ = 'CH_BAD_2nd_Network' OR Group_ = 'PL_ITC_Network')";
					break;
				case "Critical Applications": $questionSQL = "AND (Summary LIKE 'R2EARTM%')";
					break;
				case "Other": $questionSQL = " AND Group_ != 'GB_ITC_CC_Windows' AND Group_ != 'CH_BAD_2nd_ITC_Server'
					AND Group_ != 'PL_ITC_Server' AND Group_ != 'GB_ITC_CC_UNIX' AND Group_ != 'CH_BAD_3rd_UNIX' AND Group_ != 'GB_ITC_CC_Storage'
					AND Group_ != 'CH_BAD_3rd_Storage' AND Group_ != 'CH_BAD_3rd_Database' AND Category != 'Transverse Applications'
					AND Group_ != 'GB_ITC_CC_Networking' AND Group_ != 'CH_BAD_2nd_Network' AND Group_ != 'PL_ITC_Network' AND Summary NOT LIKE 'R2EARTM%' AND Group_ NOT LIKE 'WSR_%' AND Group_ != 'IC_ITC_NER_NetIQ'";
					break;
				case "Global": $questionSQL = " AND (Group_ LIKE '%sd%' OR Group_ LIKE '%dispatch%')";
					break;
				case "Monitoring": $questionSQL = " AND Group_ = 'IC_ITC_NER_NetIQ'";
					break;
				case "Active Directory": $questionSQL = " AND Group_ LIKE '%WSR%' ";
					break;
			}
			return $questionSQL;
 	}
	
	
	function roznicaDat($data_poczatek, $data_koniec)
{
	if($data_koniec == null)
		$roznica = round(((strtotime(date('Y-m-d H:i:s')) - strtotime($data_poczatek))));
	else 
		$roznica = round(((strtotime($data_koniec) - strtotime($data_poczatek))));
 	$tablica = array(
	    'decade' => 315569260,
        'year' => 31556926,
        'month' => 2629744,
        'week' => 604800,
        'day' => 86400,
        'hour' => 3601,
        'minute' => 60);
 	
	/*foreach($tablica as $value){
		$x=floor($roznica/$value);
		$a = $value."</br>";
	}*/

	foreach($tablica as $precision => $value)
	{
		$x=floor($roznica/$value);
		$str = $x." ".$precision;
		if($x > 0) break; 
	}
 return $str;
}
	
	
	

	function timeDiff($time, $opt = array()) {
    // The default values
    $defOptions = array(
        'to' => 0,
        'parts' => 1,
        'precision' => 'hour',
        'distance' => TRUE,
        'separator' => ', '
    );
    $opt = array_merge($defOptions, $opt);
    // Default to current time if no to point is given
	//(!$opt['to']) && ($opt['to'] = strtotime($dateUnix);
    (!$opt['to']) && ($opt['to'] = time());
    // Init an empty string
    $str = '';
    // To or From computation
    $diff = ($opt['to'] > $time) ? $opt['to']-$time : $time-$opt['to'];
	$diff=$time;
    // An array of label => periods of seconds;
    $periods = array(
        'decade' => 315569260,
        'year' => 31556926,
        'month' => 2629744,
        'week' => 604800,
        'day' => 86400,
        'hour' => 3601,
        'minute' => 60,
        'second' => 1
    );
    // Round to precision
    if ($opt['precision'] != 'second')
        $diff = round(($diff/$periods[$opt['precision']])) * $periods[$opt['precision']];
    // Report the value is 'less than 1 ' precision period away
    (0 == $diff) && ($str = 'less than 1 '.$opt['precision']);
    // Loop over each period
    foreach ($periods as $label => $value) {
        // Stitch together the time difference string
        (($x=floor($diff/$value))&&$opt['parts']--) && $str.='<span style="color:red;">'.($str?$opt['separator']:'').($x.' '.$label.($x>1?'s':'')).'</span>';
        // Stop processing if no more parts are going to be reported.
        if ($opt['parts'] == 0 || $label == $opt['precision']) break;
        // Get ready for the next pass
        $diff -= $x*$value;
    }
     return $str;
}

	$d = Array('Wintel Operations', 
			'Unix Operations', 
			'Storage and Backup Operations', 
			'Software Basis Administration', 
			'DC LAN', 
			'Critical Applications', 
			'Other', 
			'Global', 
			'Monitoring', 
			'Active Directory');
	$group = Array(
			'DCSL_OB_Dispatching&Reporting',
			'DCSL_OB_Monitoring',
			'DCSL_OB_SystemOperations',
			'CH_UNIX',
			'CH_WINTEL',
			'CH_STORAGE',
			'PL_UNIX',
			'PL_WINTEL',
			'PL_STORAGE',
			'UK_UNIX',
			'UK_WINTEL',
			'UK_STORAGE',
			'FR_UNIX',
			'FR_WINTEL',
			'FR_STORAGE',
			'SE_UNIX',
			'SE_WINTEL',
			'SE_STORAGE',
			'WSR_AMER',
			'WSR_APAC',
			'WSR_EMEA',
			'None');

 	function countryName($countryCode)
 	{
		switch($countryCode)
		{
			case "AD": $countryCode="Andorra";
				break;
			case "AE": $countryCode="United Arab Emirates";
				break;
			case "AF": $countryCode="Afghanistan";
				break;
			case "AG": $countryCode="Antigua and Barbuda";
				break;
			case "AL": $countryCode="Albania";
				break;
			case "AM": $countryCode="Armenia";
				break;
			case "AO": $countryCode="Angola";
				break;
			case "AR": $countryCode="Argentina";
				break;
			case "AT": $countryCode="Austria";
				break;
			case "AU": $countryCode="Australia";
				break;
			case "AX": $countryCode="Åland Islands";
				break;
			case "AZ": $countryCode="Azerbaijan";
				break;
			case "BA": $countryCode="Bosnia and Herzegovina";
				break;
			case "BB": $countryCode="Barbados";
				break;
			case "BD": $countryCode="Bangladesh";
				break;
			case "BE": $countryCode="Belgium";
				break;
			case "BF": $countryCode="Burkina Faso";
				break;
			case "BG": $countryCode="Bulgaria";
				break;
			case "BH": $countryCode="Bahrain";
				break;
			case "BI": $countryCode="Burundi";
				break;
			case "BJ": $countryCode="Benin";
				break;
			case "BN": $countryCode="Brunei";
				break;
			case "BO": $countryCode="Bolivia";
				break;
			case "BR": $countryCode="Brazil";
				break;
			case "BS": $countryCode="Bahamas";
				break;
			case "BT": $countryCode="Bhutan";
				break;
			case "BW": $countryCode="Botswana";
				break;
			case "BY": $countryCode="Belarus";
				break;
			case "BZ": $countryCode="Belize";
				break;
			case "CA": $countryCode="Canada";
				break;
			case "CD": $countryCode="The Democratic Republic of Congo";
				break;
			case "CF": $countryCode="Central African Republic";
				break;
			case "CH": $countryCode="Switzerland";
				break;
			case "DE": $countryCode="Germany";
				break;
			case "ES": $countryCode="Spain";
				break;
			case "GB": $countryCode="United Kingdom";
				break;
			case "UK": $countryCode="United Kingdom";
				break;
			case "FR": $countryCode="France";
				break;
			case "IN": $countryCode="India";
				break;
			case "IT": $countryCode="Italy";
				break;
			case "Other": $countryCode="Other";
				break;
			case "NL": $countryCode="Netherlands";
				break;
			case "NO": $countryCode="Norway";
				break;
			case "PL": $countryCode="Poland";
				break;
			case "PT": $countryCode="Portugal";
				break;
			case "SE": $countryCode="Sweden";
				break;
			case "UAE": $countryCode="United Arab Emirates";
				break;
			default: $countryCode="Global";
				break;
		}
		return $countryCode;
 	}
?>