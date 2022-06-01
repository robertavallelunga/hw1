<?php
    // Inserisce nel database il post da pubblicare 

    require_once 'dbconfig.php';
    header('Content-Type: application/json');
    session_start();
 
    if(!isset($_SESSION['hw1_user_id'])) {
        header("Location: hw1_login.php");
        exit;
    } 
    
    $userid = $_SESSION['hw1_user_id'];
    $username = $_SESSION['hw1_username'];
    $film = $_POST['film'];
    $url = $_POST['poster'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER  , true);
    curl_setopt($ch, CURLOPT_NOBODY  , true);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $res = curl_exec($ch);
    $status = curl_getinfo ($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);    

    if ($status == 200) {
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $userid = mysqli_real_escape_string($conn, $userid);
        $film = mysqli_real_escape_string($conn, $film);
        $url = mysqli_real_escape_string($conn, $url);
        $query = "INSERT INTO posts(user, content) VALUES('.$userid.', JSON_OBJECT('url', '$url', 'film', '$film'))";
        if(mysqli_query($conn, $query) or die(mysqli_error($conn))) {
            echo json_encode(array('ok' => true));
            exit;
        }
        
    }

    echo json_encode(array('ok' => false));

?>