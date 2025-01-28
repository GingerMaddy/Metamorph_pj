<?php

// includi il file con le funzioni per connettersi al db
include_once('./../librerie_comuni/db_connection.php');
//struttura generale di questi file che interagiscono con il db
//  -   controllo che la richiesta sia da post e controlla che l'utente sia connesso tramite
//      cookie di sessione, come nome utente
//if ($_SERVER["REQUEST_METHOD"] == "POST") { //controllo che la HTTP request sia POST altrimenti non eseguiamo codice
    //session_start(); //

    

  //  if (!isset($_SESSION['username'])) { // accesso ai dati della sessione se nome utente corretto

 //       die("Accesso non autorizzato."); // se non è stato impostato l'esecuzione si interrompe

   // }




   if (!isset($_SESSION['user_id'])) {

    // Imposta un ID utente fittizio o un valore predefinito

    $_SESSION['user_id'] = 1; // Puoi usare un valore predefinito o generare un ID unico

    $_SESSION['username'] = 'Visitatore'; // Imposta un nome utente predefinito

}


// Ora puoi utilizzare $_SESSION['user_id'] e $_SESSION['username'] nel tuo codice

echo "Benvenuto, " . $_SESSION['username'] . "!";









    //************************** ESEMPIO********************************* */
    //  -   se l'utente doveva mandarti dei dati necessari per l'operazione da lui richiesta e
    //      assicurati non siano input malevoli
    /*    if (isset($_POST["nome_animale"])) { // controlliamo se il campo "nome_animale" è inserito nel modulo

            $esempio_nome_animale = test_input($_POST["nome_animale"]); //se il nome è presente l'operazione va a buon fine (pulendo prima il codice con test input, impostato in db_connection e evocato qui)

        } else {

            die("Nome animale non fornito."); // altrimenti l'operazione si sospende}
        
    *********************************************/ 

    // Recupera e valida i dati inviati

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
        isset($_POST["user_id"]))
        {

    
// validare e pulire input
        $cell_id = test_input($_POST["cell_id"]); // Sanitize cell_id

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


    } else {

            die("Dati non sforniti.");

    }
//********************************************* */
    // Validate cell_id (must be 1, 2, 3, or 4)
   // Validate cell_id (must be 1, 2, 3, or 4)

if (!in_array($cell_id, [1, 2, 3, 4])) {

    die("cell_id non valido."); // Stop execution if cell_id is invalid

}

//*********************************************************** */
//} // chiusura riga 8


    //  -   connettere al db con set_up_connection che restituirà un oggetto di connessione $db
    $db = set_up_connection('localhost', 'Metamorph', 'Maddalena', '12345'); 

//********************************** */
//  -   costruire la query 
    if (!$db) { die("Connessione al database fallita."); // Stop execution if the connection fails

    }

//********************************** */


        // Definisci la query di inserimento

 /*       // Funzione per generare un cell_id unico
        function generate_unique_cell_id($db) {

            $new_cell_id = 1; // Inizia da 1 o da un altro valore base

            while (record_exists($db, 'Celle', 'cell_id', $new_cell_id)) {

                $new_cell_id++; // Incrementa fino a trovare un ID unico

            }

            return $new_cell_id; // Restituisce il cell_id unico

        }

         // Genera un cell_id unico
            $unique_cell_id = generate_unique_cell_id($db);
        */
            //TODO: errore nella query

        $query = "INSERT INTO Celle (cell_id, temperature, humidity, food, date, larvae_count, pupae_count, 

                adult_count, total_individuals, total_female, total_male, user_id) 

                VALUES (:cell_id,:temperature, :humidity, :food, :date, :larvae_count, :pupae_count, 

                :adult_count, :total_individuals, :total_female, :total_male, :user_id)";

        // Definisci i parametri da associare ai placeholder

        $params = [
            ':cell_id' => $cell_id, // deve essere univoco

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

            ':user_id' => $_SESSION ['user_id']

        ];

    //TODO: l'errore probabilmente è qui  


// - Esegui la query

try {

    $result = execute_query($query, $db, $params); // Execute the query with the provided parameters


    // Controlla il risultato

    if ($result) {

        // Messaggio dettagliato con le variabili

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
?>