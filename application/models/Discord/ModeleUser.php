<?php
class ModeleUser extends CI_Model {

    public function __construct()
    {
    }
 
    public function getUser($access_token, $token_type) {
        $opts = array('http' =>
            array(
                'header' => 'authorization: '.$token_type.' '.$access_token
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents('https://discord.com/api/users/@me', false, $context));
    }

    public function getUserGuilds($access_token, $token_type) {
        $opts = array('http' =>
            array(
                'header' => 'authorization: '.$token_type.' '.$access_token
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents('https://discord.com/api/users/@me/guilds', false, $context));
    }

    public function getCurrentUser() {
        $id = $this->session->id;
        $opts = array('http' =>
            array(
                'header' => 'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA',
                'ignore_errors' => true
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents('https://discord.com/api/v9/users/'.$id, false, $context));
    }

    public function getMember($id) {
        $opts = array('http' =>
            array(
                'header' => 'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA',
                'ignore_errors' => true
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents('https://discord.com/api/v9/users/'.$id, false, $context));
    }

    public function getUserById($id) {
        $opts = array('http' =>
            array(
                'header' => 'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA',
                'ignore_errors' => true
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents('https://discord.com/api/users/'.$id, false, $context));
    }

    public function getAvatarURL($userid) {
        $user = $this->getUserById($userid);
        return "https://cdn.discordapp.com/avatars/$userid/".$user->avatar.".png?size=64";
    }
}