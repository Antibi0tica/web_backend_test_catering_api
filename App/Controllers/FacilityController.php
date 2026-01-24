<?php

namespace App\Controllers;

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;


Class FacilityController extends BaseController {

    public function FacilityController() {

    $bestand = file_get_contents('php://input');
    $tekst = json_decode($bestand, TRUE);

    try {

        // Checks if the body mentioned 'tag' and creates a tag for the database
        if (isset($tekst['tag'])) {
            $facilityModel = new \App\Models\createModel($this->db);
            $facilityModel->createTag($tekst['tag']);
        }

        // Checks if the body mentioned 'facility' and 'location' to create a facility
        if (isset($tekst['facility_name']) && isset($tekst['location'])) {
            $facilityModel = new \App\Models\createModel($this->db);
            $facilityModel->createFacility($tekst['facility_name'], $tekst['location']);
        }
    } catch (Status\Exception $e) {
            (new Status\BadRequest(['message' => $e->getMessage()]))->send();
            return;

    }



    } 

// Function readTest() Isn't done. Current state isn't finished

    public function readalltest() {

        $readmodel = new \App\Models\ReadModel($this->db);
        $readmodel->ReadAllFacility();
        // Respond with 200 (OK):
        (new Status\Ok(['message' => 'Check if sent']))->send();
    }

    public function readonetest($id){

    $url = 'http://localhost/web_backend_test_catering_api/facility';
    $id = explode('/', $url);
    echo $id;

    }
    
    
} 







