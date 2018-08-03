// JavaScript source code Tourism_Travel_Blog_JS
/*
    Team        : Suim Park, Roman Shaiko, Dmitrii Kudrik, Larisa Sabalin
    Scripted By : Suim Park
    Date        : 4 December, 2017
    Filename    : weather.js
*/

// declare variable for XMLHttpRequest
var weather = false;

// Configuring XMLHttpRequest Objects
if (window.XMLHttpRequest) {
    weather = new XMLHttpRequest();
} else if (window.ActiveXObject) {
    weather = new ActiveXObject("Microsoft.XMLHTTP");
}

// handling data downloads from the server using anonymous function
function getWeatherInfo() {
    if (weather) {
        // AIP Call to <openweathermap.org>
        weather.open("GET", "http://api.openweathermap.org/data/2.5/weather?q=Montreal&APPID=dc3bea5de93696d83833add120fba5ec", true);

        // passing data to the server using AJAX with get or post http methods
        weather.onreadystatechange = function () {
            if (weather.readyState == 4 && weather.status == 200) {
                //obj.innerHTML = weather.responseText;
                var json = weather.responseText;

                // json into array
                var parsed = JSON.parse(json);

                // cal showweather function that display the weather infomation
                showWeather(parsed);
            }
        };  // end anonymous function

        // send the request
        weather.send();

    }   // end if block
}   // end getData function

function showWeather(weatherData) {
    var img = document.getElementById("img_weather");

    
    if (weatherData["rain"]) {                              // if there is rain infomation, display rain image
        img.src = "images/rain.png";
    } else if (weatherData["snow"]) {                       // if there is snow infomation, display snow image
        img.src = "images/snowing.png";
    } else if (weatherData["clouds"]) {                     // if there is clouds infomation
        if (parseInt(weatherData["clouds"]["all"]) < 50)    // less than 50% then display partial_cloudy image
            img.src = "images/partial_cloudy.png";
        else
           img.src = "images/cloudy.png";                   // more than 50% then display cloudy image
    } else {                                                // display sunny image
        img.src = "images/sunny.png";
    }

    // display temperature and wind speed
    var cDegree = document.getElementById("current_degree");
    var sWind = weatherData["wind"]["speed"];
    var vDegree = (parseInt(weatherData["main"]["temp"]) - 273.15).toFixed(0) + "<sup>o</sup>C(Wind:" + sWind + "m/s)";
    cDegree.innerHTML = vDegree;

}


if (window.addEventListener) {
    window.addEventListener("load", getWeatherInfo, false);
} else if (window.attachEvent) {
    window.attachEvent("onload", getWeatherInfo);
}