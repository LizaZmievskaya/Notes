<?php

session_start();

$connect = mysqli_connect("localhost", "root") or die(mysqli_error($connect));
mysqli_select_db($connect, "notes") or die(mysqli_error($connect));
mysqli_set_charset($connect, "utf8") or die(mysqli_error($connect));
$user_id = mysqli_real_escape_string($connect, $_SESSION['user_id']);
$query_string = "SELECT n.*, count(f.file) AS count FROM note AS n LEFT JOIN files AS f ON n.id=f.id_note WHERE n.id_users=$user_id GROUP BY n.id";
$query = mysqli_query($connect, $query_string);
$user_name = mysqli_fetch_assoc(mysqli_query($connect, "SELECT login FROM users  WHERE id_users=$user_id"));

?>
<!DOCTYPE>
<html>
<head>
    <title>NOTES</title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="img/note.png">
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./css/notes_style.css">
    <script src="./js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.js"></script>
</head>

<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">NOTES</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><p class="welcome">Добро пожаловать, <?=$user_name['login']?>!</p></li>
                <li><a href="#" name="exit">Выход</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
<!--КНОПКИ-->
    <div class="row">
        <input  name="accept" type="button" class="btn btn-success pull-right add" value="Применить">
        <img src="./img/colors.png" width=33px class="pull-right add img">
        <input type="color" class="pull-right add color" value="#FFFFFF">
        <input name="delete" type="button" class="btn btn-success pull-right add" value="Удалить">
        <button id="edit" type="button" class="btn btn-success pull-right add" data-toggle="modal" data-target="#editModal">Редактировать</button>
        <button id="add" type="button" class="btn btn-success pull-right add" data-toggle="modal" data-target="#myModal">Добавить</button>
    </div>
<!--ЗАМЕТКИ-->
    <div id="text" class="text-center">Нажмите кнопку "Добавить" для добавления заметки</div>
    <div class="notes row">
        <?php while ($row = mysqli_fetch_assoc($query)) { ?>
        <div class="col-md-4 note" style="background-color:<?= $row['color'] ?>" data-id="<?= $row['id'] ?>">
            <input type="checkbox" class="pull-right">
            <div><?= $row['name'] ?></div>
            <div class="content"><?= $row['content'] ?></div>
            <div class="footer">Прикрепленные файлы: <?= $row['count']?></div>
        </div>
        <?php } ?>
    </div>
</div>


<!--МОДАЛЬНОЕ ОКНО ДОБАВЛЕНИЯ-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form action="/notes/save.php" method="post" enctype='multipart/form-data'>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div id="new">Дайте название заметке</div>
                    <input name="name" id="name" type="text">
                </div>
                <div class="modal-body">
                    <textarea name="content" id="enter" placeholder="Просто начните печатать текст заметки"></textarea>
                </div>
                <div class="modal-footer">
                    <input name="attach[]" type="file" multiple>
<!--                    <button name="save" type="button" class="btn btn-success">Сохранить</button>-->
                    <input name="save" type="submit" class="btn btn-success" value="Сохранить">
                </div>
            </div>
        </form>
    </div>
</div>

<!--МОДАЛЬНОЕ ОКНО РЕДАКТИРОВАНИЯ-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form action="/notes/edit.php" method="post" enctype='multipart/form-data'>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<!--                    <div id="new">Дайте название заметке</div>-->
                    <input name="name" id="name" type="text">
                </div>
                <div class="modal-body">
                    <textarea name="content" id="enter" placeholder="Просто начните печатать текст заметки"></textarea>
                </div>
                <div class="modal-footer">
                    <input name="attach" type="file">
                    <button name="save_edit" type="submit" class="btn btn-success">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="./js/effects.js"></script>
</body>
</html>