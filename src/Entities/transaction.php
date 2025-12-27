<?php

class Transaction
{
    public ?int $id;
    public int $compteId;
    public string $type;      
    public float $montant;
    public float $frais;
    public ?string $createdAt;

    public function __construct(int $compteId, string $type, float $montant, float $frais = 0.0)
    {
        $this->id = null;           
        $this->compteId = $compteId;
        $this->type = $type;
        $this->montant = $montant;
        $this->frais = $frais;
        $this->createdAt = null;     
    }
}
