<?php
session_start(); // Start the session

// Debugging: Check if POST data is received
var_dump($_POST); // This will show the received POST data

// Include the database connection functions
include_once('./../librerie_comuni/db_connection.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required POST parameters are set
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

        // Sanitize input
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

        // Validate cell_id (must be 1, 2, 3, or 4)
        if (!in_array($cell_id, [1, 2, 3, 4])) {
            die("cell_id non valido."); // Stop execution if cell_id is invalid
        }

        // Connect to the database
        $db = set_up_connection('localhost', 'Metamorph', 'Maddalena', '12345'); 

        if (!$db) {
            die("Connessione al database fallita."); // Stop execution if the connection fails
        }

        // Define the insert query
        $query = "INSERT INTO Celle (cell_id, temperature, humidity, food, date, larvae_count, pupae_count, 
                adult_count, total_individuals, total_female, total_male, user_id) 
                VALUES (:cell_id, :temperature, :humidity, :food, :date, :larvae_count, :pupae_count, 
                :adult_count, :total_individuals, :total_female, :total_male, :user_id)";

        // Define parameters to bind to the placeholders
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

        // Execute the query
        try {
            $result = execute_query($query, $db, $params); // Execute the query with the provided parameters

            // Check the result
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
            echo "Errore durante l'aggiunta dei dati."; // Display an error message if the query fails
            }
        } catch (Exception $e) {
            // Catch any exceptions and display the error message
            echo "Errore durante l'esecuzione della query: " . $e->getMessage();
        }
    } else {
        die("Dati non sforniti."); // If required data is not provided
    }
} else {
    die("Richiesta non valida."); // If the request method is not POST
}
?>