<?php
include_once('../Model/AllBlogs.php');

$AllBlogs = new AllBlogs();

$response = stripslashes(file_get_contents("../../HTML/Overview.html"));
echo $response;

$blogs = $AllBlogs->readShortOverview($_SESSION['UserId']);
$blogsHTML = "";

for($i = 0; $i < count($blogs); $i++) {
	$blogsHTML .= "<div>" .
	"<h2>" . $blogs[$i][0] . "</h2>" .
	"<p>" . $blogs[$i][1] . "</p>" .
	"</div>";
}

echo $blogsHTML;