<?php

namespace website\labs;

use PDO;

class Customer
{
    private ?PDO $db;

    public function __construct(?PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function themCustomer($name, $phone, $email, $address)
    {
        try {
            $sql = "INSERT INTO customer (name_customer, phone_customer, email_customer, address_customer) 
                    VALUES (:name, :phone, :email, :address)";
            $statement = $this->db->prepare($sql);
            $statement->execute([
                ':name' => $name,
                ':phone' => $phone,
                ':email' => $email,
                ':address' => $address
            ]);
            return $this->db->lastInsertId();
        } catch (\PDOException $e) {
            // Xử lý lỗi
            return false;
        }
    }

    public function suaCustomer($id, $name, $phone, $email, $address)
    {
        try {
            $sql = "UPDATE customer 
                    SET name_customer = :name, phone_customer = :phone, email_customer = :email, address_customer = :address
                    WHERE id_customer = :id";
            $statement = $this->db->prepare($sql);
            $statement->execute([
                ':id' => $id,
                ':name' => $name,
                ':phone' => $phone,
                ':email' => $email,
                ':address' => $address
            ]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            // Xử lý lỗi
            return false;
        }
    }

    public function xoaCustomer($id)
    {
        try {
            $sql = "DELETE FROM customer WHERE id_customer = :id";
            $statement = $this->db->prepare($sql);
            $statement->execute([':id' => $id]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            // Xử lý lỗi
            return false;
        }
    }

    public function getCustomers()
    {
        $sql = "SELECT * FROM customer";
        $statement = $this->db->query($sql);

        if ($statement) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        return [];
    }
}
