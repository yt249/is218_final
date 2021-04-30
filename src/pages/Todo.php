<head>
    <meta charset="UTF-8">
    <title>Project-Task Manager</title>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
          crossorigin="anonymous">
    <link href="css/main.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="navbar navbar-expand-md
                    justify-content-start
                    bg-dark navbar-dark
                    col-12">

            <!-- Brand -->
            <a class="navbar-brand" href="Todo.php">Task Manager</a>
            <!-- Responsive Button for the smaller menu -->
            <button class="navbar-toggler" type="button"
                    data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ml-auto">
                    <!-- Links -->
                    <li class="nav-item">
                        <a class="nav-link" href="Todo.php">To-Do</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Completed.php">Completed</a>
                    </li>

                    <!-- Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="Completed.php" id="navbardrop"
                           data-toggle="dropdown">
                            More
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="MyProfile.html">My Profile(Personal Info)</a>
                            <a class="dropdown-item" href="Settings.html">Settings</a>
                            <a class="dropdown-item" onclick="logout()">Logout</a>

                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
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
//
// if(isset($_SESSION["login"]) != true){
//     echo "<script>
//             alert('You have not logged in');
//             window.location.href='login.html';
//           </script>";
// }

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

$createQuery = "CREATE TABLE IF NOT EXISTS 218Task(
                    taskid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(255) NOT NULL,
                    title VARCHAR(255) NOT NULL,
                    descr VARCHAR(255) NOT NULL,
                    dueDate DATETIME NOT NULL,
                    urgency VARCHAR(20) NOT NULL,
                    completed BOOLEAN NOT NULL)";

$error = "";
if(isset($_POST['submit'])){
	//$username = $_POST['username'];
	$taskname = $_POST['taskName'];
	$taskdescrip = $_POST['taskDescrip'];

	//datetime format has to be yyyy-mm-dd(yyyy/mm/dd) hh:mm:ss (string type)
	$duedate = $_POST['dueDate'];
	$taskurgency = $_POST['priority'];
	$username = $_SESSION['user'];

	$insertQuery = "INSERT INTO 218Task (userName, title, descr, dueDate, urgency, completed)
              	    VALUES ('$username', '$taskname', '$taskdescrip', '$duedate', '$taskurgency', false);";
	try{
		//add task
    	runQueryInsert($insertQuery, $conn);
    	echo "<script>alert('Successfully added!');</script>";
	}catch (PDOException $e){
    	echo "<script>alert('$e');</script>";
	}
}
if(isset($_POST['submitedit'])){
	//$username = $_POST['username'];
	$taskname = $_POST['editTaskName'];
	$taskdescrip = $_POST['editDescription'];
	$id = $_POST['stored'];

	//datetime format has to be yyyy-mm-dd(yyyy/mm/dd) hh:mm:ss (string type)
	$duedate = $_POST['editDueDate'];
	$taskurgency = $_POST['editPriority'];
	$completed = $_POST['editCompleted'];
	$username = $_SESSION['user'];

	$updateQuery = "UPDATE 218Task SET title='$taskname', descr='$taskdescrip', dueDate='$duedate', urgency='$taskurgency', completed=$completed
					WHERE taskid=$id AND userName='$username';";
	if ($id == ""){
		echo "<script>alert('Please select a row to be edited');</script>";
	}else{
		try{
    		//update table
    		runQueryInsert($updateQuery, $conn);
		}catch (PDOException $e){
    		echo "<script>alert('$e');</script>";
		}
	}
}
if(isset($_POST['submitdelete'])){
	$id = $_POST['stored'];
	$username = $_SESSION['user'];
	$updateQuery = "DELETE FROM 218Task WHERE taskid=$id AND userName='$username';";
	if ($id == ""){
		echo "<script>alert('Please select a row to be deleted');</script>";
	}else{
		try{
    		//update table
    		runQueryInsert($updateQuery, $conn);
		}catch (PDOException $e){
    		echo "<script>alert('$e');</script>";
		}
	}
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
?>
    <div class = "row">
    <div class = "col-10">

    </div>

    <div class = "col-2" style="text-align:center;">
        <p id="userdiv">Username</p>
    </div>
    </div>


    <div class = "row">
    <//img class = "rounded img-fluid" source media="(min-width: 960px)"srcset="images/beach.jpg" alt="beachfront">
    <div class = "col-2 col-8">
        <h3> Urgent</h3>
        <p class = "text justify-content-evenly">
        <table id="taskTable" border='1px solid black' cellspacing='0' table-layout= 'fixed'>
        	<thead>
        		<tr>
        			<th><a href="?orderBy=title">Task Name</a></th>
        			<th><a href="?orderBy=descr">Description</a></th>
        			<th><a href="?orderBy=dueDate">Due Date</a></th>
        			<th><a href="?orderBy=urgency">Priority</a></th>
        			<th><a href="?orderBy=dueDate">Days Due</a></th>
        		</tr>
        	</thead>
        <?php
        date_default_timezone_set("America/New_York");
        $currentTime = strtotime(date("Y/m/d H:i:s"));
        $orderBy = array('title', 'descr', 'dueDate', 'urgency');
        $username = $_SESSION['user'];
		$order = 'dueDate';
		$ascdesc = 'DESC';
		if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
    		$order = $_GET['orderBy'];
    		$ascdesc = '';
		}

		$uncompletedQuery = "SELECT * FROM 218Task WHERE userName='$username' AND completed = false AND urgency = 2 ORDER BY ".$order." ".$ascdesc;

        try{
    		//display uncomplete tasks
    		foreach (runQuery($uncompletedQuery, $conn) as $result){
    			if ($result['urgency']==0){
    				$prioritydata = 'Normal';
    			}else if ($result['urgency']==1){
    				$prioritydata = 'Important';
    			}else if ($result['urgency']==2){
    				$prioritydata = 'Very Important';
    			}
    			$datetime = strtotime($result[dueDate]);
                $secs = $datetime - $currentTime;
                $days = floor($secs / 86400);
            	echo "<tr onclick='edit(this)'>";
            		echo "<td style='display:none;' width='15%'>$result[taskid]</td>";
            		echo "<td width='15%'>$result[title]</td>";
            		echo "<td width='15%'>$result[descr]</td>";
            		echo "<td width='15%'>$result[dueDate]</td>";
            		echo "<td width='15%'>$prioritydata</td>";
                	echo "<td style='display:none;' width='15%'>$result[completed]</td>";
                	if ($days>=0){
                        $dueDays = $days.' days left';
                        echo "<td width='10%'>$dueDays</td>";
                    }else{
                        $dueDays = (-$days).' days ago';
                        echo "<td width='10%'>$dueDays</td>";
                    }
        		echo "</tr>";
    		}
		}catch (PDOException $e){
    		echo "<script>alert('$e');</script>";
		}
        ?>
        </table>
        </p>
    </div>
    <div class="col-4  text-center">
        <form action="" class="form-container" method="POST" id="myFormEdit">
            <h2>Edit Section</h2>
            Task Name: <input type="text" id="editTaskName" name="editTaskName"><br>
            Description: <input type="text" id="editDescription" name="editDescription"><br>
            Due Date: <input type="datetime-local" id="editDueDate" name="editDueDate"><br>
            <span class = "validity"></span>
            Priority:
            <select id="editPriority" name="editPriority" class = "form-control">
            	<option value=0 >        Normal</option>
            	<option value=1 >     Important</option>
            	<option value=2 > Very-Important</option>
        	</select>
            Completed:
            <select id="editCompleted" name="editCompleted" class = "form-control">
            	<option value=1 >      Completed</option>
            	<option value=0 >     Uncomplete</option>
        	</select>
        	<input id="stored" name="stored" style="display:none;">

            <button type="submit" name="submitedit" class="btn">Edit</button>
            <button type="submit" name="submitdelete" class="btn">Delete</button>
            <button type="button" class="btn cancel" onclick="clearForm()"> Close Form</button>
    	</form>
        </div>
</div>
<div class = "row">
    <//img class = "rounded img-fluid" source media="(min-width: 960px)"srcset="images/beach.jpg" alt="beachfront">
    <div class = "col-2 col-8">
        <h3> Tasks</h3>
        <p class = "text justify-content-evenly">
        <table id="taskTable" border='1px solid black' cellspacing='0' table-layout= 'fixed'>
        	<thead>
        		<tr>
        			<th><a href="?orderBy=title">Task Name</a></th>
        			<th><a href="?orderBy=descr">Description</a></th>
        			<th><a href="?orderBy=dueDate">Due Date</a></th>
        			<th><a href="?orderBy=urgency">Priority</a></th>
        			<th><a href="?orderBy=dueDate">Days Due</a></th>
        		</tr>
        	</thead>
        <?php
        $orderBy = array('title', 'descr', 'dueDate', 'urgency');

		$order = 'dueDate';
		$ascdesc = 'DESC';
		if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
    		$order = $_GET['orderBy'];
    		$ascdesc = '';
		}

		$uncompletedQuery = "SELECT * FROM 218Task WHERE userName='$username' AND completed = false ORDER BY ".$order." ".$ascdesc;

        try{
            foreach (runQuery($uncompletedQuery, $conn) as $result){
                if ($result['urgency']==0){
                    $prioritydata = 'Normal';
                }else if ($result['urgency']==1){
                    $prioritydata = 'Important';
                }else if ($result['urgency']==2){
                    $prioritydata = 'Very Important';
                }
                $datetime = strtotime($result[dueDate]);
                $secs = $datetime - $currentTime;
                $days = floor($secs / 86400);
                echo "<tr onclick='edit(this)'>";
                    echo "<td style='display:none;' width='15%'>$result[taskid]</td>";
                    echo "<td width='15%'>$result[title]</td>";
                    echo "<td width='15%'>$result[descr]</td>";
                    echo "<td width='15%'>$result[dueDate]</td>";
                    echo "<td width='15%'>$prioritydata</td>";
                    echo "<td style='display:none;' width='15%'>$result[completed]</td>";
                    if ($days>=0){
                        $dueDays = $days.' days left';
                        echo "<td width='10%'>$dueDays</td>";
                    }else{
                        $dueDays = (-$days).' days ago';
                        echo "<td width='10%'>$dueDays</td>";
                    }
                echo "</tr>";
    		}
		}catch (PDOException $e){
    		echo "<script>alert('$e');</script>";
		}
        ?>
        </table>
        </p>
    </div>
</div>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {font-family: Arial, Helvetica, sans-serif;}
        * {box-sizing: border-box;}

		#myFormEdit{
			position: fixed;
			display: none;
            top: 10%;
            right: 15px;
            border: 3px solid #f1f1f1;
		}


        /* Button used to open the contact form - fixed at the bottom of the page */
        .open-button {
            background-color: #555;
            color: white;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            opacity: 0.8;
            position: fixed;
            bottom: 23px;
            right: 28px;
            width: 280px;
        }

        /* The popup form - hidden by default */
        .form-popup {
            display: none;
            position: fixed;
            bottom: 5;
            right: 15px;
            border: 3px solid #f1f1f1;
            z-index: 9;
        }

        /* Add styles to the form container */
        .form-container {
            max-width: 300px;
            padding: 10px;
            background-color: white;
        }

        /* Full-width input fields */
        .form-container input[type=text], .form-container input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            border: none;
            background: #f1f1f1;
        }

        /* When the inputs get focus, do something */
        .form-container input[type=text]:focus, .form-container input[type=text]:focus {
            background-color: #ddd;
            padding-top: 10px;
            outline: none;
        }

        /* Set a style for the submit/login button */
        .form-container .btn {
            background-color: #4CAF50;
            color: white;
            padding: 7px 10px;
            border: none;
            cursor: pointer;
            width: 75%;
            margin-bottom:10px;
            opacity: 0.8;
        }

        /* Add a red background color to the cancel button */
        .form-container .cancel {
            background-color: red;
        }

        /* Add some hover effects to buttons */
        .form-container .btn:hover, .open-button:hover {
            opacity: 1;
        }
    </style>
</head>
<body>


<button class="open-button" onclick="openForm()">Add Task</button>

<div class="form-popup" id="myForm">
    <form action="" class="form-container" method="POST">
        <h1>Add New Task</h1>

        <label><b>Name</b></label>
        <input type="text" placeholder="Enter name of task here" name="taskName" required>

        <label><b>Description</b></label>
        <input type="text" placeholder="Enter Description here" name="taskDescrip" required>

        <label><b>Priority</b></label>
        <select name="priority" class = "form-control">
            <option value=0 >        Normal</option>
            <option value=1 >     Important</option>
            <option value=2 > Very-Important</option>
        </select>
        <label><b>Date & Time</b></label>
        <input id = "text" type = "datetime-local" name="dueDate">
        <span class = "validity"></span>

        <button type="submit" name="submit" class="btn">Create</button>
        <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
    </form>
</div>

<script>
    function openForm() {
        document.getElementById("myForm").style.display = "block";
        document.getElementById("myFormEdit").style.display = "none";
    }

    function closeForm() {
        document.getElementById("myForm").style.display = "none";
    }
</script>

</body>

</div>
<footer class="footer page-footer font-small ">
    <div class="container">
        <div class="row">
            <span class="text-muted">&copy; Group 1, 2021 |  Terms Of Use  |  Privacy Statement</span>
        </div>
    </div>
</footer>



<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
<script>
    // Current product being edited
    document.getElementById('userdiv').innerText = firstname + ' ' + lastname;

	function edit(x){
    	row = x.rowIndex;
    	document.getElementById("myFormEdit").style.display = "block";
    	document.getElementById("myForm").style.display = "none";
    	document.getElementById("stored").value = x.cells[0].innerHTML;
    	document.getElementById("editTaskName").value = x.cells[1].innerHTML;
    	document.getElementById("editDescription").value = x.cells[2].innerHTML;
  		var sep = x.cells[3].innerHTML.split(" ");
    	var newtime = sep[0] + 'T' + sep[1];
    	document.getElementById("editDueDate").value = newtime;
    	if (x.cells[4].innerHTML == 'Normal'){
    		document.getElementById("editPriority").value = 0;
    	}else if (x.cells[4].innerHTML == 'Important'){
    		document.getElementById("editPriority").value = 1;
    	}else if (x.cells[4].innerHTML == 'Very Important'){
    		document.getElementById("editPriority").value = 2;
    	}
    	document.getElementById("editCompleted").value = parseInt(x.cells[5].innerHTML);
    }
    function clearForm(){
    	document.getElementById("myFormEdit").style.display = "none";
    }
    function logout(){
            sessionStorage.clear();
            alert("You've successfully logged out.");
            window.location.href = "login.html";
        }
</script>
</body>
