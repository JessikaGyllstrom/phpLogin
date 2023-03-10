<!DOCTYPE html>
<!-- Logged in page -->
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/style.css">
        <title>Logged in</title>
    </head>
    <body>
    <div class="wrapper">
        <?php
        session_start();
                echo "<h1>Welcome " . $_SESSION["username"] . "<br></h1>";
                echo "<h4>You are logged in!</h4>";
        ?>
        <form method="post">
            <input name="logout" type="submit" class="submitbtn" value="logout">
        </form>
        <?php
            if(isset($_POST["logout"]))
            {
                // redirect to index.php
                header('Location: login.php');
                destroy_session_and_data();
                exit();
        }
        function destroy_session_and_data()
        {
            session_start();
            $_SESSION = array();
            setcookie(session_name(), '', time() - 2592000, '/');
            session_destroy();
        }
        ?>
    </div>

    </body>
</html>