<?php
$userNameToFunc = $_POST['username'];
$passToFunc = $_POST['password'];
echo $userNameToFunc;
echo $passToFunc;
processLogin($userNameToFunc, $passToFunc);
function processLogin($userName, $pass) {
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
	
		// run SQL statements
		// Use exec() to run a CREATE TABLE, DROP TABLE, INSERT, DELETE and UPDATE
		// exec() returns the number of rows affected by the change
		// Use query() to run a SELECT, which returns a resultset, which is by default an associative array
		// the array is indexed by BOTH column-name AND column-number (starting at 0)
		$userInDB = $dbConn->query("SELECT user FROM userpass");
		$passInDB = $dbConn->query("SELECT pass FROM userpass");
		if(checkIfUserExists($userInDB, $userName, 'user')) {
			if(checkPassword($passInDB, $pass, 'pass')) {
				echo 'LOGIN';
			} else {
				echo 'Invalid username/password';
			}
		} else {
			echo 'Invalid username/password!';
		}
	} catch (PDOException $e) {
		$fileName = basename($e->getFile(), ".php"); // Filename that triggered the exception
		$lineNumber = $e->getLine(); // Line number that triggers the exception
		die("[$fileName][$lineNumber] Database error: " . $e->getMessage() . '<br />');
	}
}
function checkIfUserExists($dataBaseUser, $userNameToDB, $fieldSQL) {
	foreach($dataBaseUser as $row) {
		echo $row[$fieldSQL];
		if(strcmp($userNameToDB,$row[$fieldSQL]) == 0) {
			return true;
			end;
		}
	}
}
function checkPassword($dataBasePW, $passwordToDB, $pwSQL) {
	foreach($dataBasePW as $rowPW) {
		echo $rowPW[$pwSQL];
		if(strcmp($passwordToDB,$rowPW[$pwSQL]) == 0) {
			return true;
			end;
		}
	}
}
?>