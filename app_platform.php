<?php
    //Establish Connection
    $conn = new mysqli("localhost:3306", "php", "testpassword", "scry");
    //Check Connection and stop if invalid
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }
    // $platformquery = "SELECT platformname, app_platform.url FROM app_platform WHERE app_platform.appname = '".$app["name"]."'";
    //             $platformresult = $conn->query($platformquery);
    //             $platformlist = "";
    //             if ($platformresult != false)
    //             {
    //                 while ($temp = $platformresult->fetch_assoc())
    //                 {
    //                     $platformlist.="<a href='".$temp["app_platform.url"]."'>".$temp["platformname"]."</a>"; 
    //                 }
    //             }
    if ($_POST["appname"])
    {
        $selectedApp = $_POST["appname"];
        $selectedApp = str_replace("&apos;", "'", $selectedApp);
        $selectedApp = str_replace("\"", "&quot;", $selectedApp);
        $query = $conn->prepare("SELECT platformname FROM app_platform WHERE app_platform.appname = ?;");
        $query->bind_param("s", $selectedApp);
        $query->execute();
        $result = $query->get_result();

        $linkquery = $conn->prepare("SELECT versionnum, appversion.url FROM appversion WHERE appname = ? and platformname = ?;");
        $linkquery->bind_param("ss", $selectedApp, $platform);
        $linkquery->bind_result($version, $url);

        while ($platformresult = $result->fetch_assoc())
        {
            $platform = $platformresult["platformname"];
            echo "<div class='platforminstance'><label>".$platform."<i class='fas fa-caret-down'> </i></label><div class='platformversions'>";
            $linkquery->execute();
            while ($linkquery->fetch())
            {
                echo "<a href='".$url."' target='_blank'>".$version."</a>";
            }

            echo "</div></div>";       
        }

        $linkquery->close();
        $query->close();
    }
    $conn->close();
?>