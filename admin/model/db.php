<?php

class dbModel
{
    private $dsn = "mysql:host=localhost;dbname=carsdekho";
    private $username = "root";
    private $password = "";
    public $pdo;

    public function __construct()
    {

        try {
            $this->pdo = new PDO(
                $this->dsn,
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die("DB Connection failed: " . $e->getMessage());
        }
    }


    public function insert($sql, $params = array())
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }


    public function select($sql, $params = array())
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function update($sql, $params = array())
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($sql, $params = array())
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function selectOne($sql, $params = array())
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function __destruct() {
        $this->pdo = null;
    }
}



