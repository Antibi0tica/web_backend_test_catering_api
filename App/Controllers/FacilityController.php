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
            $facilityModel = new \App\Models\FacilityModel($this->db);
            $facilityModel->createTag($tekst['tag']);
        }

        // Checks if the body mentioned 'facility' and 'location' to create a facility
        if (isset($tekst['facility_name']) && isset($tekst['location'])) {
            $facilityModel = new \App\Models\FacilityModel($this->db);
            $facilityModel->createFacility($tekst['facility_name'], $tekst['location']);
        }
    } catch (Status\Exception $e) {
            (new Status\BadRequest(['message' => $e->getMessage()]))->send();
            return;

    }



    } 
}   



//$rectext = $_POST['text'];

// $bestand = file_get_contents('php://input');
// $tekst = json_decode($bestand, TRUE);
// $jari = "jari";




// try {

//     // $tekst = (new \App\Models\FacilityModel())->FilterText($tekst, 'tag_name');

//     if (isset($tekst['tag'])) {
//         $facilityModel = new \App\Models\FacilityModel($this->db);
//         $facilityModel->createTag($tekst['tag']);
//     }

//     // if (!isset($tekst['tag_name'])) {
//     //     throw (new Status\Exception(['message' => "'tag_name' field cannot be empty"]))->send();
//     // }

//     // if (empty($tekst['tag_name'])) {
//     //     throw (new Status\Exception(['message' => "'tag_name' field cannot be empty"]))->send();
//     // }

// } catch (Status\Exception $e) {
//     (new Status\BadRequest(['message' => $e->getMessage()]))->send();
//     return;
// }