<?php  
$mysqli = mysqli_connect("localhost", "root", "devonian", "wells");  
if(isset($_POST["ddr_id"]))  
{  
$output = '';  
$api = '"' . $_POST['api'] . '"';
$width1 = "width=1%";
$width2 = "width=2%";
$width3 = "width=3%";
$width4 = "width=4%";
$width7 = "width=7%";
$width10 = "width=22%";
$width14 = "width=24%";
$ddr = "new_ddr";
$sub_date = "submission_date";

    $row = mysqli_fetch_array($dataresult);  
    echo json_encode($row);  

    
    
    $datasql = "SELECT * FROM $ddr WHERE WHERE api=$api AND id = '".$_POST["ddr_id"]."'";  
    $dataresult = mysqli_query($mysqli, $datasql) or die(mysqli_error($mysqli));
    $output .= '  
    <div class="table-responsive">  
        <table class="table table-bordered">';  
    while($datarow = mysqli_fetch_array($dataresult))  
    {  
    $type = $datarow['type'];
    if($type != "dsr")
    {
        $i = 0;
        $department = $datarow['department'];
        $ddrID = $datarow['id'];
        switch($department)
        {
            case "eng":
                $ddr_date = ($datarow['date'] != '') ? $datarow['date'] : " - ";
                $time_start = ($datarow['time_start'] != '') ? $datarow['time_start'] : " - ";
                $time_end = ($datarow['time_end'] != '') ? $datarow['time_end'] : " - ";
                $eng_contact = ($datarow['eng_contact'] != '') ? $datarow['eng_contact'] : " - ";
                $eng_contact_info = ($datarow['eng_contact_info'] != '') ? $datarow['eng_contact_info'] : " - ";
                $eng_daily_report = ($datarow['eng_daily_report'] != '') ? $datarow['eng_daily_report'] : " - ";
                $eng_edc = ($datarow['eng_edc'] != '') ? $datarow['eng_edc'] : " - ";
                $eng_ecc = ($datarow['eng_ecc'] != '') ? $datarow['eng_ecc'] : " - ";
                $data_entry_by = ($datarow['data_entry_by'] != '') ? $datarow['data_entry_by'] : " - ";
                $submission_date = ($datarow['submission_date'] != '') ? $datarow['submission_date'] : " - ";
                $output .= '
                    <tr>
                        <td class="engineering" '.$width2.'><small>Engineering</small></td>
                        <td class="engineering-date" '.$width2.'><small>'.$ddr_date.'</td ></small>
                        <td class="engineering" '.$width4.'><small>'.$time_start.' - '.$time_end.'</td ></small>
                        <td class="engineering" '.$width4.'><small>'.$eng_contact.'</a></td ></small>
                        <td class="engineering" '.$width4.'><small>'.$eng_contact_info.'</td ></small>
                        <td class="engineering" '.$width10.'><small>'.$eng_daily_report.'</small> </td >
                        <td class="engineering" '.$width4.'><small>'.$eng_edc.'</td ></small>
                        <td class="engineering" '.$width4.'><small>'.$eng_ecc.'</td ></small>
                        <td class="engineering" '.$width4.'>
                            <a href="#editEmployeeModal" id="'.$ddrID.'" class="edit" data-toggle="modal"><img src='.$image_dir.'/edit.svg border=0 data-toggle="tooltip" title="Edit"></a>
                            <a href="#deleteEmployeeModal" id="'.$ddrID.'" class="delete" data-toggle="modal"><img src='.$image_dir.'/trash-2.svg border=0 data-toggle="tooltip" title="Delete"></a>
                        </td>
                    </tr>';
            break;
            case "acct":
                $ddr_date = ($datarow['date'] != '') ? $datarow['date'] : " - ";
                $time_start = ($datarow['time_start'] != '') ? $datarow['time_start'] : "";
                $time_end = ($datarow['time_end'] != '') ? $datarow['time_end'] : "";
                $acct_vendor = ($datarow['acct_vendor'] != '') ? $datarow['acct_vendor'] : " - ";
                $acct_invoice_no = ($datarow['acct_invoice_no'] != '') ? $datarow['acct_invoice_no'] : " - ";
                $acct_invoice_details = ($datarow['acct_invoice_details'] != '') ? $datarow['acct_invoice_details'] : " - ";
                $acct_invoice_amt = ($datarow['acct_invoice_amt'] != '') ? $datarow['acct_invoice_amt'] : " - ";
                $acct_approval_initials = ($datarow['acct_approval_initials'] != '') ? $datarow['acct_approval_initials'] : " - ";
                $acct_approval_date = ($datarow['acct_approval_date'] != '') ? $datarow['acct_approval_date'] : " - ";
                $data_entry_by = ($datarow['data_entry_by'] != '') ? $datarow['data_entry_by'] : " - ";
                $submission_date = ($datarow['submission_date'] != '') ? $datarow['submission_date'] : " - ";
                $time_dash = ($time_start == "-" || $time_end == " - ") ? "" : "-";
                $output .= '
                <tr>
                    <td class="accounting" '.$width2.'><small>Accounting</small></td>
                    <td class="accounting" '.$width2.'><small>$ddr_date</td ></small>
                    <td class="accounting" '.$width4.'><small>$time_start $time_dash $time_end</td ></small>
                    <td class="accounting" '.$width4.'><small>$acct_vendor</a></td ></small>
                    <td class="accounting" '.$width4.'><small>$acct_invoice_no</td ></small>
                    <td class="accounting" '.$width10.'><small>$acct_invoice_details</small> </td >
                    <td class="accounting" '.$width4.'><small>$acct_approval_initials</td ></small>
                    <td class="accounting" '.$width4.'><small>$acct_approval_date</td ></small>
                    <td class="accounting" '.'.$width4.'.'>
                        <a href="#editEmployeeModal" class="edit" data-toggle="modal"><img src='.$image_dir.'/edit.svg border=0 data-toggle="tooltip" title="Edit"></a>
                        <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><img src='.$image_dir.'/trash-2.svg border=0 data-toggle="tooltip" title="Delete"></a>
                    </td>
                </tr>';
            break;
            case "vendor":
                $ddr_date = ($datarow['date'] != '') ? $datarow['date'] : " - ";
                $vend_name = ($datarow['vend_name'] != '') ? $datarow['vend_name'] : " - ";
                //$vend_name = $datarow['vend_name'] != '') ?  : " - ";
                $vend_service = ($datarow['vend_service'] != '') ? $datarow['vend_service'] : " - ";
                $vend_aol = ($datarow['time_start'] != '') ? $datarow['time_start'] : "";
                $vend_ll = ($datarow['time_end'] != '') ? $datarow['time_end'] : "";
                $vend_hours = ($datarow['vend_hours'] != '') ? $datarow['vend_hours'] : " - ";
                $vend_deduct_time = ($datarow['vend_deduct_time'] != '') ? "Deduction Hrs: " . $datarow['vend_deduct_time'] : " - ";
                $vend_deduct_reason = ($datarow['vend_deduct_reason'] != '') ? "Deduction Reasons: " . $datarow['vend_deduct_reason'] : " - ";
                $vend_adjust_hrs = ($datarow['vend_adjust_hrs'] != '') ? "Adjusted Hours: " . $datarow['vend_adjust_hrs'] : "";
                $vend_adjust_cost = ($datarow['vend_adjust_cost'] != '') ? "Adjusted Cost: " . $datarow['vend_adjust_cost'] : "";
                $vend_est_travel = ($datarow['vend_est_travel'] != '') ? "Est. Travel Time: " . $datarow['vend_est_travel'] : " - ";
                $vend_total_hours = ($datarow['vend_total_hours'] != '') ? "Total Time: " . $datarow['vend_total_hours'] : " - ";
                $vend_total_cost = ($datarow['vend_total_cost'] != '') ? $datarow['vend_total_cost'] : " - ";
                $vend_invoice_date = ($datarow['vend_invoice_date'] != '') ? $datarow['vend_invoice_date'] : " - ";
                $vend_invoice_received = ($datarow['date_invoice_received'] != '') ? $datarow['date_invoice_received'] : " - ";
                $data_entry_by = ($datarow['data_entry_by'] != '') ? $datarow['data_entry_by'] : " - ";
                $submission_date = ($datarow['submission_date'] != '') ? $datarow['submission_date'] : " - ";
                $vend_notes = ($datarow['vend_notes'] != '') ? "Notes: " . $datarow['vend_notes'] : " - ";
                $time_dash = ($vend_aol == "-" || $vend_ll == "-") ? "" : " - ";
                $vend_adj_hr = ($vend_adjust_hrs != "" && $vend_adjust_cost != "") ? " <hr> " : " - ";
                $vend_travel_hr = ($vend_est_travel != " - " && $vend_total_hours != " - ") ? " <hr> " : " - ";
                $vend_deduct_hr = ($vend_deduct_time != " - " && $vend_deduct_reason != " - ") ? " <hr> " : " - ";
                /* {
                    $vend_deduct_hr = " <hr> " : " - ";
                } elseif ($vend_deduct_time != " - " || $vend_deduct_reason != " - ")
                {
                    $vend_deduct_hr = "";
                }  */
                $output .= '
                <tr>
                    <td class="vendor" '.$width2.'><small>Vendor</small></td>
                    <td class="vendor" '.$width2.'><small>$ddr_date</td ></small>
                    <td class="vendor" '.$width4.'><small>$vend_aol - $vend_ll</td ></small>
                    <td class="vendor" '.$width4.'><small>$vend_name</a></td ></small>
                    <td class="vendor" '.$width4.'><small>$vend_service</td ></small>
                    <td class="vendor" '.$width10.'><small>$vend_notes</small> </td >
                    <td class="vendor" '.$width4.'><small>$vend_adjust_hrs $vend_adj_hr $vend_adjust_cost</td ></small>
                    <td class="vendor" '.$width4.'><small>$vend_est_travel $vend_travel_hr $vend_total_hours</td ></small>
                    <td class="vendor" '.$width4.'>
                        <a href="#editEmployeeModal" class="edit" data-toggle="modal"><img src='.$image_dir.'/edit.svg border=0 data-toggle="tooltip" title="Edit"></a>
                        <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><img src='.$image_dir.'/trash-2.svg border=0 data-toggle="tooltip" title="Delete"></a>
                    </td>
                </tr>;';
            break;
            default:
                $ddr_date = ($datarow['date'] != '') ? $datarow['date'] : " - ";
                $time_start = ($datarow['time_start'] != '') ? $datarow['time_start'] : " - ";
                $time_end = ($datarow['time_end'] != '') ? $datarow['time_end'] : " - ";
                $eng_contact = ($datarow['eng_contact'] != '') ? $datarow['eng_contact'] : " - ";
                $eng_contact_info = ($datarow['eng_contact_info'] != '') ? $datarow['eng_contact_info'] : " - ";
                $eng_daily_report = ($datarow['eng_daily_report'] != '') ? $datarow['eng_daily_report'] : " - ";
                $eng_edc = ($datarow['eng_edc'] != '') ? $datarow['eng_edc'] : " - ";
                $eng_ecc = ($datarow['eng_ecc'] != '') ? $datarow['eng_ecc'] : " - ";
                $output .= '
                <tr>
                    <td class="field" '.$width2.'><small>Field</small></td>
                    <td class="field" '.$width2.'><small>$ddr_date</small></td >
                    <td class="field" '.$width4.'><small>$time_start - $time_end</small></td >
                    <td class="field" '.$width4.'><small>$eng_contact</small></td >
                    <td class="field" '.$width4.'><small>$eng_contact_info</small></td >
                    <td class="field" '.$width10.'><small>$eng_daily_report</small></td >
                    <td class="field" '.$width4.'><small>$eng_edc</small></td >
                    <td class="field" '.$width4.'><small>$eng_ecc</small></td >
                    <td class="field" '.$width4.'>
                        <a href="#editEmployeeModal" class="edit" data-toggle="modal"><img src='.$image_dir.'/edit.svg border=0 data-toggle="tooltip" title="Edit"></a>
                        <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><img src='.$image_dir.'/trash-2.svg border=0 data-toggle="tooltip" title="Delete"></a>
                    </td>
                </tr>;';
            break;
        }
        $i++; 
    }
        
    $output .= '</tbody>  
        </table>  
    </div>  
    ';  
    echo $output;  
}  }
?>
