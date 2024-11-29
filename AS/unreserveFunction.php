

<?php

require_once "database.php";
    session_start();

    if (isset($_POST['unreserve_book'])) {

    // Get the ISBN from the POST request
    $isbn = $_POST['unreserve_book'];

    // Prepare the SQL query to update the "Reserved" status in the Books table
    $ReservedStatus = "UPDATE books SET Reserved = 'N' WHERE ISBN = '$isbn';";

    $RemoveFromReserve =  "DELETE FROM Reservations WHERE ISBN = '$isbn';";

    // Page
    if($_SESSION['page'] > 1){
        //if page only has one left before I unreserve then go previous page after unreserve
        if($total_rows - $offset <= 1){
            $_SESSION['page']--;
        }
    }

    // Execute the query
    if ($conn->query($ReservedStatus) === TRUE && $conn->query($RemoveFromReserve) === TRUE  ) {
        // If the removal of reservation is successful, show a confirmation message
        header("Location: view.php?page=". $_SESSION['page']); // Redirect
        exit(); // stop execution of this script

    } else {
        // If there was an error executing the query, show an error message
        echo "Error unreserving the book: " . $conn->error;
    }
}


?>