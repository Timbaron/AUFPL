<?php

use App\Models\Player;

if (!function_exists('getPlayerNameById')) {

    function getPlayerNameById($playerId)
    {
        $player = Player::wherePlayer_id($playerId)->first();
        return $player->name;
    }
}

?>

