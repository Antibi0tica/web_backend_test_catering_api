<?php

namespace App\Models;

use App\Plugins\Http\Response as Status;

class searchModel extends baseModel {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function searchModel($q) {

        // Sanitize $q


        $q = trim($_GET['q']);
        
        $query = "SELECT * FROM facility WHERE facility_name = ?;";



        $result = $this->db->executeQuery($query,[$q]);

        if ($result) {

            $stmt = $this->db->getStatement();
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $response = ['Search results:' => $rows];

            (new Status\Ok([$response]))->send();
        }
        
    }


}