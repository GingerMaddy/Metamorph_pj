<?php
session_start(); // Inizia la sessione

// Debugging: Controlla se i dati POST sono stati ricevuti
var_dump($_POST); // Mostra i dati POST ricevuti

// Include le funzioni di connessione al database
include_once('./../librerie_comuni/db_connection.php');

// Verifica se il metodo della richiesta è POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controlla se tutti i parametri POST richiesti sono impostati
    if (isset($_POST["cell_id"]) &&
        isset($_POST["temperature"]) && 
        isset($_POST["humidity"]) &&
        isset($_POST["food"]) &&
        isset($_POST["date"]) && 
        isset($_POST["larvae_count"]) &&
        isset($_POST["pupae_count"]) &&
        isset($_POST["adult_count"]) &&
        isset($_POST["total_individuals"]) &&
        isset($_POST["total_female"]) && 
        isset($_POST["total_male"]) && 
        isset($_POST["user_id"])) {
        
        // Sanitizza l'input
        $cell_id = test_input($_POST["cell_id"]);
        $temperature = test_input($_POST["temperature"]);
        $humidity = test_input($_POST["humidity"]);
        $food = test_input($_POST["food"]);
        $date = test_input($_POST["date"]);
        $larvae_count = test_input($_POST["larvae_count"]);
        $pupae_count = test_input($_POST["pupae_count"]);
        $adult_count = test_input($_POST["adult_count"]);
        $total_individuals = test_input($_POST["total_individuals"]);
        $total_female = test_input($_POST["total_female"]);
        $total_male = test_input($_POST["total_male"]);
        $user_id = test_input($_POST["user_id"]);

        // Valida cell_id (deve essere 1, 2, 3 o 4)
        if (!in_array($cell_id, [1, 2, 3, 4])) {
            die("cell_id non valido."); // Interrompe l'esecuzione se cell_id è non valido
        }

        // Connessione al database
        $db = set_up_connection('localhost', 'Metamorph', 'Maddalena', '12345'); 

        if (!$db) {
            die("Connessione al database fallita."); // Interrompe l'esecuzione se la connessione fallisce
        }

        // Definisci la query di inserimento
        $query = "INSERT INTO Celle (cell_id, temperature, humidity, food, date, larvae_count, pupae_count, 
                adult_count, total_individuals, total_female, total_male, user_id) 
                VALUES (:cell_id, :temperature, :humidity, :food, :date, :larvae_count, :pupae_count, 
                :adult_count, :total_individuals, :total_female, :total_male, :user_id)";

        // Definisci i parametri da associare ai segnaposto
        $params = [
            ':cell_id' => $cell_id,
            ':temperature' => $temperature,
            ':humidity' => $humidity,
            ':food' => $food,
            ':date' => $date,
            ':larvae_count' => $larvae_count,
            ':pupae_count' => $pupae_count,
            ':adult_count' => $adult_count,
            ':total_individuals' => $total_individuals,
            ':total_female' => $total_female,
            ':total_male' => $total_male,
            ':user_id' => $user_id
        ];

        // Esegui la query
        try {
            $result = execute_query($query, $db, $params); // Esegui la query con i parametri forniti

            // Verifica il risultato
            if ($result) {
                echo "I seguenti dati sono stati salvati nel database: 
                    Temperatura: $temperature, 
                    Umidità: $humidity, 
                    Cibo: $food, 
                    Data: $date, 
                    Conteggio larve: $larvae_count, 
                    Conteggio pupe: $pupae_count, 
                    Conteggio adulti: $adult_count, 
                    Totale individui: $total_individuals, 
                    Totale femmine: $total_female, 
                    Totale maschi: $total_male.";
            } else {
                echo "Errore durante l'aggiunta dei dati."; // Mostra un messaggio di errore se la query fallisce
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