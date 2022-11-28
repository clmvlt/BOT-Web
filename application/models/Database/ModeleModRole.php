<?php
class ModeleModRole extends CI_Model {

    public function __construct()
    {
    }

    public function getModRoles($id) {
        $query = $this->db->get_where("moderator_role", array("guildid" => $id));
        return $query->result();
    }

    public function addModRole($id, $idrole) {
        $data = array(
            'guildid' => $id,
            'roleid' => $idrole
        );
        $this->db->db_debug = FALSE;
        $this->db->insert('moderator_role', $data);
    }

    public function removeModRole($id, $idrole) {
        $data = array(
            'guildid' => $id,
            'roleid' => $idrole
        );
        $this->db->db_debug = FALSE;
        $this->db->delete('moderator_role', $data);
    }
}