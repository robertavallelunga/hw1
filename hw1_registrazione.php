<?php
require_once 'hw1_session.php';

if (isLogged()) {
    header("Location: hw1_home.php");
    exit;
}   


// controlla la validità dei campi inseriti e inserisce i dati nel database in caso di 
if(!empty($_POST["username"]) && !empty($_POST["password"] )&& !empty($_POST["email"]) && !empty($_POST["name"]) && !empty($_POST["surname"]) && !empty($_POST["confirm_password"])) {
    $error = array();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) {
        $error[] = "Username non valido";
    }
    else{
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $query = "SELECT username FROM users WHERE username ='".$username."'";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res) > 0) {
            $error[] = "username già esistente";
        }
    }

    if(strlen($_POST['password']) < 8) {
        $error[] = "caratteri non sufficienti";
    }

    if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) {
        $error[] = "Le password non coincidono";
    }

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $error[] = "email non valida";
    }
    else {
        $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
        $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
        if (mysqli_num_rows($res) > 0) {
            $error[] = "Email già utilizzata";
        }
    }

    // registrazione nel database
    if(count($error) == 0){
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $password = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users(username, password, name, surname, email)
        VALUES ('$username', '$password', '$name', '$surname', '$email')";
        echo $query;
        
        if(mysqli_query($conn, $query)){
            $_SESSION['hw1_username'] = $_POST['username'];
            $_SESSION['hw1_user_id'] = mysqli_insert_id($conn);
            mysqli_close($conn);
            header('Location: hw1_home.php');
            exit;
        }
        else{
            $error[] = "Errore di connessione al database";
        }
    }
    mysqli_close($conn);
}
else if (isset($_POST["username"])) {
    $error = array("Riempi tutti i campi");
}

?>

<html>
    <head>
        <link rel='stylesheet' href='hw1_registrazione.css' >       
        <script src='hw1_registrazione.js' defer> </script>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">

    </head>

    <body>
        <main>
            <section>
                <h1> Crea il tuo account </h1>
                <?php
                // verifica la presenza di errori
                if (isset($error)) {
                    for ($i=0; $i < count($error); $i++) {
                        echo "<span class'error'>$error[$i]</span>";
                    }
                }
                ?>
                <form name='registrazione' action='' method='post'>
                    
                    <div class="name">
                        <div><label for='name'> Nome  </label></div>
                        <div><input type='text' name='name'></div>
                        <span></span>
                    </div>
                    <div class="surname"> 
                        <div><label for='surname'> Cognome </label></div>
                        <div><input type='text' name='surname'></div>
                    </div>
                    <div class="username">
                        <div><label for='username'>Nome utente </label></div>
                        <div><input type='text' name='username'></div>
                        <span></span>
                    </div>

                    <div class="email">
                        <div><label for='email'>Email </label></div>
                        <div><input type='text' name='email'></div>
                        <span></span>
                    </div>

                    <div class="password">
                        <div><label for='password'>Password </label></div>
                        <div><input type='password' name='password'></div>
                        <span></span>
                    </div>

                    <div class="confirmPassword">
                        <div><label for='confirm_password'>Conferma password </label></div>
                        <div><input type='password' name='confirm_password'></div>
                        <span></span>
                    </div>

                    <div>
                        <label> <input type="submit"> </label>
                    </div>

                    <div> Hai già un account? <a href="hw1_login.php">Accedi</a> </div>

                </form>
            </section>
        </main>

    </body>

</html>