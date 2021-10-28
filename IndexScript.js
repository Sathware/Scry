function userLogin()
{
    let loginForm = document.forms["userCredentials"];
    let uName = loginForm["username"].value;
    let pWord = loginForm["password"].value;
    if (uName == uName && pWord == "pwd")
    {
        let UserDisplay = document.getElementById("userDisplay");
        UserDisplay.innerHTML = uName;
        UserDisplay.style.visibility = "visible";
        loginForm.style.visibility = "hidden";
    }
    else
    {
        alert("Invalid Credentials");
    }
}

function hideUnusedSections()
{
    let appclusters = document.getElementsByClassName("appCluster");
    for (i = 0; i < appclusters.length; i++)
    {
        let applistings = appclusters[i].getElementsByClassName("applisting");
        let noneShown = true;
        for (k = 0; k < applistings.length; k++)
        {
            if (applistings[i].style.display != "none")
                noneShown = false;
        }

        if (noneShown == true)
            appclusters[i].style.display = "none";
    }
}

function sortBy() {
    let choice = options.value;
    document.getElementById("defaultOption").style.display = "none";
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

function showData(appListing)//In Progress
{
    let AppData = document.getElementById("appdata");
    AppData.getElementsByTagName("h1")[0].innerHTML = appListing.getElementsByTagName("h3")[0].innerHTML;
    AppData.getElementsByTagName("img")[0].setAttribute("src", appListing.getElementsByTagName("img")[0].getAttribute("src"));
    document.getElementById("overlay").style.display = "block";
    document.body.style.overflow = "hidden";
}

function dummyDismiss(e)
{
    let x = e.currentTarget.id;
    if (x.valueOf() == "appdata")
    {
        e.stopPropagation();
    }
}

function dismiss(e)
{
    let x = e.currentTarget.id;
    if (x.valueOf() == "overlay")
    {
        e.currentTarget.style.display = "none";
        document.body.style.overflow = "auto";
    }
}

document.addEventListener("DOMContentLoaded", function() {
    //The first argument are the elements to which the plugin shall be initialized
    //The second argument has to be at least a empty object or a object with your desired options
    OverlayScrollbars(document.querySelectorAll('body'), { });
});
