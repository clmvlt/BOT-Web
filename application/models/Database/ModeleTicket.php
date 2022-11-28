<?php
class ModeleTicket extends CI_Model {

    public function __construct()
    {
    }
 
    public function getConfigTicket($id) {
        $query = $this->db->get_where("ticket_config", array("guildid" => $id));
        return $query->row();
    }

    public function setDefaultConfig($id) {
        $data = array('guildid' => $id,'messageid'=>'none','categorieid'=>'none','channelid'=>'none','message'=>'none');
        $this->db->db_debug = FALSE;
        $this->db->insert('ticket_config', $data);
    }

    public function setChannelTicket($id, $idchan) {
        if ($this->getConfigTicket($id) == null) $this->setDefaultConfig($id);
        $this->db->set('channelid', $idchan);
        $this->db->where('guildid', $id);
        $this->db->update('ticket_config');
    }

    public function setMessageTicket($id, $idmsg) {
        if ($this->getConfigTicket($id) == null) $this->setDefaultConfig($id);
        $this->db->set('messageid', $idmsg);
        $this->db->where('guildid', $id);
        $this->db->update('ticket_config');
    }

    public function setCategorieTicket($id, $idcat) {
        if ($this->getConfigTicket($id) == null) $this->setDefaultConfig($id);
        $this->db->set('categorieid', $idcat);
        $this->db->where('guildid', $id);
        $this->db->update('ticket_config');
    }

    public function setContentTicket($id, $content) {
        if ($this->getConfigTicket($id) == null) $this->setDefaultConfig($id);
        $this->db->set('message', $content);
        $this->db->where('guildid', $id);
        $this->db->update('ticket_config');
    }
}