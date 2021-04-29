<?php
session_start();

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
}catch(PDOException $e){
    http_error("500 Internal Server Error"."There was a SQL error:" . $e->getMessage());
}

$username = $_SESSION['user'];

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
function runQueryInsert($query, $conn){
    try {
        $q = $conn->prepare($query);
        $q->execute();
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
if(isset($_POST['editUser'])){
	$username = $_SESSION['user'];
	$newuser = $_POST['newuser'];
	$updateQuery = "UPDATE 218User SET userName='$newuser' WHERE userName='$username';";
	$updateTaskQuery = "UPDATE 218Task SET userName='$newuser' WHERE userName='$username';";
	try{
        runQueryInsert($updateQuery, $conn);
        runQueryInsert($updateTaskQuery, $conn);
        $_SESSION['user']=$newuser;
        ?>
        <script>
        let newuser = "<?php echo $newuser ?>";
        sessionStorage.setItem("user", String(newuser));
        alert('New Username Changed');
        window.location.href='Settings.html';
        </script>
        <?php
    }catch (PDOException $e){
        echo "<script>alert('$e');</script>";
    }
}
if(isset($_POST['editPass'])){
	$username = $_SESSION['user'];
    $newpass = $_POST['newpass'];
	$updateQuery = "UPDATE 218User SET pass='$newpass' WHERE userName='$username';";
	try{
        runQueryInsert($updateQuery, $conn);
        ?>
        <script>
        alert('New Password Changed');
        window.location.href='Settings.html';
        </script>
        <?php
    }catch (PDOException $e){
        echo "<script>alert('$e');</script>";
    }
}
?>