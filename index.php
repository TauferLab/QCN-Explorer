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
	// Description: This file 
	
	require_once("inc/template.inc");
	require_once("inc/config.inc");
	
	function getFeaturedQuakes(){
		global $mysql_host;
		global $mysql_user;
		global $mysql_pass;
		global $mysql_db;
	
		$conn = mysql_connect($mysql_host,$mysql_user,$mysql_pass) or die('MySQL Error: ' . mysql_error());		
		mysql_select_db($mysql_db);
		
		$query = "SELECT * FROM `simulations` WHERE featured=1";
		$result = mysql_query($query);
		
		while($sim=mysql_fetch_array($result)) {
			echo '<div class="featuredQuake">';
			echo '<u>'.$sim["name"]."</u><br>";
			echo $sim["description"];//."<br>";
			echo "<button OnClick='location.href=\"./results.php?ID=".$sim["ID"]."\"'>View ></button>";
			echo '</div>';
		}
	}
	
	?>

<html>
<head>

<title> Welcome to the Earthquake Simulator </title>

<link rel="stylesheet" type="text/css" href="<?php echo $siteURL?>inc/common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $siteURL?>inc/index.css" />

</head>

<body>
	<?php printHeader(); ?>
		
		<h1 id="welcomeMessage">Welcome to QCN Explorer!</h1>
		
		<div class="left" id="leftCol">
			<img id="homepageImage" src="<?php echo $siteURL?>/icon/homepage.png"\>
			
			<h3>What is it?</h3>
			<p>Welcome to QCN Explorer! QCN Explorer is a simulator of the <a href="http://qcn.stanford.edu/">Quake Catcher Network</a>, a volunteer computing project out of Stanford University. The goal of this project is to educate people about seismology and increase the awareness of QCN. QCN Explorer allows users to simulate how the QCN responds to an earthquake with a larger number of sensors than the network currently supports. The simulator is free for anyone to use. Click below to get started!</p>
			
			<button id="startButton"onClick="location.href='<?php echo $siteURL?>/editor'">Build a Simulation!</button>
		</div>
		
		<div id="rightCol" class="right">
			<h3 id="featuredHeader">Featured Earthquakes</h3>
			<?php getFeaturedQuakes(); ?>	
		</div>
	
	<?php printFooter(); ?>
</body>
</html>