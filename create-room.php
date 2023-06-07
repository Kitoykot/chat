<?php
ini_set("display_errors", false);
require_once __DIR__ . "/vendor/autoload.php";

use App\Connect;
use App\Room;

Connect::db();
?>

<!DOCTYPE html>
<html lang="en">
    <?php require_once "includes/head.php" ?>
<body>
    <?php require_once "includes/header.php" ?>

    <main>
        <div class="container">
            <h4 class="mt-5">Создать комнату:</h4>

            <form class="create-room mt-4" method="POST" action="create-room.php">
                <input name="title" type="text" placeholder="Название комнаты">
                <button type="submit" name="submit" class="btn btn-info mt-3">Создать</button>
            </form>
            <?php
                if(!is_null($_POST["submit"]))
                {
                  $room = Room::create($_POST["title"]);
                ?>
                    <div class="alert alert-<?= $room == true ? "success" : "danger" ?> mt-3" role="alert">
                        <?= $room == true ? "Комната успешно создана" : "Ошибка при создании комнаты" ?>
                    </div>
                <?
                }
            ?>
        </div>
    </main>
</body>
</html>