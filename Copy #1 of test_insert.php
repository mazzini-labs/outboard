<?php
$servername = "localhost";
$username = "root";
$password = "devonian";
$dbname = "outboard";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$title = $_GET['title'];
$s = $_GET['start'];
$e = $_GET['end'];
$sst = $_GET['sst'];
$est = $_GET['est'];

$start = $s . " " . $sst;
$end = $e . " " . $est;

$sql = "INSERT INTO events (title, start_event, end_event)
VALUES ('$title', '$start', '$end')";

echo $sql;

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>