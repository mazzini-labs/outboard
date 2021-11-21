<?php
// define("PROJECT_ROOT_PATH", __DIR__ . "/../");

// include main configuration file
require_once PROJECT_ROOT_PATH . "Model/Config.php";

class Database extends OutboardConfig
{
    protected $connection = null;
    private $result = null;	   // The current query result handle
    public function __construct()
    {
        parent::__construct();
        try {
            // $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
            $this->connection = new mysqli($this->getConfig('dbhost'),
            $this->getConfig('dbuser'),
            $this->getConfig('dbpass'));
            if (mysqli_connect_errno()) {
                throw new Exception("Unable to connect to the database server.");
            }
            $this->connection->select_db($this->getConfig('db'));
            if (mysqli_connect_errno()) {
                throw new Exception("Unable to open the OutBoard database.");
            }
            // if ( mysqli_connect_errno()) {
            //     throw new Exception("Could not connect to database.");   
            // }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }			
    }

    public function select($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);				
            $stmt->close();

            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }
    // public function _query($query = "" , $params = [])
    // {
    //     try {
    //         $stmt = $this->executeStatement( $query , $params );
    //         $stmt->close();
    //         return $stmt;
    //     } catch(Exception $e) {
    //         throw New Exception( $e->getMessage() );
    //     }
    //     return false;
    // }

    private function executeStatement($query = "" , $params = [])
    {
        try {
            $stmt = $this->connection->prepare( $query );

            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }

            if( $params ) {
                $stmt->bind_param($params[0], $params[1]);
            }

            $stmt->execute();

            return $stmt;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }	
    }
    public function _query($stmt = "")
    {
        try {
            
            if(! $stmt) { return false; }
            if($this->result = $this->connection->query( $stmt )){
                return true;
            } else {
                trigger_error("Error in database query.");
                return false;
            }
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }	
    }
    public function numRows() {
        if (! $this->result) { return null; }
        return mysqli_num_rows($this->result);
    }
    
    public function getRow() {
        if (! $this->result) { return null; }
        if ($row = mysqli_fetch_array($this->result)) { 
            return $row;
        } else {
            return null;
        } 
    }

}