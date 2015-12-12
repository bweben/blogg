<?php 
session_start();
include_once('Database.php');

class Login {
	var $db;
	
	function __construct() {
		$db = new Database();
	}
	
	public function createUser($email = "", $password = "")
	{
		$db = new Database();
		return $db->createUser($email,$password);
	}
	
	public function getUserId($email = "", $password = "") 
	{
		$db = new Database();
		return $db->searchUser($email,$password);
	}
}