<?php
namespace website\labs;

use PDO; 

class Owner
{
    private ?PDO $db;
    public $id_owner;
    public $name_owner;
    public $phone_owner;
    public $email_owner;
    public $address_owner;
    public function __construct(?PDO $pdo)
    {
        $this->db = $pdo;
    }
    public function getIdOwner(): ?int
    {
        return $this->id_owner;
    }
    public function setIdOwner(?int $id_owner): void
    {
        $this->id_owner = $id_owner;
    }


}
?>