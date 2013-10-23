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
 * Filename: areas.js
 * Author: Sam Schlachter
 * Description: 
 *
 */ 

var areaID = 0;
var currentArea = -1;
var areaArray = [];

//------ Area 'Class' -------//
var Area = function(areaObj){

	// If we're not loading a saved area create a new area
	if(areaObj==null){
		this.ID = ++areaID;
		currentArea = this.ID;
		this.type = currentSensorType;
		google.maps.event.addListener(map, 'click', Area.addPoint);
		
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
    	if(tutorial && tutStep == 12){
			loadTut(13);
		}		
	});
	
	this.poly.ID = this.ID;
	
	google.maps.event.addListener(this.poly, 'mouseup', function(event){
		Area.get(this.ID).surfaceAreaUpdate();
	}); 
		
	google.maps.event.addListener(this.poly, 'click', function(event) {
		if(currentSensorType==0){
			this.infoWindow.setContent( Area.get(this.ID).getInfoWindowHTML() );
			this.infoWindow.setPosition( event.latLng );
			this.infoWindow.open( map );
			
			if(tutorial && tutStep == 11){
				loadTut(12);
			}
		}
		else{
			if($(".quake").hasClass('sel')){
				Quake.place(event.latLng);
			}
			else if( $("#m"+currentSensorType).hasClass('sel') ){
				Marker.place(event.latLng);
			}
			else if( $("#a"+currentSensorType).hasClass('sel') ){
				Area.addPoint(event);
			}
		}
    });
    
    $("#density_" + this.ID).val(this.density);
}

Area.get = function(areaID){
	for(x in areaArray){
		if(areaArray[x].ID == areaID)
			return areaArray[x];
	}
}

Area.addPoint = function (event) {	
	var area = Area.get(currentArea);
	area.path.insertAt(area.path.length, event.latLng);
	area.surfaceAreaUpdate();
}


Area.prototype.surfaceAreaUpdate = function(){
	//Update the area contained by the polygon
	this.sArea = Math.round( google.maps.geometry.spherical.computeArea(this.path)/1000000 );
	this.numSensors = this.getNumSensors();
}

Area.prototype.densityUpdate = function(){
	this.density = $("#density_"+this.ID).val();
	this.numSensors = this.getNumSensors();
	
	this.poly.infoWindow.setContent( Area.get(this.ID).getInfoWindowHTML() );
}

Area.prototype.getNumSensors = function(){
	return Math.round( this.sArea * this.density / 10000);
}

Area.place = function(){
	areaArray.push(new Area());
}

Area.prototype.getInfoWindowHTML = function(){

	var ret = "<h4>Area " + this.ID + " <button class='removeBtn' onclick=Area.remove("+this.ID+")>Remove</button></h4>";
	ret +="<table>";
	ret +="<tr><td>Surface Area:</td><td>" + beautifyNum(this.sArea) + " Km<sup>2</sup></td></tr>";
	ret +="<tr><td>Sensor Density:</td><td><input id='density_" + this.ID + "' type='text' value='" + this.density + "'></input> Sensors/10,000 Km<sup>2</sup></td></tr>";
	ret +="<tr><td>Sensors in area:</td><td>" + beautifyNum(this.numSensors) + "</td></tr>";
	ret += "</table>";
	ret += "<button onclick='Area.get("+this.ID+").densityUpdate()'>Update</button>";
	
	return ret;
}

Area.remove = function(inID){
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

Area.removeAll = function(){
	while(areaArray.length>0){
		Area.remove(areaArray[0].ID);
	}
}

Area.addLoaded = function(areas){
	for(x in areas){
		areaArray.push(new Area(areas[x]));
	}
}

Area.prototype.serialize = function(){
    var retVal = new Object(null);
    retVal.ID = this.ID;
    retVal.type = this.type;
    retVal.density = this.density;
    retVal.sArea = this.sArea;
    retVal.numSensor = this.numSensors;
    retVal.points = [];
    
    var indexLocs = this.path.getArray();
	for(i in indexLocs){
	    var temp = new Object(null);
		var position = indexLocs[i];
		
		temp.lat = position.lat();
		temp.lng = position.lng();
		
		retVal.points.push( temp );
	}
    
    return retVal;
}
