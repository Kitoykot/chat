<?php

namespace App;

use App\Connect;

class Room extends Connect
{
    public static function create($title)
    {
        if(str_replace(" ", "", $title) === "")
        {
            return false;
        }

        $title = htmlspecialchars($title);
        $title = trim($title);
        $title = preg_replace("#s\{2,}#", " ", $title);
        $title = addslashes($title);

        $sql = "INSERT INTO `rooms` (`title`) VALUES ('$title')";
        $query = mysqli_query(self::db(), $sql);

        return $query ? true : false;
    }

    public static function get()
    {
       $sql = "SELECT * FROM `rooms`";

       return mysqli_query(self::db(), $sql);
    }

    public static function get_room($id)
    {
        $sql = "SELECT * FROM `rooms` WHERE `id` = '$id'";
        $query = mysqli_query(self::db(), $sql);

        return mysqli_fetch_assoc($query);
    }

    public static function check_ru($room_id, $user_id)
    {
        $sql_room = "SELECT * FROM `rooms` WHERE `id` = '$room_id'";
        $query_room = mysqli_query(self::db(), $sql_room);

        if(mysqli_num_rows($query_room) < 1)
        {
            return false;
        }

        $sql_user = "SELECT * FROM `users` WHERE `id` = '$user_id'";
        $query_user = mysqli_query(self::db(), $sql_user);
        $user_room_id = mysqli_fetch_assoc($query_user);

        if(mysqli_num_rows($query_user) < 1)
        {
            return false;
        }

        if((int)$room_id !== (int)$user_room_id["room_id"])
        {
            return false;
        }

        return true;
    }
}