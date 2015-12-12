<?php 
include_once('Database.php');

class AllBlogs {
	var $db;
	
	function __construct() {
		$db = new Database();
	}
	
	function readShortOverview($userId = 0) {
		$db = new Database();
		return $db->readTitleDate($userId);
	}
}