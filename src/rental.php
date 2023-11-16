<?php

namespace website\src;

use PDO;

class Rental
{
    private ?PDO $db;

    public function __construct(?PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function addRental($name_customer, $phone_customer, $email_customer, $address_customer, $start_date, $end_date, $R_deposit, $id_room, $id_owner)
    {
        $sql = "INSERT INTO rental (name_customer, phone_customer, email_customer, address_customer, start_date, end_date, R_deposit, id_room, id_owner) 
                VALUES (:name_customer, :phone_customer, :email_customer, :address_customer, :start_date, :end_date, :R_deposit, :id_room, :id_owner)";

        $statement = $this->db->prepare($sql);
        $result = $statement->execute([
            ':name_customer' => $name_customer,
            'phone_customer' => $phone_customer,
            'email_customer' => $email_customer,
            'address_customer' => $address_customer,
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':R_deposit' => $R_deposit,
            ':id_room' => $id_room,
            'id_owner' => $id_owner
        ]);

        return $result;
    }

    public function editRental($id_rental, $name_customer, $phone_customer, $email_customer, $address_customer, $start_date, $end_date, $R_deposit, $id_room, $id_owner)
    {
        $sql = "UPDATE rental SET name_customer = :name_customer, phone_customer = :phone_customer, address_customer = :address_customer, start_date = :start_date, end_date = :end_date, R_deposit = :R_deposit, id_room = :id_room 
                WHERE id_rental = :id_rental";

        $statement = $this->db->prepare($sql);
        $result = $statement->execute([
            ':id_rental' => $id_rental,
            ':name_customer' => $name_customer,
            'phone_customer' => $phone_customer,
            'email_customer' => $email_customer,
            'address_customer' => $address_customer,
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':R_deposit' => $R_deposit,
            ':id_room' => $id_room,
            'id_owner' => $id_owner
        ]);

        return $result;
    }

    public function deleteRental($id_rental)
    {
        $sql = "DELETE FROM rental WHERE id_rental = :id_rental";

        $statement = $this->db->prepare($sql);
        $result = $statement->execute([':id_rental' => $id_rental]);

        return $result;
    }

    public function getRentalByIdRoom($id_room)
    {
        $sql = "SELECT * FROM rental WHERE id_room = :id_room";
        $statement = $this->db->prepare($sql);
        $statement->execute([':id_room' => $id_room]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
