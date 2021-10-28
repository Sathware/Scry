describe("User Login", function()
{
    it("should allow login if password = pwd", function()
    {
        expect(login("Boris", "pwd")).toEqual(new Boolean(true));
    });

    it("should not allow login if password != pwd", function()
    {
        expect(login("Boris", "pass")).toEqual(new Boolean(false));
    });

    it("should allow any username as long as password = pwd", function()
    {
        expect(login("Boris", "pwd")).toEqual(new Boolean(true));
        expect(login("Yeeticus", "pwd")).toEqual(new Boolean(true));
    });
});

describe("Filtering by name", function()
{
    it("should return the correct number of apps to be shown", function()
    {
        expect(filter("spotify", new Array("Spotify", "spotify", "bank", "boris"))).toEqual(2);
        expect(filter("spotify", new Array("yyeticus", "toni", "bank", "boris"))).toEqual(0);
    });
    
});