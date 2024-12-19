

<?php

require_once "database.php";
    session_start();

    if (isset($_POST['unreserve_book'])) {

    // Get the ISBN from the POST request
    $isbn = $_POST['unreserve_book'];

    // SQL to update the "Reserved" status in the Books table from Y to N
    $ReservedStatus = "UPDATE books SET Reserved = 'N' WHERE ISBN = '$isbn';";

    // SQL to delete the reservation in Reservations table
    $RemoveFromReserve =  "DELETE FROM Reservations WHERE ISBN = '$isbn';";

    // Execute the query
    if ($conn->query($ReservedStatus) === TRUE && $conn->query($RemoveFromReserve) === TRUE  ) {
        // If the removal of reservation is successful
        header("Location: view.php?page=". $_SESSION['page']); // Redirect back to current page
        exit(); // stop execution of this script

    } else {
        // If there was an error executing the query, show an error message
        echo "Error unreserving the book: " . $conn->error;
    }
}

?>