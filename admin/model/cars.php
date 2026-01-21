<?php

class carsModel
{
    public $db; 

    function __construct()
    {
        include_once 'model/db.php';
        $this->db = new dbModel();
    }

    public function getAllCars()
    {
        $sql = "SELECT * FROM cars ORDER BY id DESC";
        return $this->db->select($sql);
    }

    public function getCar($id)
    {
        $sql = "SELECT * FROM cars WHERE id = ?";
        return $this->db->selectOne($sql, [$id]);
    }

    public function deleteCar($id)
    {
        $sql = "DELETE FROM cars WHERE id = ?";
        return $this->db->delete($sql, [$id]);
    }

    public function create($params)
    {
        $sql = "INSERT INTO cars (name, brand, price_from, price_to, fuel_type, transmission, image_path, is_most_searched, is_latest) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        return $this->db->insert($sql, $params);
    }

    public function update($params)
    {
        $sql = "UPDATE cars SET name = ?, brand = ?, price_from = ?, price_to = ?, fuel_type = ?, transmission = ?, image_path = ?, is_most_searched = ?, is_latest = ? WHERE id = ?";
        return $this->db->update($sql, $params);
    }
}