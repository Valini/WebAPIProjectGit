<?php

//header("Content-Type:application/json");
//setup variables for requests
$api_key = "dc3bea5de93696d83833add120fba5ec";
$city = "Toronto";

//https://samples.openweathermap.org/data/2.5/find?q=London&units=metric&appid=b6907d289e10d714a6e88b30761fae22
//http://api.openweathermap.org/data/2.5/weather?q=Montreal&APPID=dc3bea5de93696d83833add120fba5ec

//setup structured url for request
$url_unstructured = "http://api.openweathermap.org/data/2.5/weather?q="
  . $city . "&units=metric&"
  . "APPID=" . $api_key;


  //initialize the CURL request
  $ch = curl_init($url_unstructured);
  //setup curl options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //prevent output on curl execution
  //execute CURL request
  $results = curl_exec($ch);
  //close CURL handler
  curl_close($ch);
  //print_r($results);

  $data = json_decode($results);

  //get the weather variables
  $cp = $data->coord;
  $temp = $data->main->temp;
  $tempmin = $data->main->temp_min;
  $tempmax = $data->main->temp_max;
  $clouds=$data->weather[0]->description;
  $wind=$data->wind->speed;
  $pressure=$data->main->pressure;
  $humidity=$data->main->humidity;
  $sunrise=$data->sys->sunrise;
  $sunset=$data->sys->sunset;
  $icon=$data->weather[0]->icon;
  $dt=$data->dt;
  //print_r($cp);

  //print_r($sunriseTime);

  $sr = new DateTime("@$sunrise");  // convert UNIX timestamp to PHP DateTime
  //echo $dt->format('Y-m-d H:i:s');
$ss = new DateTime("@$sunset");  // convert UNIX timestamp to PHP DateTime
$readingTime = new DateTime("@$dt");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Hello Weather</title>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body background="images/weather.jpg"">
  <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">WeatherMap</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
    </ul>
    <form class="navbar-form navbar-left" action="/action_page.php">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Search">
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
  </div>
</nav>
<main class="page container" style="margin-top:100px;">
	<div class="container">
		<section class="clean-block clean-form dark">
		<div class="container">
			<div class="block-heading">
        <h2 class="text-info">Weather in your City</h2>
        <div id="yourweather"></div>
        <h4 class="text-info">City of <?= $city ?></h4>
        <img src="http://openweathermap.org/img/w/<?= $icon ?>.png" alt="weather icon"><span><td><?= $readingTime->format('M/d/Y') ?>  </td></span>
        <table class="table table-hover">
    <tbody>
      <tr>
        <td>Actual Temperature</td>
        <td><?= $temp ?>°C</td>
      </tr>
      <tr>
        <td>Minimum Temperature</td>
        <td><?= $tempmin ?>°C</td>
      </tr>
      <tr>
        <td>Maximum Temperature</td>
        <td><?= $tempmax ?>°C</td>
      </tr>
      <tr>
        <td>Cloudiness</td>
        <td><?= $clouds ?></td>
      </tr>
      <tr>
        <td>Wind Speed</td>
        <td><?= $wind ?> m/s</td>
      </tr>
      <tr>
      <tr>
        <td>Humidity</td>
        <td><?= $humidity ?>%</td>
      </tr>
      <tr>
        <td>Sunrise</td>
        <td><?= $sr->format('Y-m-d H:i:s') ?></td>
      </tr>
      <tr>
        <td>Sunset</td>
        <td><?= $ss->format('Y-m-d H:i:s') ?></td>
      </tr>
    </tbody>
  </table>
      </div>
    </div>
  </section>
</div>
</main>
</body>
</html>
