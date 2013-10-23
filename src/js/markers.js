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
// Filename: markers.js
// Author: Sam Schlachter
// Description: This file

var sensorID = 0;
var markerArray = [];

//------ Marker 'Class' -------\\
function Marker(location,type,ID){
	var color = COLORS[type%(COLORS.length)][0];
	var image = siteURL + 'icon/mm_20_'+ color + '.png';
	
	if(ID==null)
		this.ID = ++sensorID;
	else
		this.ID = this.ID;
	
	this.type = type;
	this.toString = markerToString;

	this.gmarker = new google.maps.Marker({position: location, map: map, icon: image});
	this.gmarker.ID = this.ID;
	//this.document = makePlacedRow(this.ID,'marker');
	this.toJSON = markerToJSON;
	
	var infoWinStr = "<h4>Marker " + this.ID + " <button class='removeBtn' onclick=removeMarker("+this.ID+")>Remove</button></h4>";
	
	this.infoWin = new google.maps.InfoWindow({
		content : infoWinStr
		});
	
	google.maps.event.addListener(this.gmarker, 'click', function(ID) {
		google.maps.event.clearListeners(map,'click');
	
    	var marker = getMarker(this.ID);
    	
    	marker.infoWin.open(map,marker.gmarker);
    });
}

function markerToString() {return "{ID: " + this.ID + ";Type: " + this.type + ";Location:"+ this.gmarker.getPosition() +"}<br>";};

function placeMarker(location){
	markerArray.push(new Marker(location,currentSensorType));
}

function printMarkerArray(){
	console.log(markerArray);
}

function getMarker(ID){
	for(i in markerArray){
		if(markerArray[i].ID == ID){
			return markerArray[i];
		}
	}
}

function removeMarker(ID){
	for(x in markerArray){
		if(markerArray[x].ID == ID){
			//markerTable.removeChild(markerArray[x].document);
			markerArray[x].gmarker.setMap(null);
			markerArray.splice(x,1);
			select(0);
			return;
		}
	}
}

function removeAllMarkers(){
	while(markerArray.length>0){
		removeMarker(markerArray[0].ID);
	}
}

function addLoadedMarkers(loadedMarkerArray){
	var temp;
	for(i in loadedMarkerArray){
		temp = loadedMarkerArray[i];
		currentSensorType = temp.type;
		$('#output').html(temp.type);
		markerArray.push(new Marker(new google.maps.LatLng(temp.location.lat,temp.location.lng),temp.type,temp.ID));
	}
}

function markerToJSON(){
	var location = this.gmarker.getPosition();
	var lat = location.lat();
	var lng = location.lng();
	return "{\"ID\":\""+this.ID+"\", \"type\":\""+this.type + "\",\"location\":{\"lat\":\""+lat+"\",\"lng\":\""+lng+"\"}}";
}