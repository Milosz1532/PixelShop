<?php
class Database {
    private $host = 'localhost';
    private $username = 'root'; 
    private $password = ''; 
    private $database = 'pixel'; 
    private $connection; // Połączenie z bazą danych


    public function DBConnect() {
        //Tworzenie połączenia z bazą danych
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        $this->connection->set_charset("utf8");
        // Sprawdzenie czy połączenie zostało utworzone poprawnie
        if ($this->connection->connect_error) {
            die('Błąd połączenia z bazą danych: ' . $this->connection->connect_error);
        }
    }


    public function executeQuery($query, $params = array()) {
        // Przygotowanie zapytania SQL
        $stmt = $this->prepareStatement($query, $params);

        // Wykonanie zapytania SQL
        $stmt->execute();

        // Pobranie wyniku zapytania SQL
        $result = $stmt->get_result();

        // Zwrócenie wyniku zapytania SQL w postaci tablicy asocjacyjnej
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function executeInsert($table, $data) {
        $fields = implode(',', array_keys($data));
        $placeholders = rtrim(str_repeat('?,', count($data)), ',');
        $values = array_values($data);
        $query = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $stmt = $this->prepareStatement($query, $values);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public function executeUpdate($table, $data, $conditions) {
        $setClause = '';
        $whereClause = '';
        $params = array();
        foreach ($data as $key => $value) {
            $setClause .= "$key = ?,";
            $params[] = $value;
        }
        foreach ($conditions as $key => $value) {
            $whereClause .= "$key = ? AND ";
            $params[] = $value;
        }
        $setClause = rtrim($setClause, ',');
        $whereClause = rtrim($whereClause, ' AND ');
        $query = "UPDATE $table SET $setClause WHERE $whereClause";
        $stmt = $this->prepareStatement($query, $params);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function executeDelete($table, $conditions) {
        $whereClause = '';
        $params = array();
        foreach ($conditions as $key => $value) {
            $whereClause .= "$key = ? AND ";
            $params[] = $value;
        }
        $whereClause = rtrim($whereClause, ' AND ');
        $query = "DELETE FROM $table WHERE $whereClause";
        $stmt = $this->prepareStatement($query, $params);
    
        if (!$stmt->execute()) {
            throw new Exception("Błąd podczas usuwania kategorii."); 
        }
    
        return $stmt->affected_rows;
    }
    

    public function fetchOne($query, $params = array()) {
        // Przygotowanie zapytania SQL
        $stmt = $this->prepareStatement($query, $params);
    
        // Wykonanie zapytania SQL
        $stmt->execute();
    
        // Pobranie wyników zapytania
        $result = $stmt->get_result();
    
        // Sprawdzenie czy zapytanie zwróciło wyniki
        if ($result->num_rows > 0) {
            // Przepisanie wyników do tablicy asocjacyjnej
            $row = $result->fetch_assoc();
            // Zwrócenie pojedynczego rekordu
            return $row;
        } else {
            return false; // zapytanie nie zwróciło żadnych wyników
        }
    }

    public function fetchAll($query, $params = array(), $limit = -1) {
        // Przygotowanie zapytania SQL
        $stmt = $this->prepareStatement($query, $params);

        // Wykonanie zapytania SQL
        $stmt->execute();

        // Pobranie wyników zapytania
        $result = $stmt->get_result();

        // Sprawdzenie czy zapytanie zwróciło wyniki
        if ($result->num_rows > 0) {
            // Przepisanie wyników do tablicy asocjacyjnej
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            // Zwrócenie wszystkich lub wybranych rekordów
            if ($limit == -1) {
                return $rows; // zwraca wszystkie rekordy
            } else {
                return array_slice($rows, 0, $limit); // zwraca wybrane rekordy
            }
        } else {
            return false; // zapytanie nie zwróciło żadnych wyników
        }
    }

    public function prepareStatement($query, $params) {
        // Wywołanie metody prepare na obiekcie połączenia z bazą danych
        $statement = $this->connection->prepare($query);

        // Sprawdzenie, czy udało się poprawnie przygotować zapytanie SQL
        if (!$statement) {
            // W przypadku błędu, rzucenie wyjątku z informacją o błędzie
            throw new Exception('Błąd przygotowania zapytania SQL: ' . $this->connection->error);
        }

        // Sprawdzenie, czy zapytanie SQL zawiera parametry
        if (!empty($params)) {
            // Stworzenie pustej tablicy na typy parametrów
            $types = '';

            // Iteracja po parametrach zapytania SQL
            foreach ($params as $param) {
                // Określenie typu parametru na podstawie jego typu danych
                if (is_int($param)) {
                    $types .= 'i'; // typ int
                } elseif (is_float($param)) {
                    $types .= 'd'; // typ double
                } elseif (is_string($param)) {
                    $types .= 's'; // typ string
                } else {
                    $types .= 'b'; // typ blob
                }
            }

            // Utworzenie tablicy z referencjami do parametrów zapytania SQL
            $paramsReferences = array();
            foreach ($params as $key => $value) {
                $paramsReferences[$key] = &$params[$key];
            }

            // Wywołanie metody bind_param na przygotowanym zapytaniu SQL, przekazując typy parametrów oraz referencje do wartości parametrów
            $bindParams = array_merge(array($types), $paramsReferences);
            call_user_func_array(array($statement, 'bind_param'), $bindParams);
        }

        // Zwrócenie przygotowanego zapytania SQL
        return $statement;
    }

    
    


}

?>