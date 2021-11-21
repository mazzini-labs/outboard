<?php 
//namespace Phppot\Model;

use Phppot\Datasource;

class Prod
{
    private $ds;
    
    function __construct()
    {
        require_once __DIR__ . './../lib/DataSource.php';
        $this->ds = new DataSource();
    }
    
    /**
     * to get the interview questions
     *
     * @return array result record
     */
    function getProd() 
    {
        //$query = "SELECT * from post2015ddr";
        //$query = "SELECT * from `list`";
        
         $query = "SELECT `list`.*, `prod_data`.*
            
             FROM list, prod_data
             WHERE `prod_data`.`prod_mo` = `list`.`last_prod_date` AND `list`.`api` = `prod_data`.`api` 
            ";  
        $result = $this->ds->select($query);
        return $result;
    }
    
    /**
     * to edit redorcbased on the question_id
     *
     * @param string $columnName
     * @param string $columnValue
     * @param string $questionId
     */
    function editRecord($columnName, $columnValue, $questionId) 
    {
        $query = "UPDATE prod_data set " . $columnName . " = ? WHERE  prod_data_id = ?";
        //$query = "UPDATE `prod_data` set " .  $columnName . " = ? WHERE  `prod_data`.`prod_data_id` = ?";
        
        $paramType = 'si';
        $paramValue = array(
            $columnValue,
            $questionId
        );
        $this->ds->execute($query, $paramType, $paramValue);
    }
}