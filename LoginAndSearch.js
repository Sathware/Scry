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
    let AppListings = document.getElementsByClassName("applisting");
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
}