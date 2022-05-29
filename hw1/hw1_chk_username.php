<?php

// controlla che l'username sia unico

require_once 'dbconfig.php';

if (!isset($_GET["q"])) {
    echo "Non dovresti essere qui";
    exit;
}

header('Content-Type: application/json');

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
$username = mysqli_real_escape_string($conn, $_GET["q"]);

$query = "SELECT username FROM users WHERE username='$username'";
$res = mysqli_query($conn, $query);
/*if(mysqli_num_rows($res) > 0){
    $response = array('exists' => true);
}
else{
    $response = array('exists' => false);
}
echo json_encode($response);*/
echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false)); //se è > 0 ritorna true
mysqli_close($conn);
?>