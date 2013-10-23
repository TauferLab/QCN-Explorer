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
 * Filename: contact.js
 * Author: Sam Schlachter
 * Description: 
 *
 */
	 
var submitForm = function () {

    if( formComplete() ){
        
        var requestObj = Object.create(null);
        requestObj.name    = $("#name").val();
        requestObj.email   = $("#email").val();
        requestObj.message = $("#message").val();
        
        requestData = JSON.stringify( requestObj );
        
        console.log( requestData );
    
        $.ajax("./contactAction.php", {
            type : "POST",
            dataType : "json",
            data : requestData,
            success : handleActionResponse
        });
    }
    else{
        $("#errorMsg").html("Please make sure the form is complete.");
    }
};

var handleActionResponse = function( data ){

    console.log(data);
    
    if( data.success ){
        $("#contactBody").html("Thank you for your message, we'll get back to you soon!");
    }
    else{
        $("#errorMsg").html("There was an issue with submitting the form. Please check your input. If you continue to have problems please contact Michela Taufer at taufer (at) udel.edu.");
    }
};

var formComplete = function (){
    if(
        $("#name").val()  == "" ||
        $("#email").val() == "" || 
        $("#message").val() == "" 
    ){
        return false;    
    }
    else{
        return true;
    }
};