<?php


try{
    $pdo = new 
    PDO('mysql:host=localhost;dbname=onekshop_invenpos','root','');
    // echo"connection successful";

}catch(PDOException $error_message){

    echo $error_message->getmessage();

} 


?> 