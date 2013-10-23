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
// Filename: chart.js
// Author: Sam Schlachter
// Description: This file



function drawChart(){
	/*
    var i;

	for(i=0;i<5;i++){
		results.push(document.getElementById('results_div_'+i));
	}

    for(i=2;i<5;i++){
		//document.write("get_data.php?graph="+i+"&file="+xml_file);

		var jsonData = $.ajax({
			url: "get_chart_data.php?graph="+(i-1)+"&id="+sim_id,
			//url: "get_data.php?graph="+i+"&file=09_24_11_20_57_0.xml",
			dataType:"json",
			async: false
			}).responseText;
			  
		// Create our data table out of JSON data loaded from server.
		var data = new google.visualization.DataTable(jsonData);

		// Instantiate and draw our chart, passing in some options.
		switch(i){
		case 2:
			var chart = new google.visualization.ColumnChart(document.getElementById('results_div_'+i));
			chart.draw(data, {width: 640, height: 360,
				chartArea:{left:50,top:50,width:"85%",height:"75%"},
				hAxis: {title: 'Time (s)'},
				vAxis: {title: 'Number of Triggers'},
				legend: 'none'
				});
			break;
		case 3:
			var chart = new google.visualization.ScatterChart(document.getElementById('results_div_'+i));
			chart.draw(data, {width: 640, height: 360,
				hAxis: {title: 'Hypocentral Distance (km)', minValue: 0, maxValue: 15},
				vAxis: {title: 'Time (s)', minValue: 0, maxValue: 15},
				chartArea:{left:50,top:50,width:"85%",height:"75%"},
				legend: 'none',
				pointSize: 3
			});
			break;
		case 4:
		    var chart = new google.visualization.ScatterChart(document.getElementById('results_div_'+i));
		    chart.draw(data, {width: 640, height: 360,
                hAxis: {title: 'Hypocentral Distance (km)', minValue: 0, maxValue: 15},
                vAxis: {title: 'Wave Amplitude (m/s/s)', minValue: 0, maxValue: 15},
                chartArea:{left:50,top:50,width:"85%",height:"75%"},
                legend: 'none',
                pointSize: 3
            });
		    break;
		}
    }
    */
    //Init the animation - function is in the animation.js file
    getAnimationData();
}
