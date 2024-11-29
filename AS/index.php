<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Susie's Library</title>
    <link rel="stylesheet" href="style.css"> 
</head>

<body>
    <!-- Header and Nav bar -->
    <?php
        include 'header.php';
    ?>

    <div class="content">

        <h2>All Books</h2>

        <?php
        require_once "database.php";

        // Have to be signed in to use system
        if (!isset($_SESSION['user_id'])) {
            echo "<p>Please <a href='login.php'>login</a> to view books.</p>";
        } else {

            // Pagination Variables
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
            $rows = 5;
            $offset = ($page - 1) * $rows; // How may lines are gonna be skipped on "next" page
            $count_sql = "SELECT COUNT(*) as total FROM books";
            $count_result = $conn->query($count_sql);
            $row = $count_result->fetch_assoc();
            $total_rows = $row['total'];
            $total_pages = ceil($total_rows/$rows);


            $sql = "SELECT * FROM books LIMIT $rows OFFSET $offset";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    // Fetch the category description using the category ID
                    $cat = $row["Category"];
                    $sql2 = "SELECT CategoryDescription FROM Categories WHERE CategoryID = '$cat'";
                    $result2 = $conn->query($sql2);
                    $row2 = $result2->fetch_assoc();

                    // Display the book info with css class box
                    echo '<div class="book-box">';
                    echo '<h3>' . $row["BookTitle"] . '</h3>';
                    echo '<p><strong>ISBN:</strong> ' . $row["ISBN"] . '</p>';
                    echo '<p><strong>Author:</strong> ' . $row["Author"] . '</p>';
                    echo '<p><strong>Edition:</strong> ' . $row["Edition"] . '</p>';
                    echo '<p><strong>Year Published:</strong> ' . $row["YearPublished"] . '</p>';
                    echo '<p><strong>Category:</strong> ' . $row2["CategoryDescription"] . '</p>';
                    echo '</div>';
                }
            } else {
                // No books selected
                echo "<div class='book-box'>
                    <p> 0 results </p> 
                    </div>";
            }

            // Pagination links
            echo "<div class='pagination' >";
            for ($i = 1; $i <= $total_pages; $i++) {
                // Highlight the current page
                if ($i == $page) {
                    echo "<strong>$i</strong> ";
                } else {
                    echo "<a href='index.php?page=$i'>$i</a> ";
                }
            }
            echo "</div>";

            $conn->close();

        }// End else that shows all content of page if user is signed in
        
        ?>

    <!--End content div-->
    </div>

    <!-- Footer -->
    <?php
        include 'footer.php';
    ?>

</body>
</html>
