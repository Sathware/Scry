
<!DOCTYPE html>
<html lang="en-us">

<?php
    $invalidUserName = false;
    $invalidPassword = false;
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
            <!-- <li style="margin-left: auto;">
                <form name="userCredentials" onsubmit="userLogin(); return false;">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" />
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" />
                    <input type="submit" value="Submit" />
                </form>
            </li> -->
            <li><input type="button" onclick="showSignIn();" value="Sign In/Sign Up"></li>
            <li id="userDisplay" style="font-size:x-large; font-family:Marcellus, Serif;">
            <?php
                if ($_POST["uname"] && $_POST["pass"])
                {
                    //Establish Connection
                    $conn = new mysqli("localhost:3306", "php", "testpassword", "scry");
                    //Check Connection and stop if invalid
                    if ($conn->connect_error) 
                    {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    if ($_POST["sign_in"])
                    {
                        $query = $conn->prepare("SELECT pass FROM user WHERE name = ?");
                        $query->bind_param("s", $userInputtedName); //$statemnt will take $username as variable for the aove '?' with the type of $username as String specified by the "s"
                        $userInputtedName = $_POST["uname"];
                        $query->execute();
                        $query->bind_result($storedPass);

                        if ($query->fetch())
                        {
                            $userInputtedPass = $_POST["pass"];
                            if (password_verify($userInputtedPass, $storedPass))
                            {
                                echo $userInputtedName;
                            }
                            else
                            {
                                $invalidPassword = true;
                            }
                        }
                        else
                        {
                            $invalidUserName = true;
                        }
                    }

                    $conn -> close();
                }
            ?>
            </li>
        </ul>
    </nav>

    <section id="apps">
        <?php
            //Establish Connection
            $conn = new mysqli("localhost:3306", "php", "testpassword", "scry");
            //Check Connection and stop if invalid
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

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

            $conn->close();
        ?>
        <!-- <article class="applisting shopping" title="Amazon" onclick="showData(this);">
            <h3>Amazon</h3>
            <img src="AppLogos\amazon.png" alt="Amazon"/>
        </article> -->
    </section>
    
    <section id="filterSelection">
            <label>Platform</label>
            <select>

            </select>
            <label>Category</label>
            <select>

            </select>
            <label>Developer</label>
            <select>

            </select>
            <label>Price</label>
            <input type="range">
    </section>

    <div id="overlay" onclick="dismiss(event);" style="<?php echo ($invalidUserName || $invalidPassword) ? "display:block;": "" ?>">
        <div id="appdata" onclick="dummyDismiss(event);">
            <h1 style="text-align: center;"></h1>
            <img src="" style="width: 50vw; height: 50vh;">
            <p></p>
            <!--<table>
                <tr><th>Comments: </th></tr>
                <tr>
                    <td>User</td>
                    <td>Comment</td>
                </tr>
                <tr>
                    <td>User</td>
                    <td>Comment</td>
                </tr>
                <tr>
                    <td>User</td>
                    <td>Comment</td>
                </tr>
            </table>-->
        </div>
        <div id="signin" onclick="dummyDismiss(event);" style="<?php echo ($invalidUserName || $invalidPassword) ? "display:block;": "" ?>">
            <h2>Sign In</h2>

            <?php
                if ($invalidUserName)
                {
                    echo "INVALID USER NAME";
                }
                if ($invalidPassword)
                {
                    echo "INAVLID PASSWORD";
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


<!--<script src="https://cdn.jsdelivr.net/npm/bubbly-bg@1.0.0/dist/bubbly-bg.js"></script>
<script>bubbly();</script>-->
