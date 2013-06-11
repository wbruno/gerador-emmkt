<?php
	$voltar = '<a href="'.htmlspecialchars($_SERVER['HTTP_REFERER']).'">voltar</a>';
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
			echo '<h2 class="warning">Nao faca slices com <strong>rowspan</strong></h2>';

			preg_match_all('/(<td( colspan=\"[0-9]+\")? rowspan=\"[0-9]+\"><img[^>]+><\/td>)/', $file, $pieces);


			foreach( $pieces[0] AS $each ){
				preg_match('/(<img[^>]+>)/', $each, $img);
				preg_match('/src=\"([^"]+)"/', $img[0], $src);


				$arr[] = '<li><p>rowspan encontrado na imagem: </p>
					<p><strong>'.$src[0].'</strong></p>'.$img[0].'</li>';
			}

			echo '<ul>'.implode($arr).'</ul>';

			echo '<br>'.$voltar;
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