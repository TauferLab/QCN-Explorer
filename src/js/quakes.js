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
// Filename: quakes.js
// Author: Sam Schlachter
// Description: This 

var quakeID = 0;
var quakeArray = [];

//DEFAULT EARTHQUAKE PARAMETERS
var QMAGNITUDE = 6.5;
var QSWAVESPEED = 10; //m/s
var QTIME = 10;
var QDEPTH = 15; //km

//------ Quake 'Class' -------//
Quake = function (location, loadedQuake){
	if(loadedQuake==null){
		this.ID = ++quakeID;
		this.magnitude = QMAGNITUDE;
		this.swaveSpeed = QSWAVESPEED;
		this.time = QTIME;
		this.depth = QDEPTH;
	}
	else{
		this.ID = loadedQuake.ID;
		this.magnitude = loadedQuake.magnitude;
		this.swaveSpeed = loadedQuake.swaveSpeed;
		this.time = loadedQuake.time;
		this.depth = loadedQuake.depth;
		
		if(this.ID>=quakeID){
			quakeID = this.ID;
		}
	}
	
	this.gmarker = new google.maps.Marker({position: location, map: map, icon: siteURL + "icon/q_icon.png",draggable: true});
	this.gmarker.ID = this.ID;
	
	this.infoWindowHTML = this.getInfoWindowHTML();
	this.infoWin = new google.maps.InfoWindow({ content: this.infoWindowHTML });
	this.infoWin.ID = this.ID;
	
	google.maps.event.addListener(this.infoWin,'closeclick', function(){
		if(! saveQuake(this.ID) ){
    		return;
		}
    	if(tutorial && tutStep == 4){
			loadTut(5);
		}		
	});
	
	google.maps.event.addListener(this.gmarker, 'click', function() {
	
    	var quake = Quake.get(this.ID);
    	
    	if(tutorial && tutStep == 3){
			loadTut(4);
		}
    	
    	quake.infoWin.open(map,quake.gmarker);
    	
    });
    
    google.maps.event.addListener(this.infoWin, 'domready', function() {
        $("[src='http://maps.gstatic.com/mapfiles/api-3/images/mapcnt3.png']").css({opacity:0});
    });
}

Quake.place = function (location){
	quakeArray.push(new Quake(location));
}

Quake.get = function (ID){
	for(i in quakeArray){
		if(quakeArray[i].ID==ID)
			return quakeArray[i];
	}
}

Quake.remove = function (ID){
	for(i in quakeArray){
		if(quakeArray[i].ID == ID){
			quakeArray[i].infoWin.close();
			quakeArray[i].gmarker.setMap(null);
			quakeArray.splice(i,1);
			select(0);
			return;
		}
	}
}

Quake.prototype.getInfoWindowHTML = function (){
    addRowTwoCol = function (col1,col2){
    	var ret	 = "<tr>";
    	ret 	+= "<td>" + col1 + "</td>";
    	ret		+= "<td>" + col2 + "</td>";
    	ret		+= "</tr>";
    	
    	return ret;
	}

    var infoWinStr  = "<div id= 'q_" + this.ID + "_prop'>"
    infoWinStr	    += "<h4>Earthquake " + this.ID + " <button class='removeBtn' onclick=Quake.remove("+this.ID+")>Remove</button></h4>";
	infoWinStr		+= "<table>";
	infoWinStr		+= addRowTwoCol("Magnitude"		, "<input class='quakeInput' id='magintude_" + this.ID + "' type='text' value='" + this.magnitude + "'></input>");
	infoWinStr		+= addRowTwoCol("Event Time"	, "<input class='quakeInput' id='time_" + this.ID + "' type='text' value='" + this.time + "'></input> Seconds");
	infoWinStr		+= addRowTwoCol("S-Wave Speed"	, "<input class='quakeInput' id='speed_" + this.ID + "' type='text' value='" + this.depth + "'></input> M/S");
	infoWinStr		+= addRowTwoCol("Depth"			, "<input class='quakeInput' id='depth_" + this.ID + "' type='text' value='" + this.depth + "'></input> KM");
	infoWinStr		+= "</table>";
	infoWinStr		+= "<div style=\"text-align:center; width: 100%;\" >";
	infoWinStr		+= "<button onclick='Quake.save("+this.ID+");'>Save</button>"
	infoWinStr		+= "</div>";
	infoWinStr		+= "</div>";
	return infoWinStr;
}

Quake.save = function (ID){
    isNum = function (n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

	var quake = Quake.get(ID);

	var mag   = $("#magintude_"+ID).val();
	var time  = $("#time_"+ID).val();
	var speed = $("#speed_"+ID).val();
	var depth = $("#depth_"+ID).val();

	if( (isNum(mag)) && (parseFloat(mag) > 0) && (parseFloat(mag) < 10.1) ){
		quake.magnitude = parseFloat(mag);
	}else{
		//Throw Error!
		makeQuakeError("#magintude_"+ID,"Please input a value between 0 and 10.");
		return false;
	}
	
	if( (isNum(time)) && (parseFloat(time) >= 0) ){
		quake.time = parseFloat(time);	
	}else{
		//Throw Error!
		makeQuakeError("#time_"+ID,"Please input a valid number greater than 0.");
		return;
	}
	
	if( (isNum(speed)) && (parseFloat(speed) > 0) ){
		quake.swaveSpeed = parseFloat(speed);	
	}else{
		//Throw Error!
		makeQuakeError("#speed_"+ID,"Please input a valid number greater than 0.");
		return;
	}
	
	if( (isNum(depth)) && (parseFloat(depth) > 0) ){
		quake.depth = parseFloat(depth);	
	}else{
		//Throw Error!
		makeQuakeError("#depth_"+ID,"Please input a valid number greater than 0.");
		return;
	}
	
	quake.infoWin.setContent( quake.getInfoWindowHTML() );
	quake.infoWin.close();
}

Quake.makeError = function (selector,message){
	$(selector).qtip({ // Grab some elements to apply the tooltip to
	    content: {
            text: message
	    },
	    style: {
	        classes: 'qtip-red qtip-rounded'
        },
        position: {
        	my: 'middle left',  // Position my top left...
        	at: 'middle right', // at the bottom right of...
        	target: $( selector ) // my target
        },
        show: {
        	ready: true
        },
        hide: {
        	target: $( selector ),
        	event: 'click'
        }
    });
}

Quake.prototype.toJSON = function (){
	var loc = this.gmarker.getPosition();
	return "{" +
		"\"ID\":\""			+ this.ID + "\"," +
		"\"magnitude\":\""	+ this.magnitude + "\","+
		"\"time\":\""		+ this.time + "\"," +
		"\"swaveSpeed\":\""	+ this.swaveSpeed + "\"," +
		"\"depth\":\""		+ this.depth + "\"," +
		"\"location\":{" +
			"\"lat\":\"" + loc.lat() + "\"," +
			"\"lng\":\"" + loc.lng() + "\"" +
		"}" +
	"}";
}

Quake.removeAll = function (){
	while(quakeArray.length>0){
		removeQuake(quakeArray[0].ID);
	}
}

Quake.addLoaded = function (quakes){
	var loc;
	for(x in quakes){
		//console.debug(quakes[x]);
		loc = new google.maps.LatLng(quakes[x].location.lat,quakes[x].location.lng);
		quakeArray.push(new Quake(loc,quakes[x]));
	}
}
