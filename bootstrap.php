<?php

require_once __DIR__ . '/src/Database/Connection.php';


require_once __DIR__ . '/src/Entities/Client.php';
require_once __DIR__ . '/src/Entities/Compte.php';
require_once __DIR__ . '/src/Entities/CompteCourant.php';
require_once __DIR__ . '/src/Entities/CompteEpargne.php';
require_once __DIR__ . '/src/Entities/Transaction.php';


require_once __DIR__ . '/src/Repositories/ClientRepository.php';
require_once __DIR__ . '/src/Repositories/CompteRepository.php';
require_once __DIR__ . '/src/Repositories/TransactionRepository.php';

require_once __DIR__ . '/src/Services/ClientService.php';
require_once __DIR__ . '/src/Services/CompteService.php';
require_once __DIR__ . '/src/Services/TransactionService.php';
