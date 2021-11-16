function showData(appListing)//In Progress, need to figure out price and categories
{
    let AppData = document.getElementById("appdata");
    appName = appListing.getElementsByTagName("h3")[0].innerText;
    AppData.getElementsByTagName("h1")[0].innerText = appName;
    AppData.getElementsByTagName("img")[0].setAttribute("src", appListing.getElementsByTagName("img")[0].getAttribute("src"));
    document.getElementById("overlay").classList.add("active");
    AppData.classList.add("active");
    AppData.getElementsByTagName("p")[0].innerText = appListing.getAttribute("description");
    document.body.style.overflow = "hidden";
    showComments(appName);
}

//!!!!!!! CHANGE URL
function showComments(appName)
{
    let userName = "";
    if (document.getElementById("userDisplay") != null) {
        userName = document.getElementById("userDisplay").innerText.trim();
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("comments").innerHTML = this.responseText;
      }
    };
    let params = "appname="+appName+"&action=show"+"&username="+userName;
    xmlhttp.open("POST", "comment.php", true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.send(params);
    return [xmlhttp, params];
}

// function showSave(commentfield)
// {
//     commentfield.innerHTML += "<i class='fas fa-save'></i>";
// }

function makeComment()
{
    let comment = document.getElementById("commentfield").innerText.trim();
    let appName = document.getElementById("appName").innerText.trim();
    let userName = document.getElementById("userDisplay").innerText.trim();
    if (comment == "")
    {
        alert("Comment cannnot be empty.");
        return;
    }
    if (comment != null)
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == "error")
                {
                    alert("Your comment could not be made. Try Again Later.");
                }
                else
                {
                    let temp = "<tr><td>"+userName+": </td><td class='commentvalue' onkeyup='presentExistingSave(this);' contenteditable> "+comment+
                    "</td><td class='noshow'><i commentid='"+this.responseText+"' onclick='editComment(this.parent)' class='fa fa-save' style='position:absolute; right: 4px; top: 5px;'></i></td></tr>";
                    document.getElementById("comments").innerHTML += temp;
                }
            }
        };
        let params = "appname=" + appName + "&action=make&comment="+comment+"&username="+userName;
        xmlhttp.open("POST", "comment.php", true);
        xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xmlhttp.send(params);
    }
}

function editComment(commentElement)
{
    let comment = commentElement.getElementsByTagName("td")[1].innerText.trim();
    let appName = document.getElementById("appName").innerText.trim();
    let userName = document.getElementById("userDisplay").innerText.trim();
    let commentid = commentElement.getElementsByTagName("i")[0].getAttribute("commentid");
    if (comment != null)
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200)
            {
                if (this.responseText == "error")
                {
                    alert("You cannot edit a comment that's not yours. Please sign in or logout and sign in.")
                }
                else
                {
                    commentElement.getElementsByTagName("i")[0].classList.remove("active");
                }
            }
        };
    }
    let params = "appname="+appName+"&action=edit&comment="+comment+"&username="+userName+"&commentid="+commentid;
    xmlhttp.open("POST", "comment.php", true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.send(params);
}

function deleteComment(commentElement)
{
    let appName = document.getElementById("appName").innerText.trim();
    let userName = document.getElementById("userDisplay").innerText.trim();
    let commentid = commentElement.getElementsByTagName("i")[0].getAttribute("commentid");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200)
        {
            if (this.responseText == "error")
            {
                alert("You cannot delete a comment that's not yours. Please sign in or logout and sign in.")
            }
            else
            {
                commentElement.remove();
            }
        }
    };
    let params = "appname="+appName+"&action=delete&username="+userName+"&commentid="+commentid;
    xmlhttp.open("POST", "comment.php", true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.send(params);
}

function presentExistingSave(editable)
{
    let parent = editable.parentElement;
    let saveicon = parent.getElementsByTagName("i")[0];
    if (!saveicon.classList.contains("active"))
    {
        saveicon.classList.add("active");
    }
}

function presentSave(textfield)
{
    if (textfield.innerText == "")
    {
        document.getElementById("saveNewComment").classList.remove("active");
    }
    else
    {
        document.getElementById("saveNewComment").classList.add("active");
    }
}

function toggleDelete(tablerow)
{
    let trash = tablerow.getElementsByTagName("i")[1];
    trash.classList.toggle("active");
}

function hasAllCategories(appcategories, selectedcategories)
{
    if (selectedcategories.length > appcategories.length)
    {
        return false;
    }
    
    let output = true;
    for (let i = 0; output && (i < selectedcategories.length); i++)
    {
        output = appcategories.includes(selectedcategories[i]);
    }
    return output;
}

function filterAppsByCategories()
{
    let applistings = document.getElementsByClassName("applisting");
    let selectedCategories = getSelectedCategories();
    for (let i = 0; i < applistings.length; i++)
    {
        let appcategories = applistings[i].getAttribute("categories").split(" ");
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