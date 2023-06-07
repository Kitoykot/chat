<?php
ini_set("display_errors", false);
require_once __DIR__ . "/vendor/autoload.php";

use App\Connect;
use App\Room;
use App\User;
use App\Message;

Connect::db();
?>

<!DOCTYPE html>
<html lang="en">
    <?php require_once "includes/head.php" ?>
<body>
    <?php require_once "includes/header.php" ?>

    <main>
        <div class="container">
            <?php
                if(!Room::check_ru($_GET["room_id"], $_GET["user_id"]))
                {
                ?>
                    <div class="alert alert-info mt-5" role="alert">
                        <h5>Такого чата или пользователя не существует</h5>
                    </div>   
                <?
                    die();
                }
            ?>
            <h4 class="mt-5">Комната: <?= Room::get_room($_GET["room_id"])["title"] ?></h4>

            <div class="chat mt-4">
                    <?php
                            $messages = Message::get($_GET["room_id"]);
                            $user_name = User::get($message["user_id"])["name"];
                            while($message = mysqli_fetch_assoc($messages))
                            {
                                $user_name = User::get($message["user_id"])["name"];
                            ?>
                                <div class="body-message right mt-2">
                                    <b><?= $user_name?></b>
                                    <div class="message get mt-2">
                                        <?=$message["body"]?>
                                    </div>
                                </div>
                            <?php
                            }
                    ?>
            </div>

            <form class="send-message mt-2">
                <input type="hidden" name="room_id" value="<?= $_GET["room_id"] ?>">
                <input type="hidden" name="user_id" value="<?= $_GET["user_id"] ?>">
                <input class="send_inp" type="text" placeholder="Введите сообщение" name="body" id="body">
                <button name="submit" type="submit" class="btn btn-info">Отправить</button>
            </form>

            <script>
                $(document).ready(function(){
                    $(".send-message").submit(function(e){
                        e.preventDefault();

                        var room_id = $("input[name='room_id']").val();
                        var user_id = $("input[name='user_id']").val();
                        var body = $("#body").val();

                        $.ajax({
                            type: "POST",
                            url: "send-message.php",
                            data: {
                                room_id:room_id,
                                user_id:user_id,
                                body:body,
                            }
                        });

                        var body = $("#body").val("");
                    });
                });

                $.ajax({
                    url:"get-message.php",
                    type: "POST",
                    dataType: "html",
                    data: {
                        room_id:<?=$_GET["room_id"]?>,
                        user_id:<?=$_GET["user_id"]?>
                    },
                    success: function(html)
                    {
                        $(".chat").html(html);
                    }
                });

                setInterval(function() {
                        $.ajax({
                        url:"get-message.php",
                        type: "POST",
                        dataType: "html",
                        data: {
                            room_id:<?=$_GET["room_id"]?>,
                            user_id:<?=$_GET["user_id"]?>
                        },
                        success: function(html)
                        {
                            $(".chat").html(html);
                        }
                    });
                }, 1000);
            </script>
        </div>
    </main>
</body>
</html>