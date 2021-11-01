
<!DOCTYPE html>

<html lang="en-us">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel|Cinzel+Decorative|Marcellus&display=swap" />
    <link href="IndexLayout.css" rel="stylesheet" />
    <script src="IndexScript.js"></script>
    <title>Scry - App Repository</title>
</head>
<body>
    <nav>
        <ul>
            <li style="font-size:xx-large;font-family:'Cinzel Decorative', cursive;">SCRY</li>
            <li><label>Search: </label><input type="search" id="searchbar" onkeyup="filterSearch();"></li>
            <li style="margin-left: auto;">
                <form name="userCredentials" onsubmit="userLogin(); return false;">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" />
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" />
                    <input type="submit" value="Submit" />
                </form>
            </li>
            <li id="userDisplay" style="visibility:hidden; font-size:x-large; font-family:Marcellus, Serif;"></li>
        </ul>
    </nav>
    <section class="appCluster" id="B">
        <h2>B</h2>
        <article class="applisting" title="Soundcloud" onclick="showData(this);">
            <h3>Soundcloud</h3>
            <img src="soundcloud.jpg" alt="Soundcloud"/>
        </article>
    </section>
    <section class="appCluster" id="S">
        <h2>S</h2>
        <article class="applisting" title="Spotify" onclick="showData(this);">
            <h3>Spotify</h3>
            <img src="spotify.png" alt="Spotify"/>
        </article>
        <article class="applisting" title="Twitter" onclick="showData(this);">
            <h3>Twitter</h3>
            <img src="twitter.png" alt="Twitter"/>
        </article>
        <article class="applisting" title="Facebook" onclick="showData(this);">
            <h3>Facebook</h3>
            <img src="facebook.png" alt="Facebook"/>
        </article>
    </section>
    <section class="appCluster" id="S">
        <h2>S</h2>
        <article class="applisting" title="Amazon" onclick="showData(this);">
            <h3>Amazon</h3>
            <img src="amazon.png" alt="Amazon"/>
        </article>
        <article class="applisting" title="Nike" onclick="showData(this);">
            <h3>Nike</h3>
            <img src="nike.png" alt="Amazon"/>
        </article>
        <article class="applisting" title="DoorDash" onclick="showData(this);">
            <h3>DoorDash</h3>
            <img src="doordash.png" alt="DoorDash"/>
        </article>
    </section>
    <section class="appCluster" id="S">
        <h2>S</h2>
        <article class="applisting" title="McDonald's" onclick="showData(this);">
            <h3>McDonald's</h3>
            <img src="mcdonalds.png" alt="Mcdonald's" />
        </article>
        <article class="applisting" title="Netflix" onclick="showData(this);">
            <h3>Netflix</h3>
            <img src="netflix.png" alt="Netflix" />
        </article>
        <article class="applisting" title="Hulu" onclick="showData(this);">
            <h3>Hulu</h3>
            <img src="hulu.png" alt="Hulu"/>
        </article>
    </section>
    <div id="overlay" onclick="this.style.display = 'none';">
        <div id="appdata">
            <h1></h1>
            <img src="" style="width: 50vw; height: 50vh;">
            <p></p>
            <table>
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
            </table>
        </div>
    </div>

</body>
</html>
