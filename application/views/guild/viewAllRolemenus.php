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
<div class="row pt-3">
    <div class="col-12">
        <div class="p-2" style="border: 2px solid; border-color: white">
            <?php if (count($rolemenus)==0) {
                echo "Aucuns rôles menus.";
            } else ?>
            <?php foreach ($rolemenus as $rm): ?>
                
                <span><strong><?php echo $rm['name'].'</strong>';?></span>
                <a href="<?php echo site_url('rolemenu/'.$guild->id.'/'.$rm['id']) ?>"><button class="btn btn-outline-warning">Modifier</button></a>
                <span class="dropdown">
                <a class="dropdown-toggle btn btn-outline-success" type="button" id="dropdownChannelsLogs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Envoyer
                </a>
                    <div class="dropdown-menu text-white" style="background-color: #2A2D30; color: white" aria-labelledby="dropdownChannelsLogs" id="ddb<?php echo $rm['id'] ?>">
                        <input type="text" style="background-color: #2A2D30; color: white; background-position: 14px 12px; background-repeat: no-repeat; font-size: 16px; padding: 14px; border: none; border-bottom: 1px solid #ddd;" placeholder="Rechercher un channel" id="myInputLogs<?php echo $rm['id'] ?>" onkeyup="filterFunction('ddb<?php echo $rm['id'] ?>', 'myInputLogs<?php echo $rm['id'] ?>')">
                        <?php
                        foreach ($channels as $c) {
                            if ($c->type==0||$c->type==5)
                                echo "<a class=\"dropdown-item text-white\" href=\"".site_url('Utilisateur/sendRM/'.$guild->id.'/'.$rm['id'].'/'.$c->id)."\">".$c->name."</a>";
                        }
                        ?>
                        <input name="channellogs" id="channellogs" type="hidden" value="<?php echo (isset($channel->id) ? $channel->id : "none") ?>">
                    </div>
                </span>
                <a href="<?php echo site_url('Utilisateur/DeleteRM/'.$rm['id'].'/'.$guild->id) ?>"><button class="btn btn-danger">Supprimer</button></a><br/><br/>

            <?php endforeach; ?>

        </div>
        <a href="<?php echo site_url('rmadd/'.$guild->id) ?>"><button class="mt-2 btn btn-success">Créer un Rôle Menu</button></a>
    </div>
</div>

</div></div>