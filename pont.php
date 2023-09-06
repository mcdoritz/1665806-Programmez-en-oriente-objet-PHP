<?php

declare(strict_types=1);
class Pont
{

    private const SURFACE_TEXT = 'Ce pont a une surface de %dm²';
    private float $longueur = 0.0;
    private float $largeur = 0.0;

    public function getLongueur(): float
    {
        return $this->longueur;
    }

    public function getLargeur(): float
    {
        return $this->largeur;
    }

    public function setLongueur(float $longueur): void
    {
        if ($longueur > 0 && is_float($longueur))
        {
            $this->longueur = $longueur;
        }
        else
        {
            trigger_error('la valeur entrée est invalide', E_USER_ERROR);
        }
    }

    public function setLargeur(float $largeur): void
    {
        if ($largeur > 0 && is_float($largeur))
        {
            $this->largeur = $largeur;
        }
        else {
            trigger_error('la valeur entrée est invalide', E_USER_ERROR);
        }
    }

    private function getSurface(): float
    {
        return $this->largeur * $this->longueur;
    }

    public function printSurface():void
    {
        echo(sprintf(self::SURFACE_TEXT, $this->getSurface()));
    }
}

$l = 2827.293;
$L = 100;

$pont = new Pont;
$pont->setLongueur($L);
$pont->setLargeur($l);
$pont->printSurface();

class PetitPont
{
    private $longueur=0;

	public static function validerTaille(float $taille):bool
	{
		if($taille < 50.0){
			return false;
		}
        return true;
	}

    public function setLongueur(float $longueur):void
    {
        if(!self::validerTaille($longueur)){
            trigger_error("MARCHE PAS");
        }
        $this->longueur = $longueur;
    }

    public function getLongueur():float
    {
        return $this->longueur;
    }
    
}

var_dump(PetitPont::validerTaille(25.0));
var_dump(PetitPont::validerTaille(150.0));

$petitPont = new PetitPont;
$petitPont->setLongueur(49.0);
echo $petitPont->getLongueur();