<?php
	session_start();
	include_once("funciones.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
	</head>
	<body>
		<div class="login">
			<?php
				if (isset($_POST) && !empty($_POST)) {
					$usuario = $_POST["username"];
					$password = $_POST["password"];
					generar_sesion($usuario,$password);
				}
				if (!empty($_SESSION))
					echo("<h3>".$_SESSION['user_nif']['NIF']."<h3>");
			?>
			<h1>Login</h1>
			<form action="welcome.php" method="post">
				<label for="username">
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input type="submit" value="Login">
			</form>
		</div>
	</body>
</html>