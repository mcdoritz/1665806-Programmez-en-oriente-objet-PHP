<?php

declare(strict_types=1);

abstract class User
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const DELAY_CONNECTION = 10;

    public function __construct(public string $email, public string $status = self::STATUS_ACTIVE, $delayConnection = self::DELAY_CONNECTION)
    {
    }

    // le mot clé self a été modifié pour le mot clé static dans la méthode :)
    public function setStatus(string $status): void
    {
        assert(
            in_array($status, [static::STATUS_ACTIVE, static::STATUS_INACTIVE]),
            sprintf('Le status %s n\'est pas valide. Les status possibles sont : %s', $status, implode(', ',[static::STATUS_ACTIVE, static::STATUS_INACTIVE]))
        );
    
        $this->status = $status;
    }
    
    public function getStatus(): string
    {
        return $this->status;
    }
    
    abstract public function getUsername(): string;

    abstract public function getDiffDelay():int;
}

final class Admin extends User
{
    public const STATUS_ACTIVE = 'is_active';
    public const STATUS_INACTIVE = 'is_inactive';
    public const DELAY_CONNECTION = 4;
    
    // Ajout d'un tableau de roles pour affiner les droits des administrateurs :)
    public function __construct(string $email, string $status = self::STATUS_ACTIVE, public array $roles = [],int $delayConnection = self::DELAY_CONNECTION)
    {
        parent::__construct($email, $status, $delayConnection);
    }
    
    public function getUsername(): string
    {
        return $this->email;
    }

    public function getDiffDelay():int
    {
        $delay = User::DELAY_CONNECTION - self::DELAY_CONNECTION;
        return $delay;
    }

    // ...
}

$admin = new Admin('michel@petrucciani.com');
var_dump($admin);
$admin->setStatus(Admin::STATUS_INACTIVE);
echo("<br />Délai : " . $admin->getDiffDelay());