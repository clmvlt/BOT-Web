<?php
class ModeleSQL extends CI_Model {

    public function __construct()
    {
    }
 
    public function getConfig($id) {
        $query = $this->db->get_where("config", array("guildid" => $id));
        return $query->row();
    }
}