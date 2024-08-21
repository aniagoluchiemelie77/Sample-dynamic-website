<?php
function logger ($logs){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    if(!file_exists("../../logs.txt")){
        file_put_contents("../../logs.txt", " ");
    };
    date_default_timezone_set("Nigeria/Lagos");
    $time = date("m/d/y h:iA", time());
    $contents = file_get_contents("../../logs.txt");
    $contents .= "$ip\t$time\t$logs\r";
    file_put_contents("../../logs.txt", $contents);
};
?>