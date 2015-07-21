<?php

class blogmain
{
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
            if($stmt = $this->con->prepare("SELECT Password FROM members WHERE Username = ?")){
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($checkedPassword);
                while($stmt->fetch()){
                    $checkPassword = $checkedPassword;
                }
                $stmt->close();
            }
            if ($checkPassword == $password) {
                $_SESSION['memUsername'] = $username;
            } else $_SESSION['memUsername'] = '';
        }
    }

    function show()
    {
        if(!empty($_SESSION['memUsername'])){
            echo $_SESSION['memUsername'];
        }
    }

    function disconnect()
    {
        $this->con->close();
    }
}

?>