<?php 

namespace App\Models;

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;


class deleteModel extends baseModel {

    public function deleteModel($id) {
        $query = "
        DELETE FROM `facility_tag` WHERE `facility_tag`.`facility_id` = ? AND `facility_tag`.`tag_id` = ?;
        DELETE FROM `facility` WHERE `facility`.`id` = ?;
        DELETE FROM `tag` WHERE `tag`.`id` = ?;";

        $result = $this->db->executeQuery($query,[$id, $id, $id, $id]);

        if ($result) {
            (new Status\Ok(['message' => 'Deleted Successfully']))->send();
        } else {
            (new Status\BadRequest(['message' => 'Delete failed']))->send();
        }   
    }
}