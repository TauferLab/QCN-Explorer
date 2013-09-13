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
	// Filename: teachers.php
	// Author: Sam Schlachter
	// Description: This file 
	
	require_once("inc/template.inc");
	require_once("inc/config.inc");
	
	?>

<html>
<head>

<title> QCN Explorer - Teacher Resources </title>

<link rel="stylesheet" type="text/css" href="<?php echo $siteURL?>inc/common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $siteURL?>inc/teachers.css" />

</head>

<body onload="initialize()">
	<?php printHeader(); ?>
	
		<div id="teacherInfo">
		
			<h2>Teacher Resources</h2>
		
			This simulator was built as part of the QCN project.
			<br><br>
			The QCN project has a number of seismology related activities designed for classroom use:<br>
			<a href="http://qcn.stanford.edu/learning-center/lessons-and-activities">http://qcn.stanford.edu/learning-center/lessons-and-activities</a>
			<br><br>
			Additionally, you can check out their learning center:<br>
			<a href="http://qcn.stanford.edu/learning-center"> http://qcn.stanford.edu/learning-center/</a>
	
		</div>
	
	<?php printFooter(); ?>
</body>
</html>