<?php


class TopChanteur 

{ 
    protection $name;

    public function __invoke(...$args) 

    { 

        return ucwords(sprintf('%s %s%s', ...$args)); 

    }

}


class CharlyEtLulu { 

    public function __construct(private TopChanteur $topChanteur){}


    public function __call($method, $arguments) { 

        return ($this->topChanteur)($method, ...$arguments); 

    }

} 

$queen = (new CharlyEtLulu(new TopChanteur))->freddy('mer', 'cury');