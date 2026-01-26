<?php

namespace App\Controllers;

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;


Class FacilityController extends BaseController {

    public function createController() {

    $bestand = file_get_contents('php://input');
    $tekst = json_decode($bestand, TRUE);

    try {

        // Checks if the body mentioned 'tag' and creates a tag for the database
        if (isset($tekst['tag'])) {
            $createModel = new \App\Models\createModel($this->db);
            $createModel->createTag($tekst['tag']);
        }

        // Checks if the body mentioned 'facility' and 'location' to create a facility
        if (isset($tekst['facility_name']) && isset($tekst['location'])) {
            $createModel = new \App\Models\createModel($this->db);
            $createModel->createFacility($tekst);
        }


        // New If statement for the creation of the conjuction table (Facility.id and )
    } catch (Status\Exception $e) {
            (new Status\BadRequest(['message' => $e->getMessage()]))->send();
            return;

    }



    } 

// Function readTest() Isn't done. Current state isn't finished

    public function readAllController() {

    try {
        $readmodel = new \App\Models\ReadModel($this->db);
        $readmodel->ReadAllFacility();
        
    } catch (Status\Exception $e) {
        (new Status\BadRequest(['message' => $e->getMessage()]))->send();
        return;
    }
}

    public function readOneController($id) {

    try {
        $readmodel = new \App\Models\ReadModel($this->db);
        $readmodel->ReadOneFacility($id);

    }catch (Status\Exception $e) {
        (new Status\BadRequest(['message' => $e->getMessage()]))->send();
        return;
    }
}

    public function updateController($id) {

    $bestand = file_get_contents('php://input');
    $tekst = json_decode($bestand, TRUE);


    try {
        if (isset($tekst['tag'])) {
            $updateModel = new \App\Models\updateModel($this->db);
            $updateModel->updateTag($id, $tekst);
        }

        if (isset($tekst['facility_name'])) {
            $updateModel = new \App\Models\updateModel($this->db);
            $updateModel->updateFacility($id, $tekst);
        }


    } catch (Status\Exception $e) {
        (new Status\BadRequest(['message' => $e->getMessage()]))->send();
        return;
    }

    }


    public function deleteController($id) {
        echo $id;
        try {
            $deleteModel = new \App\Models\deleteModel($this->db);
            $deleteModel->deleteModel($id);
        } catch (Status\Exception $e) {
        (new Status\BadRequest(['message' => $e->getMessage()]))->send();
        return;
        }
    
    
} 







}