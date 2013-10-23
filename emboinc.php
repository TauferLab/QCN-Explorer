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
 * Filename: emboinc.php
 * Author: Sam Schlachter
 * Description: 
 *
 */		
	//ini_set("memory_limit","512M");
	
	require_once("src/php/config.inc");
	
	$id_next = false;
	$id = "";
	
	foreach($argv as $value){
		if($id_next){
			$id = $value;
			$id_next = false;
			break;
		}
		if($value=="--id"){
			$id_next = true;
		}
	}
	
	if($id==""){
		return -1;
	}
	
	$JSONfname = $JSON_FILES_FOLDER.$id.".json";
	$JSONin = file_get_contents($JSONfname);
	$input = json_decode($JSONin,true);
	
	$input = $input["simulation"];
	$hosts = readHostsFromXML(); //$input["markers"];
	$quakes = $input["earthquakes"];
	$parameters = $input["parameters"];
	
	$hosts = runSimulation($parameters,$quakes,$hosts);
	
	$triggerOutput = buildTriggerOutputStr($quakes,$hosts);
	
	$output_filename = $TRICKLES_OUT_FOLDER.$id.".xml";
	$result = file_put_contents($output_filename,$triggerOutput);
	
	//Animation Output
	$animations = array();
	$animations["sensors"] = $hosts;
	$animations["quakes"]  = $quakes;
	$animations["map"] = $input["parameters"]["map"];
	
	file_put_contents($ANIMATION_FOLDER.$id.".json",json_encode($animations));
	
	if( $result === FALSE){
		return -1;
	}
	else{
		echo "sucess";
		return 0;
	}
	
	function readHostsFromXML(){
	    global $HOSTLIMIT;
		global $QCN_TRACES_FOLDER;
		global $id;
	
		$hostsFname = $QCN_TRACES_FOLDER.$id.".xml";
		$hostsXML = file_get_contents($hostsFname);
		
		$hostsXML = explode("\n", $hostsXML);

        if( count($hostsXML) > $HOSTLIMIT ){
            $hostsXML = array_slice($hostsXML,0,$HOSTLIMIT);
        }

		$hosts = array();
		
		foreach($hostsXML as $rawHost){
			$hostArray = explode("\"", $rawHost);
			
			if(count($hostArray) > 8){
				$newHost = array();
				$newHost["ID"] = $hostArray[1];
				$newHost["type"] = $hostArray[3];
				$newHost["location"] = array();
				$newHost["location"]["lat"] = $hostArray[5];
				$newHost["location"]["lng"] = $hostArray[7];
				
				$hosts[] = $newHost;
			}		
		}
		
		return $hosts;		
	}

	function buildTriggerOutputStr($quakes,$hosts){
		
		$ret = 	"<results><quakes>";
		
		foreach($quakes as $quake){
			$ret .= '<quake latitude="'.$quake["location"]["lat"].'" longitude="'.$quake["location"]["lng"];
			$ret .= '" magnitude="'.$quake["magnitude"].'" depth="'.$quake["depth"].'" time="'.$quake["time"].'"/>';
		}
		
		$ret .= "</quakes><triggers>";
		
		foreach( $hosts as $host ){
			foreach( $host["triggers"] as $trigger){
				$ret .= '<trigger time="'.$trigger["time"].'" lat="'.$host["location"]["lat"].'" lng="'.$host["location"]["lng"].'" fmag="'.$trigger["mag"].'"/>';
			}
		}
		
		
		$ret .= "</triggers></results>";
		
		return $ret;
	}
	
	//Find the distance a host is from the hypocenter of an earthquake in kilometers
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
	
	//Make a new trigger array
	function makeTrigger($time,$mag,$distance){
		$newTrigger = array();
		$newTrigger["mag"] = $mag;
		$newTrigger["time"] = $time;
		$newTrigger["distance"] = $distance;
		
		return $newTrigger;
	}
	
	function runSimulation($parameters,$quakes,$hosts){
		$simDuration = $parameters["cuttime"];
				
		foreach($hosts as &$host){
			$host["triggers"] = array();
		
			foreach($quakes as $quake){
				$distance = hypo_distance($host["location"]["lat"],$host["location"]["lng"],$quake["location"]["lat"],$quake["location"]["lng"],$quake["depth"]);
				
				/* calculate vector sum of acceleration of S-wave
			       equation taken from Chung et. al (2011)
			       |a| = 1/b*exp((M-c*ln(R)-d)/a)
			       |a| = vector sum of acceleration, a = 1.25, b = 1.8, c = 0.8, d = 3.25
			       M = magnitude of earthquake, R = focal depth
			    */
			    
			    
			    $speedVar = gauss_ms(0.75,1.25,1.0,0.08);
   			    $magVar  = gauss_ms(0.7,1.3,1.0,0.1);
			    
			    $modSwaveSpeed = $quake["swaveSpeed"] * $speedVar;
			    
			    
			    $secondaryTriggerMag  = 0.555555555556*exp(0.8*($quake["magnitude"] - 0.8*log($distance) - 3.25))*$magVar;
			    
			    // wave is ignored if < 0.01 and has 50% chance of registering if between 0.01 and 0.02
			    if( $secondaryTriggerMag > 0.01 ){
    			    $rand = mt_rand() / mt_getrandmax();
			    
			        if( $primaryTriggerMag > 0.02 || $rand > 0.5 ){
        			    $secondaryTriggerTime = $quake["time"] + $distance/$modSwaveSpeed;
        			    $host["triggers"][]   = makeTrigger($secondaryTriggerTime,$secondaryTriggerMag,$distance);    
    			    }
			    }
			    
				$primaryTriggerMag  = $secondaryTriggerMag*0.2;
				
				
				// wave is ignored if < 0.01 and has 50% chance of registering if between 0.01 and 0.02
			    if( $primaryTriggerMag > 0.01 ){
			        $rand = mt_rand() / mt_getrandmax();
			    
			        if( $primaryTriggerMag > 0.02 || $rand > 0.5 ){
    			         $primaryTriggerTime = $quake["time"] + $distance/($modSwaveSpeed*1.732); 
    			         $host["triggers"][] = makeTrigger($primaryTriggerTime,$primaryTriggerMag,$distance);   
			        }
			    }
				
			}
			
			// Create false triggers if hosts aren't perfect
			$numFalseTriggersPerDay = 1;
			/*
			$numFalseTriggers = 2;
			
			for( $q  = 0; $q < $numFalseTriggers; $q++ ){
    			$mag = gauss_ms(0.89,1.02,1.0,0.08);
    			$time = $q*2;
    			$distance = 0;
    			$host["triggers"][] = makeTrigger($time,$mag,$distance);
			}
			*/
			/*
                if (!sim_params.perfect) {
                    double mean_triggers = qcn_host->daily_false_triggers*
                                           result_secs_remaining/86400.0;
                    int trigger_time;
            
                    for (int num_triggers =
                                (int)utils.rand_gaussian(mean_triggers,mean_triggers*0.33) + 0.5;
                            num_triggers > 0; num_triggers--) {
                        //uniformly distribute trigger times
                        trigger_time = simobj.get_simulatedTime() + rand() % result_secs_remaining;
                        sprintf(buf,"%d",trigger_time);
                        xml_data[3] = string(buf);
                        sprintf(buf,"%lf",0.5);
                        xml_data[4] = string(buf); //significance factor == 0.5 for false trigger
                        sprintf(buf,"%lf",utils.Weibull(0.89,1.02)); //magnitude
                        xml_data[5] = string(buf);
                        if (trigger_time < sim_end_time) {
                            trickles.push_front(new TRICKLE_UP(result->name,
                                                               trigger_time + trickleLatency(),
                                                               (char*)"trigger",
                                                               xml_data));
            
                            if (rawOutFile) {
                                fprintf(rawOutFile,TRIGGER_OUTPUT_FORMAT,
                                        (int)(trigger_time-simobj.initial_time),
                                        qcn_host->latitude,qcn_host->longitude,
                                        xml_data[5].c_str());
                            }
                        }
                    }
                }
			*/
		}
		
		return $hosts;
	}

	function gauss(){
	   	// N(0,1)
	    // returns random number with normal distribution:
	    //   mean=0
	    //   std dev=1
	    
	    // auxilary vars
	    $x=random_0_1();
	    $y=random_0_1();
	    
	    // two independent variables with normal distribution N(0,1)
	    $u=sqrt(-2*log($x))*cos(2*pi()*$y);
	    $v=sqrt(-2*log($x))*sin(2*pi()*$y);
	    
	    // i will return only one, couse only one needed
	    return $u;
	}
	
	function gauss_ms($min,$max,$m,$s){
		// N(m,s)
	    // returns random number with normal distribution:
	    //   mean=m
	    //   std dev=s
	    
	    return gauss()*$s+$m;
	}
	
	function random_0_1(){
		// auxiliary function
	    // returns random number with flat distribution from 0 to 1
	    return (float)rand()/(float)getrandmax();
	}

?>
