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
		$color = jQuery("input[name='color']"),
		$tagA = jQuery('#tag-a'),
		$catcher = $('#catcher'),
		$sidebar = $('#sidebar'),
		$sticky = $('#format'),
		$formatLinks = $('#format-links').find("li"),
		$footer = $('footer'),
		$footTop = $footer.offset().top;

	$(window).scroll(function() {
		if(isScrolledTo($sticky)) {
			$sticky.css({
				'position':'fixed',
				'top': 0
			})
		}

		var $stopHeight = $sidebar.offset().top,
    		$stickyFoot = $sticky.offset().top + $sticky.outerHeight();

    	if ($stickyFoot > $footTop){
    		$sticky.css({
	        	position:'absolute',
	        	top: ($footTop - 168) - $sticky.outerHeight()
	      	});
    	} else {
			if ($stopHeight > $sticky.offset().top) {
			    $sticky.css('position','absolute');
			    $sticky.css('top', $stopHeight  - 152);
			}
    	}
	});

	$preview.find('td').click(function(e){
		e.stopPropagation();
		var $td = jQuery( this ),
			$font = $td.find('font');


		if($td.hasClass('is-selected')) {
			applyText( $td );

			var new_content = format( $td.html() );
			$td.html( new_content );

			updateTextarea( $preview.html() );

		} else {

			var style = $font.attr('style');

			if( style ) {
				$bgcolor.val( $td.attr('bgcolor') );
				$face.val( $font.attr('face') );
				$color.val( $font.attr('color') );
				$valign.val( $td.attr('valign') );
				$align.val( $td.attr('align') );

				$size.val( style.replace(/font-size: ([0-9]+px)(.*)/, '$1') );
				$weight.val( style.replace(/(.*)font-weight: ([a-z]+)/, '$2') );
			}

			$content.val( removeTag($td.html()) );
		}
		removeSelected();
		$td.addClass('is-selected');
	});

	$preview.on('click', 'a',function(e){
		e.preventDefault();
	});
	$body.click( removeSelected );
	$('#format').click(function(e){
		e.stopPropagation();
	});
	$tagA.click(function(){
		insertA('');
	});
	$formatLinks.on('click', function(){
		insertA($(this).attr('data-href'));
	});


	function insertA(link) {
		var content = $content.val().replace(/<a[^>]+>/g, '').replace(/<\/a>/g, '');

		var v = '<a href="' + link + '" target="_blank">' + content + '</a>';
		$content.val( v );
	}
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
	function removeSelected()
	{
		$preview.find('td').removeClass('is-selected');
	}
	function isScrolledTo(elem)
	{
		var docViewTop = $(window).scrollTop();
		var elemTop = $(elem).offset().top;
    	return elemTop <= docViewTop || elemTop >= docViewTop;
	}
});//document.ready