<?php
//Config
$dbhost = 'localhost';
$dbname = 'outboard';

$m = new Mongo("mongodb =>//$dbhost");
$db = $m->$dbname;

// select the collection
$outboard = $db->outboard;
$document = array(
  "userid" => "mlozier",
  "back" => $date,
  "remarks" => "",
  "name" => "Matt L",
  "last_change" => "mlozier,192.168.1.111",
  "timestamp" => $date
);

$collection->insert($document);
