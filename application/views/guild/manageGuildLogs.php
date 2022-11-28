<script>
    function filterFunction(divname, inputname) {
        var input, filter, ul, li, a, i;
        input = document.getElementById(inputname);
        filter = input.value.toUpperCase();
        div = document.getElementById(divname);
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
            }
        }
    }
</script>
<?php  
echo form_open('logs/'.$guild->id);
?>
<div class="row pt-3">
    <div class="col-12">
        <div style="border: 2px solid; border-color: white; width: 400px" class="p-3 d-flex">
            <span>Activer le module de logs : </span>
            
            <div class="h-100 w-100 p-2 d-flex justify-content-end">
                <label class="switch">
                    <input onclick="show()" type="checkbox" name="logsModuleEnabled" <?php echo $logsEnabled ? "checked" : "" ?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
</div>
<div class="row pt-3">
    <div class="col-12">
        <div class="dropdown">
        <span>Salon :
        <a class="dropdown-toggle ml-3 p-2" style="border: solid 2px; border-color:white; ;background-color: #2A2D30; color: white; background-position: 14px 12px;" type="button" id="dropdownChannelsLogs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo isset($channel->name) ? $channel->name : "Aucun" ?>
        </a>
            <div class="dropdown-menu text-white" style="background-color: #2A2D30; color: white" aria-labelledby="dropdownChannelsLogs" id="ddb">
                <input type="text" style="background-color: #2A2D30; color: white; background-position: 14px 12px; background-repeat: no-repeat; font-size: 16px; padding: 14px; border: none; border-bottom: 1px solid #ddd;" placeholder="Rechercher un channel" id="myInputLogs" onkeyup="filterFunction('ddb', 'myInputLogs')">
                <?php
                foreach ($channels as $c) {
                    if ($c->type==0)
                        echo "<a class=\"dropdown-item text-white\" onclick='setText(\"dropdownChannelsLogs\", \"$c->name\");setValue(\"channellogs\", \"$c->id\");show()'>".$c->name."</a>";
                }
                ?>
                <input name="channellogs" id="channellogs" type="hidden" value="<?php echo (isset($channel->id) ? $channel->id : "none") ?>">
            </div>
        </div>
    </div>
</div>
<div class="row pt-3">
    <?php 
        $libs = array(
            'messageDelete' => 'Message supprimé',
            'messageUpdate' => 'Message modifié',
            'channelDelete' => 'Salon supprimé',
            'guildMemberUpdate' => 'Membre modifié',
            'channelUpdate' => 'Salon modifié',
            'channelCreate' => 'Salon créé',
            'guildUpdate' => 'Serveur modifié',
            'guildMemberAdd' => 'Nouveau membre',
            'guildMemberRemove' => 'Membre en moins',
            'guildBanAdd' => 'Bans',
            'messageReactionRemove' => 'Retrait d\'une reaction',
            'messageReactionAdd' => 'Ajout d\'une reaction',
            'emojiDelete' => 'Emoji supprimé',
            'inviteCreate' => 'Invitation créé',
            'messageDeleteBulk' => 'Suppression de message groupé',
            'guildBanRemove' => 'Unban',
            'emojiUpdate' => 'Emoji modifié',
            'emojiCreate' => 'Emoji créé',
            'roleCreate' => 'Rôle créé',
            'roleUpdate' => 'Rôle modifié',
            'roleDelete' => 'Rôle supprimé',
        );
        foreach ($logs as $log) : 
        
            $on = $log->enabled == 't';
        ?>

        <div class="col-md-4 col-lg-3 col-6 p-2 m-2 align-middle" style="border: 2px solid; border-color: white;">
            <p><?php echo isset($libs[$log->libelle]) ? $libs[$log->libelle] : $log->libelle ?></p>
            <label class="switch">
                <input onclick="show()" type="checkbox" name="check<?php echo $log->id_type ?>"  <?php echo ($on ? "checked" : "") ?>>
                <span class="slider round"></span>
            </label> 
        </div> 

    <?php endforeach; ?>
</div>
</div></div>