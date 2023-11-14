<?php

namespace website\src;

use PDO;

class Customer
{
    private ?PDO $db;
    public $errors = [];
    public function __construct(?PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function themCustomer($name, $phone, $email, $address)
    {
        if ($this->isCustomerExists($email)) {
            return "Khách hàng có email này đã tồn tại.";
        }

        $sql = "INSERT INTO customer (name_customer, phone_customer, email_customer, address_customer) 
                VALUES (:name, :phone, :email, :address)";
        $statement = $this->db->prepare($sql);
        $success = $statement->execute([
            ':name' => $name,
            ':phone' => $phone,
            ':email' => $email,
            ':address' => $address
        ]);

        if ($success) {
            return "Khách hàng đã thêm thành công.";
        } else {
            return "Lỗi khi thêm khách hàng.";
        }
    }


    public function editCustomer($id, $name, $phone, $email, $address)
    {
        if (empty($name)) {
            $errors['name'] = 'Name is required.';
        }
        if (empty($phone)) {
            $errors['phone'] = 'Phone is required.';
        }
        if (empty($email)) {
            $errors['email'] = 'Email is required.';
        }

        if (!empty($errors)) {
            return $errors;
        }
        $sql = "UPDATE customer 
                    SET name_customer = :name, phone_customer = :phone, email_customer = :email, address_customer = :address
                    WHERE id_customer = :id";
        $statement = $this->db->prepare($sql);
        return $statement->execute([
            ':id' => $id,
            ':name' => $name,
            ':phone' => $phone,
            ':email' => $email,
            ':address' => $address
        ]);
    }

    public function deleteCustomer($id)
    {
        try {
            $sql = "DELETE FROM customer WHERE id_customer = :id";
            $statement = $this->db->prepare($sql);
            $statement->execute([':id' => $id]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
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

    public function getCustomerById($id_customer)
    {
        $sql = "SELECT * FROM customer WHERE id_customer = :id_customer";
        $statement = $this->db->prepare($sql);
        $statement->execute([':id_customer' => $id_customer]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function isCustomerExists($email)
    {
        $sql = "SELECT COUNT(*) FROM customer WHERE email_customer = :email";
        $statement = $this->db->prepare($sql);
        $statement->execute([
            "email" => $email
        ]);

        $count = $statement->fetchColumn();

        return $count > 0;
    }

    public function getAllCustomers() {
        $sql = "SELECT * FROM customer";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
