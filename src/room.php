<?php

namespace website\labs;

use PDO;

class Room
{
    private ?PDO $db;

    public function __construct(?PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function addRoom($name_room, $price_room, $area_room, $security_room, $description_room, $status_room, $id_owner)
    {
        $sql = "INSERT INTO room (name_room, price_room, area_room, security_room, description_room, status_room, id_owner)
                VALUES (:name_room, :price_room, :area_room, :security_room, :description_room, :status_room, :id_owner)";

        $statement = $this->db->prepare($sql);
        return $statement->execute([
            ':name_room' => $name_room,
            ':price_room' => $price_room,
            ':area_room' => $area_room,
            ':security_room' => $security_room,
            ':description_room' => $description_room,
            ':status_room' => $status_room,
            ':id_owner' => $id_owner,
        ]);
    }

    public function editRoom($id_room, $name_room, $price_room, $area_room, $security_room, $description_room, $status_room, $id_owner)
    {
        $sql = "UPDATE room 
                SET name_room = :name_room, price_room = :price_room, area_room = :area_room, security_room = :security_room, 
                    description_room = :description_room, status_room = :status_room, id_owner = :id_owner 
                WHERE id_room = :id_room";

        $statement = $this->db->prepare($sql);
        return $statement->execute([
            ':id_room' => $id_room,
            ':name_room' => $name_room,
            ':price_room' => $price_room,
            ':area_room' => $area_room,
            ':security_room' => $security_room,
            ':description_room' => $description_room,
            ':status_room' => $status_room,
            ':id_owner' => $id_owner,
        ]);
    }

    public function deleteRoom($id_room)
    {
        $sql = "DELETE FROM room WHERE id_room = :id_room";
        $statement = $this->db->prepare($sql);
        return $statement->execute([':id_room' => $id_room]);
    }

    public function getRoomById($id_room)
    {
        $sql = "SELECT * FROM room WHERE id_room = :id_room";
        $statement = $this->db->prepare($sql);
        $statement->execute([':id_room' => $id_room]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllRooms()
    {
        $sql = "SELECT * FROM room";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImagesByRoomId($id_room) {
        $sql = "SELECT image FROM post WHERE id_room = :id_room";
        $statement = $this->db->prepare($sql);
        $statement->execute([':id_room' => $id_room]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
