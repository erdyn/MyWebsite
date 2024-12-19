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


    <div class = 'content' >

        <!-- Rule box -->
        <h3>-Registration Rules-</h3>
        <ul>
            <li>Password must be 6 characters long.</li>
            <li>Phone numbers must be numeric and exactly 10 digits long.</li>
        </ul>

        <!-- Register form to post all values to php section -->
        <h2> Register </h2>
        <form class= "register-form" method = "post" action = "registerhandler.php">
            <p>Username:
                <input type="text" name="Username" >
            </p>
            <p>Password:
                <input type="password" name="ConfirmPassword" >
            </p>
            <p>Confirm Password:
                <input type="password" name="Password" >
            </p>
            <p>First Name:
                <input type="text" name="FirstName" >
            </p>
            <p>Surname:
                <input type="text" name="Surname"  >
            </p>
            <p>Address Line1:
                <input type="text" name="AddressLine1"  >
            </p>
            <p>Address Line2:
                <input type="text" name="AddressLine2"  >
            </p>
            <p>City:
                <input type="text" name="City"  >
            </p>
            <p>Telephone:
                <input type="text" name="Telephone"  >
            </p>
            <p>Mobile:
                <input type="text" name="Mobile"  >
            </p>
            <p>
                <input type="submit" name="Add_New" value = "Register"/>
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
                echo "Please Fill in Form.";
            }
        ?>

        <br><br>
        <!--Login link -->
        <p>Already have an account?<strong> Log in <a href="login.php">here</strong></a>.</p>
        <br><br>
            
    <!-- End content div -->
    </div>

    <!-- Footer -->
    <?php
        include 'footer.php';
    ?>


</body>


</html>