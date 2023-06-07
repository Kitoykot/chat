<?php

namespace App;

use App\Connect;

class User extends Connect
{
    public static function create($name, $room_id)
    {
        if(str_replace(" ", "", $name) === "" || str_replace(" ", "", $room_id) === "")
        {
            return false;
        }

        $name = htmlspecialchars($name);
        $name = trim($name);
        $name = preg_replace("#s\{2,}#", " ", $name);
        $name = addslashes($name);

        $room_id = htmlspecialchars($room_id);

        $db = self::db();

        $sql = "INSERT INTO `users` (`name`, `room_id`) VALUES ('$name', '$room_id')";
        $query = mysqli_query($db, $sql);

        return $query ? mysqli_insert_id($db) : false;
    }

    public static function get($id)
    {
        $sql = "SELECT * FROM `users` WHERE `id` = '$id'";
        $query = mysqli_query(self::db(), $sql);

        return mysqli_fetch_assoc($query);
    }
   
    public static function count($room_id)
    {
        $sql = "SELECT * FROM `users` WHERE `room_id` = '$room_id'";
        $query = mysqli_query(self::db(), $sql);

        return mysqli_num_rows($query);
    }
}