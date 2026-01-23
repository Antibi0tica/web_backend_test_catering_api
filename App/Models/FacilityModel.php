<?php

namespace App\Models;

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;


class FacilityModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    //  Filter text input from the JSON body  
    public function FilterText(array $text, string $key) {


        $value = $text[$key];

        $value = trim($value);
        $value = strtolower($value);
        $value = str_replace("'", "", $value);
        $value = stripslashes($value);

        $value = preg_replace('/\s+/u', ' ', $value);

        $text[$key] = $value;
        return $text[$key]; 
        }


    public function inputChecks($tekst) {
        // Implementation for input checks

        if (empty ($tekst)) {
            throw (new Status\BadRequest(['message' => 'Input cannot be empty']))->send();
        }

        if (!is_string($tekst)) {
            throw (new Status\BadRequest(['message' => 'Input must be a string']))->send();
        }
    }

    public function createTag($tekst) { 

    // Creating a query to insert the tag into the database
    $query = "INSERT INTO `tag` (`tag_id`, `name`) VALUES (NULL, ?)";


    // Mulitple checks to validate input

    if (empty ($tekst)) {
        throw (new Status\BadRequest(['message' => 'Input cannot be empty']))->send();
    } 

    if (!is_string($tekst)) {
        throw (new Status\BadRequest(['message' => 'Input must be a string']))->send();
    } 

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

    public function createFacility($facility, $location) {
        // Implementation for creating a facility
        echo "Creating facility: " . $facility . " at location: " . $location;

        $locationsArray =
        [
            'krommenie' => 1,
            'assendelft' => 2,
            'wormerveer' => 3
            
        ];

        $query = "INSERT INTO `facility` (`facility_id`, `facility_name`, `creation_date`, `location_id`) VALUES (NULL, ?, current_timestamp(), ?)";


        
            $this->inputChecks($facility);
            $this->inputChecks($location);

            // if (!empty($facility) && is_string($location)) {

            $filteredFacility = $this->FilterText(['facility_name' => $facility], 'facility_name');
            $filteredLocation = $this->FilterText(['location' => $location], 'location');

            echo "Filtered Facility and Location: " . $filteredFacility . " " . $filteredLocation . "\n";

            $locationID = NULL;

            foreach ($locationsArray as $loc => $locID) {
                if ($filteredLocation === $loc) {
                    echo "Filtered Location is ". $filteredLocation . "Which corresponds to " . $locID;
                    $locationID = $locID;
                    break;
                } 

                if ($locationID === NULL) {
                    (new Status\BadRequest(['message' => 'Location doesn\'t exist']))->send();
                }

            }

            if ($locationID = $locID) {
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
