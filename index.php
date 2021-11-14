
<!DOCTYPE html>
<html lang="en-us">

<?php
    $errors = "";
    $loggedIn = false; //Keeps track of the user's signed in/ signed up status
    $usertype = "";
    //Establish Connection
    $conn = new mysqli("localhost:3306", "php", "testpassword", "scry");
    //Check Connection and stop if invalid
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    include_once("user.php");
    
    if ($_POST["sign_in"] && $_POST["uname"] && $_POST["pass"])
    {
        $loggedIn = login($conn, $errors, $_POST["uname"], $_POST["pass"], $usertype);
    }
    else if ($_POST["sign_up"] && $_POST["uname"] && $_POST["pass"])
    {
        $loggedIn = signup($conn, $errors, $_POST["uname"], $_POST["pass"]);
    }
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel|Cinzel+Decorative|Marcellus&display=swap" />
    <link href="IndexLayout.css" rel="stylesheet" />
    <link href="nav.css" rel="stylesheet" />
    <link href="apps.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.min.css" integrity="sha512-jN4O0AUkRmE6Jwc8la2I5iBmS+tCDcfUd1eq8nrZIBnDKTmCp5YxxNN1/aetnAH32qT+dDbk1aGhhoaw5cJNlw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--Source Files-->
    <script src="IndexScript.js"></script>
    <script src="nav.js"></script>
    <script src="apps.js"></script>
    <script src="https://kit.fontawesome.com/b9a27c43ce.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/js/OverlayScrollbars.min.js" integrity="sha512-B1xv1CqZlvaOobTbSiJWbRO2iM0iii3wQ/LWnXWJJxKfvIRRJa910sVmyZeOrvI854sLDsFCuFHh4urASj+qgw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Scry - App Repository</title>
</head>

<body>

    <div style="position: relative; z-index: 0;">
        <section id="filterSelection">
            <form>
                <label id="categorybtn" onclick="toggleCategories();">Category <i class='fas fa-caret-down'> </i></label>
                <div id="categoryContainer">
                <input type="text" onkeyup="filterCategories(this.value);" style="box-sizing:border-box; width:100%; position:sticky; top: 0;">
                <ul id="categories">
                    <?php
                        //Query database for all categories
                        $query = "SELECT * FROM category;";
                        $result = $conn->query($query);

                        while ($category = $result->fetch_assoc())
                        {
                            echo "<li onclick='toggleCheck(this);' class='categoryListing'>";
                            echo $category["name"];
                            echo "</li>";
                        }
                    ?>
                </ul>
                </div>
            </form>
        </section>
    </div>

    <nav>
        <ul>
            <li style="font-size:3.5vh;font-family:'Cinzel Decorative', cursive;">SCRY</li>
            <!--<li style="margin-left: auto;">
                <label>Sort By</label>
                <select name="options" id="options" onchange="sortBy();">
                    <option id="defaultOption" style="display: none;">---Choose An Option---</option>
                    <option value="alphabetical">Alphabetical</option>
                    <option value="category">Category</option>
                </select>
            </li>-->
            <li><input type="search" placeholder="&#x1F50E;&#xFE0E; Search Apps" id="searchbar" onfocus="this.placeholder = '';" onblur="this.placeholder='&#x1F50E;&#xFE0E; Search Apps';" onkeyup="search();"></li> <!--Styling: display:flex; flex-direction:row; align-items:center; column-gap:.4vw;-->
            <li style="margin-left:auto;">
                <?php
                    if (!$loggedIn)
                    {
                        echo "<input id='signinbtn' class='scrybtn' type='button' onclick='showSignIn();' value='Sign In/Sign Up'>";
                    }
                ?>
            </li>
            <li id="userDisplay" style="font-size:x-large; font-family:Marcellus, Serif;">
                <?php
                    if ($loggedIn)
                    {
                        echo $_POST["uname"]." ";
                        echo "<i class='fas fa-caret-down'></i>";
                        //echo "<p id='userpass' hidden>".$_POST["pass"]."</p>"; BIG SECURITY VULNERSABILITY
                    }
                ?>
                <ul id="userdrpdwn">
                    <br><li onclick="window.location.href = window.location.href">Log Out</li>
                    <?php
                        if ($usertype == "admin")
                        {
                            echo "<br><li>Admin View</li>";
                        }
                    ?>
                </ul>
            </li>
        </ul>
    </nav>

    <section id="apps">
        <?php
            //Query database for all app listings
            $query = "SELECT * FROM app;";
            $result = $conn->query($query);

            //Display all app listings
            while ($app = $result->fetch_assoc()) //NEED TO IMPLEMENT CATEGORIES and price
            {
                $categoryquery = "SELECT categoryname FROM appcategory WHERE appcategory.appname = '".$app["name"]."'";
                $categoryresult = $conn->query($categoryquery);
                $categories = "";
                if ($categoryresult != false)
                {
                    while($temp = $categoryresult->fetch_assoc())
                    {
                        $categories.=$temp["categoryname"]." ";
                    }
                }
                echo "<article class='applisting' title='".$app["name"]."' onclick='showData(this);' description='".$app["description"]."' categories='".$categories."'>";
                echo "<h3>".$app["name"]."</h3>";
                echo "<img src='".$app["image"]."' alt='".$app["name"]."'/>";
                echo "</article>";
            }

        ?>
        <!-- <article class="applisting shopping" title="Amazon" onclick="showData(this);">
            <h3>Amazon</h3>
            <img src="AppLogos\amazon.png" alt="Amazon"/>
        </article> -->
    </section>

    <div id="overlay" onclick="dismiss(event);" class="<?php echo ($errors == "") ? "":"active";//If sign in error then keeps modal displayed ?>">
        <!--Holds The Modals that show app information and sign in/ sign up form -->
        <div id="appdata" onclick="dummyDismiss(event);">
            <h1 id="appName" style="align-self: center;"></h1>
            <div id="appinfo">
                <img src="">
                <div>
                    <h3>Description: </h3>
                    <p></p>
                </div>
            </div>
            <div id="appdiscussion">
                <h3>User Discussions: </h3>
                <?php
                    if ($loggedIn)
                    {
                        echo '<div style="position: relative;"><div id="commentfield" onkeyup="presentSave(this);" placeholder="Write Comment here..." 
                        contenteditable></div><i id="saveNewComment" onclick="makeComment();" class="fa fa-save" style="position:absolute; right: -18px; top: 5px;"></i></div>';
                    }
                ?>
                <table id="comments"></table>
            </div>
            <!-- <div style="margin-left: 10%; align-self: flex-start; margin-right: 10%; margin-bottom: 2%; max-width: 80%">
                <h3>User Discussions: </h3>
                 <div style="position:relative; max-width: 100%;">
                    <div id='commentfield' placeholder="Write Comment here..." contenteditable></div>
                     <i class="fa fa-save" style="position:absolute; right: 10px; top: 10px;"></i>
                 </div>
                <table id="comments"></table>
            </div> -->
        </div>
        <div id="signin" onclick="dummyDismiss(event);" class="<?php echo ($errors == "") ? "":"active";//If sign in error then keeps modal displayed ?>">
            <form id="user_verification" name="user_verification" onsubmit="return validateCredentials();" action="" method="POST">
                <h2>Sign In</h2>
                <?php
                    if ($errors != "")// Shows errors to user
                    {
                        echo $errors;
                    }
                ?>
                <label for="uname"><input type="text" name="uname" value="" required> User Name</label>
                <label for="pass"><input type="password" name="pass" value="" required> Password</label>
                <div style="display: flex; flex-direction: row; justify-content: space-between; width: 164.5px;">
                    <input type="submit" value="Sign In" name="sign_in" class="scrybtn">
                    <input type="submit" value="Sign Up" name="sign_up" class="scrybtn">
                </div>
            </form> 
        </div>
    </div>
</body>
</html>

<?php
    $conn->close();
?>

<!--<script src="https://cdn.jsdelivr.net/npm/bubbly-bg@1.0.0/dist/bubbly-bg.js"></script>
<script>bubbly();</script>-->
