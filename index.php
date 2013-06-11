<?php
/**
* @file gerador_emm.php
* @author William Moraes/Marco Bruno/Pedro Rogerio - Ft Site
*/
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
date_default_timezone_set('America/Sao_Paulo');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Gerador de Email Marketing</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body class="home">
	<aside id="main" class="content">
		<header>
			<h1>Gerador de Email Marketing</h1>
		</header>

		<form action="gerador.php" method="post" enctype="multipart/form-data">
			<fieldset>
				<p>
					<label for="emm">HTML cru, vindo dos slices do photoshop:</label>
					<textarea name="emm" id="emm" cols="90" rows="30"></textarea>
				</p>

				<p>
					<label for="arquivo">Ou arquivo:</label>
					<input type="file" name="arquivo" id="arquivo" />
				</p>

				<p>
					<label for="path">Caminho absoluto das imagens no FTP:</label>
					<input type="text" name="path" id="path" value="<?php echo $actual_link . date('Y').'/'.date('m').'/' ?>">
				</p>
				
				<p>
					<input type="submit" name="ok" id="ok" value="Ok">
				</p>
			</fieldset>
		</form>
	</aside>
</body>
</html>