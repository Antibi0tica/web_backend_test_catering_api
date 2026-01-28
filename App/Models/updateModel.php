<?php

namespace App\Models;

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;

/**
 * UpdateModel handles update operations for facilities and tags
 */

class UpdateModel extends BaseModel {

    /**
     * Update a facility's name
     * 
     * @param int $id The facility ID to update
     * @param array $data Array containing 'facility_name' key
     * @return void Sends JSON response with update status
     */
    
    public function updateFacility($id, $data) {
        // Extract and validate facility name from request data
        $facility = $data['facility_name'];
        $this->inputCheck($facility);
        $filteredFacility = $this->filterText(['facility_name' => $facility], 'facility_name');

         // Update facility name in database
        $this->updateField('facility', 'facility_name', $filteredFacility, $id, 'Facility', 'updated');    

    }


    /**
     * Update a tag's name
     * 
     * @param int $id The tag ID to update
     * @param array $data Array containing 'tag' key
     * @return void Sends JSON response with update status
     */
    public function updateTag($id, $data) {

        // Extract and validate tag name from request data
        $tag = $data['tag'];
        $this->inputCheck($tag);
        $filteredTag = $this->filterText(['tag' => $tag], 'tag');

        // Update tag name in database
        $this->updateField('tag', 'name', $filteredTag, $id, 'Tag', 'updated');
    }



}