<?php

namespace App\Models;

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;


class createModel extends baseModel {

    public function createTag(string $tekst) { 

    // Creating a query to insert the tag into the database
    $query = "INSERT INTO `tag` (`tag_id`, `name`) VALUES (NULL, ?)";


    // Mulitple checks to validate input

    $this->inputChecks($tekst);

    if (is_string($tekst) && !empty($tekst)) {

        // Apply filtering to the input text
        $FilterText = $this->FilterText(['tag' => $tekst], 'tag');

        try {
            $result = $this->db->executeQuery($query, [$FilterText]);

            if ($result) {
                (new Status\Ok(['message' => 'Tag created successfully']))->send();
            }
        } catch (\Exception $e) 
        {
            throw (new Status\BadRequest(['message' => $e->getMessage()]))->send();
        }  
      }
    }

    public function createFacility($data) {
        // Implementation for creating a facility   

        $query = "INSERT INTO `facility` (`id`, `facility_name`, `creation_date`, `location_id`) VALUES (NULL, ?, current_timestamp(), ?)";


        $facility = $data['facility_name'] ?? NULL;
        $location = $data['location'] ?? NULL;


        // Validating input for variables
        $this->inputChecks($facility);
        $this->inputChecks($location);

            

            $filteredFacility = $this->FilterText(['facility_name' => $facility], 'facility_name');
            $filteredLocation = $this->FilterText(['location' => $location], 'location');

            echo "Filtered Facility and Location: " . $filteredFacility . " " . $filteredLocation . "\n";

            $locationID = NULL;

            foreach (self::LOCATIONS as $loc => $locID) {
                if ($filteredLocation === $loc) {
                    $locationID = $locID;
                    break;
                } 
            }

            if ($locationID === NULL) {
                    (new Status\BadRequest(['message' => 'Location doesn\'t exist']))->send();
                }

            if ($locationID == $locID) {
                try {
                    $result = $this->db->executeQuery($query, [$filteredFacility, $locID]);

                    if ($result) {
                        (new Status\Ok(['message' => 'Facility created successfully']))->send();
                    }

                } catch (\Exception $e) {
                    throw (new Status\BadRequest(['message' => $e->getMessage()]))->send();
                }
            }
        // } 
    }
    
}
