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
	// Filename: index.php
	// Author: Sam Schlachter
	// Description: This is scenario builder page. Here users are presented with a map
	// and some tools they can use to build an earthquake simulation. This page queries
	// a number of external pages for various functions: save.php, load.php, run.php

	require_once("inc/config.inc");
	require_once("inc/template.inc");
	
	if($DEBUG){
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
	}
	
	if(isset($_GET["ID"])){
		$loadSimID = (integer) $_GET["ID"];
	}
	else{
		$loadSimID = 0;
	}
?>

<!DOCTYPE html>
<html>
<head>
<!--<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />-->
<title>QCN Explorer - Simulation Builder</title>

<!-- Page Style Sheet -->
<link rel="stylesheet" type="text/css" href="<?php echo $siteURL?>inc/common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $siteURL?>inc/editor.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $siteURL?>inc/tutorial.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $siteURL?>inc/jquery.qtip.min.css" />

<!-- Google Maps Javascript -->
<script type="text/javascript" src="http://www.google.com/jsapi"></script>

<!-- Jquery -->
<script language="JavaScript" src="<?php echo $siteURL?>inc/jquery-latest.js"></script>

<!-- qTip -->
<script language="JavaScript" src="<?php echo $siteURL?>inc/jquery.qtip.min.js"></script>

<!-- QCN Javascript -->
<script language="JavaScript" src="<?php echo $siteURL?>inc/editor.php.inc"></script>
<script language="JavaScript" src="<?php echo $siteURL?>inc/areas.js"></script>
<script language="JavaScript" src="<?php echo $siteURL?>inc/markers.php.inc"></script>
<script language="JavaScript" src="<?php echo $siteURL?>inc/quakes.php.inc"></script>
<script language="JavaScript" src="<?php echo $siteURL?>inc/sensorType.php.inc"></script>
<script language="JavaScript" src="<?php echo $siteURL?>inc/tutorial.js"></script>
<script language="JavaScript">
	//TODO : Don't do this assigning JavaScript variables from PHP is bad news
	<?php
		echo "var loadSimID = \"$loadSimID\";\n";
		
		if(isset($_GET["tutorial"])){
			echo "var tutorial = true;";
		}
		else{
			echo "var tutorial = false;";
		}
	?>
	
	
</script>

</head>

<body onload="initialize()">
	<?php printHeader(); ?>

	<!-- Main Content -->
		<div id="left_column" class="left">
			<div>Name:</div>
			<textarea id="sim_name" rows="1" cols="23" placeholder="Simulation Name"></textarea>
			
			<div>Description:</div>
			<textarea id="sim_desc" rows="4" cols="23" placeholder="Description"></textarea>
			
			<button id="advancedBtn">Advanced</button>
						
			<div class="typeRow">
				<div class='toolLabel'>Move Map</div>
				<div class='toolButton hand usel' onclick='select(0)'></div>
			</div>
			<div class="typeRow">
				<div class='toolLabel'>Earthquake</div>
				<div id="quakeTool" class='toolButton quake usel' onclick='select(null,"quake")' ></div>
			</div>
			
			<div id="sensorTypesHeader">
				Sensor Types
			</div>
			<button id="newSensorType" OnClick="addNewSensorType();">Add Sensor Type...</button>
			<div id="sensorTypes">
				<div id="sensorTypesContainer">
				</div>
			</div>

			<button id="runBtn" OnClick="saveSim();">Run!</button>
			
		</div>
		
		<div id="right_column">
			<div id="msgBox"></div>
			<div id="map_canvas" style="width:100%; height:100%;"></div>
			<div id="loadBG"></div>
			<div id="loadMsg">
				<span id="loadMsgText">Saving...</span><br><br>
				<img src="<?php echo $siteURL?>icon/ajax-loader.gif"\>
			</div>
		</div>
	</div>

	<!-- Popup Menus -->
	<div id="popups">
		
		<div id="advancedMenu" class="hidden">
			<table>
				<tr>
					<td colspan="2">Here you can set the advanced options for the simulation</td>
				</tr>
				<tr>
					<td>Connection of workers (probabilistic distribution):</td>
					<td><select id="sim_conn"><option value="conn">Normal</option><option value="weibull">Weibull</option></select></td>
				</tr>
				<tr>
					<td>Simulation Cutoff time (seconds):</td>
					<td><input id="cuttime" value="30" size="8" type="text"></td>
				</tr>
				<tr>
					<td>Simulation start time (seconds, Unix Epoch):</td>
					<td><input id="start_time" value="<?php echo time(); ?>" size="8" type="text"></td>
				</tr>
				<tr>
					<td>Debug mode:</td>
					<td><input id="debug" type="checkbox" onclick="toggleVal('#debug');" value="false"></td>
				</tr>
				<tr>
					<td>Random seed:</td>
					<td><input id="sim_seed" type="text" size="8"></td>
				</tr>
				<tr>
					<td>Perfect hosts:</td>
					<td><input id="perfect" type="checkbox" onclick="toggleVal('#perfect');" value="false"></td>
				</tr>
			</table>
		</div>
		
		<div id="sensorTypeEditorFrames" class="hidden">
		</div>
		
	<?php printFooter(); ?>

</body>
</html>
