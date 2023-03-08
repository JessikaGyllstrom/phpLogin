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
                //when form is submitted
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (!empty($_POST['password']) && (!empty($_POST['username']))) {
                        $password = $_POST['password'];
                        $username = $_POST['username'];
                        //set variable to true
                        $validInput = true;
                    } else {
                        echo "Please provide username and password";
                    }
                    //fetch the file into a string
                    $file = file_get_contents('testfile.txt');
                    //if user clicked on saveuser button
                    if (isset($_POST['saveuser'])) {
                        //check if username already exists
                        if (strpos($file, $username)) {
                            echo "Username already taken!";
                            echo "<br>";
                            echo "Please choose another";
                        } //if user doesnt already exist
                        else {
                            //call function to add user with parameters username and password
                            addUser($username, $password);
                        }
                    }
                    //login
                    //if user clicks login and values are provided in fields for username and password
                    if (isset($_POST['login']) & (!empty($_POST['username'])) & (!empty($_POST['password']))) {
                        //check if username already exists
                        if (strpos($file, $username)) {
                            //check if password matches
                            $lines = file('testfile.txt');
                            // loop through array
                            foreach ($lines as $line_num => $line) {
                                //split every string seperated by :
                                $str = (explode(":", $line));
                                //check if the hashed passwordstring matches given password
                                $isCorrectPassword = password_verify($password, $str[1]);
                                //if valid password
                                if ($isCorrectPassword) {
                                    if ($str[0] == $username) {
                                    }
                                    //if password or username isnt a match
                                    else {
                                        echo "Wrong username or password";
                                        echo "<br>";
                                        echo "Please try again";
                                    }
                                }
                            }
                        }
                    }
                }
            function addUser($username, $password) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $file = fopen("testfile.txt", "append") or
                die("File does not exist or you lack permission to open it");
                fputs($file, "\n$username:$hash:");
                echo "Success! New user created!";
            }
            ?>
        </div>
    </body>
</html>