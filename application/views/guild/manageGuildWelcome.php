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
echo form_open('welcome/' . $guild->id);

?>
<div class="row pt-3">
    <div class="col-12">
        <div style="border: 2px solid; border-color: white; width: 400px" class="p-3 d-flex">
            <span>Activer le module de bienvenue : </span>

            <div class="h-100 w-100 p-2 d-flex justify-content-end">
                <label class="switch">
                    <input onclick="show()" type="checkbox" name="welcomeModuleEnabled" <?php echo $welcomeEnabled ? "checked" : "" ?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
</div>

<?php
$titres = array(
    'join' => "Envoyer un message lorsque quelqu'un rejoint le serveur.",
    'leave' => "Envoyer un message lorsque quelqu'un quitte le serveur.",
    'joinimg' => "Envoyer une image lorsque quelqu'un rejoint le serveur."
)
?>

<?php foreach ($welcomeTypes as $type) :
    $channel = array_search($type->channelid, array_column($channels, 'id'));
    if ($channel !== false) $channel = $channels[$channel];
    $type->enabled = $type->enabled == 't';
?>
    <div class="mt-4 p-3" style="border: solid 2px; border-color: white">
        <span><?php echo $titres[$type->libelle] ?></span>
        <label class="switch">
            <input onclick="if (this.checked) {showDiv('div<?php echo $type->libelle ?>')} else {hideDiv('div<?php echo $type->libelle ?>')}; show()" type="checkbox" name="check<?php echo $type->libelle ?>" <?php echo (isset($type->enabled) && $type->enabled) ? "checked" : "" ?>>
            <span class="slider round"></span>
        </label>
    </div>
    <div class="p-3" id="div<?php echo $type->libelle ?>" style="border: solid 2px; border-color: white; display: <?php echo (isset($type->enabled) && $type->enabled) ? "block" : "none" ?>">
        <div class="row">
            <?php if ($type->libelle != 'joinimg') : ?>
            <div class="col-12">
                <div class="dropdown">
                    <span>Salon :
                        <a class="dropdown-toggle ml-3 p-2" style="border: solid 2px; border-color:white; ;background-color: #2A2D30; color: white; background-position: 14px 12px;" type="button" id="dropdownChannels<?php echo $type->libelle ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo isset($channel->name) ? $channel->name : "Aucun" ?>
                        </a>
                        <div class="dropdown-menu text-white" style="background-color: #2A2D30; color: white" aria-labelledby="dropdownChannels<?php echo $type->libelle ?>" id="ddb<?php echo $type->libelle ?>">
                            <input type="text" style="background-color: #2A2D30; color: white; background-position: 14px 12px; background-repeat: no-repeat; font-size: 16px; padding: 14px; border: none; border-bottom: 1px solid #ddd;" placeholder="Rechercher un channel" id="myInput<?php echo $type->libelle ?>" onkeyup="filterFunction('ddb<?php echo $type->libelle ?>', 'myInput<?php echo $type->libelle ?>')">
                            <?php
                            foreach ($channels as $c) {
                                if ($c->type == 0)
                                    echo "<a class=\"dropdown-item text-white\" onclick='setText(\"dropdownChannels$type->libelle\", \"$c->name\");setValue(\"channel$type->libelle\", \"$c->id\");show()'>" . $c->name . "</a>";
                            }
                            ?>
                            <input name="channel<?php echo $type->libelle ?>" id="channel<?php echo $type->libelle ?>" type="hidden" value="<?php echo (isset($channel->id) ? $channel->id : "none") ?>">
                        </div>
                </div>
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
                    echo form_open('welcome/' . $guild->id);
                    echo "<textarea rows='3' cols='60' onkeyup='show()' style='background-color: #2A2D30; color: white;border: solid 1px;border-color:white;' type='text' id='message$type->libelle' name='message$type->libelle' maxlength=2000>" . (isset($type->message) && $type->message != "none" ? $type->message : "") . "</textarea>";
                    ?>
                    </p>
                    <p style="font-size: 15px">Options : {user.username}, {user.id}, {user.tag}</p>
                    <p style="font-size: 10px">*none : Message de base du bot.</p>
                </div>
            <?php else :
                echo "<input type='hidden' id='message$type->libelle' name='message$type->libelle'></input>";
                echo "<input name='channel$type->libelle' type='hidden' value='none'>";
            endif; ?>
        </div>
        <?php if ($type->libelle == 'joinimg') : ?>
            <div class="row pt-4">
                <div class="col-12">
                    <canvas width="800" height="300" id="canvas" style='border :solid 2px; border-color: white'>
                        Désolé, votre navigateur ne prend pas en charge &lt;canvas&gt;.
                    </canvas>
                    <p style="font-size: 10px"><br />*Les bords blanc ne seront pas affichés.</p>
                </div>
            </div>
            <input type='hidden' name='text' id='posttext'>
            <input type='hidden' name='textx' id='posttextx'>
            <input type='hidden' name='texty' id='posttexty'>
            <input type='hidden' name='textpolice' id='posttextpolice'>
            <input type='hidden' name='textcolor' id='posttextcolor'>
            <input type='hidden' name='texttransparent' id='posttexttransparent'>
            <input type='hidden' name='imagecolor' id='postimagecolor'>
            <input type='hidden' name='imagex' id='postimagex'>
            <input type='hidden' name='imagey' id='postimagey'>
            <input type='hidden' name='imagesize' id='postimagesize'>
            <input type='hidden' name='bgtransparent' id='postbgtransparent'>
            <input type='hidden' name='bgcolor' id='postbgcolor'>
            <input type='hidden' name='bgimage' id='postbgimage'>
            <img id="img_avatar" src="<?php echo base_url() . 'assets/images/avatarVide.jpg' ?>" style="display:none;" />
            <script>
                var canvasW = 800,
                    canvasH = 300
                var canvas = document.querySelector('canvas');
                var ctx = canvas.getContext('2d');
                var bgColor = "<?php echo (isset($confImg->bgcolor) ? ($confImg->bgcolor) : 'transparent') ?>",
                    bgImg = `<?php echo (isset($confImg->bgimage) ? $confImg->bgimage : "") ?>`,
                    text = `<?php echo (isset($confImg->text) ? $confImg->text : 'Bienvenue,
{user.username}') ?>`,
                    textx = <?php echo (isset($confImg->textx) ? ($confImg->textx) : "0") ?>,
                    texty = <?php echo (isset($confImg->texty) ? ($confImg->texty) : "0") ?>,
                    textpolice = <?php echo (isset($confImg->textpolice) ? ($confImg->textpolice) : '32') ?>,
                    textcolor = "<?php echo (isset($confImg->textcolor) ? ($confImg->textcolor) : 'white') ?>",
                    imgSize = <?php echo (isset($confImg->imagesize) ? ($confImg->imagesize) : '150') ?>,
                    imgX = <?php echo (isset($confImg->imagex) ? ($confImg->imagex) : '0') ?>,
                    imgY = <?php echo (isset($confImg->imagey) ? ($confImg->imagey) : '0') ?>;

                function setBg(color) {
                    ctx.fillStyle = color;
                    if (bgImg && bgImg != '') {
                        const img = new Image(800, 300);
                        img.src = bgImg;
                        ctx.drawImage(img, 0, 0, 800, 300);
                    } else if (bgColor == 'transparent') {
                        ctx.clearRect(0, 0, 800, 300);
                    } else {
                        ctx.fillRect(0, 0, 800, 300);
                    }
                }

                function setImg() {
                    var image = document.getElementById('img_avatar');
                    ctx.drawImage(image, (canvasW / 2) - (imgSize / 2) + imgX, 35 + imgY, imgSize, imgSize);
                }

                function setText(text, police, color, x, y) {
                    var texts = text.split('\n');
                    ctx.font = police + 'px FreeMono, monospace';
                    ctx.fillStyle = color;
                    ctx.textAlign = 'center';
                    for (var i = 0; i < texts.length; i++) {
                        ctx.fillText(texts[i], (canvasW / 2) + x, (canvasH - 72) + y + i * police);
                    }
                }


                function updateCanvas() {
                    //TEXT
                    text = document.getElementById('canvasTxt').value;
                    textx = parseInt(!document.getElementById('canvasX').value ? '0' : document.getElementById('canvasX').value);
                    texty = parseInt(!document.getElementById('canvasY').value ? '0' : document.getElementById('canvasY').value);
                    textpolice = parseInt(!document.getElementById('canvasTxtPolice').value ? '0' : document.getElementById('canvasTxtPolice').value);
                    bgCheck = document.getElementById('textcolorcheck').checked;
                    textcolor = bgCheck ? "transparent" : document.getElementById('textcolor').value;

                    // Image
                    imgX = parseInt(!document.getElementById('canvasImgX').value ? '0' : document.getElementById('canvasImgX').value);
                    imgY = parseInt(!document.getElementById('canvasImgY').value ? '0' : document.getElementById('canvasImgY').value);
                    imgSize = parseInt(!document.getElementById('canvasImgSize').value ? '150' : document.getElementById('canvasImgSize').value);

                    // BG
                    bgCheck = document.getElementById('bgcheck').checked;
                    bgColor = bgCheck ? "transparent" : document.getElementById('bgcolor').value;
                    bgImg = document.getElementById('bgimg').value;

                    // SET IN FORM
                    document.getElementById('posttext').value = text;
                    document.getElementById('posttextx').value = textx;
                    document.getElementById('posttexty').value = texty;
                    document.getElementById('posttextpolice').value = textpolice;
                    document.getElementById('posttextcolor').value = textcolor;
                    document.getElementById('posttexttransparent').value = bgCheck;
                    document.getElementById('postimagecolor').value = 'none';
                    document.getElementById('postimagex').value = imgX;
                    document.getElementById('postimagey').value = imgY;
                    document.getElementById('postimagesize').value = imgSize;
                    document.getElementById('postbgtransparent').value = bgCheck;
                    document.getElementById('postbgcolor').value = bgColor;
                    document.getElementById('postbgimage').value = bgImg;

                    setBg(bgColor);
                    setImg();
                    setText(text, textpolice, textcolor, textx, texty);
                    show();
                }

                setBg(bgColor);
                setImg();
                setText(text, textpolice, textcolor, textx, texty);
                setTimeout(() => {
                    setBg(bgColor);
                    setImg();
                    setText(text, textpolice, textcolor, textx, texty);
                }, 1000);
            </script>

            <div class='row'>
                <div class="col-12">
                    <div class='col-6 p-3 mt-3' style='border :solid 2px; border-color: white'>
                        <h5>Texte : </h5>
                        <textarea onKeyUp='updateCanvas()' style='width:500px; height: 110px' id='canvasTxt'><?php echo (isset($confImg->text) ? ($confImg->text) : 'Bienvenue,
{user.username}') ?></textarea><br />
                        <span>X : </span>
                        <input type='number' value=<?php echo (isset($confImg->textx) ? ($confImg->textx) : 0) ?> onchange='updateCanvas()' onClick='updateCanvas()' style='width: 70px' id='canvasX'>
                        <span> Y : </span>
                        <input type='number' value=<?php echo (isset($confImg->texty) ? ($confImg->texty) : 0) ?> onchange='updateCanvas()' onClick='updateCanvas()' style='width: 70px' id='canvasY'><br />
                        <span> Police : </span>
                        <input type='number' value=<?php echo (isset($confImg->textpolice) ? ($confImg->textpolice) : 32) ?> onchange='updateCanvas()' onClick='updateCanvas()' value=32 style='width: 50px' id='canvasTxtPolice'><br />
                        <span>Couleur </span><input onchange='updateCanvas()' id='textcolor' type='color' value='<?php echo (isset($confImg->textcolor) ? ($confImg->textcolor) : '#FFFFFF') ?>'></input><span> Transparent </span><input onchange='updateCanvas()' onClick='updateCanvas()' id='textcolorcheck' type='checkbox' <?php echo ((isset($confImg->texttransparent)&&$confImg->texttransparent=='t') ? "checked": "") ?>></input><br />
                    </div>

                    <div class='col-6 p-3 mt-3' style='border :solid 2px; border-color: white'>
                        <h5>Image : </h5>
                        <span>X : </span>
                        <input type='number' value=<?php echo (isset($confImg->imagex) ? ($confImg->imagex) : 0) ?> onchange='updateCanvas()' onClick='updateCanvas()' style='width: 70px' id='canvasImgX'>
                        <span> Y : </span>
                        <input type='number' value=<?php echo (isset($confImg->imagey) ? ($confImg->imagey) : 0) ?> onchange='updateCanvas()' onClick='updateCanvas()' style='width: 70px' id='canvasImgY'><br />
                        <span> Taile : </span>
                        <input type='number' value=<?php echo (isset($confImg->imagesize) ? ($confImg->imagesize) : 150) ?> onchange='updateCanvas()' onClick='updateCanvas()' value=150 style='width: 50px' id='canvasImgSize'><br />
                    </div>

                    <div class='col-4 p-3 mt-3' style='border :solid 2px; border-color: white'>
                        <h5>Background : </h5>
                        <input onchange='updateCanvas()' value=<?php echo (isset($confImg->bgcolor) ? ($confImg->bgcolor) : '#000000') ?> onClick='updateCanvas()' id='bgcolor' type='color'></input><span> Transparent </span><input onchange='updateCanvas()' onClick='updateCanvas()' id='bgcheck' type='checkbox' <?php echo (isset($confImg->bgtransparent)&&$confImg->bgtransparent=='f' ? "": "checked") ?>></input><br />
                        <span>Image (url) </span><input  onKeyUp='updateCanvas()' onchange='updateCanvas()' value="<?php echo (isset($confImg->bgimage) ? ($confImg->bgimage) : '') ?>" onClick='updateCanvas()' style='width: 300px' id='bgimg' type='text'></input>
                    </div>

                    <div class='mt-3'>
                        <a href="<?php echo site_url('Utilisateur/removeWelcomeImage/'.$guild->id) ?>"><button type='button' class="btn btn-danger">Réinitialiser</button></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<div class="row pt-4">
    <div class="col-12">
        <p>Rôles :</p>
        <div class="dropdown">
            <?php
            foreach ($welcomeRoles as $role) {
                echo '<span class="p-1 m-1" style="background-color: #404549; border-radius: 7px"><span style="color: #' . dechex($role->color) . ';">◉ </span>' . $role->name . ' <a class="pr-1" style="color: #97A9B4; text-decoration: none" href="' . site_url('Utilisateur/removeWelcomeRole/' . $guild->id . '/' . $role->id) . '">×</a></span>';
            }
            ?>
            <a id="dropdownMenuButton" data-toggle="dropdown" style="cursor: pointer;" aria-haspopup="true" aria-expanded="false"><span class="p-1 m-1" style="background-color: #404549; border-radius: 7px">+</span></a>
            <div class="dropdown-menu text-white" style="background-color: #2A2D30; color: white" aria-labelledby="dropdownMenuButton" id="ddbb">
                <input type="text" style="background-color: #2A2D30; color: white; background-position: 14px 12px; background-repeat: no-repeat; font-size: 16px; padding: 14px; border: none; border-bottom: 1px solid #ddd;" placeholder="Rechercher un rôle" id="myInputb" onkeyup="filterFunctionb()">
                <?php
                foreach ($roles as $role) {
                    if (!in_array($role->id, array_column($welcomeRoles, 'id')) && !isset($role->tags->bot_id) && !(array_key_exists('tags', $role) && array_key_exists('premium_subscriber', $role->tags)) && $role->id != $guild->id) echo "<a style=\"color: " . ((dechex($role->color) == "0") ? "#FFFFFF" : dechex($role->color)) . "\" class=\"dropdown-item \" href=\"" . site_url('Utilisateur/addWelcomeRole/' . $guild->id . '/' . $role->id) . "\">" . $role->name . "</a>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<p style="font-size: 10px"><br />*Ces rôles seront atribués à l'arrivée d'un membre sur le serveur.</p>
<script>setInterval(updateCanvas(), 1000)</script>
</div>
</div>