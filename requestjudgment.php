<?php

    //Establish Connection
    $conn = new mysqli("localhost:3306", "php", "testpassword", "scry");
    //Check Connection and stop if invalid
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_POST["action"] == "delete" && $_POST["username"] && $_POST["origjson"])
    {
        deleteRequest($conn, $_POST["username"], $_POST["origjson"]);
    }
    else if ($_POST["action"] == "approve" && $_POST["username"] && $_POST["origjson"] && $_POST["appjson"])
    {
        approveRequest($conn, $_POST["username"], $_POST["origjson"], $_POST["appjson"]);
    }

    function verifyAdministrator(&$database, $user)
    {
        $query = $database->prepare("SELECT user.type FROM user WHERE user.name = ?;");
        $query->bind_param("s", $user);
        $query->execute();
        $query->bind_result($type);

        if ($query->fetch())
        {
            $query->close();
            return $type == "admin";
        }
        else
        {
            $query->close();
            echo "error";
            return false;
        }
    }

    function approveRequest(&$database, $user, $JSON, $newJSON)
    {
        if (!isset($_COOKIE["user"]) || !password_verify($user, $_COOKIE["user"]))
        {
            echo "error";
            return false;
        }

        if (!verifyAdministrator($database, $user))
        {
            echo "error";
            return false;
        }

        $app = json_decode($newJSON);
        $name = $app->name;
        $price = (int)($app->price);
        $desc = $app->desc;
        $imgurl = $app->imgurl;

        $dev = $app->dev;
        insertDev($database, $dev);

        insertApp($database, $name, $price, $desc, $imgurl, $dev);

        $categories = $app->categories;
        insertCategories($database, $categories);

        insertAppCategories($database, $name, $categories);

        $platformArrs = ($app->platforms)->value;
        foreach ($platformArrs as $platform)
        {
            $platformName = $platform[0];
            insertPlatform($database, $platformName);
            insertAppPlatform($database, $name, $platformName);
            $versions = $platform[1]->value;
            foreach($versions as $version)
            {
                $versionNum = $version[0];
                $url = $version[1];
                insertAppVersion($database, $name, $platformName, $versionNum, $url);
            }
        }

        deleteRequest($database, $user, $JSON);
    }

    function insertAppVersion(&$database, &$appName, &$platformName, &$versionNum, &$url)
    {
        $query = $database->prepare("INSERT IGNORE INTO appversion (appname, platformname, versionnum, url) VALUES (?, ?, ?, ?);");
        $query->bind_param("ssss", $appName, $platformName, $versionNum, $url);
        $query->execute();

        $query->close();
    }

    function insertAppPlatform(&$database, &$appName, &$platformName)
    {
        $query = $database->prepare("INSERT IGNORE INTO app_platform (appname, platformname) VALUES (?, ?);");
        $query->bind_param("ss", $appName, $platformName);
        $query->execute();

        $query->close();
    }

    function insertPlatform(&$database, &$platformName)
    {
        $query = $database->prepare("INSERT IGNORE INTO platform (name) VALUES (?);");
        $query->bind_param("s", $platformName);
        $query->execute();

        $query->close();
    }

    function insertAppCategories(&$database, &$name, &$categories)
    {
        $query = $database->prepare("INSERT IGNORE INTO appcategory (appname, categoryname) VALUES (?, ?);");
        $query->bind_param("ss", $name, $categoryName);
        foreach($categories as $category)
        {
            $categoryName = $category;
            $query->execute();
        }
    }

    function insertApp(&$database, &$name, &$price, &$desc, &$imgurl, &$dev)
    {
        $query = $database->prepare("INSERT IGNORE INTO app (name, price, description, image, dev) VALUES (?, ?, ?, ?, ?);");
        $query->bind_param("sisss", $name, $price, $desc, $imgurl, $dev);
        $query->execute();

        $query->close();
    }

    function insertDev(&$database, &$dev)
    {
        $query = $database->prepare("INSERT IGNORE INTO developer (name) VALUES (?);");
        $query->bind_param("s", $dev);
        $query->execute();

        $query->close();
    }

    function insertCategories(&$database, &$categories)
    {
        $query = $database->prepare("INSERT IGNORE INTO category (name) VALUES (?);");
        $query->bind_param("s", $categoryName);
        foreach ($categories as $category)
        {
            $categoryName = $category;
            $query->execute();
        }

        $query->close();
    }

    function deleteRequest(&$database, $user, $JSON)
    {
        if (!isset($_COOKIE["user"]) || !password_verify($user, $_COOKIE["user"]))
        {
            echo "error";
            return false;
        }

        if (!verifyAdministrator($database, $user))
        {
            echo "error";
            return false;
        }

        $hashed_json = md5($JSON);
        $query = $database->prepare("DELETE FROM app_request WHERE username = ? and json_hash = ?;");
        $query->bind_param("ss", $user, $hashed_json);
        $query->execute();
        if ($query->error == "")
        {
            $query->close();
            return true;
        }
        else
        {
            $query->close();
            echo "error";
            return false;
        }

    }

?>