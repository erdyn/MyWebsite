<?php

session_start();

require_once "database.php";

    if (isset($_POST['reserve_book'])) {

    // Get the ISBN from the POST request
    $isbn = $_POST['reserve_book'];
    $username = $_SESSION['user_id'];

    // SQL to update the "Reserved" status in the Books table from N to Y
    $ReservedStatus = "UPDATE books SET Reserved = 'Y' WHERE ISBN = '$isbn';";

    // SQL to insert reservation into Reservations table
    $addToReserve =  "INSERT INTO Reservations (Username, ISBN, ReservedDate) VALUES ('$username', '$isbn', CURDATE());";

    //SQL to find out book name form isbn
    $FindBookTitle = "SELECT BookTitle FROM books WHERE ISBN = '$isbn'";
    $result = $conn->query($FindBookTitle);

    $row = $result->fetch_assoc();
    $bookname = $row["BookTitle"];

    // Stay on current page after reserve
    $page = $_SESSION['page'];
    
    // Execute the query
    if ($conn->query($ReservedStatus) === TRUE && $conn->query($addToReserve) === TRUE  ) {
        // If the update is successful, show a confirmation message
        $_SESSION['message'] = "The book '$bookname' has been successfully reserved";
        header("Location: reserve.php?page=$page"); // Redirect
        exit(); // Make sure the script stops after redirect

    } else {
        // If there was an error executing the query, show an error message
        //echo "Error reserving the book: " . $conn->error;
    }
    
}

?>