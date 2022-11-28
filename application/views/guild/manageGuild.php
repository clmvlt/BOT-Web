<div class="row">
    <div class="col-12 d-flex justify-content-center">
        <div class="w-100" style="background-image: url(<?php echo $guildIcon ?>);background-repeat: no-repeat; background-size: cover; background-position: center; filter: blur(3px); height: 240px;-webkit-filter: blur(3px);" class="align-self-center mt-2"></div>
        <img class="server-card align-self-center" src="<?php echo $guildIcon ?>" class="card-img-top" style="width: 180px; border-radius: 50%; filter: drop-shadow(10px 10px 25px black); position: absolute">
    </div>
</div>
<div class="row pt-3">
    <div class="col-12 d-flex justify-content-center">
        <h1><?php echo $guild->name; ?></h1>
    </div>
    <div class="col-12 d-flex justify-content-center">
        <p style="font-size='15px'">Propriétaire : <?php echo $guildOwner->username."#".$guildOwner->discriminator; ?></p>
    </div>
    <?php if ($guild->description != null) : ?>
        <div class="col-12 d-flex justify-content-center">
            <p style="font-size='15px'"><?php echo $guild->description ?></p>
        </div>
    <?php endif ?>
</div>
<div class="row pt-3">
    <div class="col-12">
        <div class="p-2" style="border:2px solid; border-color: white">
            <span>Emojis : </span>
            <?php
                if (count($emojis)==0) echo "<span>Aucuns</span>";
                foreach ($emojis as $e) {
                    echo "<img style='width: 32px;height: 32px;' src=\"https://cdn.discordapp.com/emojis/".$e->id."\">   ";
                }
            ?>
        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col-12">
        <div class="p-2" style="border: 2px solid; border-color: white">
            <span>Roles : </span>
            <?php
                foreach ($guild->roles as $role) {
                    echo '<span class="p-1 m-1" style="background-color: #404549; border-radius: 7px"><span style="color: #'.dechex($role->color).';">◉ </span>'.$role->name.'</span>';
                }
            ?>
        </div>
    </div>
</div>

<!-- Fin des divs pour le panel module -->
</div>
</div>