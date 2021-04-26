<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');

// AFS login
 $hostname = "sql1.njit.edu";
 $username = "yt249";
 $password = "A_zxc19981128!";
 $dbname = "yt249";

// local
// $hostname = "localhost";
// $username = "root";
// $password = "";
// $dbname = "SpringBreak";


try{
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    if($conn != null){
        echo "<script>alert('successfully connected');</script>";
        echo"<br>";
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
} catch(PDOException $e){
    http_error("500 Internal Server Error"."There was a SQL error:" . $e->getMessage());
}

console.log("hi this is a test");

    $username = $_POST['username'];
    $pass = $_POST['password'];

console.log("test2");

try {
    $checkUserQuery = "SELECT password from 218User WHERE username = '$username' OR email = '$username'";
    $results = runQuery($checkUserQuery, $conn);

    foreach ($results as $result){
         echo"<script>alert($result[password])</script>";
    }

    // echo "<script>alert($result);</script>";
   // echo "<script>alert($password);</script>";

    if (count($results) == 1) {
        if ($result['password'] == $password) {
            echo "<script>
                     alert('welcome to our website');
                     window.location.href='home.html';
                   </script>";
        } else {
            echo "<script>alert('incorrect password');</script>";
            echo "<script>
                    window.location.href='login.html';
                  </script>";
        }
    } else {
        echo "<script>alert('user not found');</script>";
        echo "<script>
                window.location.href='login.html';
              </script>";
    }
} catch (PDOException $e){
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