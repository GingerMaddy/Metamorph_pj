<?php

// includi il file con le funzioni per connettersi al db
include_once('./../librerie_comuni/db_connection.php');



// Controllo che la richiesta sia da POST e che l'utente sia connesso
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    if (!isset($_SESSION['username'])) {
        die("Accesso non autorizzato.");
    }

    // Recupera e valida l'ID della cella da eliminare
    if (isset($_POST["cell_id"])) { // verifico che l'ID della cella sia valido per poterlo eliminare
        $cell_id = test_input($_POST["cell_id"]); // Assicurati di avere una funzione test_input per pulire l'input
    } else {
        die("ID della cella non fornito.");
    }
}

// Connettere al db
    $db = set_up_connection('localhost', 'Metamorph', 'Maddalena', '12345'); 

    if ($db) {
// Prima di eliminare, potresti voler recuperare i dati della cella
// Controlla se la cella esiste
        if (record_exists($db, 'Celle', $cell_id)) {
// Utilizza la funzione record_select_id per recuperare i dati della cella
        $cell_data = record_select_id($db, 'Celle', $cell_id);
// Definisci la query di eliminazione
     $query_delete = "DELETE FROM Celle WHERE cell_id = :cell_id";
     $params_delete = [':cell_id' => $cell_id];
// Esegui la query di eliminazione

    $result = execute_query($query_delete, $db, $params_delete);

    } else {

        die("Nessuna cella trovata con ID $cell_id."); // Moved else here

    }

}



// Controlla il risultato

if ($result) {

// Mostra un messaggio di conferma con i dati della cella eliminata

    echo "La cella con ID " . $cell_data[0]['cell_id'] . " è stata eliminata con successo.<br>";

    echo "Dati della cella eliminata:<br>";

    echo "Temperatura: " . $cell_data[0]['temperature'] . "<br>";

    echo "Umidità: " . $cell_data[0]['humidity'] . "<br>";

    echo "Cibo: " . $cell_data[0]['food'] . "<br>";

    echo "Data: " . $cell_data[0]['date'] . "<br>";

    echo "Conteggio larve: " . $cell_data[0]['larvae_count'] . "<br>";

    echo "Conteggio pupe: " . $cell_data[0]['pupae_count'] . "<br>";

    echo "Conteggio adulti: " . $cell_data[0]['adult_count'] . "<br>";

    echo "Totale individui: " . $cell_data[0]['total_individuals'] . "<br>";

    echo "Totale femmine: " . $cell_data[0]['total_female'] . "<br>";

    echo "Totale maschi: " . $cell_data[0]['total_male'] . "<br>";

} else {

    echo "Errore durante l'eliminazione della cella.";

}

?>