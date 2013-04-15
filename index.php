<?php
	/**
	 * @file gerador_emm.php
	 * @author William Moraes - Ft Site
	 */

	ini_set('display_errors', true);
	error_reporting(E_ALL);

	date_default_timezone_set('America/Sao_Paulo');

	header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
	<title>Gerador de Email Marketing</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body class="home">
	<div id="main" class="content">

		<h1>Gerador de Email Marketing</h1>

		<form action="gerador.php" method="post" enctype="multipart/form-data">
			<fieldset>
				<label>
					<span>HTML cru, vindo dos slices do photoshop</span>
					<textarea name="emm" cols="90" rows="30"></textarea>
				</label>
				<label>
					<span>ou Arquivo</span>
					<input type="file" name="arquivo" />
				</label>
				<label>
					<span>Caminho absoluto das imagens no FTP</span>
					<input type="text" name="path" value="http://www.mktprodutos.siteprofissional.com/Campanhas/<?php echo date('Y').'/'.date('m').'/' ?>" size="100" />
				</label>
				<label class="submit">
					<input type="submit" name="ok" value="ok" />
				</label>
			</fieldset>
		</form>

	</div><!-- /main -->
</body>
</html>