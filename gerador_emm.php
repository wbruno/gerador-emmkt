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
	<style type="text/css">
	* { margin: 0; padding: 0; border: none; list-style: none; }
	body { font: 12px Tahoma, Verdana, sans-serif; }
	#main { width: 800px; margin: 20px auto; }
	h1 { margin-bottom: 20px; font-size: 22px; font-weight: normal;  }
	label { display: block; margin-bottom: 20px; }
	label span { display: block; }
	.out { width: 700px; }
	input, textarea { border: 1px solid #666; background: #fff; padding: 2px; font: 12px Tahoma, sans-serif; color: #666; width: 600px; }
	.submit input { width: 100px; }
	</style>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		var $preview = jQuery('#preview');
		var $out = jQuery("textarea[name='out']");

		var $content = jQuery("textarea[name='content']");

		var $bgcolor = jQuery("input[name='bgcolor']");
		var $valign = jQuery("input[name='valign']");
		var $align = jQuery("input[name='align']");

		var $font = jQuery("input[name='font']");
		var $color = jQuery("input[name='color']");

		$preview.find('td').click(function(){
			var $this = jQuery( this );
			var $td = $this;

			applyText( $td );
			var new_content = format( $td.html() );
			$td.html( new_content );

			updateTextarea( $preview.html() );
		});
		function format( td )
		{
			return '<span style="color:'+$color.val()+'; font:'+$font.val()+'">'+td+'</span>';
		}

		function applyText( $td )
		{
			$td.find('img').remove();
			$td.html( $content.val() );
			$td.attr( 'bgcolor', $bgcolor.val() );
			$td.attr( 'valign', $valign.val() );	
			$td.attr( 'align', $align.val() );
		}
		function updateTextarea( new_content )
		{
			$out.val( new_content );
		}
	});//document.ready

	</script>
</head>
<body>
	<div id="main">

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

		if( stripos( $file, 'rowspan') )
		{
			echo '<p>Nao faca slices com <strong>rowspan</strong></p>';
			echo $voltar;
		}
		else
		{

			$file = str_replace( array("\t","\r\n", "\n"), '', $file );

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
			$width_table = $matches[1];


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
			echo '<label><span>Codigo HTML parametrizado</span>';
			echo '<textarea cols="70" rows="20" name="out" class="out">',$out,'</textarea></label>';

			echo '<p>Preview do EMM:</p>';
			echo '<div id="preview">',$out,'</div>';
			echo '<label><span>Texto a ser inserido:</span> <textarea name="content" cols="40" rows="10"></textarea></label>';	
			echo '<label><span>font:</span> <input type="text" name="font" value="bold 13px/16px Arial, Tahoma, Geneva, sans-serif" /></label>';
			echo '<label><span>color:</span> <input type="text" name="color" value="#000000" /></label>';
			echo '<label><span>bgcolor:</span> <input type="text" name="bgcolor" value="#ffffff" /></label>';
			echo '<label><span>valign:</span> <input type="text" name="valign" value="top" /></label>';
			echo '<label><span>align:</span> <input type="text" name="align" value="left" /></label>';
		}
	}
	else
	{
?>
		<form action="" method="post" enctype="multipart/form-data">
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
					<input type="text" name="path" value="http://www.seusite.com.br/<?php echo date('Y').'/'.date('m').'/' ?>" size="100" />
				</label>
				<label class="submit">
					<input type="submit" name="ok" value="ok" />
				</label>
			</fieldset>
		</form>
<?php
	}
?>
	</div><!-- /main -->
</body>
</html>
