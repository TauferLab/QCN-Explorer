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
// Filename: areas.js
// Author: Sam Schlachter
// Description: This file 

var areaID = 0;
var currentArea = -1;
var areaArray = [];

//------ Area 'Class' -------//
function Area(areaObj){

	//class methods
	this.toJSON = areaToJSON;
	this.surfaceAreaUpdate = areaSurfaceAreaUpdate;
	this.densityUpdate = areaDensityUpdate;
	this.getInfoWindowHTML = areaInfoWindowHTML;
	this.getNumSensors = areaGetNumSensors;

	// If we're not loading a saved area create a new area
	if(areaObj==null){
		this.ID = ++areaID;
		currentArea = this.ID;
		this.type = currentSensorType;
		google.maps.event.addListener(map, 'click', areaAddPoint);
		
		var color = COLORS[currentSensorType%(COLORS.length)][1];
		
		this.path = new google.maps.MVCArray;
		this.poly = new google.maps.Polygon({editable: true,strokeWeight: 2,fillColor: color,strokeOpacity: 0.75});
		this.poly.setMap(map);
		this.poly.setPaths(new google.maps.MVCArray([this.path]));
		this.sArea = 0;			//surface area - computed
		this.density = 1.0;		
		this.numSensors = 0;	//computed
	}
	//Otherwise load it
	else{	
		currentArea = areaID = this.ID = areaObj.ID;
		var color = COLORS[areaObj.type%(COLORS.length)][1];
		this.type = areaObj.type;
		this.path = new google.maps.MVCArray;
		this.poly = new google.maps.Polygon({editable: true,strokeWeight: 2,fillColor: color,strokeOpacity: 0.75});
		this.poly.setMap(map);
		
		for(i in areaObj.points){
			this.path.insertAt(this.path.length,new google.maps.LatLng(areaObj.points[i].lat,areaObj.points[i].lng));
		}
		
		this.poly.setPaths(new google.maps.MVCArray([this.path]));
		
		this.sArea = areaObj.sArea;			//surface area - computed
		this.density = areaObj.density;		
		this.numSensors = this.getNumSensors();	//computed
	}	
	
	this.infoWindowHTML = this.getInfoWindowHTML();
		
	this.poly.infoWindow = new google.maps.InfoWindow({
		content: this.infoWindowHTML
	});
	
	
	google.maps.event.addListener(this.poly.infoWindow,'closeclick', function(event){
		console.log(tutStep);
    	if(tutorial && tutStep == 12){
			loadTut(13);
		}		
	});
	
	this.poly.ID = this.ID;
	
	google.maps.event.addListener(this.poly, 'mouseup', function(event){
		getArea(this.ID).surfaceAreaUpdate();
	}); 
		
	google.maps.event.addListener(this.poly, 'click', function(event) {
		if(currentSensorType==0){
			this.infoWindow.setContent( getArea(this.ID).getInfoWindowHTML() );
			this.infoWindow.setPosition( event.latLng );
			this.infoWindow.open( map );
			
			if(tutorial && tutStep == 11){
				loadTut(12);
			}
		}
		else{
			if($(".quake").hasClass('sel')){
				placeQuake(event.latLng);
			}
			else if( $("#m"+currentSensorType).hasClass('sel') ){
				placeMarker(event.latLng);
			}
			else if( $("#a"+currentSensorType).hasClass('sel') ){
				areaAddPoint(event);
			}
		}
    });
    
    $("#density_" + this.ID).val(this.density);
}

function areaToJSON(){
	var first = true;
	var ret = "{"+
		"\"ID\":\"" + this.ID + "\"," +
		"\"type\":\"" + this.type + "\","+
		"\"density\":\"" + this.density + "\"," +
		"\"sArea\":\""+ this.sArea + "\"," +
		"\"numSensor\":\"" + this.numSensors + "\",";
	
	ret = ret + "\"points\":[";
	
	var indexLocs = this.path.getArray();
	for(i in indexLocs){
		var position = indexLocs[i];
		
		if(first) first = false;
		else ret = ret + ",";
		
		ret = ret +	"{\"lat\":\"" + position.lat() + "\",\"lng\":\"" + position.lng() + "\"}";
	}
	
	return ret + "]}";
}

function getArea(areaID){
	for(x in areaArray){
		if(areaArray[x].ID == areaID)
			return areaArray[x];
	}
}

function areaAddPoint(event) {	
	var area = getArea(currentArea);
	area.path.insertAt(area.path.length, event.latLng);
	area.surfaceAreaUpdate();
}


function areaSurfaceAreaUpdate(){
	//Update the area contained by the polygon
	this.sArea = Math.round( google.maps.geometry.spherical.computeArea(this.path)/1000000 );
	this.numSensors = this.getNumSensors();
}

function areaDensityUpdate(){
	this.density = $("#density_"+this.ID).val();
	this.numSensors = this.getNumSensors();
	
	this.poly.infoWindow.setContent( getArea(this.ID).getInfoWindowHTML() );
}

function areaGetNumSensors(){
	return Math.round( this.sArea * this.density / 10000);
}

function placeArea(){
	areaArray.push(new Area());
}

function areaInfoWindowHTML(){
	console.log(this.density);

	var ret = "<h4>Area " + this.ID + " <button class='removeBtn' onclick=removeArea("+this.ID+")>Remove</button></h4>";
	ret +="<table>";
	ret +="<tr><td>Surface Area:</td><td>" + beautifyNum(this.sArea) + " Km<sup>2</sup></td></tr>";
	ret +="<tr><td>Sensor Density:</td><td><input id='density_" + this.ID + "' type='text' value='" + this.density + "'></input> Sensors/10,000 Km<sup>2</sup></td></tr>";
	ret +="<tr><td>Sensors in area:</td><td>" + beautifyNum(this.numSensors) + "</td></tr>";
	ret += "</table>";
	ret += "<button onclick='getArea("+this.ID+").densityUpdate()'>Update</button>";
	//ret += "<button onclick='removeArea("+this.ID+")'>Remove</button>";
	
	return ret;
}

function removeArea(inID){
	for(x in areaArray){
		if(areaArray[x].ID == inID){
			areaArray[x].poly.infoWindow.setMap(null);
			areaArray[x].poly.setMap(null);
			areaArray.splice(x,1);
			select(0);
			return;
		}
	}	
}

function removeAllAreas(){
	while(areaArray.length>0){
		removeArea(areaArray[0].ID);
	}
}

function addLoadedAreas(areas){
	for(x in areas){
		console.debug(areas[x]);
		areaArray.push(new Area(areas[x]));
	}
}