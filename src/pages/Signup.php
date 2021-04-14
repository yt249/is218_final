<?php

// AFS login
// $hostname = "sql1.njit.edu";
// $username = "yt249";
// $password = "A_zxc19981128!";
// $dbname = "yt249";

// local
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "SpringBreak";

try{
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    if($conn != null){
        echo "<script>alert('successfully connected');</script>";
        echo"<br>";
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}catch(PDOException $e){
    http_error("500 Internal Server Error"."There was a SQL error:" . $e->getMessage());
}

$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$username = $_POST['username'];
$pass = $_POST['pwd'];
$email = $_POST['email'];

$checkUserNameQuery = "SELECT * FROM 218User WHERE userName='$username'";
$checkEmailQuery = "SELECT * FROM 218User WHERE email='$email'";
$insertQuery = "INSERT INTO 218User (firstName, lastName, email, userName, pass)
                VALUES ('$fname', '$lname', '$email', '$username', '$pass');";

$duplicate = false;
$error = "";

try{
    if (count(runQuery($checkEmailQuery, $conn)) === 1){
        $error .= 'email already exists\n';
        $duplicate = true;
    };
    if (count(runQuery($checkUserNameQuery, $conn)) === 1){
        $error .= 'user name already exists';
        $duplicate = true;
    };
    if ($error==""){
        runQuery($insertQuery, $conn);
    }else{
        echo ("<script>
   				 window.alert('$error');
   				 window.location.href='Signup.html';
   			   </script>");
    }
}catch (PDOException $e){
    echo "<script>alert('$e');</script>";
}

function runQuery($query, $conn){
    try {
        $q = $conn->prepare($query);
        $q->execute();
        $results = $q->fetchAll();
        $q->closeCursor();
        return $results;
    } catch (PDOException $e) {
        http_error("500 Internal Server Error\n\n"."There was a SQL error:\n\n" . $e->getMessage());
    }
}

function http_error($message) {
    header("Content-type: text/plain");
    die($message);
}
?>
