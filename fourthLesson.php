<?php
$fileName = "cashWeather.json";
$openFile = fopen("$fileName", 'a+');
if ((filemtime("$fileName") - time() <= -3600) or (filesize("$fileName") == 0)) {
    $json = (file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=Moscow,ru&units=metric&appid=2a05c2f887dbb8ec9888d24a55b5dbb7'));
    $clean = fopen("$fileName", 'w');
    fclose($clean);
    fwrite($openFile, $json);
}
fclose($openFile);
$cashFile = file_get_contents("$fileName");
$decode = json_decode($cashFile, true);
$temp = intval($decode["main"]["temp"]);
$pressure = intval($decode["main"]["pressure"]);
$weatherStat = ($decode["weather"]["0"]["description"]);
$humidity = ($decode["main"]["humidity"]);
$windSpeed = ($decode["wind"]["speed"]);
$sunset = ($decode["sys"]["sunset"]);
$sunrise = ($decode["sys"]["sunrise"]);
$timeSunsetFormat = date("G:i", $sunset);
$timeSunriseFormst = date("G:i", $sunrise);
$timeNow = date("G:i");
$dateNow = date("d.m.y");
$weatherStatURL = urlencode($weatherStat);
$translate = file_get_contents("https://translate.yandex.net/api/v1.5/tr.json/translate?key=trnsl.1.1.20170723T175246Z.236743f9d102d4ae.d07ab56c33c2827e8258ff52323fc147f0c8dfc4&text=$weatherStatURL&lang=en-ru&format=plain&options=1");
$decodeTranslate = json_decode($translate, true);
$endWeatherStat = ($decodeTranslate["text"]["0"]);
$lastUpdate = date("G:i d.m.y", filemtime("$fileName"));
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Погода в Москве</title>
    <style>
        span {
            font-size: 18px;
            font-weight: bold;
            display: inline-block;
            margin-right: 10px;
        }

        #lastUp {
            font-size: 14px;
            text-align: left;
        }

    </style>
</head>
<body>
<div class="title">
    <h1>Погода в Москве</h1>
</div>
<div class="container">
    <nav>
        <ul>
            <li>
                <p><span>Температура:</span><?= $temp ?> градусов Цельсия</p>
            </li>
            <li>
                <p><span>Погодные условия: </span><?= $endWeatherStat ?></p>
            </li>
            <li>
                <p><span>Давление: </span><?= $pressure ?> гПа</p>
            </li>
            <li>
                <p><span>Влажность воздуха: </span><?= $humidity ?> %</p>
            </li>
            <li>
                <p><span>Скорость ветра: </span><?= $windSpeed ?> м/с</p>
            </li>
            <li>
                <p><span>Текущее время: </span><?= $timeNow ?></p>
            </li>
            <li>
                <p><span>Сегодняшняя дата: </span><?= $dateNow ?></p>
            </li>
            <li>
                <p><span>Время восхода солнца: </span><?= $timeSunriseFormst ?></p>
            </li>
            <li>
                <p><span>Время захода солнца: </span><?= $timeSunsetFormat ?></p>
            </li>

        </ul>
    </nav>
    <p id="lastUp">Последнее обновление данных: <?= $lastUpdate ?></p>
</div>

</body>
</html>
