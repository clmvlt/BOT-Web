<?php  
echo form_open('moderation/'.$guild->id);

?>
<div class="row pt-3">
    <div class="col-12">
        <div style="border: 2px solid; border-color: white; width: 400px" class="p-3 d-flex">
            <span>Activer le module modération : </span>
            
            <div class="h-100 w-100 p-2 d-flex justify-content-end">
                <label class="switch">
                    <input onclick="if (this.checked == <?php echo $modEnabled ? 'true' : 'false' ?>) {hide()} else {show()}" type="checkbox" name="modModuleEnabled" <?php echo $modEnabled ? "checked" : "" ?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="row pt-4">
    <div class="col-12">
        <p>Rôles modérateur :</p>
        <div class="dropdown">
        <?php
        foreach ($modRoles as $role) {
            echo '<span class="p-1 m-1" style="background-color: #404549; border-radius: 7px"><span style="color: #'.dechex($role->color).';">◉ </span>'.$role->name.' <a class="pr-1" style="color: #97A9B4; text-decoration: none" href="'.site_url('Utilisateur/removeModRole/'.$guild->id.'/'.$role->id).'">×</a></span>';
        }
        ?>
            <a id="dropdownMenuButton" data-toggle="dropdown" style="cursor: pointer;" aria-haspopup="true" aria-expanded="false"><span class="p-1 m-1" style="background-color: #404549; border-radius: 7px">+</span></a>
            <div class="dropdown-menu text-white" style="background-color: #2A2D30; color: white" aria-labelledby="dropdownMenuButton" id="ddb">
                <input type="text" style="background-color: #2A2D30; color: white; background-position: 14px 12px; background-repeat: no-repeat; font-size: 16px; padding: 14px; border: none; border-bottom: 1px solid #ddd;" placeholder="Rechercher un rôle" id="myInput" onkeyup="filterFunction()">
                <?php
                $map = array_map(function($n) { return $n->id; }, $modRoles);
                foreach ($roles as $role) {
                    if (!in_array($role->id, $map) && !isset($role->tags->bot_id) && !(array_key_exists('tags', $role) && array_key_exists('premium_subscriber', $role->tags)) && $role->id != $guild->id)
                    echo "<a style=\"color: ".((dechex($role->color) == "0") ? "#FFFFFF" : dechex($role->color))."\" class=\"dropdown-item text-white\" href=\"".site_url('Utilisateur/addModRole/'.$guild->id.'/'.$role->id)."\">".$role->name."</a>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<p style="font-size: 10px"><br/>*Ces rôles auront accès aux outils de modération et aux tickets.</p>

</div></div>