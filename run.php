<?php 

	/********************
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
	 * Filename: run.php
	 * Author: Sam Schlachter
	 * Description: This file 
	 *
	 */
	require_once("src/php/config.inc");
	require_once("src/php/save_load.inc.php");

	if(isset($_GET["ID"])){
		$sim_ID = $_GET["ID"];
	}else{
		$sim_ID = 62;
	}

		$query = "SELECT * FROM simulations WHERE ID=".$sim_ID;
		mysql_connect($mysql_host,$mysql_user,$mysql_pass);
		mysql_select_db($mysql_db);
		
		$result = mysql_query($query);
		
		$results_array = array();
		while($row = mysql_fetch_array($result)){
			$results_array[] = $row;
		}
		
		$command = make_command_line($results_array[0]); 
		
		$output = array();
		$result = exec($command,$output);

		//get filename and empty file		
		$log_filename = $LOG_OUTPUT_FOLDER.$sim_ID.".log";
		file_put_contents($log_filename,"");

		foreach($output as $output_line){
			file_put_contents($log_filename, $output_line."\n", FILE_APPEND);
		}

		if($result != false){
			echo "{\"success\" : \"true\", \"simID\": ".$sim_ID."}";
		}
		else{
			echo "{\"success\" : \"false\"}";
		}
	//}
	
	/* Example input
	   array(30) { 
	   ["ID"]=> string(1) "3" 
	   ["save_time"]=> string(19) "2013-02-18 05:19:18" XXX
	   ["owner"]=> string(1) "0" XXX
	   ["name"]=> string(16) "somethingorother" XXX
	   ["user_trace"]=> string(9) "USERTRACE" XXX
	   ["wu_trace"]=> string(13) "WORKUNITTRACE" XXX 
	   ["debug"]=> string(1) "0" XXX
	   ["verbose"]=> string(1) "0" XXX
	   ["rand_num_seed"]=> string(1) "0" XXX
	   ["cuttime"]=> string(2) "30" XXX
	   ["sim_start_time"]=> string(1) "0" XXX
	   ["trickle_ups"]=> string(1) "1" 
	   ["description"]=> string(0) "" 
	   ["perfect_hosts"]=> string(1) "0" 
	   ["weibull"]=> string(1) "0" } 
	*/
	function make_command_line($sim){
	  global $HOST_TRACES_FOLDER;
	  global $USER_TRACES_FOLDER;
	  global $WU_TRACES_FOLDER;
	  global $QUAKE_TRACES_FOLDER;
	  global $QCN_TRACES_FOLDER;
	  global $ANIMATION_FOLDER;
	  global $LOG_OUTPUT_FOLDER;
	  global $TRICKLES_OUT_FOLDER;
	  global $SIM_EXE;
	  
	
	  $cmd_str = $SIM_EXE." ";
	  
	  $cmd_str .= " --id ".$sim["ID"];
	  
	  $cmd_str .= " --host ".$HOST_TRACES_FOLDER.$sim["ID"].".xml" ;
	
	  if($sim["debug"] > 0){
	    $cmd_str .= " --debug ";
	  }
	  else if($sim["verbose"] > 0){
	    $cmd_str .= " -v ";
	  }
	
	  if($sim["rand_num_seed"] > 0){
	    $cmd_str .= " --seed ".$sim["rand_num_seed"];
	  }
	  if($sim["cuttime"] > 0){
	    $cmd_str .= " --cuttime ".$sim["cuttime"];
	  }
	  if($sim["sim_start_time"] > 0){
	    $cmd_str .= " --start_time ".$sim["sim_start_time"];
	  }
	  if($sim["perfect_hosts"]){
	    $cmd_str .= " --perfect ";
	  }
	  if($sim["weibull"]){
	    $cmd_str .= " --weibull ";
	  }
	  $cmd_str .= " --quake ".$QUAKE_TRACES_FOLDER.$sim["ID"].".xml ";
	  $cmd_str .= " --qcn_hosts ".$QCN_TRACES_FOLDER.$sim["ID"].".xml ";
	  $cmd_str .= " --output ".$TRICKLES_OUT_FOLDER.$sim["ID"].".xml ";
	
	  return $cmd_str;
	}


?>
