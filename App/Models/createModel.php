<?php

namespace App\Models;

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;


/**
 * CreateModel handles creation operations for facilities and tags
 */
class CreateModel extends BaseModel {

    /**
     * Create a new tag in the database
     * 
     * @param string $data The tag name to create
     * @return void Sends JSON response with creation status
     */

    public function createTag(string $data) { 

    // Base query to insert new tag
    $query = "INSERT INTO `tag` (`id`, `name`) VALUES (NULL, ?)";

    // Validate and sanitize tag input
    $this->inputCheck($data);
    $FilterText = $this->filterText(['tag' => $data], 'tag');

        try {
            $result = $this->db->executeQuery($query, [$FilterText]);

            $this->errHandling($result, 'Tag', 'created');

    } catch (Status\Exception $e) {
            (new Status\BadRequest(['message' => $e->getMessage()]))->send();
            return;
        }
    }

    /**
     * Create a new facility with location validation
     * 
     * @param array $data Array containing 'facility_name' and 'location' keys
     * @return void Sends JSON response with creation status
     */
    public function createFacility($data) {
        // Base query to insert new facility with creation timestamp 

        $query = "INSERT INTO `facility` (`id`, `facility_name`, `creation_date`, `location_id`) VALUES (NULL, ?, current_timestamp(), ?)";

        // Extract facility name and location from request data
        $facility = $data['facility_name'] ?? NULL;
        $location = $data['location'] ?? NULL;

        // Validate input parameters
        $this->inputCheck($facility);
        $this->inputCheck($location);

        // Sanitize inputs
        $filteredFacility = $this->filterText(['facility_name' => $facility], 'facility_name');
        $filteredLocation = $this->filterText(['location' => $location], 'location');

            $locationID = NULL;

            // Validate location against allowed LOCATIONS constant
            foreach (self::LOCATIONS as $loc => $locID) {
                if ($filteredLocation === $loc) {
                    $locationID = $locID;
                    break;
                } 
            }

            // Return error if location is not valid
            if ($locationID === NULL) {
                    (new Status\BadRequest(['message' => 'Location doesn\'t exist']))->send();
                }

            // Execute insertion if location is valid
            if ($locationID == $locID) {
                try {
                    $result = $this->db->executeQuery($query, [$filteredFacility, $locID]);

                    $this->errHandling($result, 'Facility', 'created');

            } catch (Status\Exception $e) {
            (new Status\BadRequest(['message' => $e->getMessage()]))->send();
            return;
            }
    }
    
}
}