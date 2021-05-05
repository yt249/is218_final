<?php

session_start();
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
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
} catch(PDOException $e){
    http_error("500 Internal Server Error"."There was a SQL error:" . $e->getMessage());
}

$user = $_POST['username'];
$pass = $_POST['password'];

try {
    $checkUserQuery = "SELECT * from 218User WHERE userName = '$user' OR email = '$user'";
    $results = runQuery($checkUserQuery, $conn);

    if (count($results) == 1) {
        if ($results[0]['pass'] == $pass) {
        $user = $results[0]['userName'];
        $firstname = $results[0]['firstName'];
        $lastname = $results[0]['lastName'];
        ?>
        <script>
        let user = "<?php echo $user ?>";
        let firstname = "<?php echo $firstname ?>";
        let lastname = "<?php echo $lastname ?>";
        sessionStorage.setItem("login", "true");
        sessionStorage.setItem("user", String(user));
        sessionStorage.setItem("firstname", String(firstname));
        sessionStorage.setItem("lastname", String(lastname));
        alert(firstname + ", welcome to our website");
        window.location.href='Todo.php';
        </script>
        <?php
        $_SESSION['user']=$user;
//         	$_SESSION["login"]=true;
//             $_SESSION["user"]=$results[0]['userName'];
//             echo "<script>
//                      alert('welcome to our website');
//                      window.location.href='Todo.php';
//                    </script>";
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