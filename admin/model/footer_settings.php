<?php

class footer_settingsModel
{
    public $db;

    function __construct()
    {
        include_once BASE_PATH . 'model/db.php';
        $this->db = new dbModel();
    }


    public function get()
    {
        return $this->db->selectOne("SELECT * FROM footer_settings WHERE id = 1", []);
    }

    public function create($params)
    {
        $sql = "INSERT INTO footer_settings
                (id, about_text, address, phone, email, facebook, instagram, youtube)
                VALUES (1, ?, ?, ?, ?, ?, ?, ?)";
        return $this->db->insert($sql, $params);
    }

    public function update($params)
    {
        $sql = "UPDATE footer_settings SET
                    about_text = ?,
                    address    = ?,
                    phone      = ?,
                    email      = ?,
                    facebook   = ?,
                    instagram  = ?,
                    youtube    = ?
                WHERE id = 1";
        return $this->db->update($sql, $params);
    }
}