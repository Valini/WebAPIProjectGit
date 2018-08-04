<?php

function getWeatherInfo(){
    //$cities = array("Quebec", "Toronto", "Vancouver", "Halifax", "Charlottetown", "Regina", "Edmonton", "Fredericton", "Winnipeg", "Ottawa", "st. johns,CA", "Iqaluit", "Yellowknife");
    $citiIds = "6325494,6167865,5814616,6324729,5920288,6119109,5946768,5957776,6183235,6094817,6324733,5983720,6185377";
    

    $weathers = array();
    $url = "http://api.openweathermap.org/data/2.5/group?id=" . $citiIds . "&units=metric&APPID=dc3bea5de93696d83833add120fba5ec";
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $results = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($results);
            
    return $data->list;
}

