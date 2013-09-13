<?php


		// Try host ip database
		//$ip = $REMOTE_ADDR;
		//$ip = "66.191.176.243";
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