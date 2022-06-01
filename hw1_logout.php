<?php
// cancella i dati di sessione e ritorna alla pagina di login
session_start();
session_destroy();
header('Location: hw1_login.php');

?>