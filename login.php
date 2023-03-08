<!DOCTYPE html>
<!-- Login or register page -->
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/style.css">
        <title>Login</title>
    </head>
    <body>
    <div class="container">
        <div class="wrapper">
            <!-- form using the HTTP POST method to send the data -->
            <form method="post">
                <label for="username"></label>
                <input id="username" name='username' class="input" type="text" placeholder="Name">
                <label for="password"></label>
                <input id="password" name='password' class="input" type="text" placeholder="Password">
                <input name="login" type="submit" class="submitbtn" value="login">
                <input name="saveuser" type="submit" class="submitbtn" value="save user">
            </form>
        </div>
        <div>
            <?php
                session_start();
                $validInput = false;
                // when form is submitted
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (!empty($_POST['password']) && (!empty($_POST['username']))) {
                        echo "EEEECHO";
                        $password = $_POST['password'];
                        $username = $_POST['username'];
                        if (isset($_POST['saveuser'])) {
                            addUser($username, $password);
                        }
                        // set variable to true
                        $validInput = true;
                    } else {
                        echo "Please provide a username and password";
                    }
                    $file = file_get_contents('testfile.txt');


                    // login
                    // if user clicks login and values are provided in fields for username and password
                    if (isset($_POST['login']) & (!empty($_POST['username'])) & (!empty($_POST['password']))) {
                        //check if username already exists in file
                        if (strpos($file, $username)) {
                            echo $username;
                            echo $password;
                            echo 'user found!!';

                            //check if password matches
                            $lines = file('testfile.txt');
                            // loop through array
                            foreach ($lines as $line_num => $line) {
                                $str = (explode(":", $line));
                                if ($str[1] == $password) {
                                    echo "passssssSSeeedessss:!!!! ";
                                }
                            }
                        }
                    }
                }
            function addUser($username, $password) {
                $file = fopen("testfile.txt", "append") or
                die("File does not exist or you lack permission to open it");
                fputs($file, "\n$username:$password:");
                echo "Success! New user created!";
            }
            ?>
        </div>
    </body>
</html>