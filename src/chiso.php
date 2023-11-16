<?php

namespace website\src;

use PDO;

class Chiso
{
    private ?PDO $db;

    public function __construct(?PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function addChiso($id_room, $date_Chiso, $elec_Chiso, $water_Chiso)
    {
        $sql = "INSERT INTO chiso (id_room, date_Chiso, elec_Chiso, water_Chiso) 
                    VALUES (:id_room, :date_Chiso, :elec_Chiso, :water_Chiso)";

        $statement = $this->db->prepare($sql);

        $result = $statement->execute([
            ':id_room' => $id_room,
            ':date_Chiso' => $date_Chiso,
            ':elec_Chiso' => $elec_Chiso,
            ':water_Chiso' => $water_Chiso
        ]);

        return $result;
    }
}
