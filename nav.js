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

function showSignIn()
{
    document.getElementById("overlay").classList.add("active");
    document.getElementById("signin").classList.add("active");
    document.body.style.overflow = "hidden";
}