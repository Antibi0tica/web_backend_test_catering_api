<?php

namespace App\Models;

use App\Plugins\Http\Response as Status;

abstract class BaseModel {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function inputChecks($tekst) {
        if (empty($tekst)) {
            throw (new Status\BadRequest(['message' => 'Input cannot be empty']))->send();
        }

        if (!is_string($tekst)) {
            throw (new Status\BadRequest(['message' => 'Input must be a string']))->send();
        }

        
    }

    public function FilterText(array $text, string $key) {


        $value = $text[$key];

        $value = trim($value);
        $value = strtolower($value);
        $value = str_replace("'", "", $value);
        $value = stripslashes($value);

        $value = preg_replace('/\s+/u', ' ', $value);

        $text[$key] = $value;
        return $text[$key]; 
        }

    public const LOCATIONS = 
        [
            'krommenie' => 1,
            'assendelft' => 2,
            'wormerveer' => 3
            
        ];
    
}