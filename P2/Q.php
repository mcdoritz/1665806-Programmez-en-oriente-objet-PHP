<?php


class A

{ 

    protected int $model = 33; 

    public function setModel(int $model): void 

    { 

        $this->model = $model; 

    } 


    public function getModel(): int 

    { 

        return $this->model; 

    }

}


class B extends A

{ 

    protected int $model = 42; 


    public function setModel(int $model): self 

    { 

        $this->model = $model; return self;

    } 


    public function getModel(): int { 

        return $this->model; 

    }

}


echo (new B)->setModel(806)->getModel();