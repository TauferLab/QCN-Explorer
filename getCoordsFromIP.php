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
	 * Filename: getCoordsFromIP.php
	 * Author: Sam Schlachter
	 * Description: 
	 *
	 */	

	$ip = $_SERVER['REMOTE_ADDR'];
	
	$url = "http://api.hostip.info/get_json.php?ip=".$ip."&position=true";
	$json = file_get_contents($url);	
	$decodedJSON = json_decode($json, true);

	if( isset($decodedJSON["lat"]) && isset($decodedJSON["lng"]) ){
		
		$decodedJSON["success"] = "true";
		
		echo json_encode($decodedJSON);
	}
	
	else{
	
		// Try ipinfodb
		
		$apiKey = "08f085abcace19ae2b19306b23e1187923c9b348828baa21a95face04cc85642";
		
		$url = "http://api.ipinfodb.com/v3/ip-city/?key=".$apiKey."&ip=".$ip;
	
		$data = file_get_contents($url);
		
		$parsedData = explode(";",$data);
		
		if(
			$parsedData[0] == "OK" &&
			$parsedData[8] != "0" &&
			$parsedData[9] != "0"
		){
			$ret = array();
			
			$ret["lat"] = $parsedData[8];
			$ret["lng"] = $parsedData[9];
			$ret["success"] = "true";
			
			echo json_encode($ret);
		}
		else{
			echo "{\"success\":\"false\"}";		
		}	
	}

?>