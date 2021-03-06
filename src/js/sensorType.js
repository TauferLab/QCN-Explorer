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
 * Filename: sensorType.js
 * Author: Sam Schlachter
 * Description: 
 *
 */


var sensorTypeArray = [];

//Default values
var ON_FRAC = 1;
var CONN_FRAC = 1;
var ACT_FRAC = 1;
var OS_NAME = "Microsoft Windows XP";
var NUM_CPUS = 2;
var PROC_MAKE = "Genuine Intel";
var PROC_MODEL = "Pentium 4";
var FLOPS = 1411554690.0357;
var IOPS = 3164629924.34267;
var MEMBANDW = 500000000;
var C_TIME = 1;
var MEAN_CONN = 86400;
var STD_CONN = 3600;
var MAX_RPD = 24;
var SUCCESS_RATE = 98;
var ERROR_RATE = 2;
var FALSE_TRIG_RATE = 6.63;
var TRIG_LOWER_BOUND = 0.098;
var TRIG_UPPER_BOUND = 0.196;
var TRIG_PROB = 0.5;


//------ SensorType 'Class' -------\\
SensorType = function (ID, sensorTypeIn){
	this.ID = ID;
	this.document = SensorType.addRow(ID);
	
	//Properties
	if(sensorTypeIn==null){
		this.on_frac = ON_FRAC;
		this.conn_frac = CONN_FRAC;
		this.act_frac = ACT_FRAC;
		this.false_trig_rate = FALSE_TRIG_RATE;
		this.trig_lower_bound = TRIG_LOWER_BOUND;
		this.trig_upper_bound = TRIG_UPPER_BOUND;
		this.trig_prob = TRIG_PROB;	
	}
	else{
		this.on_frac=sensorTypeIn.on_frac;
		this.conn_frac=sensorTypeIn.conn_frac;
		this.act_frac=sensorTypeIn.act_frac;
		this.false_trig_rate=sensorTypeIn.false_trig_rate;
		this.trig_lower_bound=sensorTypeIn.trig_lower_bound;
		this.trig_upper_bound=sensorTypeIn.trig_upper_bound;
		this.trig_prob=sensorTypeIn.trig_prob;
	}
	
	this.addSettingFrame();
	this.modifyHTML();
	
	$("#o" + this.ID).qtip({ // Grab some elements to apply the tooltip to
	    content: {
            text: $("#sensorTypeEditor_" + ID), // Use the "div" element next to this for the content
            title: {
	            text: 'Sensor Type ' + ID + ' options.',
	            button: 'Close'
	        }
	        
	    },
	    style: {
	        classes: 'qtip-light qtip-rounded'
        },
        position: {
        	my: 'middle left',  // Position my top left...
        	at: 'middle right', // at the bottom right of...
        	target: $("#o" + this.ID) // my target
        },
        show: {
        	event: 'click',
        	solo: true
        },
        hide: {
        	target: $("#o" + this.ID),
        	event: 'click'
        }
    });
}

SensorType.prototype.modifyHTML = function(){
	$('#on_frac_'+this.ID).val(this.on_frac);
	$('#conn_frac_'+this.ID).val(this.conn_frac);
	$('#act_frac_'+this.ID).val(this.act_frac);
	$('#false_trig_rate_'+this.ID).val(this.false_trig_rate);
	$('#trig_lower_bound_'+this.ID).val(this.trig_lower_bound);
	$('#trig_upper_bound_'+this.ID).val(this.trig_upper_bound);
	$('#trig_prob_'+this.ID).val(this.trig_prob);
}

SensorType.prototype.remove = function(){
	for(x in sensorTypeArray){
		if(sensorTypeArray[x].ID == this.ID){
			buttonTable.removeChild(sensorTypeArray[x].document);
			sensorTypeArray.splice(x,1);
			return;
		}
	}
}

SensorType.get = function(ID){
	for(i in sensorTypeArray){
		if(sensorTypeArray[i].ID==ID)
			return sensorTypeArray[i];
	}
}

SensorType.addRow = function(ID){
	var color = COLORS[ID%(COLORS.length)][0];

	var newHTML = "<div class='typeRow'>"
	newHTML += '<img class="toolIcon" src="' + siteURL + 'icon/mm_20_'+ color + '.png">';
	newHTML += '<div class="toolLabel">Type ' + ID + '</div>';
	newHTML += '<div class="toolButton options usel" id="o'+ID+'" alt="Options"></div>';	
	newHTML += '<div class="toolButton area usel" id="a'+ID+'" onclick=\'select('+ID+',"area")\'></div>';
	newHTML += '<div class="toolButton marker usel" id="m'+ID+'" onclick=\'select('+ID+',"sensor")\'></div>';
	newHTML += '</div>';
	$("#sensorTypesContainer").append(newHTML);
	
	select(0);
}

SensorType.prototype.addSettingFrame = function(){
	var ID = this.ID;
	var newHTML = '' +
	'<div id="sensorTypeEditor_'+ ID +'">'+
		'<table>'+
			'<tr>'+
				'<td><b>Default ON-fraction</b></td>'+
				'<td><input type="text" id="on_frac_'+ ID + '"></td>'+
			'</tr>'+
			'<tr>'+
				'<td><b>Default CONNECTION-fraction</b></td>'+
				'<td><input type="text" id="conn_frac_'+ ID + '"></td>'+
			'</tr>'+
			'<tr>'+
				'<td><b>Default ACTIVE-fraction</b></td>'+
				'<td><input type="text" id="act_frac_'+ ID + '"></td>'+
			'</tr>'+
			'<tr>'+
				'<td><b>Default false trigger rate</b></td>'+
				'<td><input type="text" id="false_trig_rate_'+ ID + '"></td>'+
			'</tr>'+
			'<tr>'+
				'<td><b>Default |PGA| lower bound for reporting triggers</b></td>'+
				'<td><input type="text" id="trig_lower_bound_'+ ID + '"></td>'+
			'</tr>'+
			'<tr>'+
				'<td><b>Default |PGA| upper bound for reporting triggers with some probability</b></td>'+
				'<td><input type="text" id="trig_upper_bound_'+ ID + '"></td>'+
			'</tr>'+
			'<tr>'+
				'<td><b>Default probability for reporting triggers between the above two bounds</b></td>'+
				'<td><input type="text" id="trig_prob_'+ ID + '"></td>'+
			'</tr>'+
		'</table>'+
	'</div>';
	
	$("#sensorTypeEditorFrames").append(newHTML);
}

SensorType.removeAll = function(){
	var size = sensorTypeArray.length;
	for(var i =0; i < size; i++){
		sensorTypeArray[0].remove();
	}
}

SensorType.addLoaded = function(SensorTypes){
	totalSensorTypes = SensorTypes.length;
	for(x in SensorTypes){
		sensorTypeArray.push(new SensorType(SensorTypes[x].ID,SensorTypes[x]));
	}
}

SensorType.addNew = function(){
	sensorTypeArray.push(new SensorType(++totalSensorTypes));
}

SensorType.prototype.serialize = function(){
    var retVal = new Object(null);
    retVal.ID = this.ID;
    
    retVal.on_frac = $('#on_frac_'+this.ID).val();
    retVal.conn_frac = $('#conn_frac_'+this.ID).val();
    retVal.act_frac = $('#act_frac_'+this.ID).val();
    
	return retVal;
}