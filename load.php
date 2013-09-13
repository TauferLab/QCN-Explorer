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
	// Filename: load.php
	// Author: Sam Schlachter
	// Description: This file 

	require_once("inc/config.inc");
	require_once("inc/save_load.inc.php");
	
	if(isset($_GET["ID"])){
		echo file_get_contents($JSON_FILES_FOLDER.$_GET["ID"].".json");
	}
	if(isset($_GET["USER_ID"])){
		echo json_encode( getUsersSims($_GET["USER_ID"]) );	
	}	
?>