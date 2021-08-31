<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo 'stops';
die();


$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJ1c2VyX2lkIjoiYzI2NzA5YzQtNmRmYi00YjhmLThmNTgtNTliMThlZDRiOTFmIiwiZXhwIjoxNjMwMzUwNjEwLCJpYXQiOjE2MzAzMzYyMTAsInVzZXJfZW1haWwiOiJjbGE1NWlrQHlhbmRleC5ydSIsInNjb3BlcyI6WyJnZW5lcmF0ZSJdfQ.nM9nKgHc6VwGkKOCZb8UAbtSldrd4YYIZTjrZhR3EDav55gEJ9pYJDr6_r7ZCllOtgqCOZZ7JQv970VfQ7UX-jQeaVNercWuaT3Uzy1llkPlCIosfiaZguDZG79Yiu_ZbuTwkxQNuzauVyLDOCBB0wCwEOEbbgspc7x8jg-hzqnbf0EJz_rvisfo7VWpTOBj2HGoei1iUvmO7GiaRaQwcePw1QQsrsN99CszQceX3lTJF6brGrbnJFfFJyO87M9V3acJsFFfjIro1EE0eWowEGJVsx1sEYos_QnLbb2hF_xUncRm0pGlELQ8x0De0L2Ye6lqaPMb5RBIApS-v5RhuVstd_oamiE24E7zYzOg-UsvkyiGJMBwPGZ38GcCTDYUkDl21y1GzY7ASIYM4bDlxPoq98CWjPcQt8R8SR2TVxLhIvm86yIjcgoYb70dJ5PudtR-jFPfx5-O-l4nIAB5qikAbzB-3hgUX_zg_Z1Nyy7XksOAKbiK2aRPz1eLInXqXAA1z1Ntx_7wdOF_KuBtK-l9cv7PMFM_D2UJvqDRHOJqEPtCS2ixZex7RAboucTW-HRD-d_ZIIoCgEgfoNqJvNYpF1QC6E1SV2tctqSag5CKAsgVVngPSoc9f9_T9T4LTPmox1mbN4HoyvA0FyKNYmWzNv0VbnzPEEkZ2Zi0Zqg";
$refresh_token = "e000d8b65fceb8e565c29fe645fde0a915ec8793662d1e7d";

$voices = [
    "AgathaLighthearted" => "510071c9-162a-4496-8619-28383cc1ae07",
    "Amber" => "4807ea95-5b17-43b7-b25d-e409736a099f",
    "AnnabelHappy" => "2e72c59a-d80e-4316-9a20-ae233cc5b71e",
    "AtlasFierce" => "8a15430f-ddc2-4d1f-a918-02788e01319c",
    "Ava" => "6efb468f-67bf-4d59-9ac5-c20b2774153b",
    "AxorianSinister" => "c64f177b-3447-4b26-b288-6acfd3e86b28",
    "Beth" => "fc87ca7c-6cae-4fcf-ba94-c35687156274",
    "CallahanLighthearted" => "f540d782-6123-49a6-9a9d-82bce3e19f07",
    "CatalinaFriendly" => "ae62e162-9f2d-4f55-9950-4ccc6abfb1d4",
    "ColtCharm" => "1f832231-3822-4843-a4a9-fd3dfefb000f",
    "Davu" => "f054b9b8-7512-4fc4-863a-fda764251e69",
    "Deckard" => "c4fe46c4-79c0-403e-9318-ffe7bd4247dd",
    "Emily" => "60898052-3fe3-413f-8f44-53e1f3933bd2",
    "Ethan" => "b54dc73b-cb24-4c6c-a374-b888feb83a3f",
    "Evelyn" => "678dccc4-081d-443d-8802-88656690fb39",
    "Freya - Serious" => "dba32066-b435-4de5-9235-c0c5afcf1dae",
    "Gabriel" => "953ae73d-efc5-46b0-b121-d508d76ef8e0",
    "GrayHappy" => "97273159-0077-43ce-b200-7b52df616e6c",
    "Greta" => "54b588c7-f36f-483f-8715-b52d48e50d3c"

];



function getVoice($token)
{
    $headers = ["Authorization: Bearer {$token}"];
    // $token = '069b6659-984b-4c5f-880e-aaedcfd84102';
    // $folderId = "b1geosc0044m3sofpm45";
    $url = 'https://api.replicastudios.com/voice';
    // $post = 'text=' . urlencode($text) . '&voice=alena&emotion=neutral&lang=ru-RU&speed=1.0&format=oggopus&folderId=' . $folderId;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    // curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $content = trim(curl_exec($ch));
    $array = json_decode($content);
    curl_close($ch);
    return $array;
}


function getSpeech($token, $text, $speaker_id)
{

    $headers = ["Authorization: Bearer {$token}"];

    $queryParams = [
        'extension' => 'ogg',
        'bit_rate' => '320',
        'speaker_id' => $speaker_id,
        'txt' => $text,
    ];

    $url = "https://api.replicastudios.com/speech?" . http_build_query($queryParams);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    // curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $get);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $content = curl_exec($ch);
    $array = json_decode($content);
    curl_close($ch);
    return $array;
}

$response = getVoice($token);  //Получаем список голосов

// echo "<pre>";
// print_r($response);
// echo "<pre>";

$voices_id = [];
$n = 1;
foreach ($response as $voice) {
    $name = str_replace([" ", "-"], "", $voice->name);
    $voices_id[$n] = ["name" => $name, 'uid' => $voice->uuid];
    // $speaker_id = ;
    $n++;
}



#########

// $text = 'Note: the returned URL will expire after few days so we do not recommend to store them. They should either be played or downloaded straight away.Caller can provide timeout parameter (in seconds) which specifies how long the request should be held before returning, if results are not ready (this is so called "long polling" technique, which reduces the number of calls needed to get the result).';
$text = 'Note: the returned URL will expire after few days so we do not recommend to store them.';
// $speaker_id = "4807ea95-5b17-43b7-b25d-e409736a099f";

$path = $_SERVER['DOCUMENT_ROOT'] . "/replica";
if (!file_exists($path . "/voices")) {
    mkdir($path . "/voices", 0775);
}



// foreach ($voices_id as $name => $speaker_id) {
//     $speech = getSpeech($token, $text, $speaker_id);

//     $url_ogg = $speech->urls->ogg;

//     $soundfile = file_get_contents($url_ogg);
//     $path_file = $path . "/voices/{$name}.ogg";
//     $file = fopen($path_file, "w");
//     fwrite($file, $soundfile);
//     fclose($file);
// }
for ($j = 76; $j <= 114; $j++) {

    $voice = $voices_id[$j];
    $speaker_id = $voice['uid'];
    $name = $voice['name'];
    $speech = getSpeech($token, $text, $speaker_id);

    $url_ogg = $speech->urls->ogg;

    $soundfile = file_get_contents($url_ogg);
    $path_file = $path . "/voices/{$name}.ogg";
    $file = fopen($path_file, "w");
    fwrite($file, $soundfile);
    fclose($file);
}






// $speech_arr =$speech);

// echo "<pre>";
// print_r($url_ogg);
// echo "<pre>";

echo "<pre>";
print_r($voices_id);
echo "<pre>";





?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <button id="auth">AUTH</button>
    </div>
    <div>
        <button id="auth2">AUTH2</button>
    </div>

</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let resp = {};
        let token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJ1c2VyX2lkIjoiYzI2NzA5YzQtNmRmYi00YjhmLThmNTgtNTliMThlZDRiOTFmIiwiZXhwIjoxNjMwMzUwNjEwLCJpYXQiOjE2MzAzMzYyMTAsInVzZXJfZW1haWwiOiJjbGE1NWlrQHlhbmRleC5ydSIsInNjb3BlcyI6WyJnZW5lcmF0ZSJdfQ.nM9nKgHc6VwGkKOCZb8UAbtSldrd4YYIZTjrZhR3EDav55gEJ9pYJDr6_r7ZCllOtgqCOZZ7JQv970VfQ7UX-jQeaVNercWuaT3Uzy1llkPlCIosfiaZguDZG79Yiu_ZbuTwkxQNuzauVyLDOCBB0wCwEOEbbgspc7x8jg-hzqnbf0EJz_rvisfo7VWpTOBj2HGoei1iUvmO7GiaRaQwcePw1QQsrsN99CszQceX3lTJF6brGrbnJFfFJyO87M9V3acJsFFfjIro1EE0eWowEGJVsx1sEYos_QnLbb2hF_xUncRm0pGlELQ8x0De0L2Ye6lqaPMb5RBIApS-v5RhuVstd_oamiE24E7zYzOg-UsvkyiGJMBwPGZ38GcCTDYUkDl21y1GzY7ASIYM4bDlxPoq98CWjPcQt8R8SR2TVxLhIvm86yIjcgoYb70dJ5PudtR-jFPfx5-O-l4nIAB5qikAbzB-3hgUX_zg_Z1Nyy7XksOAKbiK2aRPz1eLInXqXAA1z1Ntx_7wdOF_KuBtK-l9cv7PMFM_D2UJvqDRHOJqEPtCS2ixZex7RAboucTW-HRD-d_ZIIoCgEgfoNqJvNYpF1QC6E1SV2tctqSag5CKAsgVVngPSoc9f9_T9T4LTPmox1mbN4HoyvA0FyKNYmWzNv0VbnzPEEkZ2Zi0Zqg";
        let refresh_token = "e000d8b65fceb8e565c29fe645fde0a915ec8793662d1e7d";
        let auth_btn = document.getElementById('auth');
        let auth_btn2 = document.getElementById('auth2');
        let voices = {
            "AgathaLighthearted": "510071c9-162a-4496-8619-28383cc1ae07",
            "Amber": "4807ea95-5b17-43b7-b25d-e409736a099f",
            "AnnabelHappy": "2e72c59a-d80e-4316-9a20-ae233cc5b71e",
            "AtlasFierce": "8a15430f-ddc2-4d1f-a918-02788e01319c",
            "Ava": "6efb468f-67bf-4d59-9ac5-c20b2774153b",
            "AxorianSinister": "c64f177b-3447-4b26-b288-6acfd3e86b28",
            "Beth": "fc87ca7c-6cae-4fcf-ba94-c35687156274",
            "CallahanLighthearted": "f540d782-6123-49a6-9a9d-82bce3e19f07",
            "CatalinaFriendly": "ae62e162-9f2d-4f55-9950-4ccc6abfb1d4",
            "ColtCharm": "1f832231-3822-4843-a4a9-fd3dfefb000f",
            "Davu": "f054b9b8-7512-4fc4-863a-fda764251e69",
            "Deckard": "c4fe46c4-79c0-403e-9318-ffe7bd4247dd",
            "Emily": "60898052-3fe3-413f-8f44-53e1f3933bd2",
            "Ethan": "b54dc73b-cb24-4c6c-a374-b888feb83a3f",
            "Evelyn": "678dccc4-081d-443d-8802-88656690fb39",
            "Freya - Serious": "dba32066-b435-4de5-9235-c0c5afcf1dae",
            "Gabriel": "953ae73d-efc5-46b0-b121-d508d76ef8e0",
            "GrayHappy": "97273159-0077-43ce-b200-7b52df616e6c",
            "Greta": "54b588c7-f36f-483f-8715-b52d48e50d3c",
            "test": "4807ea95-5b17-43b7-b25d-e409736a099f"

        };


        auth_btn.addEventListener('click', function(e) {
            e.preventDefault();
            // jwt = JSON.parse(replicaAuth());
            //jwt = replicaAuth();
            text = 'Note: the returned URL will expire after few days so we do not recommend to store them. They should either be played or downloaded straight away.Caller can provide timeout parameter (in seconds) which specifies how long the request should be held before returning, if results are not ready (this is so called "long polling" technique, which reduces the number of calls needed to get the result).';
            speaker_id = voices.test;
            // res = getSpeech(token, text, speaker_id);
            // resp = replicaAuth();
            resp = getSpeech(token, text, speaker_id)
            console.log(resp);

        })
        auth_btn2.addEventListener('click', function(e) {
            e.preventDefault();
            // jwt = JSON.parse(replicaAuth());
            //jwt = replicaAuth();
            text = 'Note: the returned URL will expire after few days so we do not recommend to store them. They should either be played or downloaded straight away.Caller can provide timeout parameter (in seconds) which specifies how long the request should be held before returning, if results are not ready (this is so called "long polling" technique, which reduces the number of calls needed to get the result).';
            speaker_id = voices.Greta;
            // res = getSpeech(token, text, speaker_id);
            result = getVoice(token);
            console.log('asd' + result);

        })
    });



    function replicaAuth() {
        const inputBody = 'client_id=cla55ik@yandex.ru&secret=XC7Rp@R8DBQ4_ut';
        const headers = {
            'Content-Type': 'application/x-www-form-urlencoded',
        };

        fetch('https://api.replicastudios.com/auth', {
                method: 'POST',
                body: inputBody,
                headers: headers
            })
            .then(function(res) {
                return res.json();

            }).then(function(body) {
                console.log(body);
            });
    }



    function getVoice(token) {
        const headers = {
            'Authorization': 'Bearer ' + token
        };

        fetch('https://api.replicastudios.com/voice', {
                method: 'GET',
                headers: headers
            })
            .then(function(res) {
                return res.json();
                // console.log(res);
            }).then(function(body) {
                // return body;

                console.log(body);
                let b = body;
                // let json = JSON.parse(b);
                resp = b;
                return resp;
                // console.log(resp)

            });
    }


    function getSpeech(token, text, speaker_id) {
        const headers = {
            'Authorization': 'Bearer ' + token
        };

        fetch('https://api.replicastudios.com/speech?bit_rate=320&extension=ogg&txt=' + text + '&speaker_id=' + speaker_id, {
                method: 'GET',
                headers: headers
            })
            .then(function(res) {
                return res.json();
            }).then(function(body) {
                console.log(body);
            });
    }
</script>