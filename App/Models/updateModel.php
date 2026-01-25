<?php

namespace App\Models;

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;



class updateModel extends baseModel{
    
    public function updateFacility($id, $tekst) {

        $facility = $tekst['facility_name'];

        $this->inputChecks($facility);


        $filteredFacility = $this->FilterText(['facility_name' => $facility], 'facility_name');

        $dbFacility = "SELECT facility.facility_name FROM facility WHERE facility.id = ?;";
        $updatequery = "UPDATE `facility` SET `facility_name` = ? WHERE `facility`.`id` = ?;";

        $result = $this->db->executeQuery($dbFacility,[$id]);
        $update = $this->db->executeQuery($updatequery, [$filteredFacility, $id]);

            if ($update){ 
                $stmt = $this->db->getStatement();
                $rows = $stmt->FetchAll(\PDO::FETCH_ASSOC);

            }

            if ($result){
                (new Status\Ok(['facility_name' => 'Has been updated']))->send();
            }

        







    }


    public function updateTag($id, $tekst) {

        $this->inputCheck($tekst);



    }


}