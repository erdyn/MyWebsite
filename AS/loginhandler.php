<?php
// Start the session
session_start(); 

// Connect to Database
require_once "database.php";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") 
{
	// Get POST data and place into variables
	$u = $_POST['Username'];
	$p = $_POST['Password'];

	// Check if user already exists
	$check_user_sql = "SELECT * FROM users WHERE Username = '$u'";
	$result = $conn->query($check_user_sql);

	// User exists, verify info
	if ($result->num_rows > 0) 
	{
		// Get password for user from DB
		$password = "SELECT passkey FROM users WHERE Username = '$u'";
		$result = $conn->query($password);
		

		// Get password from Users table
		$row = $result->fetch_assoc();
		
		// Check if entered password matches Database
		if ($row["passkey"] == $p)
		{
			// Password is correct, set success message
			//$_SESSION['message'] = "Login successful! Welcome, " . $u . ".";
			
			// Set user_id session variable for later validation
			$_SESSION['user_id'] = $u;
		
			// Redirect to index after successful login
			header("Location: ../AS/index.php");
			exit(); // Stop further script execution
		}
		
		// If passwords do not match
		else
		{
			// Password is incorrect, set error message
			$_SESSION['message'] = "Password is incorrect for User: '" . $u . "'.";
			
			// Redirect after setting message
			header("Location: ../AS/login.php");
			exit(); // Stop further script execution
		}
	}
		
	// If username does not exist, display message
	else 
	{
		// Set message 
		$_SESSION['message'] = "User: '" . $u . "' does not exist.";

		// Redirect after successful insertion
		header("Location: ../AS/login.php");
		exit(); // Stop further script execution
	}
}

else
{
	$_SESSION['message'] = "Page accessed incorrectly.";
	
	// Redirect
	header("Location: ../AS/login.php");
	exit(); // Stop further script execution
}


// Close connection
$conn->close();
?>