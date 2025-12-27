<?php

class ClientRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Client $client): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO clients (nom, prenom, email)
            VALUES (:nom, :prenom, :email)
        ");

        $stmt->execute([
            'nom' => $client->nom,
            'prenom' => $client->prenom,
            'email' => $client->email,
        ]);

        $newId = (int) $this->pdo->lastInsertId();
        $client->id = $newId;

        $stmt2 = $this->pdo->prepare("SELECT created_at FROM clients WHERE id = :id");
        $stmt2->execute(['id' => $newId]);
        $client->createdAt = $stmt2->fetchColumn() ?: null;

        return $newId;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT id, nom, prenom, email, created_at FROM clients ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT id, nom, prenom, email, created_at FROM clients WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $c = $stmt->fetch();
        return $c ?: null;
    }
    public function deleteById(int $id): bool
{
    $stmt = $this->pdo->prepare("DELETE FROM clients WHERE id = :id");
    return $stmt->execute(['id' => $id]);
}

   public function hasAccounts(int $clientId): bool
{
    $stmt = $this->pdo->prepare("SELECT 1 FROM comptes WHERE client_id = :id LIMIT 1");
    $stmt->execute(['id' => $clientId]);
    return (bool)$stmt->fetchColumn();
}

  public function emailExists(string $email, ?int $excludeId = null): bool
{
    if ($excludeId === null) {
        $stmt = $this->pdo->prepare("SELECT 1 FROM clients WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
    } else {
        $stmt = $this->pdo->prepare("SELECT 1 FROM clients WHERE email = :email AND id <> :id LIMIT 1");
        $stmt->execute(['email' => $email, 'id' => $excludeId]);
    }
    return (bool)$stmt->fetchColumn();
}

public function update(int $id, string $nom, string $prenom, string $email): bool
{
    $stmt = $this->pdo->prepare("
        UPDATE clients
        SET nom = :nom, prenom = :prenom, email = :email
        WHERE id = :id
    ");

    return $stmt->execute([
        'id' => $id,
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
    ]);
}




      


}