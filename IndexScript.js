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

function filterSearch()
{
    let input = document.getElementById("searchbar");
    let filter = input.value.toUpperCase();
    let AppClusters = document.getElementsByClassName("appCluster");
    let AppListings = null;
    
    for (i = 0; i < AppClusters.length; i++)
    {
        if (AppClusters[i].id.charAt(0).valueOf() == filter.charAt(0).valueOf())
        {
            AppClusters[i].style.display = "flex";
            AppListings = AppClusters[i].getElementsByClassName("applisting");
        }
        else
        {
            AppClusters[i].style.display = "none";
        }

        if (filter.length == 0)
        {
            AppClusters[i].style.display = "flex";
        }
    }

    for( i = 0; i < AppListings.length; i++)
    {
        let x = AppListings[i].getAttribute("title").toUpperCase();
        if (x.includes(filter))
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
    document.getElementById("overlay").style.display = "block";
}