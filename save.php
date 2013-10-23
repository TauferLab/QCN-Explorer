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
 * Filename: save.php
 * Author: Sam Schlachter
 * Description: This file saves the QCN host, host and quake traces as well as the raw JSON representation of the simulation scenario. It is accessed by index.php via an AJAX POST.
 *
 */

	require_once("src/php/config.inc");
	require_once("src/php/save_load.inc.php");
	
	
	if($DEBUG){
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
	}
	
	
	$mysqlconn = mysql_connect($mysql_host, $mysql_user, $mysql_pass) or die("{\"error\" : \"MYSQL ERROR:".mysql_error()."\"}");
	mysql_select_db($mysql_db) or die('Could not select database');

	$rawJSON = $HTTP_RAW_POST_DATA;

	$data = json_decode($rawJSON, true);
	$sim = $data['simulation'];
	
	$qr = paramToQueryRow($sim['parameters']);
	$qr = saveQueryRow($qr);
	
	$ID = $qr['ID'];
	
	if( $ID > 0){
		dumpJSONtoFile($rawJSON,$ID);
		
		//Collect All Sensors
		$markerSensors = $sim['markers'];
		
		$numSensors = count($markerSensors);
		
		if( $numSensors > $HOSTLIMIT ){
    		$markerSensors = array_slice($markerSensors,0,$HOSTLIMIT);
    		$areaSensors = array();
		}else{
    	    $areaSensors = makeMarkersFromAreas($sim['areas']);	
		}
		
		$allSensors = array_merge($markerSensors,$areaSensors);
		
		//Filenames
		$qcn_host_filename = $QCN_TRACES_FOLDER.$ID.".xml";
		$host_filename = $HOST_TRACES_FOLDER.$ID.".xml";
		$quake_filename = $QUAKE_TRACES_FOLDER.$ID.".xml";


		//Generate Traces and dump them to file
		//if(!file_put_contents($qcn_host_filename, generateQCNhostsXML($sim['markers']))){
		if(!file_put_contents($qcn_host_filename, generateQCNhostsXML($allSensors))){
			echo "{\"error\" : \"QCN host trace generation error. Could not write to $qcn_host_filename. \"}";
			die();
		}
		//if(!file_put_contents($host_filename, generateHostXML($allSensors,$sim['SensorTypes']))){
		//	echo "{\"error\" : \"Host trace generation error. Could not write to $host_filename. \"}";
		//	die();
		//}
		if(!file_put_contents($quake_filename,generateQuakeXML($sim["earthquakes"]))){
			echo "{\"error\" : \"Quake trace generation error. Could not write to $quake_filename. \"}";
			die();
		}
		
		
		echo "{\"savedID\" : \"$ID\" }";
	}
	else{
		echo "{\"error\" : \"database error\"}";
	}
		
?>
