function userLogin() {
    let loginForm = document.forms["userCredentials"];
    let uName = loginForm["username"].value;
    let pWord = loginForm["password"].value;
    if (uName == uName && pWord == "pwd") {
        let UserDisplay = document.getElementById("userDisplay");
        UserDisplay.innerHTML = uName;
        UserDisplay.style.visibility = "visible";
        loginForm.style.visibility = "hidden";
    }
    else {
        alert("Invalid Credentials");
    }
}

function filterSearch() {
    let input = document.getElementById("searchbar");
    let filter = input.value.toUpperCase();
    let AppClusters = document.getElementsByClassName("appCluster");
    let AppListings = null;

    for (i = 0; i < AppClusters.length; i++) {
        if (AppClusters[i].id.charAt(0).valueOf() == filter.charAt(0).valueOf()) {
            AppClusters[i].style.display = "flex";
            AppListings = AppClusters[i].getElementsByClassName("applisting");
        }
        else {
            AppClusters[i].style.display = "none";
        }

        if (filter.length == 0) {
            AppClusters[i].style.display = "flex";
        }
    }

    for (i = 0; i < AppListings.length; i++) {
        let x = AppListings[i].getAttribute("title").toUpperCase();
        if (x.includes(filter)) {
            AppListings[i].style.display = "block";
        }
        else {
            AppListings[i].style.display = "none";
        }
    }

    // let section = document.getElementById(filter.toLowerCase().charAt(0));
    // section.style.display = 'none';
}

function showData(appListing)//In Progress
{
    let AppData = document.getElementById("appdata");
    AppData.getElementsByTagName("h1")[0].innerHTML = appListing.getElementsByTagName("h3")[0].innerHTML;
    document.getElementById("overlay").style.display = "block";


    if (AppData.getElementsByTagName("h1")[0].innerHTML === "Soundcloud") {
        AppData.getElementsByTagName("p")[0].innerHTML = "Soundcloud is the world's largest music and audio streaming platform with 200 million tracks and growing."
            + " With a buzzing community of artists and musicians constantly uploading new music, Soundcloud is where you can find the next big artists alongside chart-topping albums, live sets, and"
            + " mixes for every occasion." + "<br><br>Category: Music" + "<br><br>Developed by: Soundcloud Global Limited & Co KG" + "<br><br>Version: 5.149.0" + "<br><br>Available On:<br><a href='https://apps.apple.com/us/app/soundcloud-music-songs/id336353151' target='_blank'>Apple App Store</a>."
            + "<br><a href='https://play.google.com/store/apps/details?id=com.soundcloud.android&hl=en_US&gl=US' target='_blank'>Google Play Store</a>" + "<br><br>Price: Free";
    }

    else if (AppData.getElementsByTagName("h1")[0].innerHTML === "Spotify") {
        AppData.getElementsByTagName("p")[0].innerHTML = "With Spotify, you can play millions of songs and thousands of podcasts for free. Listen to the songs you love and enjoy music from all over the world."
            + "<br><br>Category: Music" + "<br><br>Developed by: Spotify" + "<br><br>Version: 8.6.74" + "<br><br>Available On:<br><a href='https://apps.apple.com/us/app/spotify-new-music-and-podcasts/id324684580' target='_blank'>Apple App Store</a>."
            + "<br><a href='https://play.google.com/store/apps/details?id=com.spotify.music&hl=en_US&gl=US' target='_blank'>Google Play Store</a>" + "<br><br>Price: Free";
    }

    else if (AppData.getElementsByTagName("h1")[0].innerHTML === "Twitter") {
        AppData.getElementsByTagName("p")[0].innerHTML = "Retweet, chime in on a thread, go viral, or just scroll through the Twitter timeline to stay on top of what everyone is talking about."
            + "<br><br>Category: Social Media" + "<br><br>Developed by: Twitter, Inc." + "<br><br>Version: 8.88.1" + "<br><br>Available On:<br><a href='https://apps.apple.com/us/app/twitter/id333903271' target='_blank'>Apple App Store</a>."
            + "<br><a href='https://play.google.com/store/apps/details?id=com.twitter.android&hl=en_US&gl=US' target='_blank'>Google Play Store</a>" + "<br><br>Price: Free";
    }

    else if (AppData.getElementsByTagName("h1")[0].innerHTML === "Facebook") {
        AppData.getElementsByTagName("p")[0].innerHTML = "Connect with friends, family and people who share the same interests as you." 
            + "Communicate privately, watch your favorite content, buy and sell items or just spend time with your community." + "<br><br>Category: Social Media" + "<br><br>Developed by: Facebook, Inc."
            + "<br><br>Version: 341.0" + "<br><br>Available On:<br><a href='https://apps.apple.com/us/app/facebook/id284882215' target='_blank'>Apple App Store</a>."
            + "<br><a href='https://play.google.com/store/apps/details?id=com.facebook.katana&hl=en_US&gl=US' target='_blank'>Google Play Store</a>" + "<br><br>Price: Free";
    }

    else if (AppData.getElementsByTagName("h1")[0].innerHTML === "Amazon") {
        AppData.getElementsByTagName("p")[0].innerHTML = "Amazon Shopping offers app-only benefits to help make shopping on Amazon faster and easier. Browse, view product details, read reviews, and purchase millions of products."
            + "<br><br>Category: Shopping" + "<br><br>Developed by: AMZN Mobile LLC" + "<br><br>Version: 17.20.0" + "<br><br>Available On:<br><a href='https://apps.apple.com/us/app/amazon-shopping/id297606951' target='_blank'>Apple App Store</a>."
            + "<br><a href='https://play.google.com/store/apps/details?id=com.amazon.mShop.android.shopping&hl=en_US&gl=US' target='_blank'>Google Play Store</a>" + "<br><br>Price: Free";
    }

    else if (AppData.getElementsByTagName("h1")[0].innerHTML === "Nike") {
        AppData.getElementsByTagName("p")[0].innerHTML = "The Nike App is your source for daily guidance and inspiration to get you closer to your sport and style goals. Shop the latest Nike and Jordan products, clothing and shoes while getting real-time advice from our team of experts."
            + "<br><br>Category: Shopping" + "<br><br>Developed by: Nike, Inc." + "<br><br>Version: 2.186.0" + "<br><br>Available On:<br><a href='https://apps.apple.com/us/app/nike/id1095459556' target='_blank'>Apple App Store</a>."
            + "<br><a href='https://play.google.com/store/apps/details?id=com.nike.omega&hl=en_US&gl=US' target='_blank'>Google Play Store</a>" + "<br><br>Price: Free";
    }

    else if (AppData.getElementsByTagName("h1")[0].innerHTML === "DoorDash") {
        AppData.getElementsByTagName("p")[0].innerHTML = "Delivery anywhere you are. DoorDash offers the greatest selection of your favorite local and national restaurants, convenience stores, and grocery stores."
            + "<br><br>Category: Food" + "<br><br>Developed by: DoorDash, Inc." + "<br><br>Version: 4.59.0" + "<br><br>Available On:<br><a href='https://apps.apple.com/us/app/doordash-food-delivery/id719972451' target='_blank'>Apple App Store</a>."
            + "<br><a href='https://play.google.com/store/apps/details?id=com.dd.doordash&hl=en_US&gl=US' target='_blank'>Google Play Store</a>" + "<br><br>Price: Free";
    }

    else if (AppData.getElementsByTagName("h1")[0].innerHTML === "McDonald's") {
        AppData.getElementsByTagName("p")[0].innerHTML = "The McDonald's app gives you the full range of McDonald's menu available to be ordered for delivery or pick-up. Receive customized alerts and exclusive online-only coupons as well."
            + "<br><br>Category: Food" + "<br><br>Developed by: McDonald's USA" + "<br><br>Version: 6.18.2" + "<br><br>Available On:<br><a href='https://apps.apple.com/us/app/mcdonalds/id922103212' target='_blank'>Apple App Store</a>."
            + "<br><a href='https://play.google.com/store/apps/details?id=com.mcdonalds.app&hl=en_US&gl=US' target='_blank'>Google Play Store</a>" + "<br><br>Price: Free";
    }

    else if (AppData.getElementsByTagName("h1")[0].innerHTML === "Netflix") {
        AppData.getElementsByTagName("p")[0].innerHTML = "Looking for the most talked about TV shows and movies from around the world? They are all on Netflix."
        + " We have award-winning series, movies, documentaries, and stand-up specials. And with the mobile app, you get Netflix while you travel, commute, or just take a break."
            + "<br><br>Category: Entertainment" + "<br><br>Developed by: Netflix, Inc." + "<br><br>Version: 14.12.0" + "<br><br>Available On:<br><a href='https://apps.apple.com/us/app/netflix/id363590051' target='_blank'>Apple App Store</a>."
            + "<br><a href='https://play.google.com/store/apps/details?id=com.netflix.mediaclient&hl=en_US&gl=US' target='_blank'>Google Play Store</a>" + "<br><br>Price: Free";
    }

    else if (AppData.getElementsByTagName("h1")[0].innerHTML === "Hulu") {
        AppData.getElementsByTagName("p")[0].innerHTML = "With Hulu you can watch thousands of TV shows and movies, exclusive Originals, past seasons, current episodes, and more."
            + "<br><br>Category: Entertainment" + "<br><br>Developed by: Hulu, LLC" + "<br><br>Version: 7.36.1" + "<br><br>Available On:<br><a href='https://apps.apple.com/us/app/hulu-watch-tv-series-movies/id376510438' target='_blank'>Apple App Store</a>."
            + "<br><a href='https://play.google.com/store/apps/details?id=com.hulu.plus&hl=en_US&gl=US' target='_blank'>Google Play Store</a>" + "<br><br>Price: Free";
    }




    function dummyDismiss(e) {
        let x = e.currentTarget.id;
        if (x.valueOf() == "appdata") {
            e.stopPropagation();
        }
    }

    function dismiss(e) {
        let x = e.currentTarget.id;
        if (x.valueOf() == "overlay") {
            e.currentTarget.style.display = "none";
        }
    }
}
