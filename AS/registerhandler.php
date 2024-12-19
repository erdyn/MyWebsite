
<?php
// Start the session
session_start(); 

// Connect to database
require_once "database.php";

// Check if POST method used to access page
if ($_SERVER['REQUEST_METHOD'] == "POST") 
{
	// Get POST data and place into variables
	$u = $_POST['Username'];
	$p = $_POST['Password'];
	$cc = $_POST['ConfirmPassword'];
	$f = $_POST['FirstName'];
	$l = $_POST['Surname'];
	$ad1 = $_POST['AddressLine1'];
	$ad2 = $_POST['AddressLine2'];
	$c = $_POST['City'];
	$t = $_POST['Telephone'];
	$m = $_POST['Mobile'];


	// Data validation of registered account details:
	
	// Check if user filled in all the data
	if (empty($u) || empty($p) || empty($cc) || empty($f) || empty($l) || empty($ad1) || empty($ad2) || empty($c) || empty($t) || empty($m))
	{
		$_SESSION['message'] = "Registration Failed: Form not Complete";
			
		// Redirect to register
		header("Location: ../AS/register.php");
		exit(); // Stop further script execution
	}
	
	// PasswordConfirmation Function
	function PasswordConfirmation($password, $confirmPassword) {
		// Check if password is the same as confirm Password
		if ($password !== $confirmPassword)
		{
			$_SESSION['message'] = "Registration Failed: Passwords do not match";
				
			header("Location: ../AS/register.php");
			exit(); // Stop further execution
		}
		
		// Validate that both entered passwords are of length 6 or more (both are confirmed to be the same)
		if(strlen($password) != 6)
		{
			$_SESSION['message'] = "Registration Failed: Password must be 6 characters long";
				
			header("Location: ../AS/register.php");
			exit(); // Stop further execution
		}
	} // End PasswordConfirmation function

	// Call PasswordConfirmation Function
	PasswordConfirmation($p, $cc);

	// Validate that numbers is numeric and at least 10 characters
	if(!is_numeric($t) || !is_numeric($m))
	{
		$_SESSION['message'] = "Registration Failed: Telephone and mobile must be numeric";
			
		header("Location: ../AS/register.php");
		exit(); // Stop further script execution
	}

	if(strlen($t) != 10 || strlen($m) != 10)
	{
		$_SESSION['message'] = "Registration Failed: Telephone and mobile must be 10 characters long";
			
		header("Location: ../AS/register.php");
		exit(); // Stop further script execution
	}

	// Check if user already exists
	$check_sql = "SELECT * FROM users WHERE Username = '$u'";
	$result = $conn->query($check_sql);

	// Username duplicate
	if ($result->num_rows > 0) 
	{
		// If username exists, set the message and redirect to avoid resubmission
		$_SESSION['message'] = "Registration Failed: Username '" . $u . "'" . " already exists. Please enter a different username";
		
		// Redirect after unsuccessful insertion
		header("Location: ../AS/register.php");
		exit();
	} 
	

	// Registration requirements met
	// If username does not exist, proceed to insert
	else 
	{
		// Insert statement
		$sql = "INSERT INTO users (Username, Passkey, FirstName, Surname, AddressLine1, AddressLine2, City, Telephone, Mobile) VALUES ('$u', '$p', '$f', '$l', '$ad1', '$ad2','$c','$t','$m')";

		// Insert successful
		if ($conn->query($sql) === TRUE) 
		{
			//$_SESSION['message'] = "Successfully Registered User: " . $u;
			
			// Set user_id session variable for later validation
			$_SESSION['user_id'] = $u;
			
			// Redirect after successful insertion
			header("Location: ../AS/index.php");
			exit(); // Stop further script execution
			
		} 
		
		// Error with insert
		else 
		{
			$_SESSION['message'] = "<br><br> Error: " . $sql . "<br>" . $conn->error;
		}
	}
}

else
{
	$_SESSION['message'] = "Page access Denied.";
	
	// Redirect to register page after setting message
	header("Location: ../AS/register.php");
	exit(); // Stop further script execution
}

// Close connection
$conn->close();
?>
