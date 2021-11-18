<?php

    if ($_POST["username"] && $_POST["appjson"])
    {
        $user = $_POST["username"];
        if (!isset($_COOKIE["user"]) || !password_verify($user, $_COOKIE["user"]))
        {
            echo "error";
        }
        else
        {
            //Establish Connection
            $conn = new mysqli("localhost:3306", "php", "testpassword", "scry");
            //Check Connection and stop if invalid
            if ($conn->connect_error) 
            {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = $conn->prepare("INSERT INTO app_request VALUES (?, ?, ?, NULL);");
            if ($query == false)
            {
                die($conn->error);
            }
            $json = $_POST["appjson"];
            $hashedJson = md5($json);
            
            $query->bind_param("sss", $user, $hashedJson, $json);
            $query->execute();

            if ($query->error == "")
            {
                echo "";
            }
            else
            {
                echo "error";
            }

            $query->close();
            $conn->close();
        }
    }
    else
    {
        echo "error";
    }

?>