<?php

include("connection.php");
include("centreware.php");
//var_dump(get_centreware()); exit();

//while(true) {

	if($centreware = get_centreware()) {
		$black_copies = $centreware["black_copies"];
		$color_copies = $centreware["color_copies"];
		$black_prints = $centreware["black_prints"];
		$color_prints = $centreware["color_prints"];

		//get last saved print status
		$last_counter_query = "SELECT * FROM `counters` ORDER BY date DESC LIMIT 1";
		$last_counter_result = $mysqli->query($last_counter_query);

		//Last counter exists
		if ($last_counter_result->num_rows > 0) {
			$last_counter = $last_counter_result->fetch_object();

		  $last_black_copies = $last_counter->black_copies;
		  $last_color_copies = $last_counter->color_copies;
		  $last_black_prints = $last_counter->black_prints;
		  $last_color_prints = $last_counter->color_prints;

		  //last print status is different then centreware
		  if(
		  	$black_copies != $last_black_copies ||
		  	$color_copies != $last_color_copies || 
		  	$black_prints != $last_black_prints || 
		  	$color_prints != $last_color_prints
		  	) {

		  	//Centreware change, so save new centreware status
		  	$new_counter_query = "INSERT INTO `counters` (black_copies,color_copies,black_prints,color_prints) VALUES ($black_copies,$color_copies,$black_prints,$color_prints)";
			  $mysqli->query($new_counter_query);

		  } //else {
		  	//Nothing changed, needs more printing!
		  //}
		} else {

			//First centreware status
		  $new_counter_query = "INSERT INTO `counters` (black_copies,color_copies,black_prints,color_prints) VALUES ($black_copies,$color_copies,$black_prints,$color_prints)";
		  $mysqli->query($new_counter_query);
		}		
	}

	//sleep(3);

//}

$mysqli->close();
