<?php

class CompteEpargne extends Compte
{
    public function __construct(int $clientId, float $solde = 0.0)
    {
        parent::__construct($clientId, 'epargne', $solde);
    }

    public function depot(float $montant): array
    {
        if ($montant <= 0) {
            throw new Exception("Montant dépôt invalide.");
        }

        $this->solde += $montant;

        return [
            'type' => 'depot',
            'montant' => $montant,
            'frais' => 0.0,
            'delta' => $montant,
            'nouveau_solde' => $this->solde
        ];
    }

    public function retrait(float $montant): array
    {
        if ($montant <= 0) {
            throw new Exception("Montant retrait invalide.");
        }

        if ($montant > $this->solde) {
            throw new Exception("Solde insuffisant (pas de découvert).");
        }

        $this->solde -= $montant;

        return [
            'type' => 'retrait',
            'montant' => $montant,
            'frais' => 0.0,
            'delta' => -$montant,
            'nouveau_solde' => $this->solde
        ];
    }
}
