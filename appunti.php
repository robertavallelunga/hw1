 <?php
 /*
tutti i campi settati-->se sono tutti settati
 si passa al singolo controllo dei campi ad esempio username,password,email che devono rispettare certi vincoli
 (si costruisce la query e la si esegue se è maggiore di zero ,l'utente gia esiste quindi errore)
 se il vettore di errore non contiene niente possiamo fare la querry di inserimento  e la eseguiamo,se torna 
 una valore diverso da false si imposta una variabile di sessione per indirizzare l'utente alla home page senza farlo accedere
 
 si controlla anche lato client per notificare all'utente la presenza di errore nei form compilati
 lato client una sequenza di event listener 'blur' ad esempio checkursername in funzione di ciò
 
 checkusername primo controllo sul pattern 
 dell'espressione come nel server se va bene controllo eseguiamo ilcheckusername passando il valore dpresente nel formc con fetch

 si fa la conessione si scrive la query da controllare si esegue e se restituisce almeno una riga 
 vuol dire che l'utente gia esiste, si impaccheta questo risultato in un json e si rimanda insieme
 
javascript gestira i casi di errori in base al risultato della promise restituita

stesso controllo per checkemail ---> vedere se esiste email 

pagina di login
abbiamo il form html per passare i valori
is che controllo che siano settati username e password
vedere se username è assocciato ad un utente nel database e poi verificare che la password sia corretta
si leggono username e password passati si scrive la querry e la si esegue se ritorna un nummero d
i righe maggiore di zero allora l'utente esiste e si fa il controllo della password
confronto tra password attraverso password verify
si memorizzano le variabili di sessioe e si reindirizza alla home

logout
session start --->senza non avremo accesso alle variabili di sessione
session destroy
reindirizzamento alla login

pagina home
caricare le informazioni dell' utente e visualizzarle da qualche parte 
successivamente caricare tutti i posst 
definire la conessione col db
si prende username dalla variabile di sessione
si prende una serie di informazioni nome cognome ecc si esegue la query e andiamo 
amemorizzare il risulato se è maggiore di zero si memorizza in una variabile $userifo cio che ci torna la querry
le informazioni si useranno nell'html per visualizzarle
caricamento post
implementazione tramiste javascript attraverso fetchpost che carichera tutti i post del db
si fa la fetch e si gestisce la risposta 
fetchpost--> conn al db, si fa la query e si esegue 

likepost --> inseriamo nella tabella like attraverso fetch ad un file php mandiamo l'id del post a cui 
il nostro utente vuole mettere like e l'user id si prende dallae variabili di sessione
nella tabella like si inserisce id del post e dell'utente 
il numer odi like nella tabella post sarà incrementatto dal trigger dopo l'inserimetn odel like 


funzione per la ricerca del contenuto tramite api 
aoccoiamo all'evento submit la funzione search
quattro input di tipo radio e asi andra a leggere il valore selezionato passandolo a lserver 
insieme al contenuto della barra di testo
funzione giphy  ----> $apikey="1223"  ----> $url="endpoint".$_get['q']."&type=".$_GET[]
$ch=curl_init($url)
curl_sepopt($ch,CURLOPT_RETURNTRANSFER,1)
$data =curl_exec($ch);
echo json_ecode($data;
   oppure  $json=json__decode e scorrere l'array e infine restituire  il json encodando quello che si è costruito dentro il for

caio e sempronio sono due amici
sempronio pero vuole abbandonare caio in farore di lucia una donna proveninete dal nord
lucoia in realta è la sorella di sempronio e caio e diventato un personaggio in secondo piano quindi si uccide
fai come caio e ammazzati brv.
plot twist in realta caio era fratello di abele e quindi erede della dinastai degli azus futuri fautori dei pc asus 
komi non sa communicare 
tadano hitoito la aiuta 
komi si innamora 
spunta la gyaru manubu 
tadano da chad la fa innamorare 
triangolo amoroso 
komi e cosa diventano amichi ma entrambbe puntatno lo stesso ragazzo
in  una recita komi dice ti amo seguendo il copione e l'altraragazza 
 capisce che sono i suoi reali sentimenti .

)












  */
 
 
 
 ?>



<html >

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>m