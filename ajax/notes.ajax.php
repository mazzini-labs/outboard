<?php

// //load.php  
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// $connect = new PDO('mysql:host=localhost;dbname=wells', 'root', 'devonian');

// $data = array();
// $query = "SELECT * FROM list ORDER BY api asc";
// //$query = "SELECT * FROM events ORDER BY id";
// $statement = $connect->prepare($query);
// $statement->execute();
// $result = $statement->fetchAll();
// //$result = mysql_query($query) or die(mysql_error());
// foreach($result as $row)
// {
//  $data[] = array(
//   'id'   => $row["id"],
//   'title'   => $row["title"],
//   'start'   => $row["start_time"],
//   'end'   => $row["end_time"],
//   'allDay'   => $row["all_day"],
//   'color'   => "#".$row["color"],
//   'description' => $row["remarks"]
//  );
// }
// /*foreach($result as $row)
// {
//  $data[] = array(
//   'id'   => $row["id"],
//   'title'   => $row["title"],
//   'start'   => $row["start_event"],
//   'end'   => $row["end_event"]
//  );
// }*/

// echo json_encode($data);

?>
<?php
namespace Phppot;

use Phppot\Model\FAQ;
require_once ("../Model/FAQ.php");
$faq = new FAQ();
$faqResult = $faq->getFAQ();
$k = 1;
while ($row = $faqResult->fetch_assoc()) {
        $data[] = array(
            'api'    => $row["api"],
            'list_id'   => "" . $row["list_id"],
            'entity_common_name'   => "" . $row["entity_common_name"],
            'state'   => "" . $row["state"],
            'county_parish'   => "" . $row["county_parish"],
            'block'   => "" . $row["block"],
            'entity_operator_code'   => "" . $row["entity_operator_code"],
            'producing_status' => "" . $row["producing_status"],
            'production_type' => "" . $row["production_type"],
            'last_prod_date' => "" . $row["last_prod_date"],
            'pumper' => "" . $row["pumper"],
            'notes' => "" . $row["notes"],
            'si_notes' => "" . $row["si_notes"]
        );
        $k++;
   
}
// foreach ($faqResult as $k => $v) {
//         $data[] = array(
//             'k'    => $k,
//             'list_id'   => $faqResult[$k]["list_id"],
//             'entity_common_name'   => $faqResult[$k]["entity_common_name"],
//             'state'   => $faqResult[$k]["state"],
//             'county_parish'   => $faqResult[$k]["county_parish"],
//             'block'   => $faqResult[$k]["block"],
//             'entity_operator_code'   => $faqResult[$k]["entity_operator_code"],
//             'producing_status' => $faqResult[$k]["producing_status"],
//             'production_type' => $faqResult[$k]["production_type"],
//             'last_prod_date' => $faqResult[$k]["last_prod_date"],
//             'pumper' => $faqResult[$k]["pumper"],
//             'notes' => $faqResult[$k]["notes"],
//             'si_notes' => $faqResult[$k]["si_notes"]
//         );
        
//     }
echo json_encode($data);
// echo $faqResult;

?>