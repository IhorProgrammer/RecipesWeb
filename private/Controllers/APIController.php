<?php

class APIController {
    protected function connect_db_or_exit(){
        try {
            $jsonString = file_get_contents('./private/config.json');
            if ($jsonString === false) {
                die("Error reading from {$configFile}");
            }
            $config = json_decode($jsonString, true);
            if ($config === null) {
                die("Error decoding JSON from {$configFile}");
            }

            $db = new PDO(sprintf("mysql:host=%s;dbname=%s;charset=utf8mb4", $config["host"], $config["db_name"]), $config["user_name"], $config["password"], [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);            
            return $db;
        } catch (PDOException $ex) {
            http_response_code( 500 );
            echo "Connection error: " . $ex->getMessage();
            exit;
        }
    }
    public function serve(){
        $method = strtolower( $_SERVER[ 'REQUEST_METHOD' ] ) ;
        $action = "do_{$method}";
        if( method_exists( $this, $action ) ) {
            // якщо визначений, то викликаємо
            return $this->$action();
        }
        else{
            $http_response_code(405);
            echo "Method Not Allowed";
        }
    }
    protected function end_with ($result) {
        header ('Content-Type: application/json');
        echo json_encode( $result );
        exit;
    }
}