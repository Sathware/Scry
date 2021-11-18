function filterAppsByCategories()
{
    let applistings = document.getElementsByClassName("applisting");
    let selectedCategories = getSelectedCategories();
    for (let i = 0; i < applistings.length; i++)
    {
        let appcategories = applistings[i].getAttribute("categories").split(",");
        if (hasAllCategories(appcategories, selectedCategories))//infinite loop
        {
            applistings[i].style.display = "block";
        }
        else
        {
            applistings[i].style.display = "none";
        }
    }
}

function toggleCategories()
{
    let list = document.getElementById("categoryContainer");
    if (list.classList.contains("active"))
    {
        list.classList.remove("active");
    }
    else
    {
        list.classList.add("active");
    }
}

function toggleCheck(category)
{
    if (category.classList.contains("active"))
    {
        category.classList.remove("active");
    }
    else
    {
        category.classList.add("active");
    }
    filterAppsByCategories();
}

function getSelectedCategories()
{
    let categorylistings = document.getElementsByClassName("categoryListing");
    let selectedCategories = new Array();
    for (let i = 0; i < categorylistings.length; i++)
    {
        if (categorylistings[i].classList.contains("active"))
        {
            selectedCategories.push(categorylistings[i].innerText.trim());
        }
    }
    return selectedCategories;
}

function filterCategories(filter)
{
    let categorylistings = document.getElementsByClassName("categoryListing");
    for (let i = 0; i < categorylistings.length; i++)
    {
        if (categorylistings[i].innerText.substring(0, filter.length).includes(filter))
        {
            categorylistings[i].style.display = "block";
        }
        else
        {
            categorylistings[i].style.display = "none";
        }
    }
}

function filterByPrice()
{
    let maxPrice = parseInt(document.getElementById("priceSelector").value);
    let applistings = document.getElementsByClassName("applisting");
    for (let i = 0; i < applistings.length; i++)
    {
        if (maxPrice >= parseInt(applistings[i].getAttribute("price")))
        {
            applistings[i].style.display = "block";
        }
        else
        {
            applistings[i].style.display = "none";
        }
    }
}