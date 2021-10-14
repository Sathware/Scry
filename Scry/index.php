<!DOCTYPE html>

<html lang="en-us">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel|Cinzel+Decorative|Marcellus&display=swap" />
    <link href="IndexLayout.css" rel="stylesheet" />
    <script src="LoginAndSearch.js"></script>
    <title>Scry - App Repository</title>
</head>

<body>
    <nav>
        <ul>
            <li style="font-size:xx-large;font-family:'Cinzel Decorative', cursive;">SCRY</li>
            <li><label>Search: </label><input type="search" id="searchbar" onkeyup="filterSearch()"></li>
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

    <section id="b">
        <article class="applisting" title="Bank">
            <h3>Bank</h3>
        </article>
        <article class="applisting" title="Bon">
            <h3>Bon</h3>
        </article>
        <article class="applisting" title="B">
            <h3>B</h3>
        </article>
    </section>
    <section id="s">
        <article class="applisting" title="Spotify">
            <h3>Spotify</h3>
        </article>
        <article class="applisting" title="Skate 3">
            <h3>Skate 3</h3>
        </article>
        <article class="applisting" title="s">
            <h3>s</h3>
        </article>
    </section>
    <section id="s">
        <article class="applisting" title="Spotify">
            <h3>Spotify</h3>
        </article>
        <article class="applisting" title="Skate 3">
            <h3>Skate 3</h3>
        </article>
        <article class="applisting" title="s">
            <h3>s</h3>
        </article>
    </section>
    <section id="s">
        <article class="applisting" title="Spotify">
            <h3>Spotify</h3>
        </article>
        <article class="applisting" title="Skate 3">
            <h3>Skate 3</h3>
        </article>
        <article class="applisting" title="s">
            <h3>s</h3>
        </article>
    </section>
</body>
</html>

<!-- Bubble Canvas
<script src="https://cdn.jsdelivr.net/npm/bubbly-bg@1.0.0/dist/bubbly-bg.js"></script>
<script>bubbly();</script> -->
