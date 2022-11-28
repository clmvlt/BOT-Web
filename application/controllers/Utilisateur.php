<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Utilisateur extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Discord/ModeleAPIDiscord');
		$this->load->model('Discord/ModeleGuild');
		$this->load->model('Discord/ModeleUser');
		$this->load->model('Database/ModeleConfig');
		$this->load->model('Database/ModeleModRole');
		$this->load->model('Database/ModeleModule');
		$this->load->model('Database/ModeleTicket');
		$this->load->model('Database/ModeleWelcome');
		$this->load->model('Database/ModeleLogs');
		$this->load->model('Database/ModeleRM');
		if (!isset($this->session->id)) redirect(site_url('Visiteur/seConnecter'));
	}

	public function data($id)
	{
		$guild = $this->ModeleGuild->getGuild($id);
		$data['guild'] = $guild;
		$data["guildOwner"] = $data['guild']->owner_id == $this->session->id ? $this->session->user : $this->ModeleUser->getUserById($data['guild']->owner_id);
		$data["prefix"] = $this->ModeleConfig->getConfig($id)->prefix;
		$data['avatarURL'] = $this->session->avatarURL;
		$data['tag'] = $this->session->tag;
		$data['guildIcon'] = $this->ModeleGuild->getGuildIconURL($id);
		$data['emojis'] = $data['guild']->emojis;
		$data['modRoles'] = array();
		$data['roles'] = $data['guild']->roles;
		foreach ($this->ModeleModRole->getModRoles($id) as $modrole) {
			foreach ($data['roles'] as $role) {
				if ($role->id == $modrole->roleid) array_push($data['modRoles'], $role);
			};
		};
		return $data;
	}

	public function manageGuild($id)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));

		$data = $this->data($id);
		$this->load->view('templates/header', $data);
		$this->load->view('guild/panelModules', $data, $data);
		$this->load->view('guild/manageGuild', $data);
		$this->load->view('templates/footer');
	}

	public function ticketConfig($id)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('txtMessage', 'txtMessage', 'max_length[2000]');

		if ($this->form_validation->run() === FALSE) {
			$data = $this->data($id);
			$data['ticketEnabled'] = $this->ModeleModule->isTicketEnable($id);
			$data['configTicket'] = $this->ModeleTicket->getConfigTicket($id);
			$data['channels'] = $this->ModeleGuild->getGuildChannels($id);
			if (isset($data['configTicket']->channelid)) $data['channelTicket'] = $this->ModeleGuild->getGuildChannel($data['configTicket']->channelid);
			if (isset($data['configTicket']->categorieid)) $data['categorieTicket'] = $this->ModeleGuild->getGuildChannel($data['configTicket']->categorieid);
			$this->load->view('templates/header', $data);
			$this->load->view('guild/panelModules', $data);
			$this->load->view('ticket/ticketConfig', $data);
			$this->load->view('templates/saveBtn', $data);
			$this->load->view('templates/footer');
		} else {
			$ticketEnabled = $this->input->post('ticketModuleEnabled') == 'on';
			$msg = $this->input->post('txtMessage');
			if ($msg == null || $msg == "") $msg = 'none';
			$this->ModeleTicket->setContentTicket($id, $msg);
			if ($this->ModeleModule->isTicketEnable($id) !== $ticketEnabled) $this->ModeleModule->setTicket($id, !$ticketEnabled);
			redirect(site_url('ticket/' . $id));
		}
	}

	public function welcomeConfig($id)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('txtMessageDepart', 'txtMessageDepart', 'max_length[2000]');
		$this->form_validation->set_rules('txtMessageArrivee', 'txtMessageArrivee', 'max_length[2000]');

		if ($this->form_validation->run() === FALSE) {
			$data = $this->data($id);
			$data['confImg'] = $this->ModeleWelcome->getConfigImageWelcome($id);
			$data['welcomeEnabled'] = $this->ModeleModule->isWelcomeEnable($id);
			$data['configMessagesWelcome'] = $this->ModeleWelcome->getConfigMessagesWelcome($id);
			$data['welcomeTypes'] = $this->ModeleWelcome->getWelcomeTypes($id);
			$data['channels'] = $this->ModeleGuild->getGuildChannels($id);
			$data['welcomeRoles'] = array();
			foreach ($this->ModeleWelcome->getWelcomeRoles($id) as $wrole) {
				foreach ($data['roles'] as $role) {
					if ($role->id == $wrole->roleid) array_push($data['welcomeRoles'], $role);
				};
			};
			$this->load->view('templates/header', $data);
			$this->load->view('guild/panelModules', $data);
			$this->load->view('guild/manageGuildWelcome', $data);
			$this->load->view('templates/saveBtn', $data);
			$this->load->view('templates/footer');
		} else {
			$types = $this->ModeleWelcome->getWelcomeTypes($id);
			foreach ($types as $type) {
				$newId = $this->input->post('channel' . $type->libelle);
				$newMsg = $this->input->post('message' . $type->libelle);
				$check = $this->input->post('check' . $type->libelle) == 'on';
				if ($newMsg == '' || $newMsg == null) $newMsg = 'none';
				$this->ModeleWelcome->setWelcome($id, $type->id_type, $newId, $newMsg, $check);
				if ($type->libelle == 'joinimg') {
					$text = $this->input->post('text');
					$textx = $this->input->post('textx');
					$texty = $this->input->post('texty');
					$textpolice = $this->input->post('textpolice');
					$textcolor = $this->input->post('textcolor');
					$texttransparent = $this->input->post('texttransparent') == 't';
					$imagecolor = $this->input->post('imagecolor');
					$imagex = $this->input->post('imagex');
					$imagey = $this->input->post('imagey');
					$imagesize = $this->input->post('imagesize');
					$bgtransparent = $this->input->post('bgtransparent') == 't';
					$bgcolor = $this->input->post('bgcolor');
					$bgimage = $this->input->post('bgimage');
					$this->ModeleWelcome->setWelcomeImage($id, $text, $textx, $texty, $textpolice, $textcolor, $texttransparent, $imagecolor, $imagex, $imagey, $imagesize, $bgtransparent, $bgcolor, $bgimage);
				}
			};
			$welcomeEnabled = $this->input->post('welcomeModuleEnabled') == 'on';
			if ($this->ModeleModule->isWelcomeEnable($id) !== $welcomeEnabled) $this->ModeleModule->setWelcome($id, !$welcomeEnabled);
			redirect(site_url('welcome/' . $id));
		}
	}

	public function manageGuildConfig($id)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('txtPrefix', 'Prefix', 'min_length[1]|max_length[5]');

		if ($this->form_validation->run() === FALSE) {
			$data = $this->data($id);
			$this->load->view('templates/header', $data);
			$this->load->view('guild/panelModules', $data);
			$this->load->view('guild/manageGuildConfig', $data);
			$this->load->view('templates/saveBtn', $data);
			$this->load->view('templates/footer');
		} else {
			$newPrefix = $this->input->post('txtPrefix');
			$this->ModeleConfig->setPrefix($id, $newPrefix);
			redirect(site_url('configuration/' . $id));
		}
	}

	public function manageGuildMod($id)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('x', 'x', 'min_length[1]');

		if ($this->form_validation->run() === FALSE) {
			$data = $this->data($id);
			$data['modEnabled'] = $this->ModeleModule->isModerationEnable($id);
			$this->load->view('templates/header', $data);
			$this->load->view('guild/panelModules', $data);
			$this->load->view('guild/manageGuildMod', $data);
			$this->load->view('templates/saveBtn', $data);
			$this->load->view('templates/footer');
		} else {
			$modEnabled = $this->input->post('modModuleEnabled') == 'on';
			if ($this->ModeleModule->isModerationEnable($id) !== $modEnabled) $this->ModeleModule->setModeration($id, !$modEnabled);
			redirect(site_url('moderation/' . $id));
		}
	}

	public function manageGuildLogs($id)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('x', 'x', 'min_length[1]');

		if ($this->form_validation->run() === FALSE) {
			$data = $this->data($id);
			$data['logsEnabled'] = $this->ModeleModule->isLogsEnable($id);
			$data['logs'] = $this->ModeleLogs->getLogsTypes($id);
			$data['channels'] = $this->ModeleGuild->getGuildChannels($id);
			$data['channel'] = (isset($this->ModeleLogs->getLogsChannel($id)->channelid) ? $this->ModeleGuild->getGuildChannel($this->ModeleLogs->getLogsChannel($id)->channelid) : null);
			$this->load->view('templates/header', $data);
			$this->load->view('guild/panelModules', $data);
			$this->load->view('guild/manageGuildLogs', $data);
			$this->load->view('templates/saveBtn', $data);
			$this->load->view('templates/footer');
		} else {
			$logs = $this->ModeleLogs->getLogsTypes($id);
			$log = $this->ModeleLogs->getLogsTypes($id);
			foreach ($logs as $log) {
				$check = $this->input->post('check' . $log->id_type) == 'on';
				$this->ModeleLogs->setLog($id, intval($log->id_type), $check);
			};
			$logsEnabled = $this->input->post('logsModuleEnabled') == 'on';
			if ($this->ModeleModule->isLogsEnable($id) !== $logsEnabled) $this->ModeleModule->setLogs($id, !$logsEnabled);
			$this->ModeleLogs->setLogsChannel($id, $this->input->post("channellogs"));
			redirect(site_url('logs/' . $id));
		}
	}

	public function guilds()
	{
		$data['allguilds'] = $this->ModeleGuild->getGuilds();
		$data['memberguilds'] = $this->session->guilds;
		$data['guilds'] = array();
		$data['guildsCanAddeds'] = array();
		foreach ($data['memberguilds'] as $g) {
			if ($this->ModeleGuild->isAdminGuild($g)) {
				if (!array_search($g->id, array_column($data['allguilds'], 'id'))) {
					if ($this->ModeleGuild->canAdd($g)) array_push($data['guildsCanAddeds'], $g);
				} else {
					array_push($data['guilds'], $g);
				}
			}
		}
		$data['avatarURL'] = $this->ModeleUser->getAvatarURL($this->session->id);
		$data['tag'] = $this->session->tag;
		$this->load->view('templates/header', $data);
		$this->load->view('guild/viewAllGuilds', $data);
		$this->load->view('templates/footer');
	}

	public function leaveGuild($id) {
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));
		$this->ModeleGuild->leaveGuild($id);
		redirect(site_url('serveurs'));
	}

	public function setChannelTicket($id, $idchan)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));
		$this->ModeleTicket->setChannelTicket($id, $idchan);
		redirect(site_url('ticket/' . $id));
	}

	public function setChannelWelcome($id, $idchan)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));
		$this->ModeleWelcome->setChannelWelcome($id, $idchan);
		redirect(site_url('welcome/' . $id));
	}

	public function setCategorieTicket($id, $idcat)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));
		$this->ModeleTicket->setCategorieTicket($id, $idcat);
		redirect(site_url('ticket/' . $id));
	}

	public function sendTicketMessage($id)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));
		$conf = $this->ModeleTicket->getConfigTicket($id);
		$this->ModeleGuild->deleteMessage($conf->channelid, $conf->messageid);
		$msg = $this->ModeleGuild->sendTicketMessage($conf->channelid, $conf->message);
		if (isset($msg->id)) $this->ModeleTicket->setMessageTicket($id, $msg->id);
		redirect(site_url('ticket/' . $id));
	}

	public function addModRole($id, $idRole)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));
		$this->ModeleModRole->addModRole($id, $idRole);
		redirect(site_url('moderation/' . $id));
	}

	public function removeModRole($id, $idRole)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));
		$this->ModeleModRole->removeModRole($id, $idRole);
		redirect(site_url('moderation/' . $id));
	}

	public function addWelcomeRole($id, $idRole)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));
		$this->ModeleWelcome->addWelcomeRole($id, $idRole);
		redirect(site_url('welcome/' . $id));
	}

	public function removeWelcomeRole($id, $idRole)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));
		$this->ModeleWelcome->removeWelcomeRole($id, $idRole);
		redirect(site_url('welcome/' . $id));
	}

	public function removeWelcomeImage($id)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));
		$this->ModeleWelcome->resetWelcomeImage($id);
		redirect(site_url('welcome/' . $id));
	}

	public function viewRolemenus($id)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));
		$data = $this->data($id);
		$rolemenus = $this->ModeleRM->getRMs($id);
		$data['rolemenus'] = array();
		$data['channels'] = $this->ModeleGuild->getGuildChannels($id);
		foreach ($rolemenus as $rm) {
			$r = array(
				'id' => $rm->id,
				'name' => $rm->name,
				'messageid' => $rm->messageid,
				'guildid' => $rm->guildid,
				'roles' => $this->ModeleRM->getRMRoles($rm->id)
			);
			array_push($data['rolemenus'], $r);
		}
		$this->load->view('templates/header', $data);
		$this->load->view('guild/panelModules', $data);
		$this->load->view('guild/viewAllRolemenus', $data);
		$this->load->view('templates/footer');
	}

	public function manageRolemenu($id, $idrm)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('rmname', 'rmname', 'min_length[1]|max_length[50]|required');
		$this->form_validation->set_rules('messagecontent', 'messagecontent', 'min_length[1]|max_length[2000]|required');

		if ($this->form_validation->run() === FALSE) {
			$data = $this->data($id);
			$data['rolesemotes'] = $this->ModeleRM->getRMRoles($idrm);
			$data['rolemenu'] = $this->ModeleRM->getRM($idrm);
			$this->load->view('templates/header', $data);
			$this->load->view('guild/panelModules', $data);
			$this->load->view('guild/manageGuildRM', $data);
			$this->load->view('templates/saveBtn', $data);
			$this->load->view('templates/footer');
		} else {
			$rolesemotes = $this->input->post('rolesemotes');
			$rmname = $this->input->post('rmname');
			$messagecontent = $this->input->post('messagecontent');
			$buttons = $this->input->post('buttons') == 'on';
			$rm = $this->ModeleRM->getRM($idrm);
			$this->ModeleRM->editRM($id, $rmname, $messagecontent, $buttons, $idrm);
			$this->ModeleRM->deleteEmotes($idrm);
			foreach ($rolesemotes as $e) {
				$this->ModeleRM->addEmote($idrm, $e[0], $e[1]);
			}
			redirect(site_url('Utilisateur/sendRM/'.$id.'/'.$idrm.'/'.$rm->channelid));
		}
	}

	public function deleteRM($id, $idguild)
	{
		if (!isset($idguild) || !$this->ModeleGuild->isAdmin($idguild)) redirect(site_url('serveurs'));
		$this->ModeleRM->deleteRM($id);
		redirect(site_url('rolemenus/' . $idguild));
	}

	public function sendRM($idguild, $id, $idchannel)
	{
		if (!isset($idguild) || !$this->ModeleGuild->isAdmin($idguild)) redirect(site_url('serveurs'));
		$rm = $this->ModeleRM->getRM($id);
		$this->ModeleRM->sendRM($idguild, $idchannel, $id);
		$this->ModeleGuild->deleteMessage($rm->channelid, $rm->messageid);
		redirect(site_url('rolemenus/' . $idguild));
	}

	public function deleteRMMessage($id, $idchannel, $idrm)
	{
		if (!isset($idguild) || !$this->ModeleGuild->isAdmin($idguild)) redirect(site_url('serveurs'));
		$rm = $this->ModeleRM->getRM($idrm);
		$this->ModeleGuild->deleteMsg($idchannel, $rm->messageid);
		redirect(site_url('rolemenus/'.$id));
	}

	public function createRM($id)
	{
		if (!isset($id) || !$this->ModeleGuild->isAdmin($id)) redirect(site_url('serveurs'));

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('rmname', 'rmname', 'min_length[1]|max_length[50]|required');
		$this->form_validation->set_rules('messagecontent', 'messagecontent', 'min_length[1]|max_length[2000]|required');

		if ($this->form_validation->run() === FALSE) {
			$data = $this->data($id);
			$data['rolesemotes'] = $this->ModeleRM->getRMRoles(-1);
			$this->load->view('templates/header', $data);
			$this->load->view('guild/panelModules', $data);
			$this->load->view('guild/createRM', $data);
			$this->load->view('templates/saveBtn', $data);
			$this->load->view('templates/footer');
		} else {
			$rolesemotes = $this->input->post('rolesemotes');
			$rmname = $this->input->post('rmname');
			$messagecontent = $this->input->post('messagecontent');
			$buttons = $this->input->post('buttons') == 'on';
			$insertid = $this->ModeleRM->createRM($id, $rmname, $messagecontent, $buttons);
			foreach ($rolesemotes as $e) {
				$this->ModeleRM->addEmote($insertid, $e[0], $e[1]);
			}
			redirect(site_url('rolemenus/'.$id));
		}
	}
}
