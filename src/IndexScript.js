function login(name, pass)
{
    return pass == "pwd";
}

function filter(input, applistings)
{
    let filter = input.toUpperCase();
    let count = 0;

    for( i = 0; i < applistings.length; i++)
    {
        let x = applistings[i].toUpperCase();
        if (x.includes(filter))
        {
            count++;
        }
    }

    return count;
}

