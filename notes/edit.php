<?php

$id_note = $_POST['id_note'];
$name = $_POST['name'];
$content = $_POST['content'];


$connect = mysqli_connect("localhost", "root") or die(mysqli_error($connect));
mysqli_select_db($connect, "notes") or die(mysqli_error($connect));
mysqli_set_charset($connect, "utf8") or die(mysqli_error($connect));

mysqli_query($connect,"UPDATE note SET name='$name', content='$content' WHERE id=$id_note");
    
echo json_encode(['status'=>'success']);

die;

?>