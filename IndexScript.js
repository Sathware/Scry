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
    AppData.getElementsByTagName("p").innerHTML = "jon";

    if (AppData.getElementsByTagName("h1")[0].innerHTML === "U.S. Bank")
        AppData.getElementsByTagName("p")[0].innerHTML = "U.S. Bank is a premier bank with a top of the line app that allows you to manage your bank accounts, make payments, and talk to virtual advisors.";
    else if (AppData.getElementsByTagName("h1")[0].innerHTML === "Fifth Third Bank")
        AppData.getElementsByTagName("p")[0].innerHTML = "Fifth Third Bank is headquartered in Cincinnati, Ohio and their app allows users to manage their funds and make payments.";
    else
        AppData.getElementsByTagName("p")[0].innerHTML = "lorem ipsum dolor set amet.";

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
