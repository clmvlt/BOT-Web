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
<style>
body {
    background: transparent;
    height: 280px
    
}

.progress {
    background: white;
    justify-content: flex-start;
    border-radius: 100px;
    align-items: center;
    padding: 0 5px;
    display: flex;
    height: 40px;
    width: 100%;
}

.progress-value {
    box-shadow: 0 10px 40px -10px #fff;
    border-radius: 100px;
    background: black;
    height: 30px;
    width: 0;
}

</style>
<?php
$pourcentage = ($profil->exp/$xpNextLvl) * 100;
?>
<div style="height: 280px; width: 800px; padding: 25px">
  <div style="display: flex">
    <div>
      <div style="display: block; margin-top: 40px">
        <img src="<?php echo base_url().'assets/images/bois.png' ?>" style="width: 48px; height: 48px; margin-left: auto">
        <span style="font-size: 24px; font-family: FreeMono, monospace; color: white"><?php echo $profil->bois ?></span>
        <img src="<?php echo base_url().'assets/images/pierre.png' ?>" style="width: 40px; height: 40px; margin-left: auto">
        <span style="font-size: 24px; font-family: FreeMono, monospace; color: white"><?php echo $profil->pierre ?></span>
      </div>
    </div>
    <img src="<?php echo $avatarURL ?>" style="width: 128px; height: 128px;display: block;margin-left: auto;margin-right: auto; border-radius: 25%">
    <div>
      <div style="display: block; margin-top: 40px">
        <span style="font-size: 24px; font-family: FreeMono, monospace; color: white"><?php echo $profil->gold ?></span>
        <img src="<?php echo base_url().'assets/images/or.png' ?>" style="width: 48px; height: 48px; margin-right: auto">
        <span style="font-size: 24px; font-family: FreeMono, monospace; color: white"><?php echo $profil->dotcoin ?></span>
        <img src="<?php echo base_url().'assets/images/dotcoin.png' ?>" style="width: 32px; height: 32px; margin-right: auto">
      </div>
    </div>
  </div>
  <div style="display: flex">
  <span style="font-size: 24px; font-family: FreeMono, monospace; color: white; margin-left: auto;margin-right: auto;"><?php echo "Niveau ".$profil->level ?></span>
  </div>
  <div style="width: 100%; padding: 20px">
    <div class="progress">
      <div class="progress-value" style="width:<?php echo $pourcentage ?>%"></div>
    </div>
    <p style="font-size: 24px; font-family: FreeMono, monospace; color: white"><?php echo "($profil->exp/$xpNextLvl)" ?><span style=" float: right;"><?php echo $user->username."#".$user->discriminator ?></span></p>
  </div>
</div>