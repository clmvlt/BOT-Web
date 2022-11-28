<div class="row h-100">
    <div class="col-md-2 col-12" style="background-color:#26292C">
        <a class="nav-link text-white pb-3" href="<?php echo site_url('serveurs/') ?>">← retour</a>
        <img src="<?php echo $guildIcon ?>" class="p-5 w-100 rounded-circle self-align-center" style="max-height: 250px; max-width: 250px; filter: drop-shadow(10px 10px 25px black)">
        <div class="d-flex justify-content-center">
            <div class="nav flex-column nav-pills" style="width:100%" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link <?php echo (strpos(current_url(), 'informations/') !== false ? "active" : "x") ?>" href="<?php echo site_url('informations/'.$guild->id) ?>">Informations</a>
                <a class="nav-link <?php echo (strpos(current_url(), 'configuration/') !== false ? "active" : "x") ?>" href="<?php echo site_url('configuration/'.$guild->id) ?>">Configuration</a>
                <p style="border-top: 2px solid; border-color: white; border-bottom: 2px solid;" class="mt-4 mb-5 p-2 pl-3">Modules</p>
                <a class="nav-link <?php echo (strpos(current_url(), 'moderation/') !== false ? "active" : "x") ?>" href="<?php echo site_url('moderation/'.$guild->id) ?>">Modération</a>
                <a class="nav-link <?php echo (strpos(current_url(), 'ticket/') !== false ? "active" : "x") ?>" href="<?php echo site_url('ticket/'.$guild->id) ?>">Tickets</a>
                <a class="nav-link <?php echo (strpos(current_url(), 'welcome/') !== false ? "active" : "x") ?>" href="<?php echo site_url('welcome/'.$guild->id) ?>">Bienvenue</a>
                <a class="nav-link <?php echo (strpos(current_url(), 'logs/') !== false ? "active" : "x") ?>" href="<?php echo site_url('logs/'.$guild->id) ?>">Logs</a>
                <a class="nav-link <?php echo (strpos(current_url(), 'rolemenus/') !== false ? "active" : "x") ?>" href="<?php echo site_url('rolemenus/'.$guild->id) ?>">Rôle Menus</a>
                <br/><br/>
                <a class="nav-link btn btn-danger" href="<?php echo site_url('Utilisateur/leaveGuild/'.$guild->id) ?>">Retirer DOT</a>
            </div>
        </div>
    </div>
    <div class="col-10 pl-5 pb-3 pr-3 pt-3">