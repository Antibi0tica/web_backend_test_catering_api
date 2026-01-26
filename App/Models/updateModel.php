<?php

namespace App\Models;

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;



class updateModel extends baseModel{
    
    public function updateFacility($id, $tekst) {

        $facility = $tekst['facility_name'];

        $this->inputChecks($facility);


        $filteredFacility = $this->FilterText(['facility_name' => $facility], 'facility_name');
        

        $query = "UPDATE `facility` SET `facility_name` = ? WHERE `facility`.`id` = ?;";

        $update = $this->db->executeQuery($query, [$filteredFacility, $id]);

            if ($update){ 
                $stmt = $this->db->getStatement();
                $rows = $stmt->FetchAll(\PDO::FETCH_ASSOC);

                (new Status\Ok(['Message' => 'Facility updated successfully']))->send();
            } else {
                (new Status\BadRequest(['message' => 'Facilty update failed']))->send();
            }


    }


    public function updateTag($id, $tekst) {

        $tag = $tekst['tag'];

        $this->inputChecks($tag);


        $filteredTag = $this->FilterText(['tag' => $tag], 'tag');

        $query = "UPDATE `tag` SET `name` = ? WHERE `tag`.`id` = ?;";

        $update = $this->db->executeQuery($query, [$filteredTag, $id]);

        if ($update){ 
                $stmt = $this->db->getStatement();
                $rows = $stmt->FetchAll(\PDO::FETCH_ASSOC);

                (new Status\Ok(['Message' => 'Tag updated successfully']))->send();
            } else {
                (new Status\BadRequest(['message' => 'Facilty update failed']))->send();
            }
    }


}