<?php
    //Connects to the specified database and verifies user info, and sets the appropriate flags whether a username, password, or both are invalid
    function login(&$database, &$flagErrors, &$userInputtedName, &$userInputtedPass)
    {
        $query = $database->prepare("SELECT pass FROM user WHERE name = ?;"); //$conn is the global variabel for the connection to the database scry
        $query->bind_param("s", $userInputtedName); //$query will take $username as variable for the aove '?' with the type of $username as String specified by the "s"
        $query->execute();
        $query->bind_result($storedPass); //Will create a new local variable $pass and store the value from database in that variable

        if ($query->fetch())
        {
            if (password_verify($userInputtedPass, $storedPass)) //Checks that the password inputted by the user and stored in the database are the same
            {
                echo $userInputtedName;
            }
            else
            {
                $flagErrors .= "Invalid Password"; //invalid password
            }
        }
        else
        {
            $flagErrors .= "Invalid Username"; //invalid user name
        }

        $query->close();//Deallocates handle so following queries can be executed
    }

    function signup(&$database, &$flagErrors, &$userInputtedName, &$userInputtedPass)
    {
        $query = $database->prepare("INSERT INTO user VALUES (?, ?, 'user');");
        $hashedPassword = password_hash($userInputtedPass, PASSWORD_DEFAULT);
        $query->bind_param("ss", $userInputtedName, $hashedPassword);
        $query->execute();

        if ($query->error == "")
        {
            echo $userInputtedName;
        }
        else
        {
            $flagErrors .= "Username already exists";
        }

        $query->close();
    }

    //If there are any errors, then css should display
    function displayIfError(&$flagErrors)
    {
        echo ($flagErrors != "") ? "display:block;": "";
    }

?>