<?php

namespace website\src;

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

    public function getAllOwners()
    {
        $sql = "SELECT * FROM owner";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addOwner($name, $phone, $email, $address)
    {
        if (empty($name) || empty($phone) || empty($email) || empty($address)) {
            return false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
            return false;
        }
        $sql = "INSERT INTO owner (name_owner, phone_owner, email_owner, address_owner) 
         VALUES (:name, :phone, :email, :address)";
        $statement = $this->db->prepare($sql);
        return $statement->execute([
            ':name' => $name,
            ':phone' => $phone,
            ':email' => $email,
            ':address' => $address
        ]);
    }

    public function deleteOwner($id_owner)
    {
        $sql = "DELETE FROM owner WHERE id_owner = :id_owner";
        $statement = $this->db->prepare($sql);
        return $statement->execute([':id_owner' => $id_owner]);
    }
}
