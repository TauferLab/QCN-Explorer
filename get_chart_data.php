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
	 * Filename: get_chart_data.php
	 * Author: Sam Schlachter
	 * Description: 
	 *
	 */		
	require_once("inc/config.inc");
	
	$trickle_ups_folder = $TRICKLES_OUT_FOLDER;
	$quakes = array();
	$triggers = array();
	$quake_ID = 1;
	
	function startElement($parser, $name, $attrs) {
		global $quake_ID;
		global $quakes;
		global $triggers;
	
		if($name =="QUAKE"){
			$temp = array();
			$temp['lat'] = floatval($attrs['LATITUDE']);
			$temp['lng'] = floatval($attrs['LONGITUDE']);
			$temp['mag'] = floatval($attrs['MAGNITUDE']);
			$temp['depth'] = floatval($attrs['DEPTH']);
			$temp['time'] = intval($attrs['TIME']);
			$temp['ID'] = $quake_ID++;
			$quakes[] = $temp;
		}
		else if($name =="TRIGGER"){
			if($attrs['FMAG']>0){
				$temp = array();
				$temp['time'] = intval($attrs['TIME']);
				$temp['lat'] = floatval($attrs['LAT']);
				$temp['lng'] = floatval($attrs['LNG']);
				$temp['fmag'] = floatval($attrs['FMAG']);
				$triggers[] = $temp;
			}
		} 	
	}
	
	function endElement($parser, $name) {
	}
	
	function firstQuake($quakes){
		$firstQuake = $quakes[0];
		
		foreach($quakes as $quake){
			if($quake['time'] < $firstQuake['time'])
				$firstQuake = $quake;
		}
	
		return $firstQuake;
	}
	
	function lastQuake($quakes){
		$lastQuake = $quakes[0];
		
		foreach($quakes as $quake){
			if($quake['time'] > $lastQuake['time'])
				$lastQuake = $quake;
		}
	
		return $lastQuake;
	}
	
	function histogram_data(){
	
		global $quakes;
		global $triggers;
	
		$count = array();
	
		foreach($triggers as $trigger){
			$count[$trigger['time']] = $count[$trigger['time']] + 1;
		}
	
		ksort($count);
	
		$first = firstQuake($quakes);
		$last = lastQuake($quakes);
	
		$t_min = $first['time'] - 10;
		$t_max = $last['time'] + 30;
	
	
		$titles = array("Trigger Time","Number of Triggers");
		$types = array("string","number");
	
		for($i = $t_min; $i <= $t_max; $i++){
			$rows[$i][0] = $i;
			if(isset($count[$i]))
				$rows[$i][1] = $count[$i];
			else
				$rows[$i][1] = 0;
		}
		printJSON($titles,$types,$rows);
	}
	
	function scatter_plot($time=false){
		global $triggers;
		global $quakes;
	
		$titles = array("Distance from Hypocenter","Trigger Time");
		$types = array("number","number");
	
		$rows = array();
	
		for($i=0; $i<count($triggers); $i++){
			foreach($quakes as $quake){
				$rows[$i][0] = $triggers[$i]['distance'][($quake['ID'])];
	
				if($time) $rows[$i][1] = $triggers[$i]['time'];
				else $rows[$i][1] = $triggers[$i]['fmag'];
			}
		}
	
		printJSON($titles,$types,$rows);
	}
	
	//
	function printJSON($titles,$types,$rows){
		$num_cols = count($titles);
	
		echo "{\n\"cols\": [\n";
		for($i=0;$i<$num_cols;$i++){
			echo "{\"id\":\"\",\"label\":\"".$titles[$i]."\",\"pattern\":\"\",\"type\":\"".$types[$i]."\"}";
			if($i != ($num_cols - 1))
				echo ",";
			echo "\n";
		}
	
		echo "],\n\"rows\": [\n";
	
		foreach($rows as $row){
			echo "{\"c\":[";
			for($i = 0; $i < $num_cols; $i++){
				echo "{\"v\":";
				if($types[$i] == "string"){echo "\"";}
				echo $row[$i];
				if($types[$i] == "string"){echo "\"";}
				echo ",\"f\":null}";
				if($i != ($num_cols - 1))
					echo ",";
			}
			echo "]}";
			if($row != end($rows))
				echo ",";
			echo "\n";
		}
		echo "]\n}";
	}
	
	function endKey($array){
	 end($array);
	 return key($array);
	}
	
	//Find the distance a host is from the hypocenter of an earthquake
	function hypo_distance($lat_h, $lng_h, $lat_q, $lng_q, $depth){
		$EARTH_MEAN_RADIUS=6371; // kilometers
	
		//Compute Differentials and convert everything to radians
		$dLat = deg2rad(abs($lat_q-$lat_h));
		$dLng = deg2rad(abs($lng_q-$lng_h));
		$lat_q = deg2rad($lat_q);
		$lat_h = deg2rad($lat_h);
	
		//Use the haversine formula to calculate the haversine of (arclength)/(earth's radius)
		$haversine = (1-cos($dLat))/2 + cos($lat_q)*cos($lat_h)*(1-cos($dLng))/2;
	
		//Computer the archaversine of the value above to get the arcDistance
		$arcDistance = 2*$EARTH_MEAN_RADIUS*asin(sqrt($haversine));
	
		//The angle of the arc between the host and the epicenter of the quake from the center of the earth
		$theta = $arcDistance/$EARTH_MEAN_RADIUS;
	
		$hypocentral_radius = $EARTH_MEAN_RADIUS - $depth;
	
		//The distance between the host and the hypocenter of a quake. Uses law of cosines
		$distance = sqrt(pow($hypocentral_radius,2)+pow($EARTH_MEAN_RADIUS,2) - 2*$EARTH_MEAN_RADIUS*$hypocentral_radius*cos($theta));
	
		return $distance;
	}
	
	function calc_distances($triggers, $quakes){
		foreach($triggers as &$trigger){
			foreach($quakes as $quake){
				$trigger['distance'][($quake['ID'])] = hypo_distance($trigger['lat'],$trigger['lng'],$quake['lat'],$quake['lng'],$quake['depth']);
			}
		}
	
		return $triggers;
	}
	
	function parseFile($file){
		$xml_parser = xml_parser_create();
		xml_set_element_handler($xml_parser, "startElement", "endElement");
		if (!($fp = fopen($file, "r"))) {
			echo getcwd()."\n";
			echo $file."\n";
			die("{'error':'could not open XML input'}");
		}
	
		while ($data = fread($fp, 4096)) {
			if (!xml_parse($xml_parser, $data, feof($fp))) {
			    die(sprintf("XML error: %s at line %d",
			                xml_error_string(xml_get_error_code($xml_parser)),
			                xml_get_current_line_number($xml_parser)));
			}
		}
		xml_parser_free($xml_parser);
	}
	
	/************** Begin Page ******************/
	
	if(isset($_GET['graph'])){
		if(isset($_GET['id'])){
				$filename = $trickle_ups_folder.$_GET['id'].".xml";
		
				parseFile($filename);
				$triggers = calc_distances($triggers, $quakes);
	
			if($_GET['graph']==1)
				histogram_data();
			else if($_GET['graph']==2)
				scatter_plot();
			else if($_GET['graph']==3)
				scatter_plot(true);
	
		}
	}

?>

