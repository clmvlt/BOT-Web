<?php
class ModeleDotGame extends CI_Model {

    public function __construct()
    {
    }
 
    public function xpNextLvl($lvl) {
        return (5 * (pow($lvl, 2)) + (50 * $lvl) + 100);
    } 

    public function getProfil($id) {
        $query = $this->db->get_where("profil", array("memberid" => $id));
        return $query->row();
    }
}