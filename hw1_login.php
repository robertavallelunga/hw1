<?php
// gestisci sessione già attiva
session_start();


include 'dbconfig.php';
    // controllo che esista un utente con quelle credenziali
    if(isset($_POST['username'])&&isset($_POST['password'])){
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $query = "SELECT id, username, password FROM users WHERE username='$username'";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res) > 0) {
            $entry = mysqli_fetch_assoc($res);

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            if (password_verify($password, $hashed_password)) {
                $_SESSION['hw1_username'] = $entry['username'];
                $_SESSION['hw1_user_id'] = $entry['id'];
                header('Location: hw1_home.php');
                mysqli_close($conn);
                exit;
            }
            else {
                echo "Password non esistemnte";
            }
        }
    }
    

?>

<html>
    <head>
        <link rel='stylesheet' href=' hw1_login.css' >       
       

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">

    </head>

    <body>
        <main>
            <section>
                <h1> Accedi </h1>
                <form name='' action='' method='post'>
                    
                        <div>
                            <label for = "username"> Username <input type='text' name='username'></label> 
                        </div>

                        <div>
                            <label> Password <input type='password' name='password'> </label>
                        </div>

                        <div>
                            <label> <input type="submit"> </label>
                    
                    </div>
                </form>
                Non hai un account? <a href="hw1_registrazione.php">Registrati</a>
            </section>
           


        </main>


    </body>

</html>