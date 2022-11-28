
<div class="row">
    <div class="col-lg-1 col-sm-3 col-xs-0"></div>
    <div class="col-lg-10 col-sm-6 col-xs-12">
        <div class="row d-flex justify-content-center">
            <?php 
                foreach ($guilds as $g) {
                    if ($g->icon == null) {
                        $icon = base_url()."assets/images/avatarVide.jpg";
                    } else { 
                        $icon = "https://cdn.discordapp.com/icons/".$g->id."/".$g->icon.".png";
                    };
                    echo '
                        <div class="card m-2" style="width: 20rem; background-color:#26292C">
                            <div style="background-image: url('."'".$icon."'".');background-repeat: no-repeat; background-size: cover; background-position: center; filter: blur(3px); width: 18rem; height: 120px;-webkit-filter: blur(3px);" class="align-self-center mt-2"></div>
                            <img class="server-card mt-4 align-self-center" src="'.$icon.'" class="card-img-top" style="width: 80px; border-radius: 50%; filter: drop-shadow(10px 10px 25px black); position: absolute">
                            <div class="card-body">
                                <p class="card-text">'.$g->name.'</p>
                                <div class="d-flex justify-content-end"><a href="'.site_url('informations/'.$g->id).'" class="card-btn btn btn-secondary">Configurer</a></div>
                            </div>
                        </div>
                    ';
                }
            ?>
            <?php 
                foreach ($guildsCanAddeds as $g) {
                    if ($g->icon == null) {
                        $icon = base_url()."assets/images/avatarVide.jpg";
                    } else { 
                        $icon = "https://cdn.discordapp.com/icons/".$g->id."/".$g->icon.".png";
                    };
                    echo '
                        <div class="card m-2" style="width: 20rem; background-color:#26292C">
                            <div style="background-image: url('."'".$icon."'".');background-repeat: no-repeat; background-size: cover; background-position: center; filter: blur(3px); width: 18rem; height: 120px;-webkit-filter: blur(3px);" class="align-self-center mt-2"></div>
                            <img class="server-card mt-4 align-self-center" src="'.$icon.'" class="card-img-top" style="width: 80px; border-radius: 50%; filter: drop-shadow(10px 10px 25px black); position: absolute">
                            <div class="card-body">
                                <p class="card-text">'.$g->name.'</p>
                                <div class="d-flex justify-content-end"><a href="
                                https://discord.com/api/oauth2/authorize?client_id=981537507609022554&permissions=8&redirect_uri=http%3A%2F%2Fbot-dot.fr%2Findex.php%2FVisiteur%2FaddedToGuild&response_type=code&scope=identify%20bot&guild_id='.$g->id.'
                                " class="card-btn btn btn-warning">Ajouter</a></div>
                            </div>
                        </div>
                    ';
                }
            ?>
        </div>
    </div>
    <div class="col-lg-1 col-sm-3"></div>
</div>