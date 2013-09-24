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
	 * Filename: contrib.php
	 * Author: Sam Schlachter
	 * Description: 
	 *
	 */		
	require_once("inc/template.inc");
	require_once("inc/config.inc");
	?>

<html>
<head>

<title> QCN Explorer - Contributors</title>

<link rel="stylesheet" type="text/css" href="<?php echo $siteURL?>inc/common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $siteURL?>inc/contrib.css" />

</head>

<body onload="initialize()">
	<?php printHeader(); ?>
	
	<div id="content">
		<h2>QCN Explorer Contributors and Sponsors</h2>
		
		<h3>Principal Developers:</h3>
		<li>Samuel Schlachter</li>
		<li>Kyle Benson</li>
		<li>Trilce Estrada</li>
		
		<h3>Other Project Members:</h3>
		<li>Ryan Huttman</li>
		<li>Marcos Portnoi</li>
		
		<h4>Contact and Project Lead: Michela Taufer (taufer@udel.edu)</h4>
		
		<h3>Collaborators:</h3>
		
		<p>Jesse F. Lawrence (Stanford University), Elizabeth S. Cochran (US Geological Survey), Richard Allen (University of California, Berkeley), Jack Baker (Stanford University), Tomas Heaton (California Institute of Technology), Deborah Kilb (Scripps Institution of Oceanography)</p>
		
		<h3>Sponsors:</h3>
		
		<p>
			NSF EAR#1027807 Collaborative Research: CDI-Type II: From Data to Knowledge: The Quake-Catcher Network Link:
			<a href="http://www.nsf.gov/awardsearch/showAward?AWD_ID=1027807">http://www.nsf.gov/awardsearch/showAward?AWD_ID=1027807</a>
		</p>
		
		<h3>References:</h3>
		
		<p>
			K. Benson, S. Schlachter, T. Estrada, M. Taufer, E. Cochran, and J. Lawrence. On the Powerful Use of Simulations in the Quake-Catcher Network to Efficiently Position Low-cost Earthquake Sensors. Future Generation Computer Systems, 2013. (In press) Link: 
			<a href="http://www.sciencedirect.com/science/article/pii/S0167739X13000721">http://www.sciencedirect.com/science/article/pii/S0167739X13000721</a>
		</p>
		
		<p>
			K. Benson, T. Estrada, M. Taufer, E. Cochran, and J. Lawrence. On the Powerful Use of Simulations in the Quake-Catcher Network to Efficiently Position Low-cost Earthquake Sensors. In the Proceedings of the Seventh IEEE International Conference on e-Science and Grid Technologies (eScience), December 2011, Stockholm, Sweden. Link:
			<a href="http://ieeexplore.ieee.org/xpls/abs_all.jsp?arnumber=6123262">http://ieeexplore.ieee.org/xpls/abs_all.jsp?arnumber=6123262</a>
		</p>

		<h3> Libraries and Licensing:</h3>
		<p>This project makes use of the following libraries:</p>
		<li>Google Maps JavaScript API - <a href="https://developers.google.com/maps/documentation/javascript/">https://developers.google.com/maps/documentation/javascript/</a></li>
		<li>Google Charts - <a href="https://developers.google.com/chart/">https://developers.google.com/chart/</a></li>
		<li>jQuery - <a href="http://jquery.com/">http://jquery.com/</a></li>
		<li>qTip2 - <a href="http://qtip2.com/">http://qtip2.com/</a></li>
		<p>
			This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/">Creative Commons Attribution-NonCommercial 3.0 License</a>
			<br>
			<a rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/">
				<img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc/3.0/88x31.png" />
			</a>
		</p>

	</div>
	
	<?php printFooter(); ?>
</body>
</html>