<?php

/*
$host = 'localhost'; // Nome host
$dbname = 'Metamorph'; // Nome del tuo database
$username = 'Maddalena'; // Nome utente MySQL
$password = '12345'; // Password MySQL
*/

/**
 * una funzione in cui dai come parametri:
 *  -   host    :indirizzo della macchina che ha il Database
 *  -   dbname  :il nome del database a cui vuoi accedere
 *  -   username:il nome dell'utente con cui vuoi accedere al Database
 *  -   password:la password associata all'utente
 * restituisce un oggetto tramite cui puoi eseguire operazioni sul database
 * di nome dbname
 */
function set_up_connection($host, $dbname, $username, $password) {
    // Abilita la segnalazione degli errori
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    try {
        // Crea una nuova istanza PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Imposta il modo di errore di PDO su eccezione
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connessione al database riuscita!"; // Messaggio di conferma della connessione
        return $pdo;
    } catch (PDOException $e) {
        // Gestisci gli errori di connessione
        echo "Connessione fallita: " . $e->getMessage(); // Mostra il messaggio di errore
        return NULL;
    }
}

/**
 * esegue la query nel DB dato con la funzione sopra
 * e eventualemente restituisce il risultato ottenuto
 * function execute_query($query, $db, $params) {
 * // configura l'operazione in modo tale da restituire gòli errori
 * $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 * // se la query restituisce qualcosa te la restituisce
 * $result = $db->query($query);
 * return $result;}
 */
function execute_query($query, $db, $params) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Prepara la query
    $stmt = $db->prepare($query);
    // Esegui la query con i parametri
    $stmt->execute($params);
    // Restituisce l'oggetto statement
    return $stmt; 
}

# prepara la stringa di dati, 
# NECCESSARIO per la sicurezza, 
# evita attacchi di SQL injection
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

# funzione per selezionare un dato esistente prima di leggerlo, eliminarlo o aggiornarlo 
# quindi da utilizzare in read.php, delete.php,update.php
function record_exists($db, $table, $id) {
    $query = "SELECT COUNT(*) FROM $table WHERE id = :id"; // Sostituire 'id' con il nome della colonna chiave primaria (es. id = cell_id)
    $params = [':id' => $id]; # colonna id corrispondente a var id
    $result = execute_query($query, $db, $params);
    return $result[0]['COUNT(*)'] > 0; // Restituisce true se il record esiste, se no false 
}

# funzione per selezionare un dato esistente prima di leggerlo, eliminarlo o aggiornarlo 
# quindi da utilizzare in read.php, delete.php,update.php
function record_select_id($db, $table, $id) {
    $query = "SELECT * FROM $table WHERE id = :id"; // Sostituire 'id' con il nome della colonna chiave primaria (es. id = cell_id)
    $params = [':id' => $id]; # colonna id corrispondente a var id
    return execute_query($query, $db, $params);
}
?>