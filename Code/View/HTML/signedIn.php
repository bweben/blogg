<?php
include_once('../PHP/Model/Login.php');
session_start();

echo '<!DOCTYPE HTML>
<!-- created by Nathanael Weber-->
<html>
	<head>
		<script src="../js/jquery.js"></script>
		<link rel="stylesheet" href="../CSS/stylesheet.css">
	</head>
	<body>
		<div id="form_div">
			<h1 id="title">Sie waren erfolgreich.</h1>
			<p></p>
		</div>
	</body>
</html>';

$login = TRUE;
$email = $_POST['username'];
$password1 = $_POST['password1'];
$password2 = "";
$gender = "";
$sportTypes = "";
$location = "";
$userId = 0;
$Login = new Login();

if (isset($_POST['password2']) && isset($_POST['gender'])) {
	$login = FALSE;
	
	$password2 = $_POST['password2'];
	$gender = $_POST['gender'];
	$sportTypes = $_POST['sportTypes'];
	$location = $_POST['location'];
	
	$userId = $Login->createUser($email,$password1);
	
	echo $email."<br>".$password1."<br>".$password2."<br>".$gender."<br>".$location;
	foreach($sportTypes as $sport) {
		echo "<br>".$sport;
	};
} else {
	$userId = $Login->getUserId($email,$password1);
	echo $email."<br>".$password1;
}

$_SESSION['UserId'] = $userId;

header('Location:http://localhost/PHP/View/Overview.php');

