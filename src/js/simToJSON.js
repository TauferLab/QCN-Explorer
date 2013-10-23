simToJSON = function(){
	var rawJSON = "{"+
	"	\"simulation\":{"+
			getParametersJSON()+","+
			getEarthquakesJSON()+","+
			getAreasJSON()+","+
			getSensorsJSON()+","+
			getSensorTypesJSON()+
	"	}"+
	"}";
	
	return escapeJSON(rawJSON);
}

escapeJSON = function(string){

    replaceAll = function(find, replace, str) {
        return str.replace(new RegExp(find, 'g'), replace);
    }

	string = replaceAll("\n","\\\\n",string);//string.replace("/\n/g","\\\\n");

	return string;
}



getParametersJSON = function(){
	var ret = "\"parameters\":{\"ID\":\""+currentSimID+"\"";
	
	var advancedOptions = ['sim_conn','cuttime','start_time','debug','sim_seed','perfect'];
	
	for( i in advancedOptions){
		ret = ret + ",\""+advancedOptions[i]+"\":\"" + $("#"+advancedOptions[i]).val() + "\"";
	}
	
	var location = map.getCenter();
	var zoom = map.getZoom();
	var map_type = map.getMapTypeId();
	
	ret = ret + ",\"sim_name\": \"" + $("#sim_name").val() + "\","
	ret = ret + "\"sim_desc\": \"" + $("#sim_desc").val() + "\","	
		
	ret = ret + 
		"\"map\": {"+
		"\"location\": { \"lat\":\""+ location.lat() +"\", \"lng\":\""+ location.lng() +"\"},"+
		"\"zoom\" : \""+ zoom +"\","+
		"\"mapType\" : \"" + map_type + "\""+
		"}";
	
	console.log(ret);
	
	return ret + "}";
	
}
getEarthquakesJSON = function(){
	var first = true;
	var ret =  "\"earthquakes\":[";
	
	for(i in quakeArray){
		if(first) first = false;
		else ret = ret + ",";
		ret = ret + quakeArray[i].toJSON();
	}
	
	return ret + "]";
}

getAreasJSON = function(){
	var first = true;
	var ret = "\"areas\":[";
	
	for (area in areaArray){
		if(first) first = false;
		else ret = ret + ",";
		ret = ret + areaArray[area].toJSON();
	}
	
	return ret +"]";
}

getSensorsJSON = function(){
	//markerArray
	var first = true;
	var ret = "\"markers\":[";
	
	for (i in markerArray){
		if(first) first = false;
		else ret = ret + ",";
		ret = ret + markerArray[i].toJSON();
	}

	return ret + "]";
}

getSensorTypesJSON = function(){
	var first = true;
	var ret = "\"SensorTypes\":[";
	
	for (i in sensorTypeArray){
		if(first) first = false;
		else ret = ret + ",";
		ret = ret + sensorTypeArray[i].toJSON();
	}

	return ret + "]";
}
