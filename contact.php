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
 * Filename: contact.php
 * Author: Sam Schlachter
 * Description: This file 
 *
 */
	 
	require_once("src/php/template.inc");
	require_once("src/php/config.inc");
	
	?>

<html>
<head>

<title> QCN Explorer - Contact Us </title>

<link rel="stylesheet" type="text/css" href="<?php echo $siteURL?>src/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $siteURL?>src/css/contact.css" />

<!-- Jquery -->
<script language="JavaScript" src="<?php echo $siteURL?>src/js/jquery-latest.js"></script>

<!-- Other -->
<script language="JavaScript" src="<?php echo $siteURL?>src/js/contact.js"></script>

</head>

<body>
	<?php printHeader(); ?>
	
		<div id="contactInfo">
		    <div id="contactHeader">
		        <h2>Contact Us</h2>
		    </div>
		    
		    <div id="contactBody">
    		    <p id="contactMessage">We're looking to hear from you! Let us know if you have any feedback, bug reports or if you're a teacher using this page as part of a class.</p>
    			
    			<div id="inputSec">
        			<div id="contactLeftCol">
        			    <div class="leftSec section">
        			        <h3 class="sectionHeader">Name</h3>
        			        <input id="name" type="text">
        			    </div>
                		<div class="leftSec section">
                    		<h3 class="sectionHeader">Email</h3>	
                    		<input id="email" type="text">
                		</div>
            			
        			</div>
        			
        			<div id="contactRightCol">
        			    <div id="messageSec" class="section">
                		    <h3 class="sectionHeader">Message</h3>
                		    <textarea id="message"></textarea>	
        			    </div>
        			</div>
    			</div>
    			<div id="submitSec">
    			    <button id="submitBtn" onClick="submitForm();" >Send!</button>
    			    <div id="errorMsg"></div>
    			</div>
		    </div>
			
		</div>
	
	<?php printFooter(); ?>
</body>
</html>