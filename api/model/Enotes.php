<?php 
namespace Phppot\Model;

use Phppot\Datasource;

class wellFile
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
	
	var $typeSelect = null;
	var $tableSelect = null;
    function getWellFile() 
    {
		//$tableSelect = $_GET['tableSelect'];
		if (isset($_POST['typeSelect'])) {
        $typeSelect = $_POST['typeSelect'];
    	} else {
			$typeSelect = '"b2015DDR"';
		}
		if (isset($_POST['tableSelect'])) {
		$tableSelect = $_POST['tableSelect'];
		} else {
			$tableSelect = '`test2`';
		}
		//$typeSelect = $_GET['typeSelect'];
        $query = "SELECT * from " . $tableSelect . " WHERE sheet like " . $typeSelect . "";
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
    function editRecord($tableSelect, $columnName, $columnValue, $questionId) 
    {
        $query = "UPDATE " . $tableSelect ." set " . $columnName . " = ? WHERE  rowid = ?";
        
        $paramType = 'si';
        $paramValue = array(
            $columnValue,
            $questionId
        );
        $this->ds->execute($query, $paramType, $paramValue);
    }
}