<script src="https://twemoji.maxcdn.com/v/latest/twemoji.min.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/createrm.css">
<?php echo form_open('rolemenu/'.$guild->id.'/'.$rolemenu->id) ?>
<script>
    <?php
    $dir = './assets/images/emotes/';
    $dir_handle = opendir($dir);
    $images = array();
    while ($entry = readdir($dir_handle)) {
        if (is_file($dir . '/' . $entry))
            array_push($images, $entry);
    }
    closedir($dir_handle);

    echo "var images = " . json_encode($images) . '; var basepath = "' . base_url() . '";
    var guildEmotes = ' . json_encode($guild->emojis) . ';
    var roles = '.json_encode($roles).';
    var rolesemotes = '.json_encode($rolesemotes).';
    var guild = '.json_encode($guild).';
    ';
    ?>
</script>

<div class="row">
    <div class="col-12">
        <div class="p-3" style="border: 2px solid; border-color: white">
            <?php
            if (validation_errors() != null) {
                echo '<div class="alert alert-danger" role="alert">
               Une erreur s\'est produite.
                </div>';
            }
            ?>
            <p>Nom du rôle menu :</p>
            <input placeholder='Nom' onkeyup="show()" type="text" name="rmname" class="inputname" required minlength="1" maxlength="50" value="<?php echo isset($rolemenu->name) ? $rolemenu->name : "" ?>"></input>
            <br /><br />

            <p>Message :</p>
            <textarea name='messagecontent' onkeyup="show()" cols="60" rows="13" class='textareamsg' placeholder="🍌 Rôle Banane
🍎 Rôle Pomme

Clique sur un rôle pour attribuer un fruit !" required minlength="1" maxlength="2000"><?php echo isset($rolemenu->message) ? $rolemenu->message : "" ?></textarea><br /><br />

            <br />
            <div class="ml-1 button b2" id="button-10" style='border: 1px solid; border-color: white'>
                <input type="checkbox" onkeyup="show()" onclick="show()" class="checkbox" <?php echo (isset($rolemenu->buttons) && $rolemenu->buttons =='t') ? 'checked' : ""; ?> name="buttons"/>
                <div class="knobs">
                    <span>Emoji</span>
                </div>
                <div class="layer"></div>
            </div>
            <br /><br />


            <div class="mt-2 rmlist" id="rmlist">
            </div>


            <span id='loading'>Chargement des emojis...</span>
            <div id="ddEmotes" style="width: 32px; height: 32px">
                <div id='img'>&#x1F600</div>
            </div>

            <div class="list-emotes ml-3 mt-1" id='list-emotes'>
                <input placeholder='Émoji' type='text' id='emotename' class="emotename" onkeyup='filteremotes()'><br />
            </div>

            <br/>

            <div id="submitrm">
            </div>
        </div>
    </div>
</div>
</div>
<script>
    twemoji.parse(document.body);
</script>
<script type='text/javascript' src="<?php echo base_url() ?>assets/js/emotes.js"></script>