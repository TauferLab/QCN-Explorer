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
 * Filename: teachers.php
 * Author: Sam Schlachter
 * Description: This file 
 *
 */
	 
	require_once("src/php/template.inc");
	require_once("src/php/config.inc");
	
	?>

<html>
<head>

<title> QCN Explorer - Teacher Resources </title>

<link rel="stylesheet" type="text/css" href="<?php echo $siteURL?>src/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $siteURL?>src/css/teachers.css" />

</head>

<body>
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