<?php

namespace App\Models;

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;

class ReadModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }


    

}