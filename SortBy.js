function sortBy() {
    // Get choice from sortByFeature form
    let sortForm = document.forms["sortByFeature"];
    let choice = sortForm["options"].value;
    let AppListings = document.getElementsByClassName("applisting");
    let arrayToSort = new Array()
    for (var i=0;i<AppListings.length;i++) {
        let names = AppListings[i].getAttribute("title");
        let prices = parseInt(AppListings[i].getAttribute("price"));
        let category = AppListings[i].getAttribute("category");
        let headers = document.getElementById("headertag" + i);
        arrayToSort[i] = [names, prices, category, headers.innerText];
    }
    // If users choose to sort by aphabetical order of app name
    if (choice == "alphabetical") {
        arrayToSort.sort(function(a,b){return a[0].localeCompare(b[0]);});
    }
    else if (choice == "price") {
        arrayToSort.sort(function(a,b){return a[1] - b[1];});
    }
    else if (choice == "category") {
        arrayToSort.sort(function(a,b){return a[2].localeCompare(b[2]);});
    }
    for (var i=0;i<arrayToSort.length;i++) {
        console.log(arrayToSort[i]);
        let header = document.getElementById("headertag" + i);
        header.innerText = arrayToSort[i][3];            
        AppListings[i].setAttribute("title", arrayToSort[i][0]);
        AppListings[i].setAttribute("price", arrayToSort[i][1].toString());
        AppListings[i].setAttribute("category", arrayToSort[i][2]);
    }
}