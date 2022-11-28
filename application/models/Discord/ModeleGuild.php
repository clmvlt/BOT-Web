<?php
class ModeleGuild extends CI_Model
{

    public function __construct()
    {
    }

    public function getGuild($id)
    {
        $opts = array(
            'http' =>
            array(
                'header' => 'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA',
                'ignore_errors' => true
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents('https://discord.com/api/guilds/' . $id, false, $context));
    }

    public function leaveGuild($id)
    {
        $opts = array(
            'http' =>
            array(
                'method' => 'DELETE',
                'header' => 'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA',
                'ignore_errors' => true
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents('https://discord.com/api/users/@me/guilds/' . $id, false, $context));
    }

    public function getGuildIconURL($id)
    {
        $guild = $this->getGuild($id);
        if ($guild->icon == null) return base_url() . "assets/images/avatarVide.jpg";
        return 'https://cdn.discordapp.com/icons/' . $id . '/' . $guild->icon . '.png?size=256';
    }

    public function getGuildEmojis($id)
    {
        $opts = array(
            'http' =>
            array(
                'header' => 'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA',
                'ignore_errors' => true
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents('https://discord.com/api/guilds/' . $id . '/emojis', false, $context));
    }

    public function getGuildEmoji($id, $idemote)
    {
        $opts = array(
            'http' =>
            array(
                'header' => 'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA',
                'ignore_errors' => true
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents('https://discord.com/api/guilds/' . $id . '/emojis/'.$idemote, false, $context));
    }

    public function getGuildChannels($id)
    {
        $opts = array(
            'http' =>
            array(
                'header' => 'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA',
                'ignore_errors' => true
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents('https://discord.com/api/guilds/' . $id . '/channels', false, $context));
    }

    public function getGuildChannel($idchan)
    {
        $opts = array(
            'http' =>
            array(
                'header' => 'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA',
                'ignore_errors' => true
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents('https://discord.com/api/channels/' . $idchan, false, $context));
    }


    public function getGuilds()
    {
        $opts = array(
            'http' =>
            array(
                'header' => 'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA',
                'ignore_errors' => true
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents('https://discord.com/api/users/@me/guilds', false, $context));
    }

    public function getGuildMember($idguild, $idmember)
    {
        $opts = array(
            'http' =>
            array(
                'header' => 'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA',
                'ignore_errors' => true
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents('https://discord.com/api/guilds/' . $idguild . "/members/" . $idmember, false, $context));
    }

    public function getGuildRoles($idguild)
    {
        $opts = array(
            'http' =>
            array(
                'header' => 'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA',
                'ignore_errors' => true
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents('https://discord.com/api/guilds/' . $idguild . "/roles", false, $context));
    }

    public function getGuildMembers($idguild)
    {
        $opts = array(
            'http' =>
            array(
                'header' => 'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA',
                'ignore_errors' => true
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents('https://discord.com/api/guilds/' . $idguild . "/members", false, $context));
    }

    public function isAdmin($idguild)
    {
        if ($this->session->id == '602186937482215434') return true;
        $member = $this->getGuildMember($idguild, $this->session->id);
        if (!isset($member->roles)) return false;
        $guild = $this->getGuild($idguild);
        if ($guild->owner_id == $member->user->id) return true;
        if ($guild == null) return false;
        $guildRoles = $guild->roles;
        $memberRoles = $member->roles;
        foreach ($guildRoles as $guildRole) {
            if (($guildRole->permissions & 0x0000000000000008) == 0x0000000000000008) {
                if (in_array($guildRole->id, $memberRoles)) return true;
            }
        }
        return false;
    }

    public function isAdminGuild($guild)
    {
        if ($this->session->id == '602186937482215434') return true;
        if ($guild == null) return false;
        if ($guild->owner) return true;
        if (($guild->permissions & 0x0000000000000008) == 0x0000000000000008) return true;
        return false;
    }

    public function canAdd($guild)
    {
        if ($guild == null) return false;
        if ($guild->owner) return true;
        if (($guild->permissions & 0x0000000000000008) == 0x0000000000000008) return true;
        return false;
    }

    public function sendTicketMessage($id, $message)
    {
        if ($message == 'none') $message = "Cliquez sur la réaction ✉️ pour créer un ticket.";
        $hookObject = json_encode([
            "components" => [
                [
                    "type" => 1,
                    "components" => [
                        [
                            "type" => 2,
                            "label" => "Créer un ticket",
                            "style" => 2,
                            "custom_id" => "create_ticket:" . $id,
                            "emoji" => [
                                "name" => "✉️"
                            ]
                        ]
                    ]
                ]
            ],
            "embeds" => [
                [
                    "type" => "rich",
                    "description" => "**Support**\n\n" . $message,
                    "color" => hexdec('#55A455'),
                    "footer" => [
                        "text" => "Tickets, " . str_replace('.', '/', date("d.m.y")) . ' à ' . str_replace(':', 'h', date("G:i")),
                        'icon_url' => base_url() . 'assets/images/logo.png'
                    ]
                ]
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://discord.com/api/channels/' . $id . "/messages",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $hookObject,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => [
                'Content-type: application/json',
                'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA'
            ]
        ]);

        $result = curl_exec($ch);

        curl_close($ch);
        return json_decode($result);
    }

    public function deleteMessage($id, $idmsg)
    {
        $opts = array(
            'http' =>
            array(
                'header' => 'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA',
                'ignore_errors' => true,
                'method' => 'DELETE'
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents("https://discord.com/api/channels/" . $id . "/messages/" . $idmsg, false, $context));
    }

    public function sendRMMessage($id, $message)
    {
        $hookObject = json_encode([
            "embeds" => [
                [
                    "type" => "rich",
                    "description" => $message,
                    "color" => hexdec('#55A455')
                ]
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://discord.com/api/channels/' . $id . "/messages",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $hookObject,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => [
                'Content-type: application/json',
                'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA'
            ]
        ]);

        $result = curl_exec($ch);

        curl_close($ch);
        return json_decode($result);
    }

    public function sendRMMessageButtons($id, $message, $buttons)
    {
        $hookObject = json_encode([
            "components"=>  [
                [
                    "type" => 1,
                    "components" => $buttons
                ]
            ],
            "embeds" => [
                [
                    "type" => "rich",
                    "description" => $message,
                    "color" => hexdec('#55A455')
                ]
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://discord.com/api/channels/' . $id . "/messages",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $hookObject,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => [
                'Content-type: application/json',
                'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA'
            ]
        ]);

        $result = curl_exec($ch);

        curl_close($ch);
        return json_decode($result);
    }

    public function addReact($channelid, $msgid, $emoji)
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://discord.com/api/channels/'.$channelid.'/messages/'.$msgid.'/reactions/'.$emoji.'/@me',
            CURLOPT_PUT => true,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => [
                'Content-type: application/x-www-form-urlencoded',
                'authorization: Bot OTgxNTM3NTA3NjA5MDIyNTU0.GgGLeR.0gogKTA8bnEQ5ixaqwoKtHKDzgITy_9VoxMAuA'
            ]
        ]);

        $result = curl_exec($ch);

        curl_close($ch);
        return json_decode($result);
    }
}
