<?php
require_once("functions.php");


//getting value of the city selected
$cityId = "";
$lon = "";
$lat = "";
if(isset($_POST['submit'])){
    if(isset($_POST['selectedcity'])){
        $cityId = $_POST['selectedcity'];
    }else{
        $lat = $_POST['lat'];
        $lon = $_POST['lon'];
    }
}else{
    if(isset($_GET['city'])){
        $cityId = $_GET['city'];
    }else{
        $lat = $_GET['lat'];
        $lon = $_GET['lon'];
    }
}
 if($cityId !== "" || $lon !== ""){
     $data = null;
     if($cityId !== "")
        $data = getOneCityWeatherInfo($cityId);
     else
        $data = getOneCityWeatherInfoLatLon($lat, $lon);
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
    $city=$data->name;


    $sr = new DateTime("@$sunrise");  // convert UNIX timestamp to PHP DateTime
    //echo $dt->format('Y-m-d H:i:s');
    $ss = new DateTime("@$sunset");  // convert UNIX timestamp to PHP DateTime
    $readingTime = new DateTime("@$dt");
}


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
      <a class="navbar-brand" href="index.php">WeatherMap</a>
    </div>
    <ul class="nav navbar-nav">
      <li class=""><a href="#"></a></li>
      <li><a href="#"></a></li>
      <li><a href="#"></a></li>
    </ul>
    <form class="navbar-form navbar-left"  action="weatherDetails.php" method="POST">
        <select name="selectedcity" id="selectedcity" class="form-control">
            <option value="6094817">Ottawa, Canada</option>
            <option value="6324733">St. John's, Newfoundland and Labrador</option>
            <option value="6324729">Halifax, Nova Scotia</option>
            <option value="5957776">Fredericton, New Brunswick</option>
            <option value="5920288">Charlottetown, Prince Edward Island</option>
            <option value="6325494">Québec, Quebec</option>
            <option value="6167865">Toronto, Ontario</option>
            <option value="6183235">Winnipeg, Manitoba</option>
            <option value="6119109">Regina, Saskatchewan</option>
            <option value="5946768">Edmonton, Alberta</option>
            <option value="5814616">Vancouver, British Columbia</option>
            <option value="5983720">Iqaluit, Nunavut</option>
            <option value="6185377">Yellowknife, Northwest Territories</option>
            <option value="6180550">Whitehorse, Yukon</option>
        </select>
        <input class="btn btn-default" type="submit" name="submit" value="Go" />
    </form>
    <form class="navbar-form navbar-right" action="weatherDetails.php" method="post">
        <div class="form-group">
            <input type="number" step="0.00001"  min="-90.00000" max="90.00000" class="form-control" name="lat" placeholder="Enter Latitude" pattern="((\d+)(\.\d{4}))$" title="Has to be 4 decimal points">
        </div>
        <div class="form-group">
            <input type="number" step="0.00001" min="-180.00000" max="180.00000" class="form-control" name="lon" placeholder="Enter Longitude" pattern="((\d+)(\.\d{4}))$" title="Has to be 4 decimal points">
        </div>
        <button type="submit" name="submit" class="btn btn-default">Go</button>
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
  <?php
      //}
?>
      </div>
    </div>
  </section>
</div>
</main>
</body>
</html>
