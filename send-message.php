<?php
require_once __DIR__ . "/vendor/autoload.php";

use App\Connect;

$room_id = $_POST["room_id"];
$user_id = $_POST["user_id"];
$body = $_POST["body"];

$room_id = htmlspecialchars($room_id);
$user_id = htmlspecialchars($user_id);
$body = htmlspecialchars($body);
$body = trim($body);

$sql = "INSERT INTO `messages` (`room_id`, `user_id`, `body`) VALUES ('$room_id', '$user_id', '$body')";
$query = mysqli_query(Connect::db(), $sql);

return $query ? true : false;