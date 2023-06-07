<?php

namespace App;

use App\Connect;

class Message extends Connect
{
    public static function get($room_id)
    {
        $sql = "SELECT * FROM `messages` WHERE `room_id` = '$room_id'";
        
        return mysqli_query(self::db(), $sql);
    }
}