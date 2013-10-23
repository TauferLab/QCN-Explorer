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
 * Filename: config.inc
 * Author: Sam Schlachter
 * Description: 
 *
 */


	//siteURL must have trailing slash
	$siteURL = "http://qcnexplorer.org/";
	$DEBUG = false;//true;
	
	$currentSWrev = 0.5;
	
	$contactEmails = ["saschlac@udel.edu", "taufer@udel.edu"];
	
	// Timezone
	date_default_timezone_set('America/New_York');
	
	// Folders
		// Simulator Input Folders
		$HOST_TRACES_FOLDER = __DIR__."/../../files/input/host/";
		$USER_TRACES_FOLDER = __DIR__."/../../files/input/user/";
		$WU_TRACES_FOLDER = __DIR__."/../../files/input/wu/";
		$QUAKE_TRACES_FOLDER = __DIR__."/../../files/input/quakes/";
		$QCN_TRACES_FOLDER = __DIR__."/../../files/input/qcn_host/";
		
		// Simulator Output Folders
		$ANIMATION_FOLDER = __DIR__."/../../files/output/animations/";
		$LOG_OUTPUT_FOLDER = __DIR__."/../../files/output/logs/";
		$TRICKLES_OUT_FOLDER = __DIR__."/../../files/output/trickles/";
		
		// 'Meta' Folders 
		$JSON_FILES_FOLDER = __DIR__."/../../files/JSONfiles/";
		
		
	// Queue Logging
	$LOG_TIMEZONE = "UTC";
	$LOG_FILENAME = "queue.log";
	$LOG_DATE_STRING = "Y_m_d_H_i_s";
		
	// Database info
	$mysql_user = 'qcnExplorer';
	$mysql_pass = 'sh8P7ybFe3DaMwfQ';
	$mysql_host = 'localhost';
	$mysql_db = 'qcnExplorer';
	
	//Exe
	$SIM_EXE = "php ./emboinc.php";
	$HOSTLIMIT = 1000;
	
?>
