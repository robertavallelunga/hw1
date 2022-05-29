
<?php
    require_once 'dbconfig.php';
    session_start();

    function isLogged(){
        GLOBAL $dbconfig;
        if(!isset($_SESSION['hw1_user_id'])) {
            return 0;
        } 
        else {
            return $_SESSION['hw1_user_id'];
        }
    }
    
?>