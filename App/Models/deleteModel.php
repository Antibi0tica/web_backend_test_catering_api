<?php 

namespace App\Models;

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;


/**
 * DeleteModel handles delete operations for facilities and related data
 */

class DeleteModel extends BaseModel {

    /**
     * Delete a facility and its associated tags from the database
     * 
     * @param int $id The facility/tag ID to delete
     * @return void Sends JSON response with deletion status
     */

    public function deleteModel($id) {
        // Multi-statement query to delete facility_tag relations, facility, and tag
        $query = "
        DELETE FROM `facility_tag` WHERE `facility_tag`.`facility_id` = ? AND `facility_tag`.`tag_id` = ?;
        DELETE FROM `facility` WHERE `facility`.`id` = ?;
        DELETE FROM `tag` WHERE `tag`.`id` = ?;";

    try {
        // Execute deletion with ID parameter for all statements
        $result = $this->db->executeQuery($query, [$id, $id, $id, $id]);

        $this->errHandling($result, 'delete', NULL);

    } catch (Status\Exception $e) {
            (new Status\BadRequest(['message' => $e->getMessage()]))->send();
            return;
        }
    }
}