<?php
    //Establish Connection
    $conn = new mysqli("localhost:3306", "php", "testpassword", "scry");
    //Check Connection and stop if invalid
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_POST["action"] == "show" && $_POST["appname"])
    {
        showComments($conn, $_POST["appname"]);
    }
    else if ($_POST["action"] == "make" && $_POST["appname"] && $_POST["comment"] && $_POST["username"])
    {
        makeComment($conn, $_POST["username"], $_POST["appname"], $_POST["comment"]);
    }

    function showComments($database, $selectedApp)
    {
        $query = $database->prepare("SELECT username, content FROM comment WHERE appname = ?;");
        $query->bind_param("s", $selectedApp);
        $query->execute();
        $query->bind_result($user, $text);

        while ($query->fetch())
        {
            echo "<tr><td>".$user.": </td><td> ".$text."</td></tr>";
        }

        $query->close();
    }

    function makeComment($database, $user, $selectedApp, $comment)
    {
        $comment = str_replace("'", "&apos;", $comment);
        $comment = str_replace("\"", "&quot;", $comment);
        $query = $database->prepare("INSERT INTO comment VALUES (null, ?, ?, ?);");
        $query->bind_param("sss", $user, $selectedApp, $comment);
        $query->execute();

        if ($query->error == "")
        {
            $query->close();
            return true;
        }
        else
        {
            echo "error";
            $query->close();
            return false;
        }
    }

    $conn->close();
?>