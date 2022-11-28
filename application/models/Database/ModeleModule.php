<?php
class ModeleModule extends CI_Model {

    public function __construct()
    {
    }
 
    public function setModeration($id, $bool) {
        if ($this->isModerationEnable($id)) {
            $data = array('guildid' => $id, 'id' => 1, 'enabled' => false);
            $this->db->db_debug = FALSE;
            $this->db->insert('categorie_desactivee', $data);
        } else {
            $data = array('guildid' => $id, 'id' => 1);
            $this->db->db_debug = FALSE;
            $this->db->delete('categorie_desactivee', $data);
        }
    }

    public function isModerationEnable($id) {
        $query = $this->db->get_where("categorie_desactivee", array("guildid" => $id, 'id' => 1));
        return $query->row() == null;
    }

    public function setTicket($id, $bool) {
        if ($this->isTicketEnable($id)) {
            $data = array('guildid' => $id, 'id' => 2, 'enabled' => false);
            $this->db->db_debug = FALSE;
            $this->db->insert('categorie_desactivee', $data);
        } else {
            $data = array('guildid' => $id, 'id' => 2);
            $this->db->db_debug = FALSE;
            $this->db->delete('categorie_desactivee', $data);
        }
    }

    public function isTicketEnable($id) {
        $query = $this->db->get_where("categorie_desactivee", array("guildid" => $id, 'id' => 2));
        return $query->row() == null;
    }

    public function setWelcome($id, $bool) {
        if ($this->isWelcomeEnable($id)) {
            $data = array('guildid' => $id, 'id' => 3, 'enabled' => false);
            $this->db->db_debug = FALSE;
            $this->db->insert('categorie_desactivee', $data);
        } else {
            $data = array('guildid' => $id, 'id' => 3);
            $this->db->db_debug = FALSE;
            $this->db->delete('categorie_desactivee', $data);
        }
    }

    public function isWelcomeEnable($id) {
        $query = $this->db->get_where("categorie_desactivee", array("guildid" => $id, 'id' => 3));
        return $query->row() == null;
    }

    public function setLogs($id, $bool) {
        if ($this->isLogsEnable($id)) {
            $data = array('guildid' => $id, 'id' => 4, 'enabled' => false);
            $this->db->db_debug = FALSE;
            $this->db->insert('categorie_desactivee', $data);
        } else {
            $data = array('guildid' => $id, 'id' => 4);
            $this->db->db_debug = FALSE;
            $this->db->delete('categorie_desactivee', $data);
        }
    }

    public function isLogsEnable($id) {
        $query = $this->db->get_where("categorie_desactivee", array("guildid" => $id, 'id' => 4));
        return $query->row() == null;
    }
}