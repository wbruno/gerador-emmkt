<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Gerador de Email Marketing</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script type="text/javascript" src="javascript/all.js"></script>
</head>
<body>
	<aside id="main" class="content">
		<header>
			<h1>Gerador de Email Marketing</h1>
			<h2>Preview do EMM:</h2>
			<?php include "processa.php"; ?>
		</header>

		<aside id="preview" class="fleft"><?php echo $out; ?></aside>

		<aside id="format" class="fright natural">
			<form>
				<fieldset>
					<span class="format-tag fright" id="tag-a">&lt;A&gt;</span>
					<p class="cf first">
						<label for="content" class="fleft">Texto a ser inserido:</label>
						<textarea name="content" id="content" cols="40" rows="10"></textarea>
					</p>
					<p class="cf">
						<label for="face" class="fleft">face:</label>
						<input type="text" name="face" id="face" value="Arial, Tahoma, Geneva, sans-serif" class="fright">
					</p>
					<p class="cf">
						<label for="size" class="fleft">font-size:</label>
						<input type="text" name="size" id="size" value="13px" class="fright">
					</p>
					<p class="cf">
						<label for="weight" class="fleft">font-weight:</label>
						<input type="text" name="weight" id="weight" value="normal" class="fright">
					</p>
					<p class="cf">
						<label for="color" class="fleft">color:</label>
						<input type="text" name="color" id="color" value="#000000" class="fright">
					</p>
					<p class="cf">
						<label for="bgcolor" class="fleft">bgcolor:</label>
						<input type="text" name="bgcolor" id="bgcolor" value="#ffffff" class="fright">
					</p>
					<p class="cf">
						<label class="fleft">valign:</label>
						<select class="fright" name="valign">
							<option value="top">top</option>
							<option value="middle">middle</option>
							<option value="bottom">bottom</option>
						</select>
					</p>
					<p class="cf">
						<label class="fleft">align:</label>
						<select class="fright" name="align">
							<option value="left">left</option>
							<option value="center">center</option>
							<option value="right">right</option>
						</select>
					</p>
				</fieldset>
			</form>
		</aside>

		<footer>
			<aside class="output">
				<h2>Código HTML parametrizado</h2>
				<textarea cols="70" rows="20" name="out" class="out" readonly="readonly"><?php echo $out; ?></textarea>
			</aside>
		</footer>
	</aside>
</body>
</html>