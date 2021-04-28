<script>
    let login = sessionStorage.getItem("login"); // return "true"
    let user = sessionStorage.getItem("user");
    let firstname = sessionStorage.getItem("firstname");
    let lastname = sessionStorage.getItem("lastname");
    if(login !== "true"){
        alert("You have not logged in");
        window.location.href = "login.html";
    }
</script>
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
    $newpass = $_POST['newpass'];
	$updateQuery = "UPDATE 218Task SET userName='$newuser', pass='$newpass' WHERE userName='$username';";
	if ($id == ""){
		echo "<script>alert('Please select a row to be deleted');</script>";
	}else{
		try{
    		//update table
    		runQueryInsert($updateQuery, $conn);
    		$_SESSION['user']=$newuser;
            ?>
            <script>
            let newuser = "<?php echo $newuser ?>";
            sessionStorage.setItem("user", String(newuser));
            alert('Edited');
            window.location.href='*';
            </script>
            <?php
		}catch (PDOException $e){
    		echo "<script>alert('$e');</script>";
		}
	}
}
?>

<div class = "row">
    <div class = "col-10">

    </div>

    <div class = "col-2" style="text-align:center;">
        <p id="userdiv">Username</p>
    </div>
</div>
<div class="row">
    <div class="col-sm-4  text-center">
        <h2>My Profile </h2>

    </div>
</div>

<script>
    // Current product being edited
    document.getElementById('userdiv').innerText = firstname + ' ' + lastname;

    function logout(){
            sessionStorage.clear();
            alert("You've successfully logged out.");
            window.location.href = "login.html";
        }
</script>