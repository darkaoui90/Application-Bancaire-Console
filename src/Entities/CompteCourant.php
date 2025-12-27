<?php

class CompteCourant extends Compte
{
    public float $fraisDepot;
    public float $decouvertMax;

    public function __construct(int $clientId, float $solde = 0.0)
    {
        parent::__construct($clientId, 'courant', $solde);

        $this->fraisDepot = 1.0;
        $this->decouvertMax = -500.0;
    }

    public function depot(float $montant): array
    {
        if ($montant <= 0) {
            throw new Exception("Montant dépôt invalide.");
        }

        $frais = $this->fraisDepot;
        $credit = $montant - $frais;

        if ($credit <= 0) {
            throw new Exception("Montant doit être > 1$ (frais dépôt).");
        }

        $this->solde += $credit;

        return [
            'type' => 'depot',
            'montant' => $montant,
            'frais' => $frais,
            'delta' => $credit,          
            'nouveau_solde' => $this->solde
        ];
    }

    public function retrait(float $montant): array
    {
        if ($montant <= 0) {
            throw new Exception("Montant retrait invalide.");
        }

        $nouveauSolde = $this->solde - $montant;

        if ($nouveauSolde < $this->decouvertMax) {
            throw new Exception("Découvert dépassé (limite -500$).");
        }

        $this->solde = $nouveauSolde;

        return [
            'type' => 'retrait',
            'montant' => $montant,
            'frais' => 0.0,
            'delta' => -$montant,
            'nouveau_solde' => $this->solde
        ];
    }
}
