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
 * Filename: load.php
 * Author: Sam Schlachter
 * Description: 
 *
 */

	require_once("src/php/config.inc");
	require_once("src/php/save_load.inc.php");
	
	if(isset($_GET["ID"])){
		echo file_get_contents($JSON_FILES_FOLDER.$_GET["ID"].".json");
	}
	if(isset($_GET["USER_ID"])){
		echo json_encode( getUsersSims($_GET["USER_ID"]) );	
	}	
?>