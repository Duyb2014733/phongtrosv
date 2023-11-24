<?php

namespace phongtrosv\src;

use PDO;

class Chiso
{
    private ?PDO $db;
    public function __construct(?PDO $pdo)
    {
        $this->db = $pdo;
    }



    public function addChiso($id_room, $date_Chiso, $elec_Chiso, $water_Chiso, $total_cost)
    {
        $sql = "INSERT INTO chiso (id_room, date_Chiso, elec_Chiso, water_Chiso, total_cost)
                    VALUES (:id_room, :date_Chiso, :elec_Chiso, :water_Chiso, :total_cost)";

        $statement = $this->db->prepare($sql);

        $result = $statement->execute([
            ':id_room' => $id_room,
            ':date_Chiso' => $date_Chiso,
            ':elec_Chiso' => $elec_Chiso,
            ':water_Chiso' => $water_Chiso,
            ':total_cost' => $total_cost
        ]);

        return $result;
    }

    public function getLastChisoByRoomId($id_room)
    {
        $sql = "SELECT * FROM chiso WHERE id_room = :id_room ORDER BY id_Chiso DESC LIMIT 1";
        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':id_room' => $id_room
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return is_array($result) ? $result : [];
    }


    public function calculateTotalCost($id_room, $date_Chiso, $electricity, $water)
    {
        $room = $this->getRoomById($id_room);

        $lastChiso = $this->getLastChisoByRoomId($id_room);

        if (!empty($lastChiso)) {
            $lastElectricity = $lastChiso["elec_Chiso"];
            $lastWater = $lastChiso["water_Chiso"];
            $electricityUsage = $electricity - $lastElectricity;
            $waterUsage = $water - $lastWater;

            $electricityCost = $electricityUsage * $room['elec_room'];
            $waterCost = $waterUsage * $room['water_room'];

            $totalCost = $electricityCost + $waterCost;
            return $totalCost;
        }
    }


    public function updateTotalCost($id_room, $date_Chiso, $totalCost)
    {
        $sql = "UPDATE chiso SET total_cost = :total_cost WHERE id_room = :id_room AND date_Chiso = :date_Chiso";
        $statement = $this->db->prepare($sql);

        $statement->execute([
            ':total_cost' => $totalCost,
            ':id_room' => $id_room,
            ':date_Chiso' => $date_Chiso
        ]);
    }

    public function getRoomById($id_room)
    {
        $sql = "SELECT * FROM room WHERE id_room = :id_room";
        $statement = $this->db->prepare($sql);
        $statement->execute([':id_room' => $id_room]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }



    public function getChisoList($id_room)
    {
        $sql = "SELECT * FROM chiso WHERE id_room = :id_room ORDER BY date_Chiso DESC";
        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':id_room' => $id_room
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteChiso($id_Chiso)
    {
        $sql = "DELETE FROM chiso WHERE id_Chiso = :id_Chiso";
        $statement = $this->db->prepare($sql);
        return $statement->execute([':id_Chiso' => $id_Chiso]);
    }

    public function updateChiso($id_Chiso, $newElec, $newWater)
    {
        $sql = "UPDATE chiso SET elec_Chiso = :elec_Chiso, water_Chiso = :water_Chiso WHERE id_Chiso = :id_Chiso";
        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':id_Chiso' => $id_Chiso,
            ':elec_Chiso' => $newElec,
            ':water_Chiso' => $newWater
        ]);

        return $statement->rowCount() > 0;
    }

    public function getChisoById($id_Chiso)
    {
        $sql = "SELECT * FROM chiso WHERE id_Chiso = :id_Chiso";
        $statement = $this->db->prepare($sql);
        $statement->execute([':id_Chiso' => $id_Chiso]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getLatestTotalCost($id_room)
    {
        $sql = "SELECT total_cost FROM chiso WHERE id_room = :id_room ORDER BY date_Chiso DESC LIMIT 1";
        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':id_room' => $id_room
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result['total_cost'] ?? null;
    }

    public function getTotalIncomeByMonth($month, $year)
    {
        $sql = "SELECT SUM(total_cost) as totalIncome
                FROM chiso
                WHERE MONTH(date_Chiso) = :month AND YEAR(date_Chiso) = :year";

        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':month' => $month,
            ':year' => $year
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['totalIncome'] ?? 0;
    }

    public function getMonthsHasData()
    {
        $sql = "SELECT DISTINCT MONTH(date_Chiso) as month, YEAR(date_Chiso) as year
            FROM chiso";

        $statement = $this->db->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
