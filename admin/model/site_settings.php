<?php

class site_settingsModel
{
    public $db; 

    function __construct()
    {
        include_once BASE_PATH . 'model/db.php';
        $this->db = new dbModel();
    }


     public function get()
    {
        return $this->db->selectOne("SELECT * FROM site_settings WHERE id = 1", []);
    }

    public function create($params)
    {
        $sql = "INSERT INTO site_settings (id, site_name, logo_path, header_phone, header_email)
                VALUES (1, ?, ?, ?, ?)";
        return $this->db->insert($sql, $params);
    }

    public function update($params)
    {
        $sql = "UPDATE site_settings
                SET site_name = ?, logo_path = ?, header_phone = ?, header_email = ?
                WHERE id = 1";
        return $this->db->update($sql, $params);
    }



}