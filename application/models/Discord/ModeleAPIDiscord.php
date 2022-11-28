<?php
class ModeleAPIDiscord extends CI_Model {

    public function __construct()
    {
    }
 
    public function logWithCode($code) {
        $postdata = http_build_query(
            array(
                'client_id' => '981537507609022554',
                'client_secret' => '4DWNU2oz68bA1Ybbqa0yJcPW5q8woagd',
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => 'http://bot-dot.fr/index.php/Visiteur/Connexion',
                'scope' => 'identify'
            )
        );
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata,
                'ignore_errors' => true
            )
        );
        $context = stream_context_create($opts);
        $res = file_get_contents('https://discord.com/api/oauth2/token', false, $context);
        return json_decode($res);
    }
}