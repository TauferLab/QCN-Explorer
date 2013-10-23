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
 * Filename: results.php
 * Author: Sam Schlachter
 * Input: simulation id via GET (ie. ./results.php?ID=42) 
 * Description: This file is one of the two main files the users interact with. Here users
 * view the results of their simulation. These results include the raw output of the simulator
 * (stdout), an animation of the simulator's output and a handful of charts that represent the 
 * simulation results. Based on the simulation ID, this page queries get_animation_data.php 
 * and get_chart_data.php to populate the various result elements.
 *
 */
	 

	require_once("src/php/config.inc");	
	require_once("src/php/template.inc");
	require_once("src/php/save_load.inc.php");
	
	if(isset($_GET["ID"])){
		$sim_ID = (integer) $_GET["ID"];
		$raw_output = get_output_string($sim_ID);
	}
	
	function get_output_string($sim_ID){
		global $LOG_OUTPUT_FOLDER;
		$log_filename = $LOG_OUTPUT_FOLDER.$sim_ID.".log";
		return file_get_contents($log_filename);	
	}


	function printSim($sim){
		global $siteURL;
		echo '
		<div class="simEntry">
			<div class="simDesc">
				<div class="simName">'.$sim["name"].'</div>
				<div>Run Time: '.$sim["save_time"].'</div>
				<div>Description: '.$sim["description"].' </div>
			</div>
			<div class="simBtns">
				<button OnClick=\'location.href="'.$siteURL.'results/'.$sim["ID"].'"\'>View Results</button>
				<button OnClick=\'location.href="'.$siteURL.'editor/'.$sim["ID"].'"\'>Edit This Simulation</button>
			</div>
		</div>';
	}

?>

<html>
<head>

	<title> QCN Explorer - Simulation Results </title>

	<!-- Results Stylesheet -->
	<link rel="stylesheet" type="text/css" href="<?php echo $siteURL?>src/css/common.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $siteURL?>src/css/results.css" />

	<?php if(isset($sim_ID)){ ?>
		<!-- Google Charts -->
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		
		<!-- Google Maps-->
		<script type="text/javascript"
			src="http://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=true">
		</script>
		
		<!-- JSON implementation for old browsers -->
		<script language="JavaScript" src="<?php echo $siteURL?>src/js/lib/json3.min.js"></script>
		
		<!-- Chart/Animation JavaScript -->	
		<script language="JavaScript" src="<?php echo $siteURL?>src/js/results.js"></script>
		<script language="JavaScript">
			//TODO : Don't do this assigning JavaScript variables from PHP is bad news
			var sim_id  = <?php echo "\"$sim_ID\"" ?>;
			var siteURL = <?php echo "\"$siteURL\"" ?>;
		</script>
		
		<!-- Jquery -->
		<script src="<?php echo $siteURL?>src/js/lib/jquery-latest.js"></script>

	<?php } ?>



</head>
<body>

	<?php
		printHeader();
	
		if(!isset($sim_ID)){
		
			$simParams = getUsersSims();
			
			if( count($simParams) == 0 ){
				echo "<h2>You don't have any saved simulations to load!</h2>";
			}
			else{
			
				?>
				
				<div id="simTable">
					<h2>Your Previous Simulations</h2>
					
					<?php
						foreach($simParams as $sim){ 
							printSim($sim);
						}
					?>
				</div>
		
				<?php	
			}
		}
		else{	
			?>
		
			<div id="leftCol"> 
				<h4 class="selectorBtnTitle">Results</h4>
				<button class="selectorBtn" onclick="show_table(1);">Animation</button>
				<button class="selectorBtn" onclick="show_table(5);">Raw Data</button>
				<br>
				<h4 class="selectorBtnTitle">Graphs</h4>
				<button class="selectorBtn" onclick="show_table(2);">Number of Triggers per Second</button>
				<button class="selectorBtn" onclick="show_table(3);">Distance Vs. Time</button>
				<button class="selectorBtn" onclick="show_table(4);">Amplitude Vs. Time</button>
				
								
				<div id="leftBtm">
					<button class="selectorBtn" id="runAnotherBtn" onclick="window.location='<?php echo $siteURL?>editor/<?php echo $sim_ID?>'">Edit this simulation.</button>
					<button class="selectorBtn" id="runAnotherBtn" onclick="window.location='<?php echo $siteURL?>editor'">Run another simulation...</button>
					<br><br>
					<h5 class="selectorBtnTitle">Share this simulation!</h5>
					<!-- AddThis Button BEGIN -->
					<div id="addThis" class="addthis_toolbox addthis_default_style addthis_32x32_style">
						<a class="addthis_button_preferred_1"></a>
						<a class="addthis_button_preferred_2"></a>
						<a class="addthis_button_preferred_3"></a>
						<a class="addthis_button_preferred_4"></a>
						<a class="addthis_button_compact"></a>
					</div>
					<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e4589ea564f36ce"></script>
					<!-- AddThis Button END -->
				</div>
			</div>
		
			<div id="rightCol">
				<!-- Animation --> 
				<div id="results_div_1" class="results_div">
					<div id="map_canvas">
						<div class="loadMsg">
							<span id="loadMsgText">Loading Animation...</span><br><br>
							<img src="<?php echo $siteURL?>icon/ajax-loader.gif"\>
						</div>
					</div>
					<img id="intensityScale" src="http://qcn.stanford.edu/images/ShakeMap_Scale.png"/>
					<div id="animationBtnContainer">
						<button onclick="rewind()" ><<</button>
						<button onclick="play_pause();">Play/Pause</button>
						<button onclick="updateMap();">>></button></br>
						<button onclick="reset_animation();">Reset</button>
						<div id="time">Time (sec):</div>
						<div id="timeVal">0</div>
					</div>
				</div>
				
				<!-- Charts -->
				<div id="results_div_2" class="results_div">
					<div class="loadMsg">
						<span id="loadMsgText">Loading Chart...</span><br><br>
						<img src="<?php echo $siteURL?>icon/ajax-loader.gif"\>
					</div>
				</div>
				<div id="results_div_3" class="results_div">
					<div class="loadMsg">
						<span id="loadMsgText">Loading Chart...</span><br><br>
						<img src="<?php echo $siteURL?>icon/ajax-loader.gif"\>
					</div>
				</div>
				<div id="results_div_4" class="results_div">
					<div class="loadMsg">
						<span id="loadMsgText">Loading Chart...</span><br><br>
						<img src="<?php echo $siteURL?>icon/ajax-loader.gif"\>
					</div>
				</div>
				<div id="results_div_5" class="results_div">
					Below is a JSON string which represents the simulation results:
					<textarea id="rawData"></textarea>
				</div>
			</div>
			
			<?php
		}
		
		printFooter();
	?>
</body>
</html>
