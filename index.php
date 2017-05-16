<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>HData</title>
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
			<div class="recentGames">
			</div>
			<div class="statsSum">
			</div>
			<div class="news">
			</div>
		</div>
		<div class="sideBar">
			<div class="login">
				<form action="processLogin.php" method="POST">
					<p>
						Username:
						<input type="text" name="username" id="usernamejs">
						Password:
						<input type="text" name="password" id="passwordjs">
					</p>
					<input type="submit">
				</form>
<?php
// need 2 methods, 1 for username and 1 for password
// very simple select methods that compare given values with user given values

?>
				<a href="register.php">Register</a>
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