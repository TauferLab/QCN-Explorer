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