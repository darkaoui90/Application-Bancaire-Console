<?php

class CompteRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Compte $compte): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO comptes (client_id, type, solde)
            VALUES (:client_id, :type, :solde)
        ");

        $stmt->execute([
            'client_id' => $compte->clientId,
            'type' => $compte->type,
            'solde' => $compte->solde,
        ]);

        $newId = (int)$this->pdo->lastInsertId();
        $compte->id = $newId;

        $stmt2 = $this->pdo->prepare("SELECT created_at FROM comptes WHERE id = :id");
        $stmt2->execute(['id' => $newId]);
        $compte->createdAt = $stmt2->fetchColumn() ?: null;

        return $newId;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("
            SELECT id, client_id, type, solde, created_at
            FROM comptes
            ORDER BY id DESC
        ");
        return $stmt->fetchAll();
    }

    public function findByClientId(int $clientId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT id, client_id, type, solde, created_at
            FROM comptes
            WHERE client_id = :client_id
            ORDER BY id DESC
        ");
        $stmt->execute(['client_id' => $clientId]);
        return $stmt->fetchAll();
    }
}
