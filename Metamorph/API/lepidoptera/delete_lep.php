<?php


// includi il file con le funzioni per connettersi al db

include_once('./../librerie_comuni/db_connection.php');


// Controllo che la richiesta sia POST e che l'utente sia connesso

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    session_start();


    if (!isset($_SESSION['username'])) {

        die("Accesso non autorizzato.");

    }


// Recupera e valida l'ID del Lepidoptera da eliminare

    if (isset($_POST["lep_id"])) { // verifico che l'ID del Lepidoptera sia valido per poterlo eliminare

        $lep_id = test_input($_POST["lep_id"]); // funzione test_input per pulire l'input

    } else {

        die("ID Lepidoptera non fornito.");

    }

}
// Connettere al db

$db = set_up_connection('localhost', 'Metamorph', 'Maddalena', '12345'); 


if ($db) {

// Controlla se il Lepidoptera esiste

    if (record_exists($db, 'Lepidoptera', $lep_id)) {

// Utilizza la funzione record_select_id per recuperare i dati di Lepidoptera

        $lep_data = record_select_id($db, 'Lepidoptera', $lep_id);

        
 // Definisci la query di eliminazione

        $query_delete = "DELETE FROM Lepidoptera WHERE lep_id = :lep_id";

        $params_delete = [':lep_id' => $lep_id];

        

// Esegui la query di eliminazione

        $result = execute_query($query_delete, $db, $params_delete);

    } else {

        die("Nessun Lepidoptera trovato con ID $lep_id."); // Gestione dell'errore se non esiste

    }

}

// Controlla il risultato

if ($result) {

// Mostra un messaggio di conferma con i dati Lepidoptera eliminato

    echo "Lepidoptera con ID " . $lep_data[0]['lep_id'] . " è stato eliminato con successo.<br>";

    echo "Dettagli del Lepidoptera eliminato:<br>";

    echo "Specie: " . $lep_data[0]['species'] . "<br>";

    echo "Genere: " . $lep_data[0]['sex'] . "<br>";

    echo "Stadio: " . $lep_data[0]['stage'] . "<br>";

    echo "Peso: " . $lep_data[0]['weight'] . "<br>";

    echo "Lunghezza: " . $lep_data[0]['length'] . "<br>";

    echo "ID Utente: " . $lep_data[0]['user_id'] . "<br>";

    echo "ID Cella: " . $lep_data[0]['cell_id'] . "<br>";

} else {

    echo "Errore durante l'eliminazione Lepidoptera.";

}

?>
