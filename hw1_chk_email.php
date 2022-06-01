<?php

// controlla che l'email sia unica

require_once 'dbconfig.php';
// Connessione al DB
$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

// Leggo la stringa dell'email
$email = mysqli_real_escape_string($conn, $_GET["q"]);

// Costruisco la query
$query = "SELECT email FROM users WHERE email = '$email'";

// Eseguo la query
$res = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Torna un JSON con chiave exists e valore boolean
echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));

mysqli_close($conn);
?>