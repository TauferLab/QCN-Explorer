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
 * Filename: template.inc
 * Author: Sam Schlachter
 * Description: 
 *
 */


require_once("config.inc");

function printHeader(){
	global $siteURL;

	echo '
	<script>
		(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');
		
		ga(\'create\', \'UA-43858345-1\', \'qcnexplorer.org\');
		ga(\'send\', \'pageview\');
	
	</script>
	
	<div id="header">
	<h1 id="page_title">QCN Explorer</h1>
	</div>
	<div id="navbar">
		<a href="'.$siteURL.'">Home</a> ·
		<a id = "tutBtn" href="'.$siteURL.'tutorial">Tutorial</a> ·
		<a href="'.$siteURL.'editor">Simulation Builder</a> ·
		<a id = "resultsBtn" href="'.$siteURL.'results">Simulation Results</a> ·
		<a href="'.$siteURL.'contrib">Contributors</a> ·
		<a href="'.$siteURL.'teachers">Teacher Resources</a> ·
		<a href="'.$siteURL.'contact">Contact Us</a>			
	</div>
	<div id="container">
	';
}

function printFooter(){
    global $currentSWrev;
   	global $siteURL;

	echo '
	</div>
	<div id="footer">
		<span>©2013 <a href="http://www.udel.edu/">University of Delaware</a>, <a href="http://gcl.cis.udel.edu/">Global Computing Lab</a> - <a href="'.$siteURL.'version">Release v'.$currentSWrev.'</a></span>
		<div>
			<span id="cc_licence">This work is licensed under a
				<a rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/us/">
					Creative Commons Attribution-NonCommercial 3.0 United States License
				</a>
			</span>
			<a rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/us/">
				<img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc/3.0/us/80x15.png">
			</a>
		</div>
	</div>
	';
}

?>