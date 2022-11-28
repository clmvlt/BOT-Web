<?php if (is_null($this->session->id)) : ?>
    <a href="<?php echo(site_url('Visiteur/seConnecter')) ?>"><button>Se connecter</button></a>
<?php else : ?>
    <a href="<?php echo(site_url('Visiteur/seDeconnecter')) ?>"><button>Se deconnecter</button></a>
    <p>Connecté en tant que <?php echo $tag ?></p>
<?php endif ?>