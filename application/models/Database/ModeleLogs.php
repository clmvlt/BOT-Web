<?php
class ModeleLogs extends CI_Model {

    public function __construct()
    {
    }
    public function getLogsTypes($id) {
        $query = $this->db->query("select c.guildid, lt.id_type, l.enabled, lt.libelle from config c, log_type lt left join log l on l.id_type = lt.id_type and l.guildid = ? where c.guildid = ? order by lt.libelle asc", array($id, $id));
        return $query->result(); 
    }

    public function setLog($guildid, $id, $bool) {
        if ($bool == $this->isLogEnable($guildid, $id)) return;
        if ($this->isLogEnable($guildid, $id)) {
            $data = array('guildid' => $guildid, 'id_type' => $id);
            $this->db->delete('log', $data);
        } else {
            $data = array('guildid' => $guildid, 'id_type' => $id, 'enabled' => true);
            $this->db->insert('log', $data);
        }
    }

    public function isLogEnable($guildid, $id) {
        $q = $this->db->get_where("log", array('guildid'=>$guildid, 'id_type'=>$id));
        return $q->row() != null;
    }

    public function getLogsChannel($guildid) {
        $q = $this->db->get_where("log_config", array('guildid'=>$guildid));
        return $q->row();
    }

    public function setLogsChannel($guildid, $id) {
        $this->setDefaultConfig($guildid);
        $this->db->set(array('channelid' => $id));
        $this->db->where(array('guildid' => $guildid));
        $this->db->update('log_config');
    }

    public function configExist($guildid) {
        $q = $this->db->get_where("log_config", array('guildid'=>$guildid));
        return $q->row() != null;
    }

    public function setDefaultConfig($guildid) {
        if ($this->configExist($guildid)) return;
        $data = array('guildid' => $guildid, 'channelid' => 'none');
        $this->db->insert('log_config', $data);
    }
}