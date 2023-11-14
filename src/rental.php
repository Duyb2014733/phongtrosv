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

    public function addRental($start_date, $end_date, $R_deposit, $id_room, $id_owner, $id_customer)
    {
        $sql = "INSERT INTO rental (start_date, end_date, R_deposit, id_room, id_owner, id_customer) 
                VALUES (:start_date, :end_date, :R_deposit, :id_room, :id_owner, :id_customer)";

        $statement = $this->db->prepare($sql);
        $result = $statement->execute([
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':R_deposit' => $R_deposit,
            ':id_room' => $id_room,
            'id_owner' => $id_owner,
            'id_customer' => $id_customer
        ]);

        return $result;
    }

    public function editRental($id_rental, $start_date, $end_date, $R_deposit, $id_room, $id_owner, $id_customer)
    {
        $sql = "UPDATE rental SET start_date = :start_date, end_date = :end_date, R_deposit = :R_deposit, id_room = :id_room 
                WHERE id_rental = :id_rental";

        $statement = $this->db->prepare($sql);
        $result = $statement->execute([
            ':id_rental' => $id_rental,
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':R_deposit' => $R_deposit,
            ':id_room' => $id_room,
            'id_owner' => $id_owner, 
            'id_customer' => $id_customer
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
}
