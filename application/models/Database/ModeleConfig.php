<?php
class ModeleConfig extends CI_Model {

    public function __construct()
    {
    }
 
    public function getConfig($id) {
        $query = $this->db->get_where("config", array("guildid" => $id));
        return $query->row();
    }

    public function setPrefix($id, $newPrefix) {
        $this->db->set('prefix', $newPrefix);
        $this->db->where('guildid', $id);
        $this->db->update('config');
    }
}