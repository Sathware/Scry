<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel|Cinzel+Decorative|Marcellus&display=swap" />
    <link href="IndexLayout.css" rel="stylesheet" />
    <link href="apps.css" rel="stylesheet" />
    <!--Source Files-->
    <script src="apps.js"></script>
    <script src="apprequest.js"></script>
    <script src="https://kit.fontawesome.com/b9a27c43ce.js" crossorigin="anonymous"></script>
    <style>
        li:hover
        {
            cursor:pointer;
        }
    </style>
    <title>Admin - Scry</title>
</head>

<body>
    <div id="userInputtedName" hidden>
        <?php
            echo $_GET["username"];
        ?>
    </div>
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: flex-start;margin-top: 30vh;">
        <label>App Requests</label>
        <ul>
            <?php
                //Establish Connection
                $conn = new mysqli("localhost:3306", "php", "testpassword", "scry");
                //Check Connection and stop if invalid
                if ($conn->connect_error) 
                {
                    die("Connection failed: " . $conn->connect_error);
                }

                $apprequests = $conn->query("SELECT * FROM app_request;");
                while ($request = $apprequests->fetch_assoc())
                {
                    $safeJson = str_replace("%3F", "?", $request["json"]);
                    $safeJson = str_replace("%26", "&", $safeJson);
                    echo "<li onclick='displayRequest(this);' class='request' username='".$request["username"]."' json='".$safeJson."'>Request By: ".$request["username"]." at - ".$request["date"]."</li>";
                }
            ?>
        </ul>
    </div>

    <div id="overlay" onclick="dismiss(event);">
        <div id="apprequest" onclick="dummyDismiss(event);">
            <div id="apprequestinput">
                <label style="">App Name</label>
                <div onkeyup="updateName(this.innerText);" class="requestdiv" contenteditable></div>

                <label style="">Price</label>
                <input onchange="updatePrice(this.value);" type="number" min="0" max="50"value="0">

                <label style="">Description</label>
                <div onkeyup="updateDesc(this.innerText);" class="requestdiv" contenteditable></div>

                <label style="">App Image URL</label>
                <div onkeyup="updateImg(this.innerText);" class="requestdiv" contenteditable></div>

                <label style="">Developer</label>
                <div onkeyup="updateDev(this.innerText);" class="requestdiv" contenteditable></div>

                <div style="display: flex; flex-direction: row; justify-content: flex-start; width: 50vw;">
                    <div style="position: relative; min-width: 45%;">
                        <label class="selectorLabel" onclick="document.getElementById('requestCategoriesContainer').classList.toggle('active');">Categories <i class='fas fa-caret-down'> </i></label>
                        <div class="selectionContainer" id="requestCategoriesContainer">
                            <input type="text" id="textRequestCategory" onkeyup="filterRequestCategory(this.value);" style="box-sizing:border-box; position:sticky; top: 0;">
                            <ul id="requestcategories" class="requestselector">
                                    
                                <?php
                                    //Query database for all categories
                                    $query = "SELECT * FROM category;";
                                    $result = $conn->query($query);

                                    while ($category = $result->fetch_assoc())
                                    {
                                        echo "<li onclick='toggleRequestCategory(this);' class='Listing'>";
                                        echo $category["name"];
                                        echo "</li>";
                                    }
                                ?>
                                        
                            </ul>
                        </div>
                    </div>

                    <div style="position: relative; min-width: 45%;">
                        <label class="selectorLabel" onclick="document.getElementById('requestPlatformsContainer').classList.toggle('active');">Platforms <i class='fas fa-caret-down'> </i></label>
                        <div class="selectionContainer" id="requestPlatformsContainer">
                            <input type="text" id="textRequestPlatform" onkeyup="filterRequestPlatform(this.value);" style="box-sizing:border-box; position:sticky; top: 0;">
                            <ul id="requestplatforms" class="requestselector">
                                    
                                <?php
                                    //Query database for all categories
                                    $query = "SELECT * FROM platform;";
                                    $result = $conn->query($query);

                                    while ($platform = $result->fetch_assoc())
                                    {
                                        echo "<li onclick='toggleRequestPlatform(this);' class='Listing'>";
                                        echo $platform["name"];
                                        echo "</li>";
                                    }
                                ?>
                                        
                            </ul>
                        </div>
                    </div>
                </div>
                <input type="button" class="scrybtn" value="Approve" onclick="approverequest();">
                <input type="button" class="scrybtn" value="Deny" onclick="denyrequest();">
            </div>

            <div id="preview">
                <div style="display: flex; flex-direction: row; justify-content: center; align-self: center; align-items: center;">
                    <h1 id="previewheader"></h1>
                    <div id="previewplatforms"></div>
                </div>
                <div style="display:flex; flex-direction: row; justify-content: flex-start; align-self: flex-start;">
                    <img id="previewimg" src="blank.png">
                    <div style="display:flex; flex-direction: column; justify-content: center; align-items: flex-start;">
                        <ul id="previewcategories"></ul>
                        <h3>Description: </h3>
                        <p id="previewdesc"></p>
                    </div>
                </div>
                <div id="platformversion"></div>
            </div>
        </div>
    </div>
</body>

<script>
    var originalJSON = "";
    var currentrequest = null;
    function dummyDismiss(e)
    {
        let x = e.currentTarget.id;
        if (x.valueOf() == "appdata" || x.valueOf() == "apprequest")
        {
            e.stopPropagation();
        }
    }

    function dismiss(e)
    {
        let x = e.currentTarget.id;
        if (x.valueOf() == "overlay")
        {
            document.getElementById("overlay").classList.remove("active");
            document.getElementById("apprequest").classList.remove("active");
            document.body.style.overflow = "auto";
        }
    }

    function displayNewCategories()
    {
        let categories = document.getElementById("requestcategories").getElementsByTagName("li");
        for (let i = 0; i < categories.length; i++)
        {
            categories[i].classList.remove("active");
        }

        for (let i = 0; i < previewApp.categories.length; i++)//previewApp categories length will always be greater
        {
            let notInCategories = true;
            for (let k = 0; notInCategories && k < categories.length; k++)
            {
                notInCategories = !(categories[k].innerText.toUpperCase() == previewApp.categories[i].toUpperCase());

                if (!notInCategories && !categories[k].classList.contains('active'))
                {
                    categories[k].classList.add('active');
                }
            }

            if (notInCategories)
            {
                document.getElementById("requestcategories").innerHTML += "<li onclick='toggleRequestCategory(this);' class='categoryListing active'>" + previewApp.categories[i] + "</li>";
            }
        }
    }

    function displayNewPlatforms()
    {
        let platforms = document.getElementById("requestplatforms").getElementsByTagName("li");
        for (let i = 0; i < platforms.length; i++)
        {
            platforms[i].classList.remove("active");
        }

        previewApp.platforms.forEach( //previewApp categories length will always be greater
            function (versions, platform)//Platform stored in previewApp not in ul list
            {
                let notInPlatforms = true;
                for (let k = 0; notInPlatforms && k < platforms.length; k++)
                {
                    notInPlatforms = !( (platforms[k].innerText.toUpperCase() == platform.toUpperCase()) || (platforms[k].innerHTML.toUpperCase() == platform.toUpperCase()) );

                    if (!notInPlatforms && !platforms[k].classList.contains('active'))
                    {
                        platforms[k].classList.add('active');
                    }
                }

                if (notInPlatforms)
                {
                    document.getElementById("requestplatforms").innerHTML += "<li onclick='toggleRequestPlatform(this);' class='Listing active'>" + platform + "</li>";
                }
            }
        );
    }

    function displayVersionTables()
    {
        document.getElementById("platformversion").innerHTML = "";//resets version tables
        previewApp.platforms.forEach(
            function(versions, platform)
            {
                let newtable = addVersionsTable(platform);
                versions.forEach(
                    function (url, version)
                    {
                        let newrow = addVersionRow(newtable);
                        newrow.getElementsByTagName("td")[0].innerText = version;
                        newrow.getElementsByTagName("td")[1].innerText = url;
                    }
                );
            }
        );
    }

    function displayRequest(request)
    {
        currentrequest = request;
        originalJSON = request.getAttribute("json");
        document.getElementById("overlay").classList.add("active");
        document.getElementById("apprequest").classList.add("active");
        document.body.style.overflow = "hidden";

        let tempObj = JSON.parse(request.getAttribute("json"), reviver);

        previewApp.name = tempObj.name;
        previewApp.price = tempObj.price;
        previewApp.desc = tempObj.desc;
        previewApp.dev = tempObj.dev;
        previewApp.imgurl = tempObj.imgurl;
        previewApp.categories = tempObj.categories;
        previewApp.platforms = tempObj.platforms;

        let form = document.getElementById("apprequestinput");
        let editables = form.getElementsByTagName("div");
        editables[0].innerText = previewApp.name;
        editables[1].innerText = previewApp.desc;
        editables[2].innerText = previewApp.imgurl;
        editables[3].innerText = previewApp.dev;

        form.getElementsByTagName("input")[0].value = previewApp.price;

        displayNewCategories();
        displayNewPlatforms();
        displayVersionTables();

        displayPreview();
    }

    function approverequest()
    {
        let userName = document.getElementById("userInputtedName").innerText.trim();
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200)
            {
                if (this.responseText == "error")
                {
                    alert("Approve Failed");
                }
                else
                {
                    alert("Successfully approved app request");
                    document.getElementById("overlay").classList.remove("active");
                    document.getElementById("apprequest").classList.remove("active");
                    document.body.style.overflow = "auto";
                    currentrequest.remove();
                    currentrequest = null;
                }
            }
        };
        let params = "action=approve&username="+userName+"&origjson="+originalJSON+"&appjson="+JSON.stringify(previewApp, replacer);
        xmlhttp.open("POST", "requestjudgment.php", true);//!!!!!!!!!!!!CHANGE URL !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xmlhttp.send(params);
    }

    function denyrequest()
    {
        let userName = document.getElementById("userInputtedName").innerText.trim();
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200)
            {
                if (this.responseText == "error")
                {
                    alert("Deny Failed");
                }
                else
                {
                    alert("Successfully removed app request");
                    document.getElementById("overlay").classList.remove("active");
                    document.getElementById("apprequest").classList.remove("active");
                    document.body.style.overflow = "auto";
                    currentrequest.remove();
                    currentrequest = null;
                }
            }
        };
        let params = "action=delete&username="+userName+"&origjson="+originalJSON;
        xmlhttp.open("POST", "requestjudgment.php", true);//!!!!!!!!!!!!CHANGE URL !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xmlhttp.send(params);
    }
</script>

</html>