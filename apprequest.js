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

    addVersion: function(platformName, version, url)
    {
        this.platforms.get(platformName).set(version, url);
    },

    removeVersion: function(platformName, version)
    {
        this.platforms.get(platformName).delete(version);
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

function displayPreview()
{
    //let testpreview = document.getElementById("preview");
    let previewheader = document.getElementById("previewheader");
    let previewdesc = document.getElementById("previewdesc");
    previewheader.innerText = "$"+previewApp.price+" "+previewApp.name+": ";
    // image.setAttribute("src", previewApp.imgurl);
    previewdesc.innerText = previewApp.desc;
}