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
        showComments($conn, $_POST["appname"], $_POST["username"]);
    }
    else if ($_POST["action"] == "make" && $_POST["appname"] && $_POST["comment"] && $_POST["username"])
    {
        makeComment($conn, $_POST["username"], $_POST["appname"], $_POST["comment"]);
    }
    else if ($_POST["action"] == "edit" && $_POST["appname"] && $_POST["comment"] && $_POST["username"] && $_POST["commentid"])
    {
        editComment($conn, $_POST["username"], $_POST["appname"], $_POST["comment"], $_POST["commentid"]);
    }
    else if ($_POST["action"] == "delete" && $_POST["appname"] && $_POST["username"] && $_POST["commentid"])
    {
        deleteComment($conn, $_POST["username"], $_POST["appname"], $_POST["commentid"]);
    }

    /**
    * This is a test php doc
    * Just work damn you
    */
    function showComments(&$database, &$selectedApp, &$username)
    {
        $query = $database->prepare("SELECT id, username, content FROM comment WHERE appname = ?;");
        if ($query == false)
        {
            echo "error";
            return false;
        }
        $query->bind_param("s", $selectedApp);
        $query->execute();
        $query->bind_result($id, $user, $text);

        while ($query->fetch())
        {
            $contenteditable = "";
            if ($user == $username)
            {
                $contenteditable = "contenteditable";
            }
            echo "<tr><td>".$user.": </td>
            <td class='commentvalue' onblur='toggleDelete(this.parentElement);' onfocus='toggleDelete(this.parentElement);' onkeyup='presentExistingSave(this);'".$contenteditable."> ".$text."</td>
            <td class='noshow'><i commentid='".$id."' onclick='editComment(this.parentElement.parentElement)' class='fa fa-save' style='position:absolute; right: -14px; top: 5px;'></i>
            <i commentid='".$id."'class='fas fa-trash' onclick='deleteComment(this.parentElement.parentElement)' style='position:absolute; right: 4px; top: 5px;'></i></td></tr>";
        }

        $query->close();
    }

    function makeComment(&$database, &$user, &$selectedApp, &$comment)
    {
        if (!isset($_COOKIE["user"]) || !password_verify($user, $_COOKIE["user"]))
        {
            echo "error";
            return false;
        }

        $comment = str_replace("'", "&apos;", $comment);
        $comment = str_replace("\"", "&quot;", $comment);
        $query = $database->prepare("INSERT INTO comment VALUES (null, ?, ?, ?);");
        if ($query == false)
        {
            echo "error";
            return false;
        }
        $query->bind_param("sss", $user, $selectedApp, $comment);
        $query->execute();

        if ($query->error == "")
        {
            $query->close();
            $commentID = $database->insert_id;
            echo $commentID;
            return true;
        }
        else
        {
            echo "error";
            $query->close();
            return false;
        }
    }

    function editComment(&$database, &$user, &$selectedApp, &$comment, &$commentID)
    {
        if (!isset($_COOKIE["user"]) || !password_verify($user, $_COOKIE["user"]))
        {
            echo "error";
            return false;
        }
        //Ensure that commentID is infact a number
        if (!(is_numeric($commentID) && intval($commentID)))
        {
            echo "error";
            return false;
        }

        $comment = str_replace("'", "&apos;", $comment);
        $comment = str_replace("\"", "&quot;", $comment);
        $ID = (int)$commentID;
        $query = $database->prepare("UPDATE comment SET content = ? WHERE id = ? and username = ? and appname = ?;");
        if ($query == false)
        {
            echo "error";
            return false;
        }
        $query->bind_param("siss", $comment, $ID, $user, $selectedApp);
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

    function deleteComment(&$database, &$user, &$selectedApp, &$commentID)
    {
        if (!isset($_COOKIE["user"]) || !password_verify($user, $_COOKIE["user"]))
        {
            echo "error";
            return false;
        }
        //Ensure that commentID is infact a number
        if (!(is_numeric($commentID) && intval($commentID)))
        {
            echo "error";
            return false;
        }

        $ID = (int)$commentID;
        $query = $database->prepare("DELETE FROM comment WHERE id = ? and username = ? and appname = ?;");
        if ($query == false)
        {
            echo "error";
            return false;
        }
        $query->bind_param("iss", $ID, $user, $selectedApp);
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