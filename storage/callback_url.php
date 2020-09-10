<?php
$callbackResponse = file_get_contents('php://input');

$logFile = "CallbackResponse.json";
$log = fopen($logFile, "a");

if (substr("[]", -1)){
    fwrite($log, $callbackResponse);
}
else {
    fwrite($log, "[". $callbackResponse. "]");
}
 
fclose($log);

?>