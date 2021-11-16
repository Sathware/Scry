function search()
{
    let input = document.getElementById("searchbar");
    let filter = input.value.toUpperCase();
    let AppListings = document.getElementsByClassName("applisting");

    for(let i = 0; i < AppListings.length; i++)
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

function sort(select)
{
    let Apps = document.getElementById("apps");
    let applistings = Array.from(document.getElementsByClassName("applisting"));
    let temp = applistings[0].getAttribute("price");
    if (select.value == "Alphabetical Descending")
    {
        applistings.sort(function (a, b) {
            return a.getAttribute("title").localeCompare(b.getAttribute("title"));
        });
    }
    else if (select.value == "Alphabetical Ascending")
    {
        applistings.sort(function (a, b) {
            return b.getAttribute("title").localeCompare(a.getAttribute("title"));//b and a are switched in localecompare
        });
    }
    else if (select.value == "Price")
    {
        applistings.sort(function (a, b) {
            return parseInt(a.getAttribute("price")) - parseInt(b.getAttribute("price"));
        });
    }
    applistings.forEach(app => Apps.appendChild(app));
}

function showSignIn()
{
    document.getElementById("overlay").classList.add("active");
    document.getElementById("signin").classList.add("active");
    document.body.style.overflow = "hidden";
}

function showRequest()
{
    document.getElementById("overlay").classList.add("active");
    document.getElementById("apprequest").classList.add("active");
    document.body.style.overflow = "hidden";
}