<?php
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
 * Filename: contactAction.php
 * Author: Sam Schlachter
 * Description: This file 
 *
 */


    require_once('src/php/config.inc');
    
    /* Main */
    function main(){        
        $requestObj = getFormData();
        
        $responseObj = array();

        if( isValidEmail($requestObj["email"]) && storeMessage($requestObj) && emailMessage($requestObj) ){
            $responseObj["success"] = true;    
        }
        else{
            $responseObj["success"] = false;
        }
    
        return json_encode( $responseObj );   

    }
    
    function getFormData(){
        $POSTData = file_get_contents('php://input');
        
        return json_decode($POSTData, true);
    }    
    
    function emailMessage($requestObj){
        global $contactEmails;
        
        $ret = true;
        
        $name    = escapeshellcmd ( $requestObj["name"] );
        $email   = escapeshellcmd ( $requestObj["email"] );
        $message = escapeshellcmd ( $requestObj["message"] );
        
        $sender = "QCN Explorer <admin@qcnexplorer.org>";
        
        $message = "From: $name <$email>\r\nMessage: $message";
        $headers =  "" .
                    "Reply-To:" . $sender . "\r\n" .
                    "From: " . $sender . "\r\n".
                    "Mailed-By: " . $sender . "\r\n".
                    "X-Mailer: PHP/" . phpversion()."\r\n".
                    "MIME-Version: 1.0" . "\r\n".
                    "Content-type: text/plain; charset=iso-8859-1" . "\r\n";
                    
        foreach($contactEmails as $email){
            if($ret){
                $ret = mail($email, "QCN Explorer contact from $name", $message, $headers);
            }
                
        }
        
        return $ret;
    }
    
    function storeMessage($requestObj){
        global $mysql_host;
        global $mysql_db;
        global $mysql_user;
        global $mysql_pass;
        
        $mysqli = new mysqli($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
        
        if ($mysqli->connect_error) {
            return false;
        }
        
        
        $name    = $mysqli->escape_string( $requestObj["name"] );
        $email   = $mysqli->escape_string( $requestObj["email"] );
        $message = $mysqli->escape_string( $requestObj["message"] );
        
        $query = "INSERT INTO `contact`(
                                    `date`,
                                    `name`,
                                    `email`,
                                    `message`
                                ) VALUES (
                                    NOW(),
                                    \"$name\",
                                    \"$email\",
                                    \"$message\"
                                )";   
        
        if ( $mysqli->query($query) ){ 
            $mysqli->close();
            return true;
        }
        else{
            $mysqli->close();
            return false;
        }
    }
    
    function isValidEmail($email){ 
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    /* Call Main */
    echo main();
?>