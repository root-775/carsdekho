<?php

class bannersModel
{
    private $db; 

    function __construct()
    {
        include_once 'model/db.php';
        $this->db = new dbModel();
    }

    public function create($params){
        $sql = "INSERT INTO banners (title, subtitle, button_text, button_link, image_path, sort_order, is_active)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        return $this->db->insert($sql, $params);

    }

    public function getAllBanners(){
        $sql = "SELECT * FROM banners ORDER BY sort_order ASC";
        return $this->db->select($sql);
    }

    public function getBanner($id){
        $sql = "SELECT * FROM banners WHERE id = ?";
        return $this->db->selectOne($sql, [$id]);
    }

    public function deleteBanner($id){
        $sql = "DELETE FROM banners WHERE id = ?";
        return $this->db->delete($sql, [$id]);
    }


    public function updateBannerModel($params){
        $sql = "UPDATE banners SET title = ?, subtitle = ?, button_text = ?, button_link = ?, image_path = ?, sort_order = ?, is_active = ? WHERE id = ?";
        return $this->db->update($sql, $params);
    }


}