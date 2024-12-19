<?php
    // Header
    echo
    "<header>
        <h1>Welcome to Susie's Library</h1>";

    // If user logged in display a logout option
        session_start();
        if (isset($_SESSION['user_id'])) {
            echo '<a class="logout" href="logout.php">Log out</a>';
            echo '<p class="account"> Signed in as: '. $_SESSION['user_id']. '</p>';
        }

    echo "</header>";

    // Nav Bar
    echo
    '<nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="reserve.php">Reserve Books</a></li>
            <li><a href="view.php">View Reservations</a></li>
        </ul>
    </nav>';

?>