<?php
session_start();

//session_unset();

class Blog
{
    public $blogMain;
    public $con;

    function connect()
    {
        $this->con = new mysqli("localhost", "root", "", "blogdb");
        if (mysqli_connect_errno()) {
            echo "Failed to connect: " . mysqli_connect_error();
        }
    }

    function logIn()
    {
        if (!empty($_POST['Username']) && !empty($_POST['Password'])) {
            $username = $_POST['Username'];
            $password = $_POST['Password'];
            $dbPassword = $this->con->query("SELECT Password FROM members WHERE Username = '$username'");
            while ($row = $dbPassword->fetch_array()) {
                $checkPassword = $row['Password'];
            }
            if ($checkPassword == $password) {
                $_SESSION['memUserName'] = $username;
            } else $_SESSION['memUserName'] = '';
        }
    }

    function show()
    {
        echo "<body>";
        echo "<h1>Blog Title</h1>";
        echo <<<EOT
        <form action= 'Blog.php' method="post">
            <input type="text" name="Username">
            <input type="text" name="Password">
            <input type="submit" name="submitLogIn" value="Login">
        </form>
EOT;
        echo "<p>Date + Author</p>";
        echo "<p>Entry content</p>";
        echo "</body>";
        echo $_SESSION['memUsername'];
    }

    function disconnect()
    {
        $this->con->close();
    }
}

if (empty($_SESSION['blogMain'])) {
    $_SESSION['blogMain'] = new Blog();
}

$blogMain = $_SESSION['blogMain'];
$blogMain->connect();
$blogMain->logIn();
$blogMain->show();
$blogMain->disconnect();

?>