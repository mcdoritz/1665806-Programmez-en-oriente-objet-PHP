<?php

// vos classes ici.

    

class Encounter{

    const RESULT_WINNER = 1;
    const RESULT_LOSER = -1;
    const RESULT_DRAW = 0;
    const RESULT_CANCELED = 2;
    const RESULT_POSSIBILITIES = [self::RESULT_WINNER, self::RESULT_DRAW, self::RESULT_LOSER];

    public static function probabilityAgainst(Player $levelPlayer1, Player $levelPlayer2):float
    {
        return 1/(1+(10 ** (($levelPlayer2->level - $levelPlayer1->level)/400)));
    }

    public static function setNewLevel(Player $levelPlayer1, Player $levelPlayer2,int $resultPlayer1)
    {
        if(!in_array($resultPlayer1, self::RESULT_POSSIBILITIES))
        {
            trigger_error("Erreur dans le résultat du match");
        }
        $levelPlayer1->level += (int) (32 * ($resultPlayer1 - self::probabilityAgainst($levelPlayer1, $levelPlayer2)));
    }
}

class Player{

    public int $level = 0;

}

$greg = new Player;
$jade = new Player;

$greg->level = 400;
$jade->level = 800;

echo sprintf(
	'Greg à %.2f%% chance de gagner face a Jade', 
	Encounter::probabilityAgainst($greg, $jade)*100
).PHP_EOL;

// Imaginons que greg l'emporte tout de même.
Encounter::setNewLevel($greg, $jade, Encounter::RESULT_WINNER);
Encounter::setNewLevel($jade, $greg, Encounter::RESULT_LOSER);

echo sprintf(
	'les niveaux des joueurs ont évolués vers %s pour Greg et %s pour Jade', 
	$greg->level,
	$jade->level
);

exit(0);