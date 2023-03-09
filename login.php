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
            <form method="POST">
                <label for="username"></label>
                <input id="username" name='username' class="input" type="text" placeholder="Name">
                <label for="password"></label>
                <input id="password" name='password' class="input" type="password" placeholder="Password">
                <input name="login" type="submit" class="submitbtn" value="login">
                <input name="register" type="submit" class="submitbtn" value="save user">
            </form>
        </div>
        <div>
            <?php
            $notValid = false;
            //when form is submitted
            if(!empty($_POST['password']) && !empty($_POST['username'])) {
                    $password = $_POST['password'];
                    $username = $_POST['username'];
                    //set variable to true
                    $validInput = true;
                    //fetch the file into a string
                    $file = file_get_contents('testfile.txt');
                    //if user clicked on register button
                    if(isset($_POST['register'])) {
                        //check if username already exists
                        if (strpos($file, $username)) {
                            echo "Username already taken!";
                            echo "<br>";
                            echo "Please choose another";
                        }//if user doesn't already exist
                        else {
                            //call on function to add user with parameters username and password
                            addUser($username, $password);
                        }
                    }

                      } else {
                    echo "Please provide username and password";
            }
            if (isset($_POST['login'])) {
                //check if password matches
                $lines = file('testfile.txt');
                //loop through array
                foreach ($lines as $line_num => $line) {
                    //split every string seperated by :
                    $str = (explode(":", $line));
                    //check if the hashed password-string matches given password
                    $isCorrectPassword = password_verify($password, $str[1]);
                    //if valid password
                    if ($isCorrectPassword) {
                        echo "correct password";
                        if($str[0] == $username){
                            echo "correct user";
                            session_start();
                            // store the username of the current session
                            $_SESSION['username'] = $username;
                            echo $username;
                            // redirect to index.php
                            header('Location: index.php');
                            exit();
                        }

                        /*
                        session_start();
                        // store the username of the current session
                        $_SESSION['username'] = $username;
                        echo $username;
                        // redirect to index.php
                        header('Location: index.php');
                        exit();
                        */
                    }
                    else {
                        $notValid = true;
                    }
                }
            }
                //if password or username isn't a match
                    if($notValid) {
                        echo "Wrong username or password";
                        echo "<br>";
                        echo "Please try again";
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