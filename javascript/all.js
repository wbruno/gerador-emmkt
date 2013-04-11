jQuery(document).ready(function(){
	var $body = $('body'),
		$preview = jQuery('#preview'),
		$out = jQuery("textarea[name='out']"),
		$content = jQuery("textarea[name='content']"),
		$bgcolor = jQuery("input[name='bgcolor']"),
		$valign = jQuery("select[name='valign']"),
		$align = jQuery("select[name='align']"),
		$font = jQuery("input[name='font']"),
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


			$preview.find('a').off('click').on('click',function(e){
				e.preventDefault();
			});
		} else {
			$content.val( $td.html() );
		}


		removeSelected();
		$this.addClass('is-selected');
	});
	$body.click( removeSelected );
	$('#format').click(function(e){
		e.stopPropagation();
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
	function removeSelected(){
		$preview.find('td').removeClass('is-selected');
	}
});//document.ready