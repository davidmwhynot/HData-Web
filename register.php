<?php
// step 1 - get our data from the form

$uName = $_POST['usernameReg'];
$pw1 = $_POST['passwordReg1'];
$pw2 = $_POST['passwordReg2'];

$uNameLen = strlen($uName);
$pw1len = strlen($pw1);
$pw2len = strlen($pw2);


// step 2 - verify that our data is good (all forms are filled in, passwords match, password is secure etc)

if(!($uNameLen == 0) && !($pw1len == 0) && !($pw2len == 0)) {
	if($pw1 == $pw2) {
		if($uNameLen > 4) {
			if($pw1len > 5) {
				
				// step 2a - if data is good, keep going, if not then spit out an error message (see below 2b)

				// step 3 - connect to database
					
					/**
						* Testing PDO MySQL Database Connection, query() and exec().
						* For CREATE TABLE, INSERT, DELETE, UPDATE:
						*   exec(): returns the affected rows.
						* For SELECT:
						*   query(): returns a result set.
					*/
					// Define the MySQL database parameters.
					// Avoid global variables (which live longer than necessary) for sensitive data.
				$dbHost = 'localhost'; // MySQL server hostname
				$dbPort = '3306'; // MySQL server port number (default 3306)
				$dbName = 'hdata'; // name of the database we will be using
				$dbUser = 'root'; // CHANGE THIS
				$dbPass = ''; // CHANGE THIS TOO
					
				try {
					// Create a PDO database connection to MySQL server, in the following syntax:
					//   new PDO('mysql:host=username;port=number;dbname=database', username, password);
					$dbConn = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
					$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set error mode to exception
					echo 'Connected', '</br>';
					
					$dbConn->exec("create table if not exists userpass (user varchar(20), pass varchar(20))");
					// run SQL statements
					// Use exec() to run a CREATE TABLE, DROP TABLE, INSERT, DELETE and UPDATE
					// exec() returns the number of rows affected by the change
					// Use query() to run a SELECT, which returns a resultset, which is by default an associative array
					// the array is indexed by BOTH column-name AND column-number (starting at 0)
					$usersInDB = $dbConn->query("SELECT * FROM userpass");
					
					// step 4 - verify data again (username is unique)
						
					if(testForDuplicate($usersInDB, $uName, 'user')) {
						// step 5 - if data is good, then store it in the database
							$dbConn->exec("INSERT INTO userpass (user,pass) VALUES ('" . $uName . "','" . $pw1 . "')");
			// keep in mind that these commands ARE NOT EXECUTED HERE
			// this SQL statement simply INITIALIZES THE MATCH HISTORY TABLE
			// a new table is created for each user!
			// first field in table "matchHistory" will be the class id for a match
			// class id's are:
				// 0 - warrior
				// 1 - shaman
				// 2 - rogue
				// 3 - paladin
				// 4 - hunter
				// 5 - druid
				// 6 - warlock
				// 7 - mage
				// 8 - priest
			// second field will be for a win or a loss with specified class
				// 0 - win
				// 1 - loss
			// third field will be for what class that match was played against
				// same integer assignments as "class" for what class was played
			// fourth field is the game mode/type
				// 0 - arena
				// 1 - normal (includes practice mode)
				// 2 - ranked
			// fifth field is the format
				// 0 - wild
				// 1 - standard
			// sixth field is the users deck id
			// seventh field will be the unique "matchID"
							$dbConn->exec("create table if not exists " . uName . "matchHistory (class int, wl int, against int, gameType int, format int, deckID int, matchID INT_AUTO_INCREMENT)"); 
			// now we need to make ANOTHER table to store each users decks
			// again, not EXECUTED HERE, only SETTING UP THE TABLES
			// first field is the deck id (integer starting at 0 for the users first deck)
			// second field indicates whether or not the deck is standard/wild/arena, reevaluated each time the deck is saved
				// 0 - wild
				// 1 - standard
				// 2 - arena
			// third through thirtythird field are the ids of each card in the deck, organized from lowest ID to highest
							$dbConn->exec("create table if not exists " . uName . "decks (deckID INT_AUTO_INCREMENT, format int, card1 int, card2 int, card3 int," .
							" card4 int, card5 int, card6 int, card7 int, card8 int, card9 int, card10 int, card11 int, card12 int, card13 int, card14 int, card15 int," . 
							" card16 int, card17 int, card18 int, card19 int, card20 int, card21 int, card22 int, card23 int, card24 int, card25 int, card26 int, card27 int, card28 int, card29 int, card30 int)");
						// step 6 - success message and redirect to homepage, more things will be added here later
						// TODO
					} else {
						echo 'Username already exists!';
					}
						
				} catch (PDOException $e) {
					$fileName = basename($e->getFile(), ".php"); // Filename that triggered the exception
					$lineNumber = $e->getLine(); // Line number that triggers the exception
					die("[$fileName][$lineNumber] Database error: " . $e->getMessage() . '<br />');
				}
			} else {
				echo 'Password must be greater than 5 characters';
			}
		} else {
			echo 'Username must be greater than 4 characters!';
		}
	} else {
		echo 'Passwords must match!';
	}
} else {
	
	// step 2b - determine what error message needs to be spat out
	
	if($uNameLen == 0) {
		echo 'Please input a username';
	}
	if($pw1len == 0) {
		echo 'Please input password';
	}
	if($pw2len == 0) {
		echo 'Please retype password';
	}
}
function testForDuplicate($userArray, $userTest, $fieldName) {
	foreach($userArray as $row) {
		if($userTest == $row[$fieldName]) {
			return false;
		} else {
			return true;
		}
	}
}
?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Register</title>
		<link rel="stylesheet" href="index.css" media="(min-width: 700px)">
	</head>
	<body class="index">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="script.js"></script>
		<h1>HData (Placeholder for Image Header)</h1>
		<div class="nav">
			<a href="index.php">Home</a>
			<a href="newgame.php">New Game</a>
			<a href="stats.php">Stats</a>
			<a href="decks.php">Decks</a>
			<a href="about.php">About</a>
		</div>
		<div class="main">
			<form method="POST">
				<p>
					Username:
					<input type="text" name="usernameReg" id="usernameRegjs">
					Password:
					<input type="text" name="passwordReg1" id="passwordReg1js">
					Retype Password:
					<input type="text" name="passwordReg2" id="passwordReg2js">
				</p>
				<input type="submit">
			</form>
		</div>
		<div class="sideBar">
			<div class="login">
			</div>
			<div class="sideLinks">
			</div>
			<div class="social">
			</div>
		</div>
		<div class="foot">
		</div>
	</body>
</html>