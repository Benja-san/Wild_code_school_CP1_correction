<?php
    require_once "connec.php";

    function connection(): PDO|false
    {
        try{
            $connection = new PDO(DSN, USER, PASS);
            return $connection;
        } catch(Exception $error){
            echo "Woops something went wrong, Error: " . $error->getMessage();
            return false;
        }
    }

    function getBribes(): array
    {
        $bribes = [];
        $connection = connection();
        $query = "SELECT * FROM bribe";
        $statement = $connection->query($query); 
        $bribes = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $bribes;
    }

    function getBribesByLetter(string $letter): array
    {
        $bribes = [];
        $queryByLetter="$letter%";
        $connection = connection();
        $query = "SELECT * FROM bribe WHERE name LIKE :letter";
        $statement = $connection->prepare($query);
        $statement->bindValue(':letter', $queryByLetter, PDO::PARAM_STR);
        $statement->execute();
        $bribes = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $bribes;
    }

    function addBribe($name, $payment): void
    {
        $connection = connection();
        $query = 'INSERT INTO bribe (name, payment) VALUES (:name, :payment)';
        $statement = $connection->prepare($query);
        $statement->bindValue(':name', $name, PDO::PARAM_STR);
        $statement->bindValue(':payment', $payment, PDO::PARAM_INT);
        $statement->execute();

        header("location: /book.php");
    }

    function cleanValue($value){
        $cleanValue = htmlentities(trim($value));
        return $cleanValue;
    }

    function checkEmptyValue(string $value): bool
    {
        if(!$value) return false;
        return true;
    }

    function checkMaxLength(string $value): bool
    {
        if(strlen($value) > 255) return false;
        return true;
    }

    function checkPositiveInteger($value): bool
    {
        if(!filter_var($value, FILTER_VALIDATE_INT, ["options" => ["min_range"=>0]])) return false;
        return true;
    }

    function checkEliottNess(string $value): bool
    {
        $lowerCasedValue = strtolower($value);
        if($lowerCasedValue === "eliott ness") return false;
        return true;
    }