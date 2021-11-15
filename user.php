<?php
    //Connects to the specified database and verifies user info, and sets the appropriate flags whether a username, password, or both are invalid
    function login(&$database, &$flagErrors, &$userInputtedName, &$userInputtedPass, &$usertype)
    {
        $query = $database->prepare("SELECT pass, user.type FROM user WHERE name = ?;"); //$conn is the global variabel for the connection to the database scry
        $query->bind_param("s", $userInputtedName); //$query will take $username as variable for the aove '?' with the type of $username as String specified by the "s"
        $query->execute();
        $query->bind_result($storedPass, $usertype); //Will create a new local variable $pass and store the value from database in that variable

        if ($query->fetch())
        {
            if (password_verify($userInputtedPass, $storedPass)) //Checks that the password inputted by the user and stored in the database are the same
            {
                $query->close();
                pushUserCookie($userInputtedName);
                return true; //Deallocates handle so following queries can be executed
            }
            else
            {
                $flagErrors .= "Invalid Password"; //invalid password
                $query->close();
                return false;
            }
        }
        else
        {
            $flagErrors .= "Invalid Username"; //invalid user name
            $query->close();
            return false;
        }
    }

    function signup(&$database, &$flagErrors, &$userInputtedName, &$userInputtedPass)
    {
        if ($userInputtedName == "" || $userInputtedName == "")
        {
            $flagErrors .= "Username or password cannot be empty";
            return false;
        }
        $query = $database->prepare("INSERT INTO user VALUES (?, ?, 'user');");
        $hashedPassword = password_hash($userInputtedPass, PASSWORD_DEFAULT);
        $query->bind_param("ss", $userInputtedName, $hashedPassword);
        $query->execute();

        if ($query->error == "")
        {
            $query->close();//deallocates handle so further queries can be executed
            pushUserCookie($userInputtedName);
            return true;
        }
        else
        {
            $flagErrors .= "Username already exists";
            $query->close();
            return false;
        }
    }

    //Saves a cookie of the user's encryptes username so user security is maintained
    function pushUserCookie($userName)
    {
        setcookie("user", password_hash($userName, PASSWORD_DEFAULT), time() + (86400 * 3), "/"); // 86400 = 1 day
    }

?>