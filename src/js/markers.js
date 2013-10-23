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
 * Filename: markers.js
 * Author: Sam Schlachter
 * Description: 
 *
 */

var sensorID = 0;
var markerArray = [];

//------ Marker 'Class' -------\\
var Marker = function(location,type,ID){
	var color = COLORS[type%(COLORS.length)][0];
	var image = siteURL + 'icon/mm_20_'+ color + '.png';
	
	if(ID==null){
		this.ID = ++sensorID;
    }
	else{
		this.ID = ID;
	}	
	
	this.type = type;

	this.gmarker = new google.maps.Marker({position: location, map: map, icon: image});
	this.gmarker.ID = this.ID;
	
	var infoWinStr = "<h4>Marker " + this.ID + " <button class='removeBtn' onclick=Marker.remove("+this.ID+")>Remove</button></h4>";
	
	this.infoWin = new google.maps.InfoWindow({
		content : infoWinStr
		});
	
	var ID = this.ID;
		
	google.maps.event.addListener(this.gmarker, 'click', function() {
		google.maps.event.clearListeners(map,'click');
	
		console.log(ID, this);
	
    	var marker = Marker.get(this.ID);
    	
    	marker.infoWin.open(map,marker.gmarker);
    });
}

Marker.place = function(location){
	markerArray.push(new Marker(location,currentSensorType));
}

Marker.get = function(ID){
	for(i in markerArray){
		if(markerArray[i].ID == ID){
			return markerArray[i];
		}
	}
}

Marker.remove = function(ID){
	for(x in markerArray){
		if(markerArray[x].ID == ID){
			markerArray[x].gmarker.setMap(null);
			markerArray.splice(x,1);
			select(0);
			return;
		}
	}
}

Marker.removeAll = function(){
	while(markerArray.length>0){
		removeMarker(markerArray[0].ID);
	}
}

Marker.addLoaded = function(loadedMarkerArray){

	var temp;
	for(i in loadedMarkerArray){
		temp = loadedMarkerArray[i];
		
		markerArray.push(new Marker(new google.maps.LatLng(temp.location.lat,temp.location.lng),temp.type,temp.ID));
	}
}

Marker.prototype.serialize = function(){
    var retVal = new Object(null);

	var location = this.gmarker.getPosition();

	retVal.ID = this.ID;
	retVal.type = this.type;
	retVal.location = new Object(null);
	retVal.location.lat = location.lat();
	retVal.location.lng = location.lng();
		
	return retVal;
}