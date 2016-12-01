<?php

require_once 'DB.php';

$dbConnect = DB::getInstance()->mysqliConnect();
$sql = "select id,name,sort from kant_category";
$results = [];
$result = $dbConnect->query($sql);
var_dump($result);
while ($row = $result->fetch_assoc()) {
    $results = $row;
}
var_dump($results);
var_dump($result->fetch_object());