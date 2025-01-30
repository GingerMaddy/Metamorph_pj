<?php
session_start(); // Inizia la sessione

// Debugging: controlla se i dati POST sono ricevuti
var_dump($_POST); // Questo mostrerà i dati POST ricevuti

// Include le funzioni di connessione al database
include_once('./../librerie_comuni/db_connection.php');

// Funzione per selezionare un dato esistente
function record_select_id($db, $table, $id) {
    $query = "SELECT * FROM $table WHERE obsv_id = :id"; // Sostituisci 'id' con il nome della colonna chiave primaria
    $params = [':id' => $id];
    return execute_query($query, $db, $params);
}

// Funzione per verificare se un record esiste
function record_exists($db, $table, $id) {
    $query = "SELECT COUNT(*) FROM $table WHERE obsv_id = :id"; // Sostituisci 'id' con il nome della colonna chiave primaria
    $params = [':id' => $id];
    $result = execute_query($query, $db, $params);
    return $result[0]['COUNT(*)'] > 0; // Restituisce true se il record esiste, altrimenti false
}

// Controlla se il metodo di richiesta è POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controlla se il parametro POST richiesto è impostato
    if (isset($_POST["obsv_id"])) {
        // Sanitize input
        $obsv_id = test_input($_POST["obsv_id"]);

        // Connessione al database
        $db = set_up_connection('localhost', 'Metamorph', 'Maddalena', '12345'); 

        if (!$db) {
            die("Connessione al database fallita."); // Ferma l'esecuzione se la connessione fallisce
        }

        // Verifica se il record esiste
        if (record_exists($db, 'Celle', $obsv_id)) {
            // Definisci la query di eliminazione
            $query = "DELETE FROM Celle WHERE obsv_id = :obsv_id";

            // Definisci i parametri da associare ai segnaposto
            $params = [
                ':obsv_id' => $obsv_id
            ];

            // Esegui la query
            try {
                $result = execute_query($query, $db, $params); // Esegui la query con i parametri forniti

                // Controlla il risultato
                if ($result) {
                    echo "I dati con obsv_id $obsv_id sono stati eliminati con successo.";
                } else {
                    echo "Errore durante l'eliminazione dei dati."; // Mostra un messaggio di errore se la query fallisce
                }
            } catch (Exception $e) {
                // Cattura eventuali eccezioni e mostra il messaggio di errore
                echo "Errore durante l'esecuzione della query: " . $e->getMessage();
            }
        } else {
            echo "Nessun record trovato con obsv_id $obsv_id."; // Messaggio se il record non esiste
        }
    } else {
        die("Dati non forniti."); // Se i dati richiesti non sono forniti
    }
} else {
    die("Richiesta non valida."); // Se il metodo di richiesta non è POST
}

// Funzione sanitize input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>