<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Book</title>
    <link rel="stylesheet" href="style.css?">
</head>
<body>
    <!-- Header and Nav bar-->
    <?php
        include 'header.php';
    ?>

    <div class="content">

        <h2>Search for a Book</h2>

        <?php
        require_once "database.php";
        if (!isset($_SESSION)) {
            // Restart session
            session_start();
        }

        //Need To be signed in
        if (!isset($_SESSION['user_id'])) {
            echo "<p>Please <a href='login.php'>login</a> to search for books.</p>";
        } else {
        ?>

        <!-- Book Search Form -->
        <form method="post">
            <div class="form-group">
                <label for="BookTitle">Book Title:</label>
                <input type="text" id="BookTitle" name="BookTitle">
            </div>
            <div class="form-group">
                <label for="Author">Author:</label>
                <input type="text" id="Author" name="Author">
            </div>
            <div class="form-group">
                <label for="categories">Category:</label>
                <select id="categories" name="Category">
                    <option value="">-- Please Select --</option>
                    <option value="001">Health</option>
                    <option value="002">Business</option>
                    <option value="003">Biography</option>
                    <option value="004">Technology</option>
                    <option value="005">Travel</option>
                    <option value="006">Self-Help</option>
                    <option value="007">Cookery</option>
                    <option value="008">Fiction</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" name="Add_New" value="Search">
            </div>
        </form>

        <!--  -->
        <?php

        if (!isset($_SESSION)) {
            // Restart session
            session_start();
        }

        // Display success or error message if it exists in session
        if (isset($_SESSION['message'])) {
            // Display and clear message
            echo "<div class='message'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);

        }

        // Set page variable for pagination
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $_SESSION['page'] = $page;

        if (isset($_POST['Add_New'])) {
            $u = $_POST['BookTitle'];
            $p = $_POST['Author'];
            $f = $_POST['Category'];

            $_SESSION['BookTitle'] = $_POST['BookTitle'];
            $_SESSION['Author'] = $_POST['Author'];
            $_SESSION['Category'] = $_POST['Category'];

            // Reset page to 1 when a new search is performed
            $page = 1;
            $_SESSION['page'] = $page;
            
        } else {
            // Get search values from session or set to empty
            $u = isset($_SESSION['BookTitle']) ? $_SESSION['BookTitle'] : '';
            $p = isset($_SESSION['Author']) ? $_SESSION['Author'] : '';
            $f = isset($_SESSION['Category']) ? $_SESSION['Category'] : '';
        }

        // Validation so user can't search with "" ie not enter anything
        if(empty($u) && empty($p) && empty($f)) {
            echo "<p>Please fill at least one field to search. </p>";
        } else {

            // Pagination Variables
            $rows = 3;
            $offset = ($page - 1) * $rows; // How may lines are gonna be skipped on "next" page
            $count_sql = "SELECT COUNT(*) as total FROM books
                    WHERE ('$u' = '' OR lower(BookTitle) LIKE lower('%$u%')) 
                    AND ('$p' = '' OR lower(Author) LIKE lower('%$p%')) 
                    AND ('$f' = '' OR lower(Category) LIKE lower('%$f%'))";

            $count_result = $conn->query($count_sql);
            $row = $count_result->fetch_assoc();
            $total_rows = $row['total'];
            $total_pages = ceil($total_rows/$rows);

            // Select to search for values, partial search valid too
            $sql = "SELECT books.*, categories.CategoryDescription AS CategoryName 
                    FROM books
                    LEFT JOIN categories ON books.category = categories.CategoryID
                    WHERE ('$u' = '' OR lower(BookTitle) LIKE lower('%$u%')) 
                    AND ('$p' = '' OR lower(Author) LIKE lower('%$p%')) 
                    AND ('$f' = '' OR lower(Category) LIKE lower('%$f%'))
                    LIMIT $rows OFFSET $offset";

            $result = $conn->query($sql);

            // Display book info back, using same div class as in index for 
            // consistent appearance
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='book-box'>";
                    echo '<h3 class="book-title">' . $row["BookTitle"] . '</h3>';
                    echo "<p><strong>ISBN:</strong> " . $row["ISBN"] . "</p>";
                    echo "<p><strong>Author:</strong> " . $row["Author"] . "</p>";
                    echo "<p><strong>Edition:</strong> " . $row["Edition"] . "</p>";
                    echo "<p><strong>Year Published:</strong> " . $row["YearPublished"] . "</p>";
                    echo "<p><strong>Category:</strong> " . $row["CategoryName"] . "</p>";
                    echo "<p><strong>Reserved:</strong> " . ($row["Reserved"] == "Y" ? "Yes" : "No") . "</p>";

                    if ($row["Reserved"] == "N") {
                        echo "<form action='reserveFunction.php' method='POST' style='display:inline;'>";
                        echo "<button type='submit' name='reserve_book' value='" . $row["ISBN"] . "'>Reserve Book</button>";
                        echo "</form><br><br>";
                    } else {
                        echo "<button style='display:inline;'>Reserved</button><br><br>";
                    }
                    echo "</div>";

                }

            }

            // Pagination links
            echo "<div class='pagination' >";
            for ($i = 1; $i <= $total_pages; $i++) {
                // Highlight the current page
                if ($i == $page) {
                    echo "<strong>$i</strong> ";
                } else {
                    echo "<a href='reserve.php?page=$i'>$i</a>";
                }
            }
            echo "</div>";

        }

    }

    $conn->close();


        ?>
    </div>

    <!-- Footer -->
    <?php
        include 'footer.php';
    ?>

</body>
</html>
