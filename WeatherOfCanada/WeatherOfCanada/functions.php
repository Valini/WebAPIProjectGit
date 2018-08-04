<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getcpOfCanada()
{
  //68 Greenway Crescent, Thompson, MB R8N 0R4
  $api_key = "AjDvdPcUrSfJfrA73THbzgQimIgKmNp1u4Q1GAq1TQKcEEVsGU_zn0BaJllRMkhm";
  $country = "CA";
  $province = "MB";
  $city = "Saint-Pierre-Jolys";
  $address = urlencode("377 Rue Sabourin");//"275 Notre-Dame East");
  $postalCode = "R0A1V0";

  $url_structured = "http://dev.virtualearth.net/REST/v1/Locations/" . $country . "/"
  //CA/adminDistrict/postalCode/locality/addressLine?includeNeighborhood=includeNeighborhood&include=includeValue&maxResults=maxResults&key=BingMapsKey";
    . $province . "/"
    . $postalCode . "/"
    . $city . "/"
    . $address . "?"
    . "key=" . $api_key;

  $ch = curl_init($url_structured);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  $results = curl_exec($ch);
  curl_close($ch);

  $data = json_decode($results);
  $cp = $data->resourceSets[0]->resources[0]->point->coordinates;

  //print_r($cp);
  //getCityNameByLonLat($cp[1], $cp[0]);
  return $cp;
}

function getCityNameByLonLat($weathers, $lon, $lat){
    /*
    $api_key = "AjDvdPcUrSfJfrA73THbzgQimIgKmNp1u4Q1GAq1TQKcEEVsGU_zn0BaJllRMkhm";
    $url_structured = "http://dev.virtualearth.net/REST/v1/Locations/" . $lat . "," . $lon . "?"
    //CA/adminDistrict/postalCode/locality/addressLine?includeNeighborhood=includeNeighborhood&include=includeValue&maxResults=maxResults&key=BingMapsKey";
      . "key=" . $api_key;

    $ch = curl_init($url_structured);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $results = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($results);
    
    $addr = explode(",", $data->resourceSets[0]->resources[0]->name);
    //print_r($addr[1]);
    
    return $addr[1];
     */
    
    foreach($weathers as $city => $weather) {      
      $orglon = $weather->coord->lon;
      $orglat = $weather->coord->lat;

      if ($lon >= ($orglon - 2) && $lon <= ($orglon + 2) && $lat >= ($orglat -5) && $lat <= ($orglat +5)){
          return $city;
      }
    }
        
    return "none";
}

function getWeatherInfo(){
        $cities = array("Quebec", "Toronto", "Vancouver", "Halifax", "Charlottetown", "Regina", "Edmonton", "Fredericton", "Winnipeg", "Ottawa", "St. Johns", "Iqaluit", "Yellowknife");
    

    $weathers = array();
    foreach($cities as $city){
        $url = "http://api.openweathermap.org/data/2.5/weather?q=" .  $city . "&APPID=dc3bea5de93696d83833add120fba5ec";
        //print_r($url);
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $results = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($results);
        
        $weathers[$city] = $data;

    }
    
    return $weathers;
}

