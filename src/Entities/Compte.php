<?php

abstract class Compte
{
    public ?int $id;
    public int $clientId;
    public string $type;    
    public float $solde;
    public ?string $createdAt;

    public function __construct(int $clientId, string $type, float $solde = 0.0)
    {
        $this->id = null;          
        $this->clientId = $clientId;
        $this->type = $type;
        $this->solde = $solde;
        $this->createdAt = null;    
    }


    abstract public function depot(float $montant): array;
    abstract public function retrait(float $montant): array;
}
