<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);




##############
### API for https://replicastudios.com/
##############

/****
** Используем стандартные методы API https://replicastudios.com/
**  1. Сначала получаем API key методом getAuth - аргументы login и pass - логин и пароль от учетной записи на https://replicastudios.com/
**    Полученный API key действует в течение 1 часа, затем нужно сгенерировать новый
** 
**  2. Метод getVoice отдает список всех доступных голосов  
**
**  3. Метод getSpeech запускает генерацию озвучки и возвращает информацию о готовом файле. 
**     Чтобы получить ссылку на файл обращаемся к полю $array->urls->ogg;      
        // $speech = getSpeech($token, $text, $speaker_id);
        // $url_ogg = $speech->urls->ogg;
**
**  4. Метод getAllVoicesSample - генерирует и сохраняет примеры озвучки для всех голосов
****/

/** Пример реализации:
 * Получаем API token
 * 
 * $token = getAuth($login, $pass); //Токен API полученный методом getAUTH
 * 
 */

############

function getAuth($login, $pass)  // Генерация Api токена для авторизации. Для генерации используем логин и пароль от своего аккаунта на https://replicastudios.com/
{

    $headers = ["Content-Type': 'application/x-www-form-urlencoded"];

    $queryParams = [
        'client_id' => $login,
        'secret' => $pass,
    ];


    $url = "https://api.replicastudios.com/auth";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $queryParams);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $content = curl_exec($ch);
    $array = json_decode($content);
    curl_close($ch);
    return $array->access_token;  // Возвращаем API token
}

function getVoice($token)  // Получаем список доступных голосов 
{
    $headers = ["Authorization: Bearer {$token}"];
    $url = 'https://api.replicastudios.com/voice';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $content = trim(curl_exec($ch));
    $array = json_decode($content);
    curl_close($ch);
    return $array;
}


function getSpeech($token, $text, $speaker_id)  // Генерация озвучки методом API getSpeech
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
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $content = curl_exec($ch);
    $array = json_decode($content);
    curl_close($ch);
    return $array;
}





function getAllVoicesSample($login, $pass)  // Генерируем и сохраняем все образцы озвучки
{
    $text = 'Note: the returned URL will expire after few days so we do not recommend to store them.';
    $token = getAuth($login, $pass);
    $voices = getVoice($token); //Получаем список доступных голосов

    $voices_arr = [];   // Переформатируем ответ API в удобный массив  $arr([name=>'speaker_name', uuid=>'voice_uid']) 
    $n = 1;
    foreach ($voices as $voice) {
        $name = str_replace([" ", "-"], "", $voice->name);
        $voices_arr[$n] = ["name" => $name, 'uuid' => $voice->uuid];
        $n++;
    }


    $path = $_SERVER['DOCUMENT_ROOT'] . "/replica"; //Папка на сервере для сохранения сгенерированных примеров озвучки
    if (!file_exists($path . "/voices")) {
        mkdir($path . "/voices", 0775);
    }

    foreach ($voices_arr as $name => $speaker_id) {   // Генерируем и сохраняем образцы озвучки
        $speech = getSpeech($token, $text, $speaker_id);

        $url_ogg = $speech->urls->ogg;

        $soundfile = file_get_contents($url_ogg);
        $path_file = $path . "/voices/{$name}.ogg";
        $file = fopen($path_file, "w");
        fwrite($file, $soundfile);
        fclose($file);
    }

    return 'DONE';
}


?>
