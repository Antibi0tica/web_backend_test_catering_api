<?php

namespace App\Models;

use App\Plugins\Http\Response as Status;


/**
 * BaseModel provides common database operations for all model classes
 */
abstract class BaseModel {
    protected $db;

    /**
     * Constructor to initialize database connection
     * 
     * @param object $db Database connection instance
     */

    public function __construct($db) {
        $this->db = $db;
    }
    /**
     * Validate input to ensure it's not empty and is a string
     * 
     * @param mixed $data Input data to validate
     * @return void
     * @throws Status\BadRequest If validation fails
     */
    public function inputCheck($data) {
        if (empty($data)) {
            throw (new Status\BadRequest(['message' => 'Input cannot be empty']))->send();
        }

        if (!is_string($data)) {
            throw (new Status\BadRequest(['message' => 'Input must be a string']))->send();
        }

        
    }

    /**
     * Update a single field in a database table
     * 
     * @param string $table Table name to update
     * @param string $column Column name to update
     * @param mixed $value New value for the column
     * @param int $id Record ID to update
     * @param string $name Entity name for response message
     * @param string $op Operation description (e.g., 'updated')
     * @return void Sends JSON response with operation status
     */
    public function updateField($table, $column, $value, $id, $name, $op) {
        $query = "UPDATE `$table` SET `$column` = ? WHERE `$table`.`id` = ?";
        $update = $this->db->executeQuery($query, [$value, $id]);

        $this->errHandling($update, $name, $op);
    }

    /**
     * Handle database operation results and send appropriate response
     * 
     * @param bool $result Database operation result
     * @param string $name Entity name for response message
     * @param string $op Operation description (e.g., 'created', 'updated', 'deleted')
     * @return void Sends JSON response
     */
    public function errHandling ($result, $name, $op) {
        if ($result) {
            (new Status\Ok(['message' => "$name $op successfully"]))->send();
        } else {
            (new Status\BadRequest(['message' => "$name $op failed"]))->send();
        }

        
        }

    /**
     * Sanitize and normalize text input
     * 
     * @param array $text Array containing the text to filter
     * @param string $key Key in the array to filter
     * @return string Filtered and sanitized text
     */
    public function filterText(array $text, string $key) {


        $value = $text[$key];

        // Remove whitespace, convert to lowercase, remove quotes and slashes
        $value = trim($value);
        $value = strtolower($value);
        $value = str_replace("'", "", $value);
        $value = stripslashes($value);

        // Normalize multiple spaces to single space
        $value = preg_replace('/\s+/u', ' ', $value);

        $text[$key] = $value;
        return $text[$key]; 
        }


        /**
     * Valid location names mapped to their database IDs
     * 
     * @var array<string, int>
     */
    public const LOCATIONS = 
        [
            'krommenie' => 1,
            'assendelft' => 2,
            'wormerveer' => 3,
            'amsterdam' => 4
            
        ];

        /**
     * Trim string input if not null
     * 
     * @param string|null $input Input string to check and trim
     * @return void
     */
    public function checkString ($input) {
        if ($input != NULL) {
            trim($input);
        }
    }
    
}