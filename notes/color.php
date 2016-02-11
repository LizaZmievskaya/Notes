<?php
    $connect = mysqli_connect('localhost','root','') or die(mysqli_error($connect));
    mysqli_select_db($connect,'notes');

    $color = $_POST['color'];
    $id_note = $_POST['id_note'];

    mysqli_query($connect,"UPDATE note SET color='".$color."' WHERE id=$id_note");
    
    echo json_encode(['status'=>'success']);
?>