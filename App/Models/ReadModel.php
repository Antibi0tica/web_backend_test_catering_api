<?php

namespace App\Models;

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;

class ReadModel extends baseModel{
    
    // Function must be reworked into a better state

    public function ReadAllFacility() {
        $query =
        "SELECT facility.facility_name, facility.location_id, tag.name
        FROM facility 
        LEFT JOIN facility_tag ON (facility.id = facility_tag.facility_id)
        LEFT JOIN tag ON (tag.id = facility_tag.tag_id);";


        $result = $this->db->executeQuery($query,[]);


        if ($result) {
            $stmt = $this->db->getStatement();
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $response = ['facility' => $rows];
            
            (new Status\Ok($response))->send();
        

        }

    }

    public function ReadOneFacility($id) {


       $query = 
       "SELECT facility.facility_name, facility.location_id, tag.name
        FROM facility 
        LEFT JOIN facility_tag ON (facility.id = facility_tag.facility_id)
        LEFT JOIN tag ON (tag.id = facility_tag.tag_id)
        WHERE facility.id = ?;";


        $result = $this->db->executeQuery($query,[$id]);

        if ($result) {
            $stmt = $this->db->getStatement();
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $response = ['facility' => $rows];

            (new Status\Ok($response))->send();
        }

        
    }
}  