<?php
ini_set("display_errors", false);
require_once __DIR__ . "/vendor/autoload.php";

use App\Connect;
use App\Room;
use App\User;

Connect::db();
?>

<!DOCTYPE html>
<html lang="en">
    <?php require_once "includes/head.php" ?>
<body>
    <?php require_once "includes/header.php" ?>
    <main>
        <div class="container">
            <h4 class="mt-5">Список комнат:</h4>

            <div class="rooms mt-4">
                <?php
                    $rooms = Room::get();

                    while($room = mysqli_fetch_assoc($rooms))
                    {
                    ?>
                        <div class="room">
                            <h4><?= $room["title"] ?></h4>
                            <p>Кол-во участников: <?= User::count($room["id"]) ?></p>
                            <form action="/" method="POST">
                                <input name="room_id" type="hidden" value="<?=$room["id"]?>">
                                <input name="name" type="text" placeholder="Ваше имя">
                                <button name="submit_<?=$room["id"]?>" type="submit" class="btn btn-info mt-3">Перейти</button>
                            </form>

                            <?php
                                if(!is_null($_POST["submit_".$room["id"]]))
                                {
                                   $user = User::create($_POST["name"], $_POST["room_id"]);
                                    
                                    if($user)
                                    {
                                        header("Location: /chat.php?room_id=".$room["id"]."&user_id=".$user);
                                        die();

                                    } else {
                                    ?>
                                        <div class="alert alert-danger mt-3" role="alert">
                                            Пожалуйста, введите имя
                                        </div>
                                    <?php
                                    }
                                }
                            ?>
                        </div>
                    <?php
                    }
                ?>
            </div>
        </div>
    </main>
</body>
</html>