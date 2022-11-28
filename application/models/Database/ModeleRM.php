<?php
class ModeleRM extends CI_Model {

    public function __construct()
    {
        $this->load->model('DIscord/ModeleGuild');
    }
 
    public function getRMs($id) {
        $query = $this->db->get_where("rolemenu_config", array("guildid" => $id));
        return $query->result();
    }

    public function getRM($id) {
        $query = $this->db->get_where("rolemenu_config", array("id" => $id));
        return $query->row();
    }

    public function deleteRM($id) {
        $data = array(
            'id' => $id
        );
        $this->db->db_debug = FALSE;
        $this->db->delete('rolemenu_roles', $data);
        $this->db->delete('rolemenu_config', $data);
    }

    public function getRMRoles($id) {
        $query = $this->db->get_where("rolemenu_roles", array("id" => $id));
        return $query->result();
    }

    public function createRM($id, $name, $msg, $buttons) {
        $data = array(
            'guildid' => $id,
            'name' => $name,
            'message' => $msg,
            'messageid' => 'none',
            'channelid' => 'none',
            'buttons' => $buttons
        );
        $this->db->insert('rolemenu_config', $data);
        return $this->db->insert_id();
    }

    public function deleteEmotes($rmid) {
        $this->db->where(array('id'=>$rmid));
        $this->db->delete('rolemenu_roles');
    }

    public function editRM($id, $name, $msg, $buttons, $rmid) {
        $data = array(
            'name' => $name,
            'message' => $msg,
            'buttons' => $buttons
        );
        $this->db->where(array('id'=>$rmid));
        $this->db->update('rolemenu_config', $data);
        
    }

    public function addEmote($id, $emote, $roleid) {
        $data = array(
            'id' => $id,
            'emote' => $emote,
            'roleid' => $roleid
        );
        $this->db->insert('rolemenu_roles', $data);
    }

    public function setMsgId($id, $msgid) {
        $data = array(
            'id' => $id
        );
        $this->db->where($data);
        $this->db->set('messageid', $msgid);
        $this->db->update('rolemenu_config');
    }

    public function setChannelId($id, $channelid) {
        $data = array(
            'id' => $id
        );
        $this->db->where($data);
        $this->db->set('channelid', $channelid);
        $this->db->update('rolemenu_config');
    }

    public function sendRM($guildid, $channelid, $id) {
        $roles = $this->ModeleGuild->getGuildRoles($guildid);
        $rm = $this->getRM($id);
        if (is_null($rm)) return;
        $rmroles = $this->getRMRoles($id);
        if (is_null($rmroles)) return;
        if ($rm->buttons=="t") {
            $buttons = [];
            foreach ($rmroles as $e) {
                $i = array_search($e, $rmroles);
                $role = $roles[array_search($e->roleid, array_column($roles, 'id'))];
                if (intval($e->emote) > 0) {
                    $emote = $this->ModeleGuild->getGuildEmoji($guildid, $e->emote);
                    array_push($buttons,
                        [
                            "type"=> 2,
                            "label"=> $role->name,
                            "style"=> 3,
                            "custom_id"=> "rm:".$role->id,
                            "emoji" => [
                                "name"=>$emote->name,
                                "id"=>$emote->id
                            ]
                        ] 
                    );
                } else {
                    array_push($buttons,
                        [
                            "type"=> 2,
                            "label"=> $role->name,
                            "style"=> 3,
                            "custom_id"=> "rm:".$role->id,
                            "emoji" => [
                                "name"=>$e->emote
                            ]
                        ] 
                    );
                }
            }
            $msg = $this->ModeleGuild->sendRMMessageButtons($channelid, $rm->message, $buttons);
        } else {
            $msg = $this->ModeleGuild->sendRMMessage($channelid, $rm->message);
            foreach ($rmroles as $e) {
                if (intval($e->emote) > 0) {
                    $emote = $this->ModeleGuild->getGuildEmoji($guildid, $e->emote);
                    $this->ModeleGuild->addReact($channelid, $msg->id, $emote->name.':'.$emote->id);
                } else {
                    $x = $this->ModeleGuild->addReact($channelid, $msg->id, $e->emote);
                }
                sleep(1);
            }
        }
        $this->setMsgId($id, $msg->id);
        $this->setChannelId($id, $channelid);
    }
}