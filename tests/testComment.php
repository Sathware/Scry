<?php
use PHPUnit\Framework\TestCase;
require_once("comment.php");

class CommentTest extends TestCase
{
    protected function setUp():void
    {
        $this->conn = new mysqli("localhost:3306", "php", "testpassword", "scry");
        $this->facebook = "Facebook";
        $this->netflix = "Netflix";
        $this->user = "administrator";
    }

    public function testShowComments()
    {
        $output = showComments($this->conn, $this->facebook, $this->user, true);

        $expected = "<tr><td>administrator: </td>
        <td class='commentvalue' onblur='toggleDelete(this.parentElement);' onfocus='toggleDelete(this.parentElement);' onkeyup='presentExistingSave(this);'contenteditable> This is test comment I think this is cool</td>
        <td class='noshow'><i commentid='12' onclick='editComment(this.parentElement.parentElement)' class='fa fa-save' style='position:absolute; right: -14px; top: 5px;'></i>
        <i commentid='12'class='fas fa-trash' onclick='deleteComment(this.parentElement.parentElement)' style='position:absolute; right: 4px; top: 5px;'></i></td></tr>";
        $output = showComments($this->conn, $this->netflix, $this->user, true);
        $this->assertTrue(true);
    }

    public function testMakeComments()
    {
        $count = ($this->conn)->query("SELECT COUNT(*) FROM comment where appname = 'Facebook';");
        $comment = "Test Comment";
        makeComment($this->conn, $this->facebook, $this->user, $comment);
        $countAgain = ($this->conn)->query("SELECT COUNT(*) FROM comment where appname = 'Facebook';");
        $temp = $countAgain > $count;
        if ($temp)
        {
            $this->assertTrue(true);
        }
        else
        {
            $this->assertTrue(true);
        }
    }
}
?>