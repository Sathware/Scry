const previewApp = {
    name: "Lorem",
    price: "0",
    desc: "Lorem Ipsum",
    imgurl: "blank.png",
    dev: "Lorem",
    categories: new Array(),
    platforms: new Map(),

    addPlatform: function(platformName)
    {
        this.platforms.set(platformName, new Map());
    },

    removePlatform: function(platformName)
    {
        this.platforms.delete(platformName);
    },

    updateVersion: function(platformName, version, url)
    {
        this.platforms.get(platformName).set(version, url);
    },

    removeVersion: function(platformName, version)
    {
        this.platforms.get(platformName).delete(version);
    }
}

function filterRequestCategory(value)
{
    let categories = document.getElementById("requestcategories").getElementsByTagName("li");
    let count = 0;
    for (let i = 0; i < categories.length; i++)
    {
        if (categories[i].innerText.substring(0, value.length).toUpperCase().includes(value.toUpperCase()))
        {
            categories[i].style.display = "block";
        }
        else
        {
            categories[i].style.display = "none";
            count++;
        }
    }

    if (count == categories.length)
    {
        document.getElementById("newCategory").style.display = "block";
    }
    else
    {
        document.getElementById("newCategory").style.display = "none";
    }
}

function toggleRequestCategory(catListing)
{
    if (catListing.classList.contains('active'))
    {
        let index = previewApp.categories.indexOf(catListing.innerText);
        if (index > -1)
        {
            previewApp.categories.splice(index, 1);
        }
    }
    else
    {
        previewApp.categories.push(catListing.innerText);
    }
    catListing.classList.toggle('active');
    displayPreview();
}

function newRequestCategory()
{
    let userinput = document.getElementById("textRequestCategory").value;
    document.getElementById("requestcategories").innerHTML += "<li onclick='toggleRequestCategory(this);' class='categoryListing active'>" + userinput + "</li>";
    document.getElementById("newCategory").style.display = "none";
    previewApp.categories.push(userinput);
    displayPreview();
}

//Platform
function filterRequestPlatform(value)
{
    let platforms = document.getElementById("requestplatforms").getElementsByTagName("li");
    let count = 0;
    for (let i = 0; i < platforms.length; i++)
    {
        if (platforms[i].innerText.substring(0, value.length).toUpperCase().includes(value.toUpperCase()))
        {
            platforms[i].style.display = "block";
        }
        else
        {
            platforms[i].style.display = "none";
            count++;
        }
    }

    if (count == platforms.length)
    {
        document.getElementById("newPlatform").style.display = "block";
    }
    else
    {
        document.getElementById("newPlatform").style.display = "none";
    }
}

function toggleRequestPlatform(platListing)
{
    if (platListing.classList.contains('active'))
    {
        removeVersionsTable(platListing.innerText);
        previewApp.platforms.delete(platListing.innerText);
    }
    else
    {
        addVersionsTable(platListing.innerText);
        previewApp.addPlatform(platListing.innerText);
    }
    platListing.classList.toggle('active');
    displayPreview();
}

function newRequestPlatform()
{
    let userinput = document.getElementById("textRequestPlatform").value;
    document.getElementById("requestplatforms").innerHTML += "<li onclick='toggleRequestPlatform(this);' class='Listing active'>" + userinput + "</li>";
    document.getElementById("newPlatform").style.display = "none";
    addVersionsTable(platListing.innerText);
    previewApp.addPlatform(userinput);
    displayPreview();
}

function addVersionsTable(name)
{
    let newtable = document.createElement("table");
    newtable.classList.add("editableversions");
    newtable.setAttribute("name", name);
    newtable.innerHTML = '<tr><th>Version</th><th>URL</th><th><label>'+name+'</label></th><th><i class="fas fa-plus" onclick="addVersionRow(this.parentElement.parentElement.parentElement);"></i></th></tr>';
    document.getElementById("platformversion").appendChild(newtable);
    return newtable;
}

function removeVersionsTable(name)
{
    let tables = document.getElementById("platformversion").getElementsByTagName("table");
    for (let i = 0; i < tables.length; i++)
    {
        if (tables[i].getAttribute("name") == name)
        {
            tables[i].remove();
            return;
        }
    }
}

function updateName(value)
{
    previewApp.name = value;
    displayPreview();
}

function updatePrice(value)
{
    previewApp.price = value;
    displayPreview();
}

function updateDesc(value)
{
    previewApp.desc = value;
    displayPreview();
}

function updateImg(value)
{
    previewApp.imgurl = value;
    displayPreview();
}

function updateDev(value)
{
    previewApp.dev = value;
    displayPreview();
}

function updateVersions(table, row)
{
    let userinput = row.getElementsByTagName("td");
    previewApp.removeVersion(table.getAttribute("name"), userinput[0].getAttribute("prev"));//This is to prevent each update the user makes to a row be stored as a separate key-value pair
    previewApp.updateVersion(table.getAttribute("name"),userinput[0].innerText,userinput[1].innerText);
    userinput[0].setAttribute("prev", userinput[0].innerText);
    displayPreview();
}

function deleteVersions(table, row)
{
    let chosenVersion = row.getElementsByTagName("td");
    previewApp.removeVersion(table.getAttribute("name"), chosenVersion[0].innerText);
    row.remove();
    displayPreview();
}

function addVersionRow(table)
{
    let newRow = document.createElement("tr");

    let versionfield = document.createElement("td");
    versionfield.contentEditable = "true";
    versionfield.setAttribute("onfocus", "toggleVersionDelete(this.parentElement);");
    versionfield.setAttribute("onblur", "toggleVersionDelete(this.parentElement);");
    versionfield.setAttribute("prev", "");
    versionfield.setAttribute("onkeyup", "updateVersions(this.parentElement.parentElement.parentElement, this.parentElement);");//You need three to access table and not tbody
    newRow.appendChild(versionfield);

    let urlfield = document.createElement("td");
    urlfield.contentEditable = "true";
    urlfield.setAttribute("onfocus", "toggleVersionDelete(this.parentElement);");
    urlfield.setAttribute("onblur", "toggleVersionDelete(this.parentElement);");
    urlfield.setAttribute("onkeyup", "updateVersions(this.parentElement.parentElement.parentElement, this.parentElement);");
    newRow.appendChild(urlfield);

    let hidden = document.createElement("td")
    hidden.classList.add("noshow");
    hidden.innerHTML = '<i class="fas fa-trash" onclick="deleteVersions(this.parentElement.parentElement.parentElement.parentElement, this.parentElement.parentElement);"></i>';
    newRow.appendChild(hidden);

    table.appendChild(newRow);
    return newRow;
}

function toggleVersionDelete(row)
{
    row.getElementsByTagName("i")[0].classList.toggle("active");
}

function displayPreview()
{
    //let testpreview = document.getElementById("preview");
    let previewheader = document.getElementById("previewheader");
    let previewdesc = document.getElementById("previewdesc");
    let previewimage = document.getElementById("previewimg");
    let previewcategories = document.getElementById("previewcategories");
    let previewplatforms = document.getElementById("previewplatforms");
    previewheader.innerText = "$"+previewApp.price+" "+previewApp.name+": ";
    previewimage.setAttribute("src", previewApp.imgurl);
    previewdesc.innerText = previewApp.desc;

    previewcategories.innerHTML = "";
    for (let i = 0; i < previewApp.categories.length; i++)
    {
        previewcategories.innerHTML += "<li>" + previewApp.categories[i] + "</li>";
    }

    previewplatforms.innerHTML = "";
    let x = ""//Necessary since tags are autoclosed if you directly use innerHTML
    previewApp.platforms.forEach(
        function (versions, platform)
        {
            x += "<div class='platforminstance'><label>"+platform+"<i class='fas fa-caret-down'> </i></label><div class='previewlinks'>";
            versions.forEach(
                function (url, version)
                {
                    x += "<a href='"+url+"' target='_blank'>"+version+"</a>";
                }
            );
            x += "</div></div>";
        }
    );
    previewplatforms.innerHTML = x;
}

//https://stackoverflow.com/questions/29085197/how-do-you-json-stringify-an-es6-map
function replacer(key, value) {
    if(value instanceof Map) {
      return {
        dataType: 'Map',
        value: Array.from(value.entries()), // or with spread: value: [...value]
      };
    } else {
      return value;
    }
}

function reviver(key, value) {
    if(typeof value === 'object' && value !== null) {
      if (value.dataType === 'Map') {
        return new Map(value.value);
      }
    }
    return value;
}

function sendrequest()
{
    let userName = document.getElementById("userDisplay").innerText.trim();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200)
        {
            if (this.responseText == "error")
            {
                alert("Request failed, try signing in again");
            }
            else
            {
                alert("Request sent successfully");
            }
        }
    };
    let params = "username="+userName+"&appjson="+JSON.stringify(previewApp, replacer);
    xmlhttp.open("POST", "request.php", true);//!!!!!!!!!!!!CHANGE URL !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.send(params);
}