<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1.DTD/html1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang ="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Susie's Library</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Header -->
    <header>
        <h1>Welcome to Susie's Library</h1>
    </header>

    <div class = 'content'>
        <!--Log in form -->
        <h2> Log In </h2>
        <form class="register-form" method = "post" action = "loginhandler.php">
            <p>Username:
                <input type="text" name="Username">
            </p>
            <p>Password:
                <input type="password" name="Password">
            </p>
            <p>
                <input type="submit" name="Add_New" value = "Log in"/>
            </p>
        
        </form>

            
        <?php
            if (!isset($_SESSION))
            {
                // Restart session
                session_start();
                // Unset user_id to ensure not logged in to previous user's acc
                unset($_SESSION['user_id']);             
            }
            
            // Display success or error message if it exists in session
            if (isset($_SESSION['message'])) 
            {
                // Display and clear message
                echo $_SESSION['message'];
                unset($_SESSION['message']); 
            }
            else
            {
                echo "Enter login details.";
            }
        ?>

        <br><br>

        <!--Register link-->
        <p>Don't already have an account?<strong> Sign up <a href="register.php">here</strong></a>.</p>

    <!--End content div-->
    </div>

    <!-- Footer -->
    <?php
        include 'footer.php';
    ?>

</body>
</html>