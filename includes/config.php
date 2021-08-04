<?php 

	// mysqli connection start here 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gam_review";

// create connection 
$conn = mysqli_connect($servername, $username, $password, $dbname );
// Check connection
if (!$conn) {
	die ("connnection failed:" . mysqli_connect_error());

}


#Security
function get_post($conn, $var){
	
	return $conn->real_escape_string($_POST[$var]);

}

function secure_post($conn, $var){
	return htmlentities(get_post($conn, $var));
}






?>