<?php
class ModeleWelcome extends CI_Model {

    public function __construct()
    {
    }
 
    public function getConfigMessagesWelcome($id) {
        $this->db->select('*');
        $this->db->from('welcome');
        $this->db->join('welcome_type', 'welcome_type.id_type = welcome.id_type');
        $this->db->where(array('guildid'=>$id));
        return $this->db->get()->result();
    }

    public function getConfigImageWelcome($id) {
        $this->db->select('*');
        $this->db->from('welcome_image');
        $this->db->where(array('guildid'=>$id));
        return $this->db->get()->row();
    }

    public function getWelcomeTypes($id) {
        $query = $this->db->query("select c.guildid, c.prefix, wt.id_type, wt.libelle, w.channelid, w.message, w.enabled from config c, welcome_type wt left join welcome w on w.id_type = wt.id_type and w.guildid = ? where c.guildid = ?", array($id, $id));
        return $query->result(); 
    }

    public function getWelcomeRoles($id) {
        $query = $this->db->query("select * from welcome_role where guildid = ?", array($id));
        return $query->result();
    }

    public function isWelcomeSet($id, $idtype) {
        $query = $this->db->query('select * from welcome where guildid = ? and id_type = ?', array($id, $idtype));
        return $query->row() != null;
    }

    public function isWelcomeImageSet($id, $idtype) {
        $query = $this->db->query('select * from welcome_image where guildid = ?', array($id));
        return $query->row() != null;
    }

    public function resetWelcomeImage($id) {
        $data = array(
            'guildid' => $id
        );
        $this->db->db_debug = FALSE;
        $this->db->delete('welcome_image', $data);
    }

    public function setWelcome($id, $idtype, $channelid, $message, $enabled) {
        if ($this->isWelcomeSet($id, $idtype)) {
            $this->db->set(array('channelid' => $channelid, 'message' => $message, 'enabled' => $enabled));
            $this->db->where(array('guildid' => $id, 'id_type' => $idtype));
            $this->db->db_debug = FALSE;
            $this->db->update('welcome');
        } else {
            $data = array('channelid' => $channelid, 'message' => $message, 'guildid' => $id, 'id_type' => $idtype, 'enabled' => $enabled);
            $this->db->db_debug = FALSE;
            $this->db->insert('welcome', $data);
        }
    }

    public function setWelcomeImage($id, $text, $textx, $texty, $textpolice, $textcolor, $texttransparent, $imagecolor, $imagex, $imagey, $imagesize, $bgtransparent, $bgcolor, $bgimage) {
        if ($this->isWelcomeImageSet($id, 3)) {
            $this->db->set(array(
                'text' => $text,
                'textx' => $textx,
                'texty' => $texty,
                'textpolice' => $textpolice,
                'textcolor' => $textcolor,
                'imagecolor' => $imagecolor,
                'texttransparent' => $texttransparent,
                'imagex' => $imagex,
                'imagey' => $imagey,
                'imagesize' => $imagesize,
                'bgimage' => $bgimage,
                'bgcolor' => $bgcolor,
                'bgtransparent' => $bgtransparent
            ));
            $this->db->where(array('guildid' => $id));
            $this->db->db_debug = FALSE;
            $this->db->update('welcome_image');
        } else {
            $data = array(
                'guildid' => $id,
                'text' => $text,
                'textx' => $textx,
                'texty' => $texty,
                'textpolice' => $textpolice,
                'textcolor' => $textcolor,
                'imagecolor' => $imagecolor,
                'texttransparent' => $texttransparent,
                'imagex' => $imagex,
                'imagey' => $imagey,
                'imagesize' => $imagesize,
                'bgimage' => $bgimage,
                'bgcolor' => $bgcolor,
                'bgtransparent' => $bgtransparent
            );
            $this->db->db_debug = FALSE;
            $this->db->insert('welcome_image', $data);
        }
    }

    public function addWelcomeRole($id, $idrole) {
        $data = array(
            'guildid' => $id,
            'roleid' => $idrole
        );
        $this->db->db_debug = FALSE;
        $this->db->insert('welcome_role', $data);
    }

    public function removeWelcomeRole($id, $idrole) {
        $data = array(
            'guildid' => $id,
            'roleid' => $idrole
        );
        $this->db->db_debug = FALSE;
        $this->db->delete('welcome_role', $data);
    }
}