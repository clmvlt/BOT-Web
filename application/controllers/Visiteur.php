<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visiteur extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Discord/ModeleAPIDiscord');
		$this->load->model('Discord/ModeleGuild');
		$this->load->model('Database/ModeleDotGame');
		$this->load->model('Discord/ModeleUser');
        $this->load->helper('url');
        $this->load->library('session');
	}

	public function seConnecter()
	{
        redirect('https://discord.com/api/oauth2/authorize?client_id=981537507609022554&redirect_uri=http%3A%2F%2Fbot-dot.fr%2Findex.php%2FVisiteur%2FConnexion&response_type=code&scope=identify%20guilds');
	}

    public function seDeconnecter() {
        $this->session->sess_destroy();
        redirect(site_url('Welcome/index'));
    }

    public function Connexion()
	{
        if ($this->input->get('code') === NULL) {
            //redirect(site_url('Visiteur/seConnecter'));
		} else {
            $res = $this->ModeleAPIDiscord->logWithCode($this->input->get('code'));
            if (isset($res->error)) {
                echo "<h1>Echec de la connexion</h1>";
                redirect(site_url('Welcome/index'));
            } else {
                $user = $this->ModeleUser->getUser($res->access_token, $res->token_type);
                $guilds = $this->ModeleUser->getUserGuilds($res->access_token, $res->token_type);
                echo "<h1>Connecté en tant que ".$user->username."</h1>";
                $userdata = array(
                    'tag' => $user->username."#".$user->discriminator,
                    'id' => $user->id,
                    'avatarURL' => $this->ModeleUser->getAvatarURL($user->id),
                    'user' => $user,
                    'guilds' => $guilds
                );
                $this->session->set_userdata($userdata);   
                redirect(site_url('Welcome/index'));
            }
		}
	}

    public function addedToGuild() {
        $data['avatarURL'] = $this->ModeleUser->getAvatarURL($this->session->id);
		$data['tag'] = $this->session->tag;
		$this->load->view('templates/header', $data);
        $this->load->view('guild/addedToGuild');
		$this->load->view('templates/footer');
    }

    public function commands() {
        $data = array();
        if (isset($this->session->id)) $data['tag'] = $this->session->userdata["tag"];
        if (isset($this->session->id)) $data['avatarURL'] = $this->ModeleUser->getAvatarURL($this->session->id);
        $this->load->view('templates/header', $data);
		$this->load->view('commands/help');
		$this->load->view('templates/footer');
    }

    public function profil($id) {
        $data['profil'] = $this->ModeleDotGame->getProfil($id);
        if (is_null($data['profil'])) return;
        $data['user'] = $this->ModeleUser->getMember($id);
        $data['avatarURL'] = $this->ModeleUser->getAvatarURL($id);
        $data['xpNextLvl'] = $this->ModeleDotGame->xpNextLvl($data['profil']->level);
        $this->load->view('image/profil', $data);
        $this->load->view('templates/footer');
    }
}
