<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('file');
       	$this->load->library("pagination");
		$this->load->library('session');
		$this->load->model('Discord/ModeleAPIDiscord');
		$this->load->model('Discord/ModeleGuild');
		$this->load->model('Discord/ModeleUser');
	}

	public function index()
	{
        $data = array();
        if (isset($this->session->id)) $data['tag'] = $this->session->userdata["tag"];
        if (isset($this->session->id)) $data['avatarURL'] = $this->ModeleUser->getAvatarURL($this->session->id);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/footer');
	}
}
