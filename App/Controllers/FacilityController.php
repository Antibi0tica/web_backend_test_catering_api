<?php

namespace App\Controllers;

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;


/**
 * FacilityController handles all HTTP requests for facility operations
 */
class FacilityController extends BaseController {

    /**
     * Handle POST request to create a new tag or facility
     * 
     * @return void Sends JSON response with creation status
     */
    public function createController() {

    // Parse JSON request body
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, TRUE);

    try {

        // Create tag if 'tag' key is present in request
        if (isset($data['tag'])) {
            $createModel = new \App\Models\CreateModel($this->db);
            $createModel->createTag($data['tag']);
        }

        // Create facility if 'facility_name' and 'location' keys are present
        if (isset($data['facility_name']) && isset($data['location'])) {
            $createModel = new \App\Models\CreateModel($this->db);
            $createModel->createFacility($data);
        }

        
    } catch (Status\Exception $e) {
            (new Status\BadRequest(['message' => $e->getMessage()]))->send();
            return;
    }
} 


    /**
     * Handle GET request to retrieve all facilities
     * 
     * @return void Sends JSON response with all facilities
     */
    public function readAllController() {

    try {
        $readModel = new \App\Models\ReadModel($this->db);
        $readModel->readAllFacility();
        
    } catch (Status\Exception $e) {
        (new Status\BadRequest(['message' => $e->getMessage()]))->send();
        return;
    }
}

    /**
     * Handle GET request to retrieve a single facility by ID
     * 
     * @param int $id The facility ID from the URL
     * @return void Sends JSON response with facility data
     */
    public function readOneController($id) {

    try {
        $readModel = new \App\Models\ReadModel($this->db);
        $readModel->readOneFacility($id);

    } catch (Status\Exception $e) {
        (new Status\BadRequest(['message' => $e->getMessage()]))->send();
        return;
    }
}

   /**
     * Handle PUT/PATCH request to update a facility or tag
     * 
     * @param int $id The facility/tag ID from the URL
     * @return void Sends JSON response with update status
     */
    public function updateController($id) {

    // Parse JSON request body
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, TRUE);


    try {
        // Update tag if 'tag' key is present
        if (isset($data['tag'])) {
            $updateModel = new \App\Models\UpdateModel($this->db);
            $updateModel->updateTag($id, $data);
        }
        // Update facility if 'facility_name' key is present
        if (isset($data['facility_name'])) {
            $updateModel = new \App\Models\UpdateModel($this->db);
            $updateModel->updateFacility($id, $data);
        }
    } catch (Status\Exception $e) {
        (new Status\BadRequest(['message' => $e->getMessage()]))->send();
        return;
    }

    }


    /**
     * Handle DELETE request to remove a facility by ID
     * 
     * @param int $id The facility ID from the URL
     * @return void Sends JSON response with deletion status
     */
    public function deleteController($id) {
        try {
            $deleteModel = new \App\Models\DeleteModel($this->db);
            $deleteModel->deleteModel($id);
        } catch (Status\Exception $e) {
        (new Status\BadRequest(['message' => $e->getMessage()]))->send();
        return;
        }
} 

    /**
     * Handle GET request to search facilities by name, city, or tag
     * 
     * @return void Sends JSON response with search results
     */
    public function searchController() {

    // Extract search parameters from query string
        $name = $_GET['name'] ?? '';
        $city = $_GET['city'] ?? '';
        $tag = $_GET['tag'] ?? '';

        // Only search if at least one parameter is provided
        if ($name != '' || $city != '' || $tag != '') {
            try {
                $searchModel = new \App\Models\SearchModel($this->db);
                $searchModel->searchModel($name, $tag, $city);
            } catch (Status\Exception $e) {
            (new Status\BadRequest(['message' => $e->getMessage()]))->send();
            return;
        }
    }      
 }
}