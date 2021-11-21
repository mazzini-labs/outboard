<?php 
namespace Phppot\Model;

use Phppot\Datasource;

class FAQ
{
    private $ds;
    
    function __construct()
    {
        require_once __DIR__ . './../lib/DataSourceEnotes.php';
        $this->ds = new DataSource();
    }
    
    /**
     * to get the interview questions
     *
     * @return array result record
     */
    function getFAQ() 
    {
        //$query = "SELECT * from post2015ddr";
        $query = "SELECT * from `list` order by api asc";
        /* $query = "SELECT `list`.*, `prod_data`.*
            
             FROM list, prod_data
             WHERE `prod_data`.`prod_mo` = `list`.`last_prod_date` AND `list`.`api` = `prod_data`.`api` 
            ";  */
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
       
        //columnValue = $this->ds->superentities($columnValue);
        $columnValue = mysqli_real_escape_string($this->ds->getConnection(), $columnValue);
        //$columnValue = htmlentities($columnValue, ENT_SUBSTITUTE, UTF-8);
        //$query = "UPDATE post2015ddr set " . $columnName . " = ? WHERE  rowid = ?";
        $query = "UPDATE `list` set " .  $columnName . " = ? WHERE  `list`.`api` = ?";
        
        $paramType = 'si';
        $paramValue = array(
            $columnValue,
            $questionId
        );
        $this->ds->execute($query, $paramType, $paramValue);
    }
}