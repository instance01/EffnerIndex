<?php


include 'config.php';

$mysqli = connect();

$subject = $_POST['subject'];
$id = $_POST['id'];

$result = $mysqli->query("SELECT * FROM subjposts WHERE subject = '".$subject."' AND id='".$id."'");
$row = $result->fetch_assoc();
echo($row['description']);


?>