<?php
session_start();

class register
{

    public $con;
    public $username;
    public $password;
    public $email;
    public $namePass;
    public $succes;

    function connect()
    {
        $this->con = new mysqli("localhost", "root", "", "blogdb");
        if (mysqli_connect_errno()) {
            echo "Failed to connect: " . mysqli_connect_error();
        }
    }

    function Register()
    {
        if (!empty($_POST['Username']) && !empty($_POST['Password']) && !empty($_POST['Email'])) {
            $this->username = $_POST['Username'];
            $this->password = $_POST['Password'];
            $this->email = $_POST['Email'];
            $checkUserName = "";
            $dbUserName = $this->con->query("SELECT Username FROM members WHERE Username= '$this->username'");
            while ($row = $dbUserName->fetch_array()) {
                $checkUserName = $row['Username'];
            }

                if ($checkUserName == $this->username) {
                 echo "Username already exist, please try again";
                }
                else {
                    $this->con->query("INSERT INTO members (Email, Username, Password, user_level) VALUES ('$this->email', '$this->username', '$this->password', 2)");
                    echo "test";
                }

        }


    }

    function show()
    {
        echo "<body>";
        echo "<h1>Register</h1>";
        echo <<<EOT
        <form action= 'register.php' method="post">
            <p>Enter Email     <input type="text" name="Email"><br></p>
            <p>Enter Username  <input type="text" name="Username"><br></p>
            <p>Enter Password  <input type="text" name="Password"><br><br></p>
            <input type="submit" name="submitLogIn" value="Register!">
        </form>
EOT;
    }

    function disconnect()
    {
        $this->con->close();
    }
}

if (empty($_SESSION['register'])) {
    $_SESSION['register'] = new register();
}

$register = $_SESSION['register'];
$register->connect();
$register->Register();
$register->show();
$register->disconnect();

?>


