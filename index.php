<?php
    $location = "cesis";
    if($_GET["location"] == null) {
        $location = "cesis";
    } else {
        $location = $_GET["location"];
    }
    $data = file_get_contents("https://emo.lv/weather-api/forecast/?city=$location");

    // $data = '{"location":{"city":"Cesis","woeid":851991,"country":"Latvia","lat":57.31802,"long":25.281811,"timezone_id":"Europe/Riga"},"current_observation":{"pubDate":1741941340,"wind":{"chill":16,"direction":"NW","speed":12},"atmosphere":{"humidity":83,"visibility":14.98,"pressure":994.6},"astronomy":{"sunrise":"6:36 AM","sunset":"6:21 PM"},"condition":{"temperature":28,"text":"Cloudy","code":26}},"forecasts":[{"day":"Fri","date":1741968000,"high":36,"low":21,"text":"Partly Cloudy","code":30},{"day":"Sat","date":1742054400,"high":41,"low":27,"text":"Sunny","code":32},{"day":"Sun","date":1742140800,"high":40,"low":22,"text":"Snow","code":16},{"day":"Mon","date":1742227200,"high":41,"low":26,"text":"Partly Cloudy","code":30},{"day":"Tue","date":1742313600,"high":44,"low":29,"text":"Mostly Cloudy","code":28},{"day":"Wed","date":1742400000,"high":48,"low":31,"text":"Mostly Sunny","code":34},{"day":"Thu","date":1742486400,"high":51,"low":32,"text":"Sunny","code":32},{"day":"Fri","date":1742572800,"high":55,"low":35,"text":"Partly Cloudy","code":30},{"day":"Sat","date":1742659200,"high":54,"low":36,"text":"Partly Cloudy","code":30},{"day":"Sun","date":1742745600,"high":54,"low":35,"text":"Mostly Sunny","code":34},{"day":"Mon","date":1742832000,"high":53,"low":38,"text":"Sunny","code":32}]}';
    $weatherData = json_decode($data, true);

    if($weatherData == null) {
        echo "<div class='errorPrompt'><img src='https://media.tenor.com/sLgNruA4tsgAAAAM/warning-lights.gif'><p>Location not found! Enter a valid location.</p></div>";
    }
?>

<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VTDT Sky</title>
    <link rel="stylesheet" href="css/index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body class="light">
<script src="js/index.js"></script>
<div class="root">
    <div class="mainContent">
        <header class="navbar">
            <div class="sec1">
                <svg class="hamburgerMenu" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path></svg>
                <h1 class="VTDTtext">VTDT Sky</h1>
                <img class="google-maps" src="image/google-maps.gif">
                <p class="locationCity"><?php echo $weatherData['city']['name']?>, <?php echo $weatherData['city']['country']?></p>
            </div>
            <div class="sec1dot5">
                <form>
                    <input class="searchBar" type="text" placeholder="Search Location" name="location">
                    <!-- <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M11 2a9 9 0 1 0 6.293 15.293l4.707 4.707a1 1 0 0 0 1.414-1.414l-4.707-4.707A9 9 0 0 0 11 2zM11 4a7 7 0 1 1 0 14 7 7 0 0 1 0-14z"></path></svg> -->
                </form>
            </div>
            <div class="sec2">
                <button onClick="darkMode();" class="modeChange">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"></path></svg>
                    <span id="textMode">Light</span>
                </button>
                <button class="notification">
                    <img src="image/notification.gif" alt="Notification Button">
                </button>
                <button class="settings">
                    <img src="image/settings.gif" alt="Settings Button">
                </button>
            </div>
        </header>
        <div class="flex-container">
            <div class="left">
                <section class="section1">
                    <div class="containerSection1">
                        <div class="weatherInfoMain"> 
                            <div class="leftSideWeather">
                                <div class="currentWeather">Current Weather</div>
                                <?php $countryTime = json_decode(file_get_contents("https://timeapi.io/api/time/current/coordinate?latitude=" . $weatherData['city']['coord']['lat'] . "&longitude=" . $weatherData['city']['coord']['lon']), true);?>
                                <div class="localTime">Local time: <?php date_default_timezone_set($countryTime['timeZone']); echo date("H:i");?></div>
                                <div class="weatherInfo">
                                    <?php $weatherIcon = "https://openweathermap.org/img/wn/" . $weatherData['list'][0]['weather'][0]['icon'] ."@2x.png"?>
                                    <img class="weatherIcon" src="<?php echo $weatherIcon?>" alt="Weather Icon">
                                    <?php
                                        // soreizejais laiks
                                        $currentTime = "day";
                                        if($countryTime['hour'] >= 6 && $countryTime['hour'] <= 12) {
                                            $currentTime = "morn";
                                        }
                                        if($countryTime['hour'] >= 12 && $countryTime['hour'] <= 16) {
                                            $currentTime = "day";
                                        }
                                        if($countryTime['hour'] >= 16 && $countryTime['hour'] < 24) {
                                            $currentTime = "eve";
                                        }
                                        if($countryTime['hour'] >= 24 && $countryTime['hour'] < 6) {
                                            $currentTime = "eve";
                                        }

                                    ?>
                                    <div class="currentTemp"> <?php echo $weatherData['list'][0]['temp'][$currentTime] ?> </div>
                                    <p class="tempSymbol" id="value"><span class="metricC">°C</span></p>
                                    <div class="secondaryInfo">
                                        <div class="text1">  <?php echo $weatherData['list'][0]['weather'][0]['main']?> </div>
                                        <div id="value" class="text2"> Feels like <span id="value"><?php echo $weatherData['list'][0]['feels_like'][$currentTime]?></span><span class="metricC">°C</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="motherSelector">
                                <div class="selectorChild">
                                    <select id="selector" class="cursor-pointer 440px:w-auto max-w-full rounded-lg px-2 py-1 border bg-white text-gray-800 border-gray-300" onchange="console.log(this.value)">
                                        <option value="Celsius">Celsius and Kilometers</option>
                                        <option value="Fahrenheit">Fahrenheit and Miles</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php
                            $array = array("N","NNE","NE","ENE","E","ESE", "SE", "SSE","S","SSW","SW","WSW","W","WNW","NW","NNW");
                            $val = ($weatherData['list'][0]['deg']/22.5)+.5;
                        ?>
                        <p class="windDirection">Current wind direction: <?php echo $array[(int) $val%16] ?> </p>
                    </div>
                </section>

                <section class="section2">
                    <div class="div1">
                        <div class="textSec">
                            <img src="image/clouds.gif" alt="" class="iconGrid">
                            <span class="text">Clouds</span>
                        </div>
                        <span class="infoText">
                            <?php echo $weatherData['list'][0]['clouds']?>
                        </span>
                    </div>
                    <div class="div2">
                        <div class="textSec">
                            <img src="image/wind.gif" alt="" class="iconGrid">
                            <span class="text">Wind</span>
                        </div>
                        <span class="infoText" id="value">
                            <?php echo $weatherData['list'][0]['speed']?> <span class="kmh">km/h</span>
                        </span>
                    </div>
                    <div class="div3">
                        <div class="textSec">
                            <img src="image/humidity.gif" alt="" class="iconGrid">
                            <span class="text">Humidity</span>
                        </div>
                        <span class="infoText">
                            <?php echo $weatherData['list'][0]['humidity']?>%
                        </span>
                    </div>
                    <div class="div4">
                        <div class="textSec">
                            <img src="image/vision.gif" alt="" class="iconGrid">
                            <span class="text">Probability of Precipitation</span>
                        </div>
                        <span class="infoText">
                            <?php echo $weatherData['list'][0]['pop']?>
                            %
                        </span>
                    </div>
                    <div class="div5">
                        <div class="textSec">
                            <img src="image/air-pump.gif" alt="" class="iconGrid">
                            <span class="text">Gust</span>
                        </div>
                        <span class="infoText" id="value">
                            <?php echo $weatherData['list'][0]['gust']?> <span class="kmh">km/h</span>
                        </span>
                    </div>
                    <div class="div6">
                        <div class="textSec">
                            <img src="image/air-pump.gif" alt="" class="iconGrid">
                            <span class="text">Pressure</span>
                        </div>
                        <span class="infoText">
                            <!-- hPa -->
                            <?php echo $weatherData['list'][0]['pressure']?>
                            hPa
                        </span>
                    </div>
                </section>

                <!-- <section class="section3">
                    
                    <div style="display: flex; justify-content: start; align-items: center; margin-bottom: 1rem;">
                        <span>Sun & Moon Summary</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="image/sun.gif" alt="Sun Icon" class="size-12">
                            <div class="flex flex-col text-sm" style="padding-left: 0.5rem;">
                                <div>
                                    Air Quality
                                </div>
                                <span>1</span>  
                            </div>
                        </div>
                        <div class="flex flex-col xsm:flex-row items-start">
                            <div class="flex items-center justify-between space-x-4 pt-4 xsm:pt-0">
                                    <div class="flex flex-col items-center">
                                        <img class="height-6 width-6" src="image/field.gif" alt="">
                                        <div class="text-sm">Sunrise</div>
                                        <span class="font-semibold">06:36am</span>
                                    </div>
                                    <div style="width: 12rem; height: 3.5rem;" class="relative overflow-hidden">
                                    </div>
                                    <div></div>
                            </div>
                        </div>
                    </div>
                    <div></div>
                </section> -->
            </div>

            <div class="right">
                <div class="secondnav">
                    <div class="controls">
                        <button class="todayBtn">Today</button>
                        <button class="tomorrowBtn">Tomorrow</button>
                        <button class="tendaysBtn">10 Days</button>
                    </div>
                </div>
                <div style="display: flex; height: 37.8rem; scrollbar-width: thin; padding-right: .5rem; white-space: nowrap; overflow-y: auto; overflow-x: hidden; flex-direction: column; gap: 1rem; overflow-x: auto; position: relative; line-height: inherit;">
                    
                    <!-- start el -->

                    <?php 
                        $day = 0;
                        foreach($weatherData['list'] as $x) {
                                $t=$weatherData['list'][$day]['dt'];
                                echo'<div class="weatherPrognoze">';
                                echo'<div class="leftSidePrognoze">';
                                echo'<img class="" src="//cdn.weatherapi.com/weather/64x64/night/113.png" alt="Weather Icon">';
                                echo'<div class="timeWeather">';
                                echo'<span class="time">' . date("d. M",$t) . '</span>';
                                echo'<span class="weatherText">N/A</span>';
                                echo'</div>';
                                echo'</div>';
                                echo'<div class="line"></div>';
                                echo'<div class="rightSidePrognoze">';
                                echo'<div class="temprightside">';
                                echo'<div style="color: var(--gray-800); font-size: 1.5rem; line-height: 2rem; font-weight: 600;">' . $weatherData['list'][$day]['temp']['max'] . '</div>';
                                echo'<p style="color: var(--gray-600); font-size: 1.25rem; line-height: 1.75rem; padding-right: .5rem; margin-bottom: .5rem;" class="metricC">°C</p>';
                                echo'</div>';
                                echo'<div class="secondaryRight">';
                                echo'<span style="color: var(--gray-800); font-size: .875rem; line-height: 1.25rem; white-space: nowrap;">Wind: N/A </span>';
                                echo'<span style="color: var(--gray-800)">Humidity: N/A</span>';
                                echo'</div>';        
                                echo'</div>';
                                echo'</div>';
                                $day++;
                        }
                        
                    ?>

                    <!-- <div class="weatherPrognoze">
                        <div class="leftSidePrognoze">
                            <img class="" src="//cdn.weatherapi.com/weather/64x64/night/113.png" alt="Weather Icon">
                            <div class="timeWeather">
                                <span class="time">PT:PT</span>
                                <span class="weatherText">Placeholder</span>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="rightSidePrognoze">
                            <div class="temprightside">
                                <div style="color: var(--gray-800); font-size: 1.5rem; line-height: 2rem; font-weight: 600;">14.54</div>
                                <p style="color: var(--gray-600); font-size: 1.25rem; line-height: 1.75rem; padding-right: .5rem; margin-bottom: .5rem;">°C</p>
                            </div>
                            <div class="secondaryRight">
                                <span style="color: var(--gray-800); font-size: .875rem; line-height: 1.25rem; white-space: nowrap;">Wind: phldr km/h</span>
                                <span style="color: var(--gray-800)">Humidity: ph%</span>
                            </div>        
                        </div>
                    </div> -->
                    
                </div>
                
            </div>
            

        </div> 
    </div>
</div>
</body>
</html>