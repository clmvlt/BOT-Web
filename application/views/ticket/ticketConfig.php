<script>
    function filterFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("ddb");
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
    function filterFunctionb() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("myInputb");
        filter = input.value.toUpperCase();
        div = document.getElementById("ddbb");
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
echo form_open('ticket/'.$guild->id);
?>

<div class="row pt-3">
    <div class="col-12">
        <div style="border: 2px solid; border-color: white; width: 400px" class="p-3 d-flex">
            <span>Activer le module ticket : </span>
            
            <div class="h-100 w-100 p-2 d-flex justify-content-end">
                <label class="switch">
                    <input onclick="if (this.checked == <?php echo $ticketEnabled ? 'true' : 'false' ?>) {hide()} else {show()}" type="checkbox" name="ticketModuleEnabled" <?php echo $ticketEnabled ? "checked" : "" ?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="row pt-4">
    <div class="col-12">
        <div class="dropdown">
        <span>Salon :
        <a class="dropdown-toggle ml-3 p-2" style="border: solid 2px; border-color:white; ;background-color: #2A2D30; color: white; background-position: 14px 12px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo isset($channelTicket->id) ? '#'.$channelTicket->name : "Aucun" ?>
        </a>
        <a class="btn btn-success" href="<?php echo site_url('Utilisateur/sendTicketMessage/'.$guild->id) ?>">Envoyer</a>
            <div class="dropdown-menu text-white" style="background-color: #2A2D30; color: white" aria-labelledby="dropdownMenuButton" id="ddb">
                <input type="text" style="background-color: #2A2D30; color: white; background-position: 14px 12px; background-repeat: no-repeat; font-size: 16px; padding: 14px; border: none; border-bottom: 1px solid #ddd;" placeholder="Rechercher un channel" id="myInput" onkeyup="filterFunction()">
                <?php
                $map = array_map(function($n) { return $n->id; }, $modRoles);
                foreach ($channels as $c) {
                    if ($c->type==0)
                        echo "<a class=\"dropdown-item text-white\" href=\"".site_url('Utilisateur/setChannelTicket/'.$guild->id.'/'.$c->id)."\">".$c->name."</a>";
                }
                ?>
            </div>
        </div>
        <p style="font-size: 10px">*Le salon est celui dans le quel sera envoyer le message créer un ticket.</p>
    </div>
</div> 

<div class="row pt-3">
    <div class="col-12">
        <div class="dropdown">
        <span>Catégorie :
        <a class="dropdown-toggle ml-3 p-2" style="border: solid 2px; border-color:white; ;background-color: #2A2D30; color: white; background-position: 14px 12px;" type="button" id="dropdownMenuButtonx" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo isset($categorieTicket->id) ? '#'.$categorieTicket->name : "Aucun" ?>
        </a>
            <div class="dropdown-menu text-white" style="background-color: #2A2D30; color: white" aria-labelledby="dropdownMenuButtonx" id="ddb">
                <input type="text" style="background-color: #2A2D30; color: white; background-position: 14px 12px; background-repeat: no-repeat; font-size: 16px; padding: 14px; border: none; border-bottom: 1px solid #ddd;" placeholder="Rechercher un channel" id="myInput" onkeyup="filterFunction()">
                <?php
                $map = array_map(function($n) { return $n->id; }, $modRoles);
                foreach ($channels as $c) {
                    if ($c->type==4)
                        echo "<a class=\"dropdown-item text-white\" href=\"".site_url('Utilisateur/setCategorieTicket/'.$guild->id.'/'.$c->id)."\">".$c->name."</a>";
                }
                ?>
            </div>
        </div>
        <p style="font-size: 10px">*La catégorie est celle dans la quelle les tickets seront créés.</p>
    </div>
</div>
<div class="row pt-3">
    <div class="col-12">
        <p>Message : </p>
        <?php
        if (validation_errors() != null) {
            echo '<div class="alert alert-danger" role="alert">
            Le message ne doit pas dépasser 2000 caractères.
            </div></div><div class="row">';
        }
        echo form_open('ticket/'.$guild->id);
        echo "<textarea rows='9' cols='60' onkeyup='if (this.value != \"".(isset($configTicket->message) ? $configTicket->message : "none")."\") {show()} else {hide()}' style='background-color: #2A2D30; color: white;border: solid 1px;border-color:white;' type='text' id='txtMessage' name='txtMessage' maxlength=2000>".(isset($configTicket->message) ? $configTicket->message : "none")."</textarea>";
        ?>
    </p>
    <p style="font-size: 10px">*Ce messages est affiché avant de créer un ticket, appuyez sur envoyer pour l'actualiser.<br/>*none : Message de base du bot.</p>
</div>

</div></div>