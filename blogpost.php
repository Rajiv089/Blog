<?php
class post
{
    public $con;

    function connect()
    {
        $this->con = new mysqli("localhost", "root", "", "blogdb");
        if (mysqli_connect_errno()) {
            echo "Failed to connect: " . mysqli_connect_error();
        }
    }

    function getPostTitle()
    {
        if($stmt = $this->con->prepare("SELECT PostTitle, PostContent FROM post")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($dbPostTitle, $dbPostContent);
            while($stmt->fetch()){
                echo "<h2>" . $dbPostTitle . "</h2>";
                echo "<p>" . $dbPostContent . "</p>";
            }
            $stmt->close();
        }
    }

    function disconnect()
    {
        $this->con->close();
    }
}
?>