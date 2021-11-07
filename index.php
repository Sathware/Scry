
<!DOCTYPE html>
<html lang="en-us">

<?php
    $errors = "";

    //Establish Connection
    $conn = new mysqli("localhost:3306", "php", "testpassword", "scry");
    //Check Connection and stop if invalid
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    include_once("user.php");
    include_once("app.php");
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel|Cinzel+Decorative|Marcellus&display=swap" />
    <link href="IndexLayout.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.min.css" integrity="sha512-jN4O0AUkRmE6Jwc8la2I5iBmS+tCDcfUd1eq8nrZIBnDKTmCp5YxxNN1/aetnAH32qT+dDbk1aGhhoaw5cJNlw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--Source Files-->
    <script src="IndexScript.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/js/OverlayScrollbars.min.js" integrity="sha512-B1xv1CqZlvaOobTbSiJWbRO2iM0iii3wQ/LWnXWJJxKfvIRRJa910sVmyZeOrvI854sLDsFCuFHh4urASj+qgw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Scry - App Repository</title>
</head>

<body>
    <nav>
        <ul>
            <li style="font-size:3.5vh;font-family:'Cinzel Decorative', cursive;">SCRY</li>
            <li style="margin-left: auto;">
                <label>Sort By</label>
                <select name="options" id="options" onchange="sortBy();">
                    <option id="defaultOption" style="display: none;">---Choose An Option---</option>
                    <option value="alphabetical">Alphabetical</option>
                    <option value="category">Category</option>
                </select>
            </li>
            <li><input type="search" placeholder="&#x1F50E;&#xFE0E; Search Apps" id="searchbar" onfocus="this.placeholder = '';" onblur="this.placeholder='&#x1F50E;&#xFE0E; Search Apps';" onkeyup="search();"></li> <!--Styling: display:flex; flex-direction:row; align-items:center; column-gap:.4vw;-->
            <li><input type="button" onclick="showSignIn();" value="Sign In/Sign Up"></li>
            <li id="userDisplay" style="font-size:x-large; font-family:Marcellus, Serif;">
            <?php
                if ($_POST["sign_in"] && $_POST["uname"] && $_POST["pass"])
                {
                    login($conn, $errors, $_POST["uname"], $_POST["pass"]);
                }
                else if ($_POST["sign_up"] && $_POST["uname"] && $_POST["pass"])
                {
                    signup($conn, $errors, $_POST["uname"], $_POST["pass"]);
                }
            ?>
            </li>
        </ul>
    </nav>

    <section id="apps">
        <?php
            //Query database for all app listings
            $query = "SELECT * FROM app;";
            $result = $conn->query($query);

            //Display all app listings
            while ($app = $result->fetch_assoc()) //NEED TO IMPLEMENT CATEGORIES
            {
                $safeName = str_replace("'", "&apos;", $app["name"]);//For instance McDonald's the ' will produce incorrect results, so this code fixes that
                $safeDescription = str_replace("'", "&apos;", $app["description"]);
                echo "<article class='applisting' title='".$safeName."' onclick='showData(this);' description='".$safeDescription."'>";
                echo "<h3>".$safeName."</h3>";
                echo "<img src='".$app["image"]."' alt='".$safeName."'/>";
                echo "</article>";
            }

        ?>
        <!-- <article class="applisting shopping" title="Amazon" onclick="showData(this);">
            <h3>Amazon</h3>
            <img src="AppLogos\amazon.png" alt="Amazon"/>
        </article> -->
    </section>
    
    <section id="filterSelection">
        <form>
            <label>Category</label>
            <input type="text" style="box-sizing:border-box; width:100%;" onfocus="document.getElementById('categories').style.display = 'block'" 
            onblur="document.getElementById('categories').style.display = 'none'">
            <div id="categories">
            <ul style="height:inherit;">
                <li>food</li>
                <li>apparel</li>
                <li>shopping</li>
            </ul>
            </div>
        </form>
    </section>

    <div id="overlay" onclick="dismiss(event);" style="<?php displayIfError($errors);//If there are errors then keep overlay displayed ?>">
        <!--Holds The Modals that show app information and sign in/ sign up form -->
        <div id="appdata" onclick="dummyDismiss(event);">
            <h1 style="text-align: center;"></h1>
            <img src="" style="width: 50vw; height: 50vh;">
            <p></p>
        </div>
        <div id="signin" onclick="dummyDismiss(event);" style="<?php displayIfError($errors);//If there are errors then keep sign in modal displayed ?>">
            <h2>Sign In</h2>

            <?php
                if ($errors != "")// Shows errors to user
                {
                    echo $errors;
                }
            ?>

            <form name="user_verification" onsubmit="return validateCredentials();" action="" method="POST">
                <label for="uname">User Name:</label><br>
                <input type="text" name="uname" value="" required><br>
                <label for="pass">Password </label><br>
                <input type="password" name="pass" value="" required><br><br>
                <input type="submit" value="Sign In" name="sign_in">
                <input type="submit" value="Sign Up" name="sign_up">
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
