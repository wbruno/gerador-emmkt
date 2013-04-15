jQuery(document).ready(function(){
	var $body = $('body'),
		$preview = jQuery('#preview'),
		$out = jQuery("textarea[name='out']"),
		$content = jQuery("textarea[name='content']"),
		$bgcolor = jQuery("input[name='bgcolor']"),
		$valign = jQuery("select[name='valign']"),
		$align = jQuery("select[name='align']"),
		$face = jQuery("input[name='face']"),
		$size = jQuery("input[name='size']"),
		$weight = jQuery("input[name='weight']"),
		$color = jQuery("input[name='color']");


	$preview.find('td').click(function(e){
		e.stopPropagation();
		var $this = jQuery( this ),
			$td = $this;

		if($this.hasClass('is-selected')) {
			applyText( $td );
			var new_content = format( $td.html() );
			$td.html( new_content );

			updateTextarea( $preview.html() );

		} else {
			$content.val( removeTag($td.html()) );
		}

		$preview.find('a').off('click').on('click',function(e){
			e.preventDefault();
		});
		removeSelected();
		$this.addClass('is-selected');
	});
	$body.click( removeSelected );
	$('#format').click(function(e){
		e.stopPropagation();
	});


	function removeTag( td )
	{
		td = td.replace(/<font[^>]+>/,'');
		td = td.replace('</font>','');
		return td;
	}
	function format( td )
	{
		return '<font color="'+$color.val()+'" face="'+$face.val()+'" style="font-size: '+$size.val()+'; font-weight: '+$weight.val()+'">'+td+'</font>';
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
	function removeSelected(){
		$preview.find('td').removeClass('is-selected');
	}
});//document.ready