<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reservations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header and Nav bar-->
    <?php
        include 'header.php';
    ?>

    <div class="content">
        <h2>Your Reservations</h2>

        <?php
        require_once "database.php";

        // Have to be signed in
        if (!isset($_SESSION['user_id'])) {
            echo "<p>Please <a href='login.php'>login</a> to view your reservations.</p>";
        } else {
            // We get this value from login/register completion
            $username = $_SESSION['user_id'];

            // Pagination Variables
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
            $_SESSION['page'] = $page;

            $rows = 3;
            $offset = ($page - 1) * $rows; // How may lines are gonna be skipped on "next" page
            $count_sql = "SELECT COUNT(*) as total FROM reservations WHERE Username = '$username'";
            $count_result = $conn->query($count_sql);
            $row = $count_result->fetch_assoc();
            $total_rows = $row['total'];
            $total_pages = ceil($total_rows/$rows);

            // Query to fetch the user's reserved books
            $sql = "SELECT * FROM reservations WHERE Username = '$username' LIMIT $rows OFFSET $offset";
            $result = $conn->query($sql);

            // Check if there are any reserved books
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    // Get the book title based on ISBN
                    $isbn = $row["ISBN"];
                    $sql2 = "SELECT BookTitle, Author, Edition, YearPublished, Category FROM books WHERE ISBN = '$isbn'";
                    $result2 = $conn->query($sql2);
                    $row2 = $result2->fetch_assoc();

                    // Get the category description based off Category (ID)
                    $cat = $row2["Category"];
                    $sql3 = "SELECT CategoryDescription FROM Categories WHERE CategoryID = '$cat'";
                    $result3 = $conn->query($sql3);
                    $row3 = $result3->fetch_assoc();

                    echo "<div class='book-box'>";
                    echo '<h3 class="book-title">' . $row2["BookTitle"] . '</h3>';
                    echo "<p><strong>ISBN:</strong> " . $row["ISBN"] . "</p>";
                    echo "<p><strong>Author:</strong> " . $row2["Author"] . "</p>";
                    echo "<p><strong>Edition:</strong> " . $row2["Edition"] . "</p>";
                    echo "<p><strong>Year Published:</strong> " . $row2["YearPublished"] . "</p>";
                    echo "<p><strong>Category:</strong> " . $row3["CategoryDescription"] . "</p>";
                    echo "<p><strong>Date Reserved:</strong> " . $row["ReservedDate"] . "</p>";
                    
                    // Button to unreserve
                    echo "<form action='unreserveFunction.php' method='POST' style='display:inline;'>";
                    echo "<button type='submit' name='unreserve_book' value='" . $row["ISBN"] . "'>Unreserve this book</button>";
                    echo "</form><br><br>";
                    echo "</div>"; // Close book box
                }
            } else {
                echo "<p>No reservations on this page.</p>";
            }

            // Pagination links
            echo "<div class='pagination' >";
            for ($i = 1; $i <= $total_pages; $i++) {
                // Highlight the current page
                if ($i == $page) {
                    echo "<strong>$i</strong> ";
                } else {
                    echo "<a href='view.php?page=$i'>$i</a>";
                }
            }

        }// End all content that shows when logged in
        echo "</div>";

        $conn->close();
        ?>
    </div>

    <!-- Footer -->
    <?php
        include 'footer.php';
    ?>

</body>
</html>
