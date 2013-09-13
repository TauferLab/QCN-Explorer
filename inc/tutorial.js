var tutStep = 0;

function loadTut(n){

	$("#msgBox").css({"opacity":0});
	
	switch(n)
		{
		case 0:
			var target = "msgBox";
			var text = "Welcome to QCN explorer! Click the button below to learn how to use the simulation editor." +
						"<br><button onclick=\"loadTut(1)\">Start Tutorial!</button>";
		break;
		
		case 1:
			var target = "quakeTool";
			var text = "First, click here to select the Earthquake tool. You can use the earthquake tool to place earthquakes on the map.";
			var endCallback = function(event, api) {
				    loadTut(2);
				    $("#qtip-qtip1").remove();
			    }
			var delay = 0;
			var solo = true;
		break;
		
		case 2:
			var target = "msgBox";
			var text = "Now click on the map to place an earthquake.";
		break;
		
		case 3:
			var target = "msgBox";
			var text = "Good! You've placed your first earthquake! You can edit the earthquake's properties by clicking on it. Click on the earthquake now.";
		break;
		
		case 4:
			var target = "msgBox";
			var text = "Earthquakes have four different properties: Magnitude, Event Time, S-Wave speed and Depth. Click the close button in the upper right corner of the Quake properties.";
		break;
		
		case 5:
			var target = "msgBox";
			var text = "Now we need to add some sensors to sense the earthquake. You can do that two different ways - by placing individual sensors or by placing an area with a given sensor density.";
			loadTut(6);
			
		break;
		
		case 6:
			var target = "m1";
			var text = "Click the sensor button here to select the individual sensor placement tool.";
			var delay = 1000;
			var endCallback = function(event, api) {
				    loadTut(7);
				    $("#qtip-qtip6").remove();
			    }
			var solo = true;
		break;
		
		case 7:
			var target = "msgBox";
			var text = "Click on the map to place a sensor.";
		break;
		
		case 8:
			var target = "msgBox";
			var text = "Good! Your simulation has everything it needs to run. But with only one sensor it is difficult to learn anything interesting about the earthquake. Next we will place an area full of sensors.";
			loadTut(9);
		break;
		
		case 9:
			var target = "a1";
			var text = "Select the area tool and use it to place an area on the map."
			var endCallback = function(event, api) {
				    loadTut(10);
				    $("#qtip-qtip9").remove();
			    }
			var delay = 1000;
			var solo = true;
		break;
		
		case 10:
			var target = "msgBox";
			var text = "Each time you click on the map it will add a new vertex. Once you've added at least 3 points the click on the \"Move Map\" tool.";
		break;		
		
		case 11:
			var target = "msgBox";
			var text = "Awesome! You now have an area with a number of sensors in it. Once an area has been placed you can edit it by dragging it's verticies. Click on the area to see how many sensors are inside.";
		break;
		
		case 12:
			var target = "msgBox";
			var text =  "By default the sensor density is 1 sensor per 10,000 square km. Increase the sensor density so that there are 100 sensors inside of the area. You will have to click the update button every time you modify the sensor density. When you're finished close the Area properties window."
		break;
		
		case 13:
			var target = "msgBox";
			var text = "Almost finished! All we have left to do is give our simulation name and a description.";
			loadTut(14);
		break;
		
		case 14:
			var target = "sim_name";
			var text = "Type a name for your simulation."
			var endCallback = function(event, api) {
				loadTut(15);
				$("#qtip-qtip14").remove();
			};
			var delay = 10;
			var solo = false;
		break;
		
		case 15:
			var target = "sim_desc";
			var text = "And a description."
			var endCallback = function(event, api) {
				$("#qtip-qtip15").remove();
			};
			var delay = 10;
			var solo = false;
			
			loadTut(16);
			
			$("#sim_desc").change(function(){
				$("#qtip-qtip15").remove();
			});
		break;	
		
		case 16:
			var target = "msgBox";
			var text = "Once you give your simulation a name and a description it will be ready to run. Before you run the simulation there are a couple of other things you should know about." +
						"<br><button onclick=\"loadTut(17)\">Tell me!</button>";
			
		break;
		
		case 17:
			var target = "resultsBtn";
			var text = "After the simulation is run you will be able to come back and view your previous simulations on the Results page "+
						"<br><button onclick=\"loadTut(18)\">Next</button>";
			var endCallback = function(event, api) {
				
			};
			var delay = 0;
			var solo = false;
		break;
		
		case 18:
			var target = "advancedBtn";
			var text = "This button will open up the advanced options menu for advanced users."+
						"<br><button onclick=\"loadTut(19)\">Next</button>";;
			var endCallback = function(event, api) {};
			var delay = 0;
			var solo = false;
			$("#qtip-qtip17").remove();
		break;

		case 19:
			var target = "newSensorType";
			var text = "This button adds additional sensor types."+
						"<br><button onclick=\"loadTut(20)\">Next</button>";;
			var endCallback = function(event, api) {};
			var delay = 0;
			var solo = false;
			$("#qtip-qtip18").remove();
		break;
		
		case 20:
			var target = "o1";
			var text = "And this button opens the options for different sensor types. Once again, this feature is for advanced users."+
						"<br><button onclick=\"loadTut(21)\">Next</button>";;
			var endCallback = function(event, api) {};
			var delay = 0;
			var solo = false;
			$("#qtip-qtip19").remove();
		break;
		
		case 21:
			var target = "runBtn";
			var text = "If you're ready to run your simulation click this button. When you click the button your simulation will run and you'll be redirected to the results page.";
			var endCallback = function(event, api) {
					$("#qtip-qtip21").remove();
			    };
			var delay = 0;
			var solo = false;
			$("#qtip-qtip20").remove();
		break;
	}
	
	if( target == "msgBox" ){
		showMsgBox(text);
	}else{
		$("#"+target).qtip({
			id: "qtip"+n,
		    content: {
		        text: text
		    },
		    style: {
	        	classes: 'qtip-blue qtip-rounded'
	        },
		    show: {
		        ready: true,
		        delay: delay,
               	solo: solo
		    },
		    hide: {
		        fixed: true,
		        event: 'click'
		    },
		    events: {
			    hide: endCallback
        	}
		});
		
		$("#qtip-qtip"+n).change(function(data){
			console.log(data);			
		});
	}
	
	tutStep = n;
}

function showMsgBox(msg){
	$("#msgBox").html(msg);
	$("#msgBox").animate({"opacity":1},300);
}