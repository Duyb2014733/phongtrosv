<?php

namespace phongtrosv\src;

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
    public function getIdOwner($name_owner)
    {
        $sql = "SELECT id_owner FROM owner WHERE name_owner = :name_owner";
        $statement = $this->db->prepare($sql);
        $statement->execute([':name_owner' => $name_owner]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['id_owner'] : null;
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

    public function ownerExists($email, $phone)
    {
        $sql = "SELECT COUNT(*) FROM owner WHERE email_owner = :email OR phone_owner = :phone";
        $statement = $this->db->prepare($sql);
        $statement->execute([':email' => $email, ':phone' => $phone]);

        $count = $statement->fetchColumn();

        return ($count > 0);
    }

    public function addOwner($name, $phone, $email, $address, $id_name)
    {
        $existingOwnerSql = "SELECT COUNT(*) FROM owner WHERE id_name = :id_name";
        $existingOwnerStatement = $this->db->prepare($existingOwnerSql);
        $existingOwnerStatement->execute([':id_name' => $id_name]);
        $existingOwnerCount = $existingOwnerStatement->fetchColumn();

        if ($existingOwnerCount > 0) {
            return false;
        }

        if ($this->ownerExists($name, $phone)) {
            return false;
        }

        $sql = "INSERT INTO owner(name_owner, phone_owner, email_owner, address_owner, id_name)
                  VALUES(:name_owner, :phone_owner, :email_owner, :address_owner, :id_name)";

        $statement = $this->db->prepare($sql);

        return $statement->execute([
            ':name_owner' => $name,
            ':phone_owner' => $phone,
            ':email_owner' => $email,
            ':address_owner' => $address,
            ':id_name' => $id_name
        ]);
    }
    public function deleteOwner($id_owner)
    {
        $sql = "DELETE FROM owner WHERE id_owner = :id_owner";
        $statement = $this->db->prepare($sql);
        return $statement->execute([':id_owner' => $id_owner]);
    }
    public function getOwnerByIdRoom($id_room)
    {
        $sql = "SELECT owner.* FROM owner
            INNER JOIN room ON owner.id_owner = room.id_owner
            WHERE room.id_room = :id_room";

        $statement = $this->db->prepare($sql);
        $statement->execute([':id_room' => $id_room]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getOwnerById($id_owner)
    {
        $sql = "SELECT * FROM owner WHERE id_owner = :id_owner";
        $statement = $this->db->prepare($sql);
        $statement->execute(['id_owner' => $id_owner]);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateOwner($id_owner, $name_owner, $phone_owner, $email_owner, $address_owner)
    {
        $sql = "UPDATE owner
                SET name_owner = :name_owner,
                    phone_owner = :phone_owner,
                    email_owner = :email_owner,
                    address_owner = :address_owner
                WHERE id_owner = :id_owner";

        $statement = $this->db->prepare($sql);
        $statement->execute([
            'id_owner' => $id_owner,
            'name_owner' => $name_owner,
            'phone_owner' => $phone_owner,
            'email_owner' => $email_owner,
            'address_owner' => $address_owner
        ]);
        return $statement->rowCount();
    }
}
