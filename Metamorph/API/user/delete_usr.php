<?php


// includi il file con le funzioni per connettersi al db

include_once('./../librerie_comuni/db_connection.php');


// Controllo che la richiesta sia POST e che l'utente sia connesso

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    session_start();


    if (!isset($_SESSION['username'])) {

        die("Accesso non autorizzato.");

    }


// Recupera e valida l'ID dell'utente da eliminare

    if (isset($_POST["user_id"])) { // verifico che l'ID dell'utente sia valido per poterlo eliminare

        $user_id = test_input($_POST["user_id"]); // funzione test_input per pulire l'input

    } else {

        die("ID utente non fornito.");

    }

}

// Connettere al db

$db = set_up_connection('localhost', 'Metamorph', 'Maddalena', '12345'); 

if ($db) {

// Controlla se l'utente esiste

    if (record_exists($db, 'Users', $user_id)) {

// Utilizza la funzione record_select_id per recuperare i dati dell'utente

        $user_data = record_select_id($db, 'Users', $user_id);

        

// Definisci la query di eliminazione

        $query_delete = "DELETE FROM Users WHERE user_id = :user_id";

        $params_delete = [':user_id' => $user_id];

        

// Esegui la query di eliminazione

        $result = execute_query($query_delete, $db, $params_delete);

    } else {

        die("Nessun utente trovato con ID $user_id."); // Gestione dell'errore se non esiste

    }

}

// Controlla il risultato

if ($result) {

// Mostra un messaggio di conferma, ma senza dati personali sensibili

    echo "L'utente è stato eliminato con successo.";

} else {

    echo "Errore durante l'eliminazione dell'utente.";

}


?>