<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha256-CjSoeELFOcH0/uxWu6mC/Vlrc1AARqbm/jiiImDGV3s=" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
    
    <link rel="stylesheet" href="css/hierarchy-select.min.css">
    <script src="js/hierarchy-select.min.js"></script>
  
    <title>DOT</title>
  </head>
<body>

  <nav class="navbar navbar-expand-lg navbar navbar-dark" style="background-color: #23272A">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active mr-5 mb-2 mt-2">
                    <a href='http://discord.bot-dot.fr'><button class="btn btn-info" type="button">Serveur de support</button></a>
                    </li>
                    <li class="nav-item active mr-5 mb-2 mt-2">
                    <a href='https://discord.com/api/oauth2/authorize?client_id=981537507609022554&permissions=8&redirect_uri=http%3A%2F%2Fbot-dot.fr%2Findex.php%2FVisiteur%2FaddedToGuild&response_type=code&scope=bot'><button class="btn btn-success" type="button">Invite</button></a>
                    </li>
                    <li class="nav-item active mr-5 mb-2 mt-2">
                        <a class="nav-link" href="<?php echo site_url(); ?>">Accueil</a>
                    </li>
                    <li class="nav-item active mr-5 mb-2 mt-2">
                        <a class="nav-link" href="<?php echo site_url('serveurs'); ?>">Serveurs</a>
                    </li>
                    <li class="nav-item active mr-5 mb-2 mt-2">
                        <a class="nav-link" href="<?php echo site_url('aide'); ?>">Commandes</a>
                    </li>
                </ul>
            </div>
            <?php if (!is_null($this->session->id)) : ?>
              <div class="dropdown dropleft">
                  <a class="dropdown-toggle" href="#" style="text-decoration: none; color: white" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <img src="<?php echo $avatarURL ?>">
                  </a>
                  <div class="dropdown-menu text-white" aria-labelledby="navbarDropdown" style="background-color: #23272A">
                      <span class="dropdown-item bg-dark text-white" href="#"><?php echo $tag; ?></span>
                      <a class="dropdown-item text-white" href="<?php echo site_url('serveurs'); ?>">Mes serveurs</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="<?php echo site_url('Visiteur/seDeconnecter') ?>"><button class="btn btn-info" type="button">Se déconnecter</button></a>
                    </div>
                  </div>
          <?php else : ?>
              <a href="<?php echo site_url('Visiteur/seConnecter') ?>"><button class="btn btn-outline-info" type="button">Connexion</button></a>
          <?php endif; ?>
          </div>
</nav>
<style>
body {
    background-color: #2C2F33;
    color: white;
}

.nav-pills .nav-link {
  color: white;
}
.nav-pills .nav-link:hover {
  background-color: #A9A9A9;
}

.nav-pills .nav-link.active {
  background-color: #7289DA;
  color: black;
}

.dropdown-item:hover {
  background-color: #7289DA;
  color: black;
}

.tab-content {
  border: 1px solid #dee2e6;
  padding: 15px;
  margin: 15px;
}

.dropdown-menu {
    max-height: 280px;
    overflow-y: auto;
}

::-webkit-scrollbar {
  width: 10px;
}

::-webkit-scrollbar-thumb {
  background: #23272A;
}

::-webkit-scrollbar-track {
  background: #2B2F32;
}

::-webkit-scrollbar-thumb:hover {
  background: #35393D;
}

.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<script>
function elementPosition (a) {
  var b = a.getBoundingClientRect();
  return {
    clientX: a.offsetLeft,
    clientY: a.offsetTop,
    viewportX: (b.x || b.left),
    viewportY: (b.y || b.top)
  }
}

async function hide() {
  var div = document.getElementById('saveDiv');
  if (div.style.display == 'none') return;
    var posBot = 0;
    var x = await setInterval(() => {
        posBot-=5;
        div.style.bottom=posBot;
        if (posBot<-100) clearInterval(x);
    }, 15);
    setTimeout(() => {
      div.style.display = 'none';
    }, 300);
}

function show() {
    var div = document.getElementById('saveDiv');
    if (div.style.display == 'block') return;
    div.style.display = 'block';
    var posBot = -100;
    var x = setInterval(() => {
        posBot+=5;
        div.style.bottom=posBot;
        if (posBot>=0) clearInterval(x);
    }, 15);
}


function setText(id, text) {
        document.getElementById(id).text = text;
    }

    function setValue(id, value) {
        document.getElementById(id).value = value;
    }

    function showDiv(div) {
        document.getElementById(div).style.display = 'block';
    }

    function hideDiv(div) {
        document.getElementById(div).style.display = 'none';
    }
</script>