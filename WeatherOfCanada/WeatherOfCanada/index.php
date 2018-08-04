<!DOCTYPE html>

<?php
    require_once("functions.php");

    $weathers = getAllCityWeatherInfo();

    $maptype = "Microsoft.Maps.MapTypeId.aerial";
    if(isset($_GET['maptype'])){
        $tmp = $_GET['maptype'];
        switch($tmp){
            case 'aerial':
                $maptype = "Microsoft.Maps.MapTypeId.aerial";
                break;
            case 'canvasDark':
                $maptype = "Microsoft.Maps.MapTypeId.canvasDark";
                break;
            case 'canvasLight':
                $maptype = "Microsoft.Maps.MapTypeId.canvasLight";
                break;
            case 'grayscale':
                $maptype = "Microsoft.Maps.MapTypeId.grayscale";
                break;
        }
    }

?>

<html>
<head>
    <meta charset="utf-8" />
    <title>Hello Weather</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type='text/javascript'
            src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap'
            async defer></script>
    <script type='text/javascript'>
        var map = null;
        var cursorStyle = null;
        function GetMap() {
            map = new Microsoft.Maps.Map('#myMap', {
                credentials: '<?= $map_api_key ?>',
                center: new Microsoft.Maps.Location(49.440788269043,-96.985130310059),
                mapTypeId: <?= $maptype; ?>,
                labelOverlay: Microsoft.Maps.LabelOverlay.hidden,
                zoom: 5
            });
            <?php
            foreach($weathers as $weather) : ?>
            <?php
                $lon = floatval($weather->coord->lon);
                $lat = floatval($weather->coord->lat);
                $temperature = floatval($weather->main->temp);
                $icon = 'http://openweathermap.org/img/w/' . $weather->weather[0]->icon;
            ?>

              var location = new Microsoft.Maps.Location(<?= $lat ?>,<?= $lon ?>);
              var pin = new Microsoft.Maps.Pushpin(location,
                {icon:"<?= $icon ?>.png",
                  height:50, width:50,
                  anchor:new Microsoft.Maps.Point(0,0), draggable: false,
                  title: '<?= $weather->name ?>',
                  subTitle: '<?= $temperature . '\u02DAC' ?>',
                }
              );
              pin.metadata = {
                  title: '<?= $weather->id ?>'
              };

              //Add the pushpin to the map
              map.entities.push(pin);

              Microsoft.Maps.Events.addHandler(pin, 'mouseout', changeCursor);
              Microsoft.Maps.Events.addHandler(pin, 'mouseover', revertCursor);
              Microsoft.Maps.Events.addHandler(pin, 'click', moveToDetails);
            <?php endforeach; ?>

        }

        function changeCursor(e) {
            map.getRootElement().style.cursor = 'default';
        }
        function revertCursor(e) {
            map.getRootElement().style.cursor = 'crosshair';
        }
        function moveToDetails(e) {
            var city = e.target.metadata.title;
            window.location.href="weatherDetails.php?city=" + city;
        }
    </script>
</head>
<body>
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
                //$cities = array("Quebec", "Toronto", "Vancouver", "Halifax", "Charlottetown", "Regina", "Edmonton", "Fredericton", "Winnipeg", "Ottawa", "st. johns,CA", "Iqaluit", "Yellowknife");
    $citiIds = ",,,,,,,,,,";

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

        </div>
    </nav>
    <div style="width:100%">
        <div class="dropdown" style="padding-left:20px;padding-bottom:20px">
          <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Map Type
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li><a href="index.php?maptype=aerial">Aerial</a></li>
            <li><a href="index.php?maptype=canvasDark">Canvas Dark</a></li>
            <li><a href="index.php?maptype=canvasLight">Canvas Light</a></li>
            <li><a href="index.php?maptype=grayscale">Gray Scale</a></li>
          </ul>
        </div>
        <div id="myMap" style="position:relative;width:1800px;height:800px;margin:auto;"></div>
    </div>
</body>
</html>
