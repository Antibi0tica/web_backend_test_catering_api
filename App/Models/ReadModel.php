<?php

namespace App\Models;

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;

class ReadModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }



    // Function must be reworked into a better state

    public function ReadFacility() {
        $query = "SELECT * FROM facility";



        $result = $this->db->executeQuery($query,[]);


        if ($result) {
            $stmt = $this->db->getStatement();
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            echo $row['facility_name'];
        }

        }

    }
}  