<?php 
    session_start();


    $host  = $_SERVER['HTTP_HOST'];
    $name = $_POST['name'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $connect = mysqli_connect('localhost','root','') or die(mysqli_error($connect));
    mysqli_select_db($connect,'notes');
    mysqli_set_charset($connect, "utf8") or die(mysqli_error($connect));
    mysqli_query($connect,"INSERT INTO note VALUES ('','$name','$content','$user_id','')");
    $id_note = mysqli_insert_id($connect);

    if(!empty($_FILES['attach']['tmp_name'])){
        $files = $_FILES['attach'];
        $count_files = count($files['name']);
        $upload_dir = __DIR__ . "/img/uploads/";
        for ($i=0; $i<$count_files; $i++){
            $new_filename = md5(microtime(true) . $user_id . $files['name'][$i]);
            $type = explode("/",$files["type"][$i]);
            $new_file = $new_filename . "." . $type;
            move_uploaded_file($files["tmp_name"][$i],$upload_dir . $new_file);
            $new_file = '/img/uploads/'.$new_file;
            mysqli_query($connect,"INSERT INTO files VALUES ('','$id_note','$new_file')");
        }
    }

    header("Location: http://" . $host."/notes/notes.php");

?>