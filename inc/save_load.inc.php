<?php 	
	// QCN Web Simulator
	// This file is part of the QCN Web Simulator, which is based on EmBOINC
	// 
	// Copyright (C) 2013 University of Delaware
	//
	// QCN Web Simulator is free software; you can redistribute it and/or modify it
	// under the terms of the GNU Lesser General Public License
	// as published by the Free Software Foundation,
	// either version 3 of the License, or (at your option) any later version.
	//
	// QCN Web Simulator is distributed in the hope that it will be useful,
	// but WITHOUT ANY WARRANTY; without even the implied warranty of
	// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
	// See the GNU Lesser General Public License for more details.
	//
	// You should have received a copy of the GNU Lesser General Public License
	// along with QCN Web Simulator.  If not, see <http://www.gnu.org/licenses/>.
	//
	// Filename: save_load.inc
	// Author: Sam Schlachter
	// Description: This file 

	function paramToQueryRow($param){
		$queryRow = array();
		if($param["ID"] != 0){
			$queryRow["ID"] = $param["ID"];
		}
		else{
			$queryRow["ID"] = 0;
		}
		
		$queryRow["name"]=$param["sim_name"];
		$queryRow["description"] = $param['sim_desc'];
		$queryRow["cuttime"] = $param["cuttime"];
		$queryRow["trickle_ups"] = 1;		
		$queryRow["save_time"] = "NOW()";
		$queryRow['rand_num_seed'] = $param["sim_seed"];
		$queryRow['sim_start_time'] = $param["start_time"];
		
		if($param["debug"]=="true")
			$queryRow["debug"] = 1;
		else
			$queryRow["debug"] = 0;
			
		if($param['perfect']=="true")
			$queryRow["perfect_hosts"] = 1;
		else
			$queryRow["perfect_hosts"] = 0;
			
		if($param["sim_conn"]=='weibull')
			$queryRow['weibull'] = 1;
		else	
			$queryRow['weibull'] = 0;
			
		$queryRow['user_trace'] = "USERTRACE";
		$queryRow['wu_trace'] = "WORKUNITTRACE";
		
		return $queryRow;
	}
	
	function saveQueryRow($qr){
		$keys = array();
		$vals = array();
		
		foreach($qr as $k=>$v){
			$keys[] = $k;
			$vals[] = $v;
		}
		
		if($qr["ID"]==0){
			$query = "INSERT INTO simulations
			(".implode(array_splice($keys,1,count($keys)),",").")
			VALUES ('".implode(array_splice($vals,1,count($vals)),"','")."')";
			$query= str_replace("'NOW()'", "NOW()", $query);
		}
		else{
		  //TODO - Handle case where simuation has already been saved
		  $query = "INSERT INTO simulations                                                                                            
                        (".implode(array_splice($keys,1,count($keys)),",").")                                                                       
                        VALUES ('".implode(array_splice($vals,1,count($vals)),"','")."')";
		  $query= str_replace("'NOW()'", "NOW()", $query);
		}
		
		$result = mysql_query($query) or die('Query failed: ' . mysql_error());
		
		$qr['ID'] = mysql_insert_id();
		return $qr;
	}
	
	function dumpJSONtoFile($rawJSON,$ID){		
		global $JSON_FILES_FOLDER;
		global $DEBUG;

		$rawJSON = str_replace("{\"ID\":\"0\",","{\"ID\":\"$ID\",",$rawJSON);
		$target = $JSON_FILES_FOLDER."$ID.json";
		//echo "<br>".$target."<br>";
		
		if(!file_put_contents($target,$rawJSON)){
			if($DEBUG){
				$error = error_get_last();
				die_with_error("Line ".$error["line"]." in ".$error["file"]." : ".$error["message"] );
			}
			else{
				die("File i/o Error");
			}
		}
	}
	
	function makeMarker($ID,$type,$lat,$lng){
		$newMarker = array();
	
		$newMarker['ID'] = $ID;
		$newMarker['type'] = $type;
		$newMarker['location'] = array();
		$newMarker['location']['lat'] = $lat;
		$newMarker['location']['lng'] = $lng;
	
		return $newMarker;
	}
	
	function makeMarkersFromAreas($areas){
		$newMarkers = array();
		$nextID = 0;
	
		foreach($areas as $area){
			$limits = getLimits($area);
			
			//var_dump($limits);
			
			$numNewMarkers = $area["numSensor"];
			
			$sum = 0;
	
			for($i=0;$i<$numNewMarkers;$i++){
				$tries = 0;
				do{
					$newLat = rand($limits["lat"]["min"]*100000,$limits["lat"]["max"]*100000)/100000;
					$newLng = rand($limits["lng"]["min"]*100000,$limits["lng"]["max"]*100000)/100000;
	
					$tries++;
				}while(!isInsideArea($newLng,$newLat,$area)&&$tries<1000);
				
				$sum += $tries;
					
				$newMarkers[] = makeMarker($nextID++,$area["type"],$newLat,$newLng);
			}
		}
		
		//echo "Average Tries: " . $sum/$numNewMarkers . "\n"; 
		
		//var_dump($newMarkers);
		return $newMarkers;
	}
	
	//Returns a 2x2 array with the first dimention being lat/lng and the second being min/max
	function getLimits($area){
		$limits = array();
		$limits["lat"] = array();
		$limits["lat"]["max"] = -360;
		$limits["lat"]["min"] = 360;
		$limits["lng"] = array();
		$limits["lng"]["max"] = -360;
		$limits["lng"]["min"] = 360;
	
		foreach($area["points"] as $point){
			if($point["lat"]>$limits["lat"]["max"]){
				$limits["lat"]["max"] = $point["lat"];
			}
			if($point["lat"]<$limits["lat"]["min"]){
				$limits["lat"]["min"] = $point["lat"];
			}
			if($point["lng"]>$limits["lng"]["max"]){
				$limits["lng"]["max"] = $point["lng"];
			}
			if($point["lng"]<$limits["lng"]["min"]){
				$limits["lng"]["min"] = $point["lng"];
			}
		}
	
		return $limits;
	}
	
	
	/*
	
	def isPointInPath(x, y, poly):
        num = len(poly)
        i = 0
        j = num - 1
        c = False
        for i in range(num):
                if  ((poly[i][1] > y) != (poly[j][1] > y)) and \
                    (x < (poly[j][0] - poly[i][0]) * (y - poly[i][1]) / (poly[j][1] - poly[i][1]) + poly[i][0]):
                        c = not c
                j = i
        return c
    */
	function isInsideArea($x,$y,$area){
		$points = $area["points"];
		
		$inside = false;
	
		for($i=0,$j = count($points)-1;$i<count($points);$i++){	
			if(
					(($points[$i]["lat"] > $y) != ($points[$j]["lat"] > $y)) &&
					($x < ($points[$j]["lng"] - $points[$i]["lng"]) * ($y - $points[$i]["lat"]) / ($points[$j]["lat"] - $points[$i]["lat"]) + $points[$i]["lng"])
			){
				$inside = !$inside;
			}
				
			$j = $i;
		}
		return $inside;
	}
	
	function generateQCNhostsXML($markers){
		$markersXML = new SimpleXMLElement('<markers/>');
	
		foreach ( $markers as $marker ){
			$markerXML = $markersXML->addChild('marker');
			$markerXML->addAttribute('name', $marker['ID']);
			$markerXML->addAttribute('type', $marker['type']);
			$markerXML->addAttribute('lat', $marker['location']['lat']);
			$markerXML->addAttribute('lng', $marker['location']['lng']);
		}
	
		return str_replace(">",">\n",$markersXML->asXML());
	}
	
	function generateHostXML($markers,$types){
		$hostsXML = "";
		$type = $types[0];
		$currentHostID = 1;
		$currentUserID = 1;
	
		foreach ( $markers as $marker ){
			//make sure we're pointing to the correct type object
			if($type['ID']!=$marker['type']){
				foreach ( $types as $temp_type ){
					if($temp_type['ID']==$marker['type']){
						$type = $temp_type;
						break;
					}
				}
			}
	
			$hostXML = "<row_host>\n";
			$hostXML .= basicXML("id",$currentHostID++);
			$hostXML .= basicXML("userid",$currentUserID++);
			$hostXML .= basicXML("create_time",$type['c_time']);
			//$hostXML .= basicXML("timezone",marker[]);
			$hostXML .= basicXML("on_frac",$type['on_frac']);
			$hostXML .= basicXML("con_frac",$type["conn_frac"]);
			$hostXML .= basicXML("act_frac",$type["act_frac"]);
			$hostXML .= basicXML("p_ncpus",$type["num_cpus"]);
			$hostXML .= basicXML("p_vendor",$type["proc_make"]);
			$hostXML .= basicXML("p_fpops",$type["flops"]);
			$hostXML .= basicXML("p_iops",$type["iops"]);
			$hostXML .= basicXML("p_membw",$type["membandw"]);
			$hostXML .= basicXML("p_model",$type["proc_model"]);
			$hostXML .= basicXML("os_name",$type["os_name"]);
			$hostXML .= basicXML("max_rday",$type["max_rpd"]);
			//$hostXML .= basicXML("total_r",$type[""]);
			$hostXML .= basicXML("err_r",$type["error_rate"]);
			$hostXML .= basicXML("success_r",$type["success_rate"]);
			$hostXML .= basicXML("mean_con",$type["mean_conn"]);
			$hostXML .= basicXML("std_con",$type["std_conn"]);
				
			$hostXML .= "</row_host>\n";
				
			$hostsXML .= $hostXML;
		}
	
		return $hostsXML;
	}
	
	function basicXML($tag,$value){
		return "<".$tag.">".$value."</".$tag.">\n";
	}
	
	function generateQuakeXML($quakes){
		$quakesXML = new SimpleXMLElement('<quakes/>');
	
		foreach ( $quakes as $quake ){
			$quakeXML = $quakesXML->addChild('quake');
			$quakeXML->addAttribute('latitude', $quake['location']['lat']);
			$quakeXML->addAttribute('longitude', $quake['location']['lng']);
			$quakeXML->addAttribute('magnitude', $quake['magnitude']);
			$quakeXML->addAttribute('depth', $quake['depth']);
			$quakeXML->addAttribute('time', $quake['time']);
			if($quake["swaveSpeed"]!=3){
				$quakeXML->addChild("s_wave_speed",$quake["swaveSpeed"]);
			}
		}
	
		return str_replace("d>\n","d>",str_replace(">",">\n",$quakesXML->asXML()));
	}

	function die_with_error($message){
		die("{\"error\" : \"".$message."\"}\n");
	}
	
	function getUsersSims($userID){
		global $mysql_host;
		global $mysql_user;
		global $mysql_pass;
		global $mysql_db;
		
		if($_COOKIE["QCNexpSave"]==NULL){
			return NULL;
		}
		else{
			$simIDs = str_replace("|",",",$_COOKIE["QCNexpSave"]);
			
			$conn = mysql_connect($mysql_host,$mysql_user,$mysql_pass) or die('MySQL Error: ' . mysql_error());		
			mysql_select_db($mysql_db);
			
			$userID = mysql_real_escape_string ($userID, $conn);
			
			$query = "SELECT * FROM simulations WHERE ID IN (".$simIDs.")";
			
			$result = mysql_query($query);
			$sim_param_array = array();
			
			while($row=mysql_fetch_array($result)) {
				$sim_param_array[] = $row; 
			}
			return $sim_param_array;
			
		}
	

	}
?>
