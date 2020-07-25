<?php
// Load composer
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');


$db_host = "localhost";
$db_user = "sammy"; // Логин БД
$db_password = "lazyb0y2020!"; // Пароль БД
$db_base = 'new'; // Имя БД
$db_table = "admin_users"; // Имя Таблицы БД
$baseUrl = "https://demo.noti.by";

// Подключение к базе данных
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_base);



use Telegram\Bot\Api;

$telegram = new Api('1177756837:AAEaUyDfrCoaERgqEYUpRgf4hDN8fm_vaTM');
$result = $telegram->getWebhookUpdates();

$text = $result["message"]["text"];
$chat_id = $result["message"]["chat"]["id"];
$name = $result["message"]["from"]["username"];
$first_name = $result["message"]["from"]["first_name"];
$last_name = $result["message"]["from"]["last_name"];

if ($text == "hello") {
    $reply = "hello" . $first_name . " " . $last_name;
    $telegram->sendMessage(["chat_id" => $chat_id, 'text' => $reply]);
}

if (substr($text, 0, 6) == '/start')
{
    $token=substr($text, 7, strlen($text));
    $mysqli->query("UPDATE `admin_users` SET `chat_id` = '$chat_id' WHERE `password_reset_token` ='$token'");
    $reply = $baseUrl.'/user/reset-password?token='.$token;
    $telegram->sendMessage(["chat_id" => $chat_id, 'text' => $reply]);
}



