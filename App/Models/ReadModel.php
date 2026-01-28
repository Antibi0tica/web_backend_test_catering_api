<?php

namespace App\Models;

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;

// ReadModel handles retrieval operations for facilities

class ReadModel extends BaseModel {
    /** 
    * Retrieve all facilities with their locations and tags
    *
    * @return void Sends JSON response with all facilities
    */
    public function readAllFacility() {

        // Base Query to join facility, location and tag tables
        $query =
        "SELECT facility.facility_name, facility.location_id, tag.name
        FROM facility 
        LEFT JOIN facility_tag ON (facility.id = facility_tag.facility_id)
        LEFT JOIN tag ON (tag.id = facility_tag.tag_id);";


        // Execute query and send response
        try {
            $result = $this->db->executeQuery($query, []);

        if ($result) {
            $stmt = $this->db->getStatement();
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $response = ['facility' => $rows];
            
            (new Status\Ok($response))->send();
        }
        } catch  (Status\Exception $e) {
            (new Status\BadRequest(['message' => $e->getMessage()]))->send();
            return; 
        }

    }

    /**
     * Retrieve a single facility by ID with its location and tags
     * 
     * @param int $id The facility ID to retrieve
     * @return void Sends JSON response with facility data
     */
    public function readOneFacility($id) {

        // Base query
       $query = 
       "SELECT facility.facility_name, facility.location_id, tag.name
        FROM facility 
        LEFT JOIN facility_tag ON (facility.id = facility_tag.facility_id)
        LEFT JOIN tag ON (tag.id = facility_tag.tag_id)
        WHERE facility.id = ?;";


        

        
        // Execute query and send response
        try {
            $result = $this->db->executeQuery($query, [$id]);

            if ($result) {
            $stmt = $this->db->getStatement();
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $response = ['facility' => $rows];

            (new Status\Ok($response))->send();
            }
        
        } catch (Status\Exception $e) {
            (new Status\BadRequest(['message' => $e->getMessage()]))->send();
            return; 
        }

        
    }
}  