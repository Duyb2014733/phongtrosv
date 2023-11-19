<?php

namespace phongtrosv\src;

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

    public function getRentalRoomAll()
    {
        $sql = "
    SELECT
        r.id_rental,
        r.start_date,
        r.end_date,
        r.name_customer,
        r.phone_customer,
        r.email_customer,
        r.address_customer,
        ro.id_room,
        ro.name_room,
        ro.price_room,
        ro.elec_room,
        ro.water_room,
        ro.area_room
    FROM rental r
    JOIN room ro ON r.id_room = ro.id_room
";

        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getRentalRoomById($id_owner)
    {
        $sql = "
    SELECT
        r.id_rental,
        r.start_date,
        r.end_date,
        r.name_customer,
        r.phone_customer,
        r.email_customer,
        r.address_customer,
        ro.id_room,
        ro.name_room,
        ro.price_room,
        ro.elec_room,
        ro.water_room,
        ro.area_room
    FROM rental r
    JOIN room ro ON r.id_room = ro.id_room
    WHERE ro.id_owner = :id_owner
    ";

        $statement = $this->db->prepare($sql);
        $statement->execute([
            'id_owner' => $id_owner
        ]);
        return $statement->fetchAll();
    }

    function calculateRentCost($startDate, $endDate, $roomPrice, $totalcost)
    {
        $startTimestamp = strtotime($startDate);
        $endTimestamp = strtotime($endDate);

        $months = ceil(($endTimestamp - $startTimestamp) / (60 * 60 * 24 * 30));

        $rentCost = ($months * $roomPrice) +  $totalcost;

        return $rentCost;
    }

    public function getRoomDetailsByRentalId($id_rental)
    {
        $sql = "
        SELECT
            r.id_rental,
            r.start_date,
            r.end_date,
            r.name_customer,
            r.phone_customer,
            r.email_customer,
            r.address_customer,
            ro.id_room,
            ro.name_room,
            ro.price_room,
            ro.elec_room,
            ro.water_room,
            ro.area_room
        FROM rental r
        JOIN room ro ON r.id_room = ro.id_room
        WHERE r.id_rental = :id_rental
    ";

        $statement = $this->db->prepare($sql);
        $statement->execute([
            'id_rental' => $id_rental
        ]);

        return $statement->fetchAll();
    }
}
