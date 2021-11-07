function sortBy() {
    let choice = options.value;
    let AppListings = document.getElementsByClassName("applisting");
    let arrayToSort = new Array()
    for (var i=0;i<AppListings.length;i++) {
        let name = AppListings[i].getAttribute("title");
        let type = AppListings[i].className;
        let content = AppListings[i].innerHTML;
        //let category = AppListings[i].getAttribute("category");
        arrayToSort[i] = [name, type, content];//, prices, category, headers.innerText];
    }

    if (choice == "alphabetical")
    {
        arrayToSort.sort(function(a,b){return a[0].localeCompare(b[0]);});
        setAppListings(arrayToSort, AppListings);
    }
    else if (choice == "category") 
    {
       arrayToSort.sort(function(a,b){return a[1].localeCompare(b[1]);});
       setAppListings(arrayToSort, AppListings);
    }

    //     for (var i=0;i<arrayToSort.length;i++) {       
    //         AppListings[i].setAttribute("title", arrayToSort[i][0]);
    //         AppListings[i].innerHTML = arrayToSort[i][2];
    //     }
    // }
}

function setAppListings(sorted, applistings)
{
    for (var i=0;i<sorted.length;i++) {       
        applistings[i].setAttribute("title", sorted[i][0]);
        applistings[i].setAttribute("class", sorted[i][1]);
        applistings[i].innerHTML = sorted[i][2];
    }
}

function search()
{
    let input = document.getElementById("searchbar");
    let filter = input.value.toUpperCase();
    let AppListings = document.getElementsByClassName("applisting");

    for( i = 0; i < AppListings.length; i++)
    {
        let x = AppListings[i].getAttribute("title").toUpperCase();
        if (x.substring(0, filter.length).includes(filter))
        {
            AppListings[i].style.display = "block";
        }
        else
        {
            AppListings[i].style.display = "none";
        }
    }

    // let section = document.getElementById(filter.toLowerCase().charAt(0));
    // section.style.display = 'none';
}

function showSignIn()
{
    document.getElementById("overlay").style.display = "block";
    document.getElementById("signin").style.display = "block";
    document.body.style.overflow = "hidden";
}

function validateCredentials()
{
    let userInfo = document.forms["user_verification"];
    let invalidChars = /^[0-9a-zA-Z]+$/;
    if (invalidChars.test(userInfo["uname"].value) && invalidChars.test(userInfo["pass"].value))
    {
        return true;
    }
    else
    {
        alert("Please enter a valid username and password.");
        return false;
    }
}

function showData(appListing)//In Progress, need to figure out price and categories
{
    let AppData = document.getElementById("appdata");
    AppData.getElementsByTagName("h1")[0].innerHTML = appListing.getElementsByTagName("h3")[0].innerHTML;
    AppData.getElementsByTagName("img")[0].setAttribute("src", appListing.getElementsByTagName("img")[0].getAttribute("src"));
    document.getElementById("overlay").style.display = "block";
    AppData.style.display = "block";
    AppData.getElementsByTagName("p")[0].innerHTML = appListing.getAttribute("description");
    document.body.style.overflow = "hidden";
}

function dummyDismiss(e)
{
    let x = e.currentTarget.id;
    if (x.valueOf() == "appdata" || x.valueOf() == "signin")
    {
        e.stopPropagation();
    }
}

function dismiss(e)
{
    let x = e.currentTarget.id;
    if (x.valueOf() == "overlay")
    {
        document.getElementById("overlay").style.display = "none";
        document.getElementById("signin").style.display = "none";
        document.getElementById("appdata").style.display = "none";
        document.body.style.overflow = "auto";
    }
}

document.addEventListener("DOMContentLoaded", function() {
    //The first argument are the elements to which the plugin shall be initialized
    //The second argument has to be at least a empty object or a object with your desired options
    OverlayScrollbars(document.querySelectorAll('body'), { });
});
