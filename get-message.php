<?php

require_once __DIR__ . "/vendor/autoload.php";

use App\Connect;
use App\User;

$room_id = $_POST["room_id"];
$user_id = $_POST["user_id"];


$sql = "SELECT * FROM `messages` WHERE `room_id` = '$room_id'";
$query = mysqli_query(Connect::db(), $sql);

$messages = [];

while($message = mysqli_fetch_assoc($query))
{
    $messages[] = $message;
}

$html = "";

foreach($messages as $item)
{
    $user_name = User::get($item["user_id"])["name"];
    $message_body = $item["body"];
    $item_user_id = $item["user_id"];

    $html .= '<div class="body-message right mt-2">
                <b>' . $user_name . '</b>
                <div class="message get mt-2">
                    '.$message_body.'
                </div>
            </div>';
}

echo $html;