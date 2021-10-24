
<!DOCTYPE html>

<html lang="en-us">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel|Cinzel+Decorative|Marcellus&display=swap" />
    <link href="IndexLayout.css" rel="stylesheet" />
    <script src="IndexScript.js"></script>
    <script src="SortBy.js"></script>
    <title>Scry - App Repository</title>
</head>

<body>
    <nav>
        <ul>
            <li style="font-size:xx-large;font-family:'Cinzel Decorative', cursive;">SCRY</li>
            <li><label>Search: </label><input type="search" id="searchbar" onkeyup="filterSearch();"></li>
            <form name="sortByFeature" onsubmit="sortBy(); return false;">
                <label for="sortOptions">Sort by:</label>
                <select name="options" id="options">
                    <option value="alphabetical" selected>Alphabetical Order</option>
                    <option value="category">Category</option>
                    <option value="price">Price</option>
                </select>
                <input type="submit" value="Submit" />
            </form>
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

    <!-- <section class="appCluster" id="B">
        <h2>B</h2>
        <article class="applisting" title="Bank" onclick="showData(this);">
            <h3>Bank</h3>
        </article>
        <article class="applisting" title="Bon" onclick="showData(this);">
            <h3>Bon</h3>
        </article>
    </section>
    <section class="appCluster" id="S">
        <h2>S</h2>
        <article class="applisting" title="Spotify" onclick="showData(this);">
            <h3>Spotify</h3>
        </article>
        <article class="applisting" title="Skate 3" onclick="showData(this);">
            <h3>Skate 3</h3>
        </article>
    </section> -->

    <section id="app">
        <article class="applisting" title="Bank" price="5" category="finance" onclick="showData(this);">
            <h5 id="headertag0">Bank 5$ Finance</h5>
        </article>
        <article class="applisting" title="Facebook" price="0" category="texting" onclick="showData(this);">
            <h5 id="headertag1">Facebook 0$ Texting</h5>
        </article>
        <article class="applisting" title="Spotify" price="10" category="music" onclick="showData(this);">
            <h5 id="headertag2">Spotify 10$ Music</h5>
        </article>
        <article class="applisting" title="Snapchat" price="2" category="texting" onclick="showData(this);">
            <h5 id="headertag3">Snapchat 2$ Texting</h5>
        </article>
    </section>

    <div id="overlay" onclick="dismiss(event);">
        <div id="appdata" onclick="dummyDismiss(event);">
            <h1></h1>
            <img src="Links standing.jpg" style="width: 50vw; height: 50vh;">
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

<!-- Bubble Canvas
<script src="https://cdn.jsdelivr.net/npm/bubbly-bg@1.0.0/dist/bubbly-bg.js"></script>
<script>bubbly();</script> -->
