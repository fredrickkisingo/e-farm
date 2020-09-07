<?php
ini_set("log_errors", 0);
ini_set("error_log", "php-error.log");
date_default_timezone_set('Africa/Nairobi'); 
 $callbackResponse = json_decode(file_get_contents('php://input'),true);
 error_log( print_r($data, TRUE) );
// $logFile = "CallbackResponse.json";
// $log = fopen($logFile, "a");

// if (substr("[]", -1)){
//     fwrite($log, $callbackResponse);
// }
// else {
//     fwrite($log, "[". $callbackResponse. "]");
// }

// fclose($log);
?>