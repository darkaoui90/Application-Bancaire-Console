<?php

class Client
{
    public ?int $id;           
    public string $nom;
    public string $prenom;
    public string $email;
    public ?string $createdAt; 

    public function __construct(string $nom, string $prenom, string $email)
    {
        $this->id = null;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->createdAt = null;
    }
}
