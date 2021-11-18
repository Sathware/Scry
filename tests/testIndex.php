<?php
use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{

    protected function setUp(): void
    {
        //"localhost:3306", "php", "testpassword", "scry"
        $this->url = "localhost:3306";
        $this->user = "php";
        $this->password = "testpassword";
        $this->dbname = "scry";
    }

    public function testDatabaseConnection()
    {
        $conn = new mysqli($this->url, $this->user, $this->password, $this->dbname);
        $this->assertEquals($conn->connect_error, "");
    }

    public function testLogin()
    {
        $conn = new mysqli($this->url, $this->user, $this->password, $this->dbname);
        $conn->query("SELECT user.type FROM user WHERE user.nam = 'administrator';");
        if ($conn->error == "")
        {
            $this->assertTrue(true);
        }
        else
        {
            $this->assertFalse(false);
        }
    }
}
?>
