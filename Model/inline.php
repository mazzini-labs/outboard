<?php 
//namespace Phppot\Model;

//use Phppot\Datasource;
//require_once "../lib/DataSource.php";
class inline
{
    private $ds;
    
    function __construct()
    {
        require_once __DIR__ . './../lib/DataSource.php';
        $this->ds = new DataSource();
    }
    //SELECT * from `000api_list` WHERE `api` like `01-075-20110`
    /**
     * to get the interview questions
     *
     * @return array result record
     */
    function getwell($api) 
    {
        $conn = $this->ds->getConnection();
        /*could i put query as a variable in getinline to then differentiate between wells?*/
        $convert = "SELECT well from `000api_list` WHERE `api` like \"%".$api."%\"";
        //$well = $this->ds->select($convert);
        $wellResult = mysqli_query($conn, $convert);
	    while ($row = mysqli_fetch_array($wellResult)) {
            $well = $row['well'];
        }
        return $well;
    }
    function getinline($api, $sheet) 
    {
        $well = $this->getwell($api);
        $query = "SELECT * from `$well` WHERE sheet like '" . $sheet . "'";
        $result = $this->ds->select($query);
        return $result;
    }
    
    /**
     * to edit redorcbased on the question_id
     *
     * @param string $columnName
     * @param string $columnValue
     * @param string $rowId
     */
    function editRecord($api, $sheet, $columnName, $columnValue, $rowId) 
    {
        $table = $this->getwell($api);
        $query = "UPDATE `$table` set " . $columnName . " = ? WHERE id = ? AND sheet = '" . $sheet . "'";
        
        $paramType = 'si';
        $paramValue = array(
            $columnValue,
            $rowId
        );
        $this->ds->execute($query, $paramType, $paramValue);
    }

    function getColumns($database, $table)
    {
        $conn = $this->ds->getConnection();
        $query = "SELECT `COLUMN_NAME` 
                FROM `INFORMATION_SCHEMA`.`COLUMNS` 
                WHERE `TABLE_SCHEMA`='$database' 
                AND `TABLE_NAME`='$table'
                ";
        $result = mysqli_query($conn, $query);
        $fields = array();
        while ($row = mysqli_fetch_arry($wellResult))
        {
            $fields[] = $row['Field'];
        }
        return $fields;
        
    }

    function addRecord($database, $table, $values)
    {
        $fields = $this->getColumns($database, $table);
        $query = "INSERT INTO " . $table . "(" . $fields . ") VALUES (" . $values . ")";
        $this->ds->execute($query);
    }
    
    function addEngDDR($t, $d, $ts, $te, $ec, $eci, $edr, $edc, $ecc, $deb, $api) 
    {
        //$table = $this->getwell($api);
        if($edc != 0.00 && $ecc != 0.00){
        $query = "INSERT INTO `new_ddr` " 
        . " (`type`, `department`, `date`, `time_start`, "
        . "`time_end`, `eng_contact`, `eng_contact_info`, `eng_daily_report`, "
        . "`eng_edc`, `eng_ecc`, `data_entry_by`, `api`)"
        . "VALUES (?, 'eng', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        //NOT SURE IF WORKING YET, NEED TO FIGURE OUT HOW TO GET ALL VALUES
         $paramType = 'sssssssiiss';
         $paramValue = array(
            $t, $d, $ts, $te, $ec, $eci, $edr, $edc, $ecc, $deb, $api
         ); 
        }
        elseif($edc == 0.00 && $ecc != 0.00){
            $query = "INSERT INTO `new_ddr` " 
        . " (`type`, `department`, `date`, `time_start`, "
        . "`time_end`, `eng_contact`, `eng_contact_info`, `eng_daily_report`, "
        . "`eng_ecc`, `data_entry_by`, `api`)"
        . "VALUES (?, 'eng', ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        //NOT SURE IF WORKING YET, NEED TO FIGURE OUT HOW TO GET ALL VALUES
         $paramType = 'sssssssiss';
         $paramValue = array(
            $t, $d, $ts, $te, $ec, $eci, $edr, $ecc, $deb, $api
         ); 
        }
        elseif($ecc == 0.00 && $edc != 0.00){
            $query = "INSERT INTO `new_ddr` " 
        . " (`type`, `department`, `date`, `time_start`, "
        . "`time_end`, `eng_contact`, `eng_contact_info`, `eng_daily_report`, "
        . "`eng_edc`, `data_entry_by`, `api`)"
        . "VALUES (?, 'eng', ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        //NOT SURE IF WORKING YET, NEED TO FIGURE OUT HOW TO GET ALL VALUES
         $paramType = 'sssssssiss';
         $paramValue = array(
            $t, $d, $ts, $te, $ec, $eci, $edr, $edc, $deb, $api
         ); 
        }
        elseif($edc == 0.00 && $ecc == 0.00){
            $query = "INSERT INTO `new_ddr` " 
        . " (`type`, `department`, `date`, `time_start`, "
        . "`time_end`, `eng_contact`, `eng_contact_info`, `eng_daily_report`, "
        . "`data_entry_by`, `api`)"
        . "VALUES (?, 'eng', ?, ?, ?, ?, ?, ?, ?, ?)";
        //NOT SURE IF WORKING YET, NEED TO FIGURE OUT HOW TO GET ALL VALUES
         $paramType = 'sssssssss';
         $paramValue = array(
            $t, $d, $ts, $te, $ec, $eci, $edr, $deb, $api
         ); 
        }
        $this->ds->execute($query, $paramType, $paramValue); 
        //$this->ds->execute($query);
    }
    function addAcctDDR($t, $d, $ts, $te, $av, $aid, $aia, $aai, $aad, $_aad, $deb, $api) 
    {
        $query = "INSERT INTO `new_ddr` " 
        . " (`type`, `department`, `date`, `time_start`, "
        . "`time_end`, `acct_vendor`, `acct_invoice_details`, `acct_invoice_amt`, "
        . "`acct_approval_initials`, $_aad `data_entry_by`, `api`)"
        . "VALUES (?, 'acct', ?, ?, ?, ?, ?, ?, ?, $aad ?, ?)";
        //NOT SURE IF WORKING YET, NEED TO FIGURE OUT HOW TO GET ALL VALUES
         $paramType = 'ssssssisss';
         $paramValue = array(
            $t, $d, $ts, $te, $av, $aid, $aia, $aai, $deb, $api
         ); 
        $this->ds->execute($query, $paramType, $paramValue); 
        //$this->ds->execute($query);
    }
    function addVendDDR($t, $d, $ts, $te, $vna, $vs, $vno, $vah, $vac, $vet, $vtt, $vtc, $_vah, $_vac, $_vet, $_vtt, $_vtc, $deb, $api) 
    {
        $query = "INSERT INTO `new_ddr` " 
        . " (`type`, `department`, `date`, `time_start`, "
        . "`time_end`, `vend_name`, `vend_service`, `vend_notes`, "
        . "$_vah $_vac $_vet $_vtt $_vtc `data_entry_by`, `api`)"
        . "VALUES (?, 'vendor', ?, ?, ?, ?, ?, ?, $vah $vac $vet $vtt $vtc ?, ?)";
        //NOT SURE IF WORKING YET, NEED TO FIGURE OUT HOW TO GET ALL VALUES
         $paramType = 'sssssssss';
         $paramValue = array(
            $t, $d, $ts, $te, $vna, $vs, $vno, $deb, $api
         ); 
        $this->ds->execute($query, $paramType, $paramValue); 
        //$this->ds->execute($query);
    }

    function addFieldDDR($t, $d, $ts, $te, $fc, $fci, $fdr, $fdc, $fcc, $deb, $api) 
    {
        //$table = $this->getwell($api);
        if($fdc != 0.00 && $fcc != 0.00){
        $query = "INSERT INTO `new_ddr` " 
        . " (`type`, `department`, `date`, `time_start`, "
        . "`time_end`, `eng_contact`, `eng_contact_info`, `eng_daily_report`, "
        . "`eng_edc`, `eng_ecc`, `data_entry_by`, `api`)"
        . "VALUES (?, 'field', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        //NOT SURE IF WORKING YET, NEED TO FIGURE OUT HOW TO GET ALL VALUES
         $paramType = 'sssssssiiss';
         $paramValue = array(
            $t, $d, $ts, $te, $fc, $fci, $fdr, $fdc, $fcc, $deb, $api
         ); 
        }
        elseif($fdc == 0.00 && $fcc != 0.00){
            $query = "INSERT INTO `new_ddr` " 
        . " (`type`, `department`, `date`, `time_start`, "
        . "`time_end`, `eng_contact`, `eng_contact_info`, `eng_daily_report`, "
        . "`eng_ecc`, `data_entry_by`, `api`)"
        . "VALUES (?, 'field', ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        //NOT SURE IF WORKING YET, NEED TO FIGURE OUT HOW TO GET ALL VALUES
         $paramType = 'sssssssiss';
         $paramValue = array(
            $t, $d, $ts, $te, $fc, $fci, $fdr, $fcc, $deb, $api
         ); 
        }
        elseif($fcc == 0.00 && $fdc != 0.00){
            $query = "INSERT INTO `new_ddr` " 
        . " (`type`, `department`, `date`, `time_start`, "
        . "`time_end`, `eng_contact`, `eng_contact_info`, `eng_daily_report`, "
        . "`eng_edc`, `data_entry_by`, `api`)"
        . "VALUES (?, 'field', ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        //NOT SURE IF WORKING YET, NEED TO FIGURE OUT HOW TO GET ALL VALUES
         $paramType = 'sssssssiss';
         $paramValue = array(
            $t, $d, $ts, $te, $fc, $fci, $fdr, $fdc, $deb, $api
         ); 
        }
        elseif($fdc == 0.00 && $fcc == 0.00){
            $query = "INSERT INTO `new_ddr` " 
        . " (`type`, `department`, `date`, `time_start`, "
        . "`time_end`, `eng_contact`, `eng_contact_info`, `eng_daily_report`, "
        . "`data_entry_by`, `api`)"
        . "VALUES (?, 'field', ?, ?, ?, ?, ?, ?, ?, ?)";
        //NOT SURE IF WORKING YET, NEED TO FIGURE OUT HOW TO GET ALL VALUES
         $paramType = 'sssssssss';
         $paramValue = array(
            $t, $d, $ts, $te, $fc, $fci, $fdr, $deb, $api
         ); 
        }
        $this->ds->execute($query, $paramType, $paramValue); 
        //$this->ds->execute($query);
    }
}