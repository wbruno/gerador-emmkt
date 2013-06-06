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
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="javascript/all.js"></script>
</head>
<body>
	<div id="main" class="content">

		<h1>Gerador de Email Marketing</h1>
<?php
	$voltar = '<a href="javascript:history.back(-1)">voltar</a>';
	if( $_SERVER['REQUEST_METHOD']=='POST' )
	{

		if( !empty( $_FILES['arquivo']['name'] ) )
		{

			$handle = fopen( $_FILES['arquivo']['tmp_name'], "r");
			$file = '';
			while (!feof($handle)) {
				$file .= fread($handle, 8192);
			}
			fclose($handle);
		}
		else
		{
			$file = str_replace( '\"', '"', $_POST['emm'] );
		}

		$file = str_replace( array("\t","\r\n", "\n"), '', $file );



		$pos_rowspan = stripos( $file, 'rowspan');
		if( $pos_rowspan )
		{
			echo '<h2>Nao faca slices com <strong>rowspan</strong></h2>';

			preg_match_all('/(<td( colspan=\"[0-9]+\")? rowspan=\"[0-9]+\"><img[^>]+><\/td>)/', $file, $pieces);


			foreach( $pieces[0] AS $each ){
				preg_match('/(<img[^>]+>)/', $each, $img);
				preg_match('/src=\"([^"]+)"/', $img[0], $src);


				$arr[] = '<li><p>rowspan encontrado na imagem: </p>
					<p><strong>'.$src[0].'</strong></p>'.$img[0].'</li>';
			}

			echo '<ul>'.implode($arr).'</ul>';

			echo '<br><br>'.$voltar;
			exit();
		}
		else
		{

			$file = preg_replace(
							array(
							// Remove titulo
							'@<title[^>]*?>.*?</title>@siu',),
								array(
							' ', ),$file
					);
					// Remove all remaining tags and comments and return.
			$text = strip_tags( $file );


			/* busca todas as TDs e imagens */
			$pattern = '/<td( colspan="[0-9]*")?><img src="image(n)?s\/([-A-Za-z_0-9\.]+)" (width="[0-9]+" height="[0-9]+") alt=""><\/td>/';

			/* devolve na TD, valign, a mesma largura e altura da imagem correspondente, e coloca align em cada imagem  */
			$replacement = '<td${1} $4 valign="top" align="left"><img src="'.$_POST['path'].'image${2}s/${3}" $4 alt="" align="top" border="0"></td>';


			$out = preg_replace( $pattern, $replacement, $file );


			/* descobrindo a largura total da tabela */
			$pattern = '/<table id="[\w]+" width="([0-9]+)"/';
			preg_match( $pattern, $file, $matches );
			$width_table = isset($matches[1]) ? $matches[1] : '700';


			$out = str_replace(
					'.jpg" width="'.$width_table.'"',
					'.jpg" width="'.$width_table.'" style="display: block;"',
					$out
				 );



			$out = str_replace(
					Array( '</tr>', '<tr>', '</td>', '<html>', '<head>', '</title>', '</head>',
						'<table', 'cellspacing="0">', 'marginheight="0">' ),
					Array( "\t</tr>\n", "\t<tr>\n", "</td>\n", "<html>\n", "<head>\n", "</title>\n", "\n</head>\n",
						"\n<table", "cellspacing=\"0\" align=\"center\">\n", "marginheight=\"0\">\n" ),
					$out
				);


			$out = preg_replace( '/<td([^>]+)*>/', "\t\t".'<td${1}>', $out ); //<td width="64" height="75" valign="top">

			echo $voltar;

		}
	}
?>

		<h2>Preview do EMM:</h2>
		<div id="preview" class="fleft"><?php echo $out; ?></div>

		<div id="format" class="fleft">
			<h2 class="fleft format-title">Texto a ser inserido:</h2>
			<span class="format-tag fright" id="tag-a">&lt;A&gt;</span>
			<fieldset>
				<label><textarea name="content" cols="40" rows="10"></textarea></label>
				<label>
					<span class="fleft">face:</span>
					<input type="text" name="face" value="Arial, Tahoma, Geneva, sans-serif" class="fright" />
				</label>
				<label>
					<span class="fleft">font-size:</span>
					<input type="text" name="size" value="13px" class="fright" />
				</label>
				<label>
					<span class="fleft">font-weight:</span>
					<input type="text" name="weight" value="normal" class="fright" />
				</label>
				<label>
					<span class="fleft">color:</span>
					<input type="text" name="color" value="#000000" class="fright" />
				</label>
				<label>
					<span class="fleft">bgcolor:</span>
					 <input type="text" name="bgcolor" value="#ffffff" class="fright" />
				</label>
				<label>
					<span class="fleft">valign:</span>
					<select class="fright" name="valign">
						<option value="top">top</option>
						<option value="middle">middle</option>
						<option value="bottom">bottom</option>
					</select>
				</label>
				<label>
					<span class="fleft">align:</span>
					<select class="fright" name="align">
						<option value="left">left</option>
						<option value="center">center</option>
						<option value="right">right</option>
					</select>
				</label>
			</fieldset>
		</div><!-- format -->

		<div id="output" class="content clear">
			<h2>Codigo HTML parametrizado</h2>
			<label>
				<textarea cols="70" rows="20" name="out" class="out" readonly="readonly"><?php echo $out; ?></textarea>
			</label>
		</div><!-- #output -->



	</div><!-- /main -->
</body>
</html>


