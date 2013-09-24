<?php
	/*
	 * QCN Explorer
	 *
	 * This file is part of the QCN Web Simulator, which is based on EmBOINC
	 *
	 * Copyright (C) 2013 University of Delaware
	 *
	 * QCN Explorer is licensed under the Creative Commons Attribution-NonCommercial
	 * 3.0 Unported License. To view a copy of this license, visit
	 * http://creativecommons.org/licenses/by-nc/3.0/ or send a letter to
	 * Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
	 *
	 * QCN Web Simulator is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
	 *
	 * Filename: get_animation_data.php
	 * Author: Sam Schlachter
	 * Description: 
	 *
	 */	
	
	// Example output:
	/*
	echo' 
	{
		"map" : {
			"center" : { "lat" : "0", "lng" : "0" },
			"zoom" : "",
			"type" : ""
		}
	
		"quakes" : [
						{ 
							"time": "30" ,
							"location" : {
								"lat": "123",
								"lng" : "123"
								}
						}
		],
	    "sensors": [
	        {
	            "location": {
	                "lat": 32.990300,
	                "lng": -116.830900
	            },
	            "triggers": [
					{ "time" :  "1", "magnitude" : "0.490237" },
					{ "time" : "12", "magnitude" : "2.451184" }
				]
	        },
	        {
	            "location": {
	                "lat": 33.179800,
	                "lng": -116.968300
	            },
	            "triggers": [
					{ "time" :  "3", "magnitude" : "0.217347" },
					{ "time" : "15", "magnitude" : "1.205821" }
				]
	        }
	    ]
	}';
	*/

	if(isset($_GET['id'])){
		require_once('inc/config.inc');
		
		$sim_id = $_GET['id'];
		
		echo file_get_contents($ANIMATION_FOLDER.$sim_id.".json");
		/*
		
		$return_object = array();
		
		$filename = $TRICKLES_OUT_FOLDER.$sim_id.".xml";
		$trickle_xml = simplexml_load_file($filename);
	
	
		// Get quake information
	
		$quakes = array();
	
		foreach($trickle_xml->quakes->quake as $quake_raw){
			$newQuake = array();
			$newQuake["time"] = (string) $quake_raw["time"];
			$newQuake["location"] = array();
			$newQuake["location"]["lat"] = (string) $quake_raw["latitude"];
			$newQuake["location"]["lng"] = (string) $quake_raw["longitude"];
			$newQuake["depth"] = (string) $quake_raw["depth"];
			$newQuake["magnitude"] = (string) $quake_raw["magnitude"];
			$quakes[] = $newQuake;
		}
		
		$return_object["quakes"] = $quakes;
		
		// Get sensor/trickle message information 
		
		$sensors = array();
		
		foreach($trickle_xml->triggers->trigger as $trigger_raw){
			$found = false;
			foreach($sensors as &$sensor){
				//if this same sensor is already accounted for then we just need to append the new trigger to the sensor's trigger list
				if( $sensor["location"]["lat"] == $trigger_raw["lat"] &&
				    $sensor["location"]["lng"] == $trigger_raw["lng"]){
						$found = true;
						//add new trigger
						$sensor["triggers"][]= array("time" => (string) $trigger_raw["time"],"magnitude" => (string) $trigger_raw["fmag"]);
				    }
			}
			
			unset($sensor);
			
			//if it wasn't found we need to create a new sensor and a new trigger
			if($found == false){
				$new_sensor = array();
				$new_sensor["location"] = array("lat" => (string) $trigger_raw["lat"], "lng" => (string) $trigger_raw["lng"]);
				$new_sensor["triggers"] = array();
				$new_sensor["triggers"][]= array("time" => (string) $trigger_raw["time"],"magnitude" => (string) $trigger_raw["fmag"]);
				
				$sensors[] = $new_sensor;
			}
		}
	
		$return_object["sensors"] = $sensors;
		
		// Get map information
		
		$json_filename = $JSON_FILES_FOLDER.$sim_id.".json";
		$raw_json = file_get_contents($json_filename);
		$sim_parameters = json_decode($raw_json,TRUE);
		
		$return_object["map"] = $sim_parameters["simulation"]["parameters"]["map"];
		
		// Return
		echo json_encode($return_object)."\n";	
		*/	
	}
?>