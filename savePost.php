<?php

include 'config.php';

$mysqli = connect();

$subject = mysqli_real_escape_string($mysqli, $_POST['subject']);
$title = mysqli_real_escape_string($mysqli, $_POST['title']);
$description = mysqli_real_escape_string($mysqli, $_POST['description']);
$pw = mysqli_real_escape_string($mysqli, $_POST['pw']);

$result_ = $mysqli->query("SELECT pw FROM password WHERE id = 0");
$row = $result_->fetch_assoc();
$real_pw = $row['pw'];

if($pw != $real_pw){
	echo("Password missing");
	return;
}

$result = $mysqli->query("INSERT INTO subjposts VALUES (0, '".$subject."', '".$title."', '".$description."', '".date("Y-m-d H:i:s")."')");
echo($result);

?>