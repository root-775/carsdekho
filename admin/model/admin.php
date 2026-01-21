<?php
class adminModel
{
    public $db; 

    function __construct()
    {
        include_once 'model/db.php';
        $this->db = new dbModel();
    }

    public function getAdminUser($email)
    {
        $sql = "SELECT * FROM admins WHERE username = :email";
        return $this->db->selectOne($sql, ['email' => $email]);        
    }

    public function getAllCarsCount()
    {
        $sql = "SELECT COUNT(id) as total_cars FROM cars";
        return $this->db->select($sql)[0] ?? 0;
    }
    public function getAllBannersCount()
    {
        $sql = "SELECT COUNT(id) as total_banners FROM banners";
        return $this->db->select($sql)[0] ?? 0;
    }

    public function getAllCars()
    {
        $sql = "SELECT * FROM cars ORDER BY id DESC limit 5";
        return $this->db->select($sql);
    }
}
