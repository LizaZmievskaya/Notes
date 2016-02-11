<?php
    session_start();

    $user_id = $_SESSION['user_id'];

    $connect = mysqli_connect('localhost','root','') or die(mysqli_error($connect));
    mysqli_select_db($connect,'notes');
    mysqli_set_charset($connect, "utf8") or die(mysqli_error($connect));
    $id_note = $_POST['id_note'];
    $id_note = (is_array($id_note)) ? implode(",", $id_note) : $id_note;

    $query = mysqli_query($connect,"DELETE FROM note WHERE id IN ($id_note)") or die(mysqli_error($connect));
    echo json_encode(['status'=>'success']);
?>