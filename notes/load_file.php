<?php

$connect = mysqli_connect("localhost", "root") or die(mysqli_error($connect));
mysqli_select_db($connect, "notes") or die(mysqli_error($connect));
mysqli_set_charset($connect, "utf8") or die(mysqli_error($connect));

$id_note = $_POST['id_note'];
$files = mysqli_query($connect, "SELECT file FROM files  WHERE id_note=$id_note");

while($row=mysqli_fetch_assoc($files)){
    $a[]= $row['file'];
}

echo json_encode($a);
die;

?>