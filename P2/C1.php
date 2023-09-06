<?php
 
declare(strict_types=1);
 
class User
{
    private const STATUS_ACTIVE = 'active';
    private const STATUS_INACTIVE = 'inactive';
 
    public function __construct(public string $username, private string $status = self::STATUS_ACTIVE)
    {
    }
 
    public function setStatus(string $status): void
    {
        if (!in_array($status, [self::STATUS_ACTIVE, self::STATUS_INACTIVE])) {
            trigger_error(sprintf('Le status %s n\'est pas valide. Les status possibles sont : %s', $status, implode(', ', [self::STATUS_ACTIVE, self::STATUS_INACTIVE])), E_USER_ERROR);
        };

        $this->status = $status;
    }
 
    public function getStatus(): string
    {
        return $this->status;
    }
}
 

class Admin
{
    private const STATUS_ACTIVE = 'active';
    private const STATUS_INACTIVE = 'inactive';
 
    // Ajout d'un tableau de roles pour affiner les droits des administrateurs :)
    public function __construct(public string $username, private array $roles = [], private string $status = self::STATUS_ACTIVE)
    {
    }
 
    public function setStatus(string $status): void
    {
        if (!in_array($status, [self::STATUS_ACTIVE, self::STATUS_INACTIVE])) {
            trigger_error(sprintf('Le status %s n\'est pas valide. Les status possibles sont : %s', $status, implode(', ', [self::STATUS_ACTIVE, self::STATUS_INACTIVE])), E_USER_ERROR);
        };
 
        $this->status = $status;
    }
 
    public function getStatus(): string
    {
        return $this->status;
    }
 
    // Méthode d'ajout d'un rôle, puis on supprime les doublons avec array_filter.
    public function addRole(string $role): void
    {
        $this->roles[] = $role;
        $this->roles = array_filter($this->roles);
    }

    // Méthode de renvoie des rôles, dans lequel on définit le rôle ADMIN par défaut.
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ADMIN';

        return $roles;
    }
 
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
}

$josette = new User("Josette");
echo $josette->getStatus();

var_dump($josette);