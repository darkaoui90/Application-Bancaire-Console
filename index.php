<?php
header('Content-Type: text/plain; charset=utf-8');

require_once __DIR__ . '/src/database/Connection.php';
require_once __DIR__ . '/src/Entities/Client.php';
require_once __DIR__ . '/src/Repositories/ClientRepository.php';

$action = $_GET['action'] ?? 'home';

try {
    $pdo = Connection::get();
    $repo = new ClientRepository($pdo);

    if ($action === 'home') {
        echo "DB Connected ✅\n\n";
        echo "Actions:\n";
        echo "- ?action=create_client\n";
        echo "- ?action=list_clients\n";
        echo "- ?action=client_details&id=1\n";
        echo "- ?action=update_client&id=1\n";
        echo "- ?action=delete_client&id=1\n";
        exit;
    }

   
   
    if ($action === 'create_client') {
    $nom = $_GET['nom'] ?? '';
    $prenom = $_GET['prenom'] ?? '';
    $email = $_GET['email'] ?? '';

    if ($nom === '' || $prenom === '' || $email === '') {
        echo "Usage:\n";
        echo "?action=create_client&nom=ALI&prenom=BENALI&email=ali@gmail.com\n";
        exit;
    }

    $client = new Client($nom, $prenom, $email);
    $repo->create($client);

    echo "Client inserted ✅ ID={$client->id}\n";
    echo "created_at={$client->createdAt}\n";
    exit;
}

  
    if ($action === 'list_clients') {
        echo "=== All clients ===\n";
        foreach ($repo->findAll() as $c) {
            echo "#{$c['id']} | {$c['nom']} {$c['prenom']} | {$c['email']} | {$c['created_at']}\n";
        }
        exit;
    }

   
    if ($action === 'client_details') {
        $id = (int)($_GET['id'] ?? 0);
        $c = $repo->findById($id);
        if (!$c) { echo "Client not found\n"; exit; }
        echo "ID={$c['id']} | {$c['nom']} {$c['prenom']} | {$c['email']} | {$c['created_at']}\n";
        exit;
    }

     if ($action === 'delete_client') {
    $id = (int)($_GET['id'] ?? 0);
    if ($id <= 0) { echo "Invalid id\n"; exit; }

    if ($repo->hasAccounts($id)) {
        echo "Cannot delete  : client #$id has comptes\n";
        exit;
    }

    $repo->deleteById($id);
    echo "Client deleted ✅ (#$id)\n";
    exit;
}

if ($action === 'update_client') {
    $id = (int)($_GET['id'] ?? 0);
    $nom = trim($_GET['nom'] ?? '');
    $prenom = trim($_GET['prenom'] ?? '');
    $email = strtolower(trim($_GET['email'] ?? ''));

    if ($id <= 0 || $nom === '' || $prenom === '' || $email === '') {
        echo "Usage:\n";
        echo "?action=update_client&id=ID&nom=NewNom&prenom=NewPrenom&email=new@mail.com\n";
        exit;
    }

    
    if ($repo->emailExists($email, $id)) {
        echo "Cannot update ❌ : email already used\n";
        exit;
    }

    $repo->update($id, $nom, $prenom, $email);
    echo "Client updated ✅ (#$id)\n";
    exit;


    if ($action === 'list_comptes') {
    $compteRepo = new CompteRepository($pdo);

    echo "=== All comptes ===\n";
    foreach ($compteRepo->findAll() as $c) {
        echo "#{$c['id']} | client={$c['client_id']} | {$c['type']} | solde={$c['solde']} | {$c['created_at']}\n";
    }
    exit;
}
}


 



} catch (Throwable $e) {
    echo "Error ❌: " . $e->getMessage() . "\n";
}
