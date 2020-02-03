<?php
// function compute_minutes($recieve_date,$release_date){
// 	$from_time = strtotime($recieve_date);
// 	$to_time = strtotime($release_date);

// 	if(round(abs($to_time - $from_time)/60,2)>900){

// 		$datetime1 = $recieve_date;
// 		$datetime2 = $release_date;

// 		$timestamp1 = strtotime($datetime1);
// 		$timestamp2 = strtotime($datetime2);

		
// 		$weekend = array(0,6);
// 		//activate this is weekends are not included on working days
// 		if(in_array(date("w",$timestamp1), $weekend)|| in_array(date("w",$timestamp2), $weekend)){
// 			return 0;
// 		}
// 		//
		

// 		$diff = $timestamp2 - $timestamp1;
// 		$one_day = 60*60*24; //$one_day = 60*60*24; days in seconds

// 		//if($diff<$one_day){
// 		//	return floor($diff / 3600);
// 		//}

// 		$days_between = floor($diff / $one_day);
// 		$remove_days = 0;


// 		//activate this is weekends are not included on working days
// 		for($i=1;$i<=$days_between;$i++){
// 			$next_day = $timestamp1+($i * $one_day);
// 			if(in_array(date("w",$next_day), $weekend)){
// 				$remove_days++;
// 			}
// 		}
// 		//


// 		$dys = ((((($diff-($remove_days*$one_day))/3600)*60)/60)/24);
// 		$minus = ($dys*900);
		
// 		return (((((($diff-($remove_days*$one_day))/3600)*60)*60)/60)-$minus);
// 	}
// 	else{
// 		return round(abs($to_time - $from_time)/60,2);
// 	}

// }

function compute_minutes($recieve_date,$release_date){
		//kunin ung total minutes
	$to_time = strtotime($recieve_date);
	$from_time = strtotime($release_date);
	$totalMinutes = round(abs($to_time - $from_time) / 60,2);
	
	$begin = new DateTime($recieve_date);
	$end = new DateTime($release_date);

	$interval = DateInterval::createFromDateString('1 day');
	$period = new DatePeriod($begin, $interval, $end);

	$counter = 0; //counter para sa no of days falls on weekends
	foreach ($period as $indexKey=>$dt) { //loop
		//check if date is weekend
		if($dt->format("l")=="Saturday"||$dt->format("l")=="Sunday"){ //if weekend
			$counter+=1; 
			//$dt->format("l Y-m-d H:i:s\n");	
			//insert condition for holidays
		}
		else{
			//echo $dt->format("l Y-m-d H:i:s\n");	
		}
	}
	return ($totalMinutes-($counter*1440)); //ok totalminutes less ung totalminutes of weekends
}

function working_hours(){
	include("../database/database_connection.php");
	//include("../database/database_connection.php");
  	
	$time_settings = mysqli_query($connection,"select * from tbl_working_hours");
	$ts = mysqli_fetch_assoc($time_settings);

	if(date('H:i:s')<$ts['time_start']){
		$time = $ts['time_start'];
	}
	else{		
		if(date('H:i:s')>$ts['time_end']){
			$time = $ts['time_end'];
		}
		else{
			$time = date('H:i:s');
		}
	}
	
	$date_time = date('Y-m-d')." ".$time;

	return $date_time;
}

// function convert_time($time){
// 	include("../database/database_connection.php");
// 	$qry_day = mysqli_query($connection,"select timestampdiff(minute,time_start,time_end)min from tbl_working_hours");
// 	$day = mysqli_fetch_assoc($qry_day);

// 	if($time>60 && $time<$day['min']){ //hours
// 		$hours= $time/60;
// 		return number_format($hours,2)." hrs.";
// 	}
// 	else if($time>$day['min']){ //days
// 		$days = (($time/60)/9);
// 		return number_format($days,2)." days"; 
// 	}
// 	else if($time==0){
// 		return "-";
// 	}
// 	else{ //minutes
// 		if($time<1){
// 			return number_format(($time*60),2)." sec.";
// 		}
// 		else{
// 			return number_format($time,2)." mins.";
// 		}
// 	}

// }

function convert_time($time){
	if($time<1){
		$time = $time*60;
		return  number_format($time,2)." sec.";
		//return  number_format($time,2)." min.";
	}
	else if($time<=59 && $time>=1){
		return number_format($time,2)." mins.";
	}	
	else if($time>=60 && $time<1440){
		$hours = ($time/60);
		return number_format($hours,2)." hrs.";
	}
	else{
		$days = ($time/1440);
		return number_format($days,2)." days.";
	}
}

function end_date($startdate,$noofdays){
	//$_POST['startdate'] = '2012-08-14';
    //$_POST['numberofdays'] = 10;

    $d = new DateTime($startdate);
    $t = $d->getTimestamp();

    // loop for X days
    for($i=0; $i<$noofdays; $i++){

        // add 1 day to timestamp
        $addDay = 86400;

        // get what day it is next day
        $nextDay = date('w', ($t+$addDay));

        // if it's Saturday or Sunday get $i-1
        if($nextDay == 0 || $nextDay == 6) {
            $i--;
        }

        // modify timestamp, add 1 day
        $t = $t+$addDay;
    }

    $d->setTimestamp($t);

    return $d->format('Y-m-d');
}

function get_total_office_time($barcode){
	include("../database/database_connection.php");
	//get total_office and total_transit time
	$qry_get_totals = mysqli_query($connection,"select total_office_time from tbl_document where barcode='$barcode'");
	$total = mysqli_fetch_assoc($qry_get_totals);

	return $total['total_office_time'];
}

function get_total_transit_time($barcode){
	include("../database/database_connection.php");
	//get total_office and total_transit time
	$qry_get_totals = mysqli_query($connection,"select total_transit_time from tbl_document where barcode='$barcode'");
	$total = mysqli_fetch_assoc($qry_get_totals);

	return $total['total_transit_time'];
}
?>