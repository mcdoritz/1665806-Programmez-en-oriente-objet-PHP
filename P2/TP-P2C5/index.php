<?php

/*
 * This file is part of the OpenClassRoom PHP Object Course.
 *
 * (c) Grégoire Hébert <contact@gheb.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Player as GlobalPlayer;

class Lobby
{
    /** @var array<QueuingPlayer> */
    public array $queuingPlayers = [];

    public function findOponents(QueuingPlayer $player): array
    {
        $minLevel = round($player->getRatio() / 100);
        $maxLevel = $minLevel + $player->getRange();

        return array_filter($this->queuingPlayers, static function (QueuingPlayer $potentialOponent) use ($minLevel, $maxLevel, $player) {
            $playerLevel = round($potentialOponent->getRatio() / 100);

            return $player !== $potentialOponent && ($minLevel <= $playerLevel) && ($playerLevel <= $maxLevel);
        });
    }

    public function addPlayer(Player $player): void
    {
        $this->queuingPlayers[] = new QueuingPlayer($player);
    }

    public function addPlayers(Player ...$players): void
    {
        foreach ($players as $player) {
            $this->addPlayer($player);
        }
    }
}

abstract class AbstractPlayer
{

    public const INIT_RATIO = 400.0;

    public function __construct(public string $name = 'anonymous', public float $ratio = self::INIT_RATIO)
    {
    }

    abstract public function getName(): string;

    abstract public function getRatio(): float;

    abstract public function setBlitzRatio(): void;

    abstract protected function probabilityAgainst(self $player): float;

    abstract public function updateRatioAgainst(self $player, int $result): void;
}

class Player extends AbstractPlayer
{
    public function getName(): string
    {
        return $this->name;
    }

    protected function probabilityAgainst(AbstractPlayer $player): float
    {
        return 1 / (1 + (10 ** (($player->getRatio() - $this->getRatio()) / static::INIT_RATIO)));
    }

    public function updateRatioAgainst(AbstractPlayer $player, int $result): void
    {
        $this->ratio += 32 * ($result - $this->probabilityAgainst($player));
    }

    public function getRatio(): float
    {
        return $this->ratio;
    }

    public function setBlitzRatio(): void
    {
        $this->ratio;
    }
    
}

class QueuingPlayer extends Player
{
    public function __construct(AbstractPlayer $player, protected int $range = 1)
    {
        parent::__construct($player->getName(), $player->getRatio());
    }

    public function getRange(): int
    {
        return $this->range;
    }

    public function upgradeRange(): void
    {
        $this->range = min($this->range + 1, 40);
    }
}

class BlitzPlayer extends GlobalPlayer
{
    public const INIT_RATIO = 1200.0;

    public function __construct(public string $name = 'anonymous', public float $ratio = self::INIT_RATIO)
    {
        parent::__construct($name, $ratio);
    }

    public function updateRatioAgainst(AbstractPlayer $player, int $result): void
    {
        $this->ratio += 128 * ($result - $this->probabilityAgainst($player));
    }

}

$greg = new BlitzPlayer('greg');
$jade = new BlitzPlayer('jade');

var_dump($greg);

$lobby = new Lobby();
$lobby->addPlayers($greg, $jade);



exit(0);