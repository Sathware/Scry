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

function dummyDismiss(e)
{
    let x = e.currentTarget.id;
    if (x.valueOf() == "appdata" || x.valueOf() == "signin" || x.valueOf() == "apprequest")
    {
        e.stopPropagation();
    }
}

function dismiss(e)
{
    let x = e.currentTarget.id;
    if (x.valueOf() == "overlay")
    {
        document.getElementById("overlay").classList.remove("active");
        document.getElementById("signin").classList.remove("active");
        document.getElementById("appdata").classList.remove("active");
        document.getElementById("apprequest").classList.remove("active");
        document.body.style.overflow = "auto";
    }
}

//MAY NEED TO CHANGE URL UNSURE
function openAdminView()
{
    let username = document.getElementById("userDisplay").innerText.trim().split(" ")[0];
    window.open('admin.php?username='+username);
}

document.addEventListener("DOMContentLoaded", function() {
    //The first argument are the elements to which the plugin shall be initialized
    //The second argument has to be at least a empty object or a object with your desired options
    OverlayScrollbars(document.querySelectorAll('body'), { 
        overflowBehavior : {
            x : "hidden"
        }
    });
});
