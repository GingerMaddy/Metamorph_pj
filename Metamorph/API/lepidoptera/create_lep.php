<?php

// includi il file con le funzioni per connettersi al db
include_once('./../librerie_comuni/db_connection.php');
//struttura generale di questi file che interagiscono con il db
//  -   controllo che la richiesta sia da post e controlla che l'utente sia connesso tramite
//      cookie di sessione, come nome utente
if ($_SERVER["REQUEST_METHOD"] == "POST") { //controllo che la HTTP request sia POST altrimenti non eseguiamo codice
    session_start(); //

    if (!isset($_SESSION['username'])) { // accesso ai dati della sessione se nome utente corretto

        die("Accesso non autorizzato."); // se non è stato impostato l'esecuzione si interrompe

    }

}

if (isset($_POST["species"]) && isset($_POST["sex"]) && isset($_POST["stage"]) && 

    isset($_POST["weight"]) && isset($_POST["length"]) && isset($_POST["user_id"]) && 

    isset($_POST["cell_id"])) {


    $species = test_input($_POST["species"]);

    $sex = test_input($_POST["sex"]);

    $stage = test_input($_POST["stage"]);

    $weight = test_input($_POST["weight"]);

    $length = test_input($_POST["length"]);

    $user_id = test_input($_POST["user_id"]);

    $cell_id = test_input($_POST["cell_id"]);

} else {

    die("Dati non forniti.");

}

// Connettere al db

$db = set_up_connection('localhost', 'Metamorph', 'Maddalena', '12345'); 


if ($db) {

    // Definisci la query di inserimento

    $query = "INSERT INTO Lepidoptera (species, sex, stage, weight, length, user_id, cell_id) 

              VALUES (:species, :sex, :stage, :weight, :length, :user_id, :cell_id)";


    // Definisci i parametri da associare ai placeholder

    $params = [

        ':species' => $species,

        ':sex' => $sex,

        ':stage' => $stage,

        ':weight' => $weight,

        ':length' => $length,

        ':user_id' => $user_id,

        ':cell_id' => $cell_id

    ];


    // Esegui la query

    $result = execute_query($query, $db, $params);

    // Controlla il risultato

    if ($result) {

        // Messaggio dettagliato con le variabili

        echo "I seguenti dati sono stati salvati nel database: 

              Specie: $species, 

              Genere: $sex, 

              Stadio: $stage, 

              Peso: $weight, 

              Lunghezza: $length, 

              ID Utente: $user_id, 

              ID Cella: $cell_id.";

    } else {

        echo "Errore durante l'aggiunta dei dati.";

    }

}

?>

