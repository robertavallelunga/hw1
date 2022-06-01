<?php
session_start();

//carica informazioni utente
include 'dbconfig.php';
$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'],$dbconfig['name']) or die(mysqli_error($conn));
$user_id=$_SESSION['hw1_user_id'];
$user_id = mysqli_real_escape_string($conn, $user_id);
$query = "SELECT * FROM users WHERE id = $user_id";
$res_1 = mysqli_query($conn, $query);
$userinfo = mysqli_fetch_assoc($res_1);

?>

<html>

   <head>
      <link rel='stylesheet' href='hw1_home.css'>
      <script src='hw1_home.js' defer> </script>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta charset="utf-8">
   
   </head>

   <body>
      <header>
         <div id="barra"><div>
            <div> <button><a href="hw1_home.php"> HOME </a></button></div>
            <div ><button class="post"> CREA POST </button></div>
         </div>
         </div>
         <div>              
            <button> <a href="hw1_logout.php"> LOG OUT </a></button>
         </div>
      </header>
         
      <main>
         <section>
            <div> Benvenuto <?php echo $_SESSION['hw1_username']; ?></div>
            <form id="films">
               <label>Film da condividere</label>
               <input type="text" name="film" id="film" />
               <input type="submit" id="submit" value="Condividi" />
            </form>

         </section>
         <section id="ris_ricerca"></section>
      </main>

   </body>
</html>