<?php

namespace App\Models;

use App\Plugins\Http\Response as Status;

/**
 * SearchModel handles search operations for facilities
 */

class SearchModel extends BaseModel {
    
    /**
     * Search for facilities by name, tag, or city using LIKE queries
     * 
     * @param string $name Facility name to search for
     * @param string $tag Tag name to filter by
     * @param string $city City location to filter by
     * @return void Sends JSON response with search results
     */
    
    public function searchModel($name, $tag, $city) {
        // Sanitize parameters
        $this->checkString($name);
        $this->checkString($city);
        $this->checkString($tag);


        // Base query with joins for facility, tags and location
        $query = 
        "SELECT facility_name, tag.name, location.city, facility_id
        FROM facility
        LEFT JOIN facility_tag
        ON facility.id = facility_tag.facility_id
        LEFT JOIN tag
        ON facility_tag.tag_id = tag.id
        LEFT JOIN location
        ON facility.location_id = location.id
        WHERE 1=1";
        
        // Dynamic query, WHERE clause is based on provided search criteria
        $params = [];
        
        if ($name != '' || $city != '' || $tag != '') {
            $query .= " AND (1=0";

        if ($name != '') {
            $query .= " OR facility.facility_name LIKE CONCAT('%', ?, '%')";
            $params[] = $name;
        }
        if ($city != '') {
            $query .= " OR location.city LIKE CONCAT('%', ?, '%')";
            $params[] = $city;
        }
        if ($tag != '') {
            $query .= " OR tag.name LIKE CONCAT('%', ?, '%')";
            $params[] = $tag;
        }

        $query .= ")";

        }

        // Execute query and send response
        try {
        $result = $this->db->executeQuery($query, $params);

        if ($result) {
            $stmt = $this->db->getStatement();
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $response = ['search_results' => $rows];

            (new Status\Ok($response))->send();
        } 
        } catch (Status\Exception $e) {
            (new Status\BadRequest(['message' => $e->getMessage()]))->send();
            return;
        }
    }     
}
