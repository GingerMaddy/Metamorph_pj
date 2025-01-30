<?php
session_start(); // Inizia sessione

// Controlla i dati POST
var_dump($_POST); // Mostra i dati POST ricevuti

// Include le funzioni di connessione al database
include_once('./../librerie_comuni/db_connection.php');

// Verifica se il metodo della richiesta è POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controlla se tutti i parametri POST richiesti sono impostati
    if (isset($_POST["lep_id"]) &&
        isset($_POST["species"]) && 
        isset($_POST["sex"]) &&
        isset($_POST["weight"]) &&
        isset($_POST["length"]) && 
        isset($_POST["stage"]) &&
        isset($_POST["obsv_id"]) &&
        isset($_POST["user_id"])) {
        
        // Sanitizza l'input
        $lep_id = test_input($_POST["lep_id"]);
        $species = test_input($_POST["species"]);
        $sex = test_input($_POST["sex"]);
        $weight = test_input($_POST["weight"]);
        $length = test_input($_POST["length"]);
        $stage = test_input($_POST["stage"]);
        $obsv_id = test_input($_POST["obsv_id"]);
        $user_id = test_input($_POST["user_id"]);

        // Valida il sesso (deve essere 'maschio', 'femmina', 'sconosciuto')
        if (!in_array($sex, ['maschio', 'femmina', 'sconosciuto'])) {
            die("Sesso non valido."); // Interrompe l'esecuzione se il sesso è non valido
        }

        // Valida lo stadio (deve essere 'uovo', 'larva', 'pupa', 'adulto')
        if (!in_array($stage, ['uovo', 'larva', 'pupa', 'adulto'])) {
            die("Stadio non valido."); // Interrompe l'esecuzione se lo stadio è non valido
        }

        // Connessione al database
        $db = set_up_connection('localhost', 'Metamorph', 'Maddalena', '12345'); 

        if (!$db) {
            die("Connessione al database fallita."); // Interrompe l'esecuzione se la connessione fallisce
        }

        // Definisci la query di inserimento
        $query = "INSERT INTO Lepidoptera (lep_id, species, sex, weight, length, stage, obsv_id, user_id) 
                  VALUES (:lep_id, :species, :sex, :weight, :length, :stage, :obsv_id, :user_id)";

        // Definisci i parametri da associare ai segnaposto
        $params = [
            ':lep_id' => $lep_id,
            ':species' => $species,
            ':sex' => $sex,
            ':weight' => $weight,
            ':length' => $length,
            ':stage' => $stage,
            ':obsv_id' => $obsv_id,
            ':user_id' => $user_id
        ];

        // Esegui la query
        try {
            $result = execute_query($query, $db, $params); // Esegui la query con i parametri forniti

            // Verifica il risultato
            if ($result) {
                echo "I seguenti dati sono stati salvati nel database: 
                      Specie: $species, 
                      Sesso: $sex, 
                      Peso: $weight, 
                      Lunghezza: $length, 
                      Stadio: $stage, 
                      ID osservazione: $obsv_id.";
            } else {
                echo  "Errore durante l'aggiunta dei dati."; // Mostra un messaggio di errore se la query fallisce
            }
        } catch (Exception $e) {
            // Cattura eventuali eccezioni e mostra il messaggio di errore
            echo "Errore durante l'esecuzione della query: " . $e->getMessage();
        }
    } else {
        die("Dati non forniti."); // Se i dati richiesti non sono forniti
    }
} else {
    die("Richiesta non valida."); // Se il metodo della richiesta non è POST
}
?>