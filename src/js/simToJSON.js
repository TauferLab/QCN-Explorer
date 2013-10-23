simToJSON = function(){

	var sim = new Object(null);
	sim.simulation = new Object(null);
	
	sim.simulation.parameters = getParametersJSON();
	sim.simulation.earthquakes = getEarthquakesJSON();
	sim.simulation.areas = getAreasJSON();
	sim.simulation.markers = getMarkersJSON();
	sim.simulation.SensorTypes = getSensorTypesJSON();
	
	return escapeJSON( JSON.stringify(sim) );
}

escapeJSON = function(string){

    //helper function
    replaceAll = function(find, replace, str) {
        return str.replace(new RegExp(find, 'g'), replace);
    }

	string = replaceAll("\n","\\\\n",string);//string.replace("/\n/g","\\\\n");

	return string;
}

getParametersJSON = function(){
    var retVal = new Object(null);

    // ID 
    retVal.ID = currentSimID;
    
    //Advanced Options
    retVal.sim_conn = $("#sim_conn").val();
    retVal.cuttime = $("#cuttime").val();
    retVal.start_time = $("#start_time").val();
    retVal.debug = $("#debug").val();
    retVal.sim_seed = $("#sim_seed").val();
    retVal.perfect = $("#perfect").val();
    
    //Sim Name and Description
    retVal.sim_name = $("#sim_name").val();
    retVal.sim_desc = $("#sim_desc").val();
    
    //Map Info
    
    retVal.map = new Object(null);
    retVal.map.zoom = map.getZoom();
    retVal.map.mapType = map.getMapTypeId();

    var location = map.getCenter();
    
    retVal.map.location = new Object(null);
    retVal.map.location.lat = location.lat();
    retVal.map.location.lng = location.lng();

    return retVal;

}
getEarthquakesJSON = function(){
    var retArr = [];

    for(i in quakeArray){  
        retArr.push( quakeArray[i].serialize() );
	}

    return retArr;
}

getAreasJSON = function(){
    var retArr = [];

    for(i in areaArray){  
        retArr.push( areaArray[i].serialize() );
	}

    return retArr;
}

getMarkersJSON = function(){
    var retArr = [];

    for(i in markerArray){  
        retArr.push( markerArray[i].serialize() );
	}

    return retArr;
}

getSensorTypesJSON = function(){
    var retArr = [];

    for(i in sensorTypeArray){  
        retArr.push( sensorTypeArray[i].serialize() );
	}

    return retArr;
}
