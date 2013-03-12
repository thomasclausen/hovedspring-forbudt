(function($) {
	$(document).ready(function(){
		$('html').removeClass('no-js');
		if (!$.browser.msie) {
			$(document).on('click', 'nav a#update', function(e) {
				var data = { action: 'hovedspringforbudt_update', security: hovedspringforbudtAjax.nonce };
				$.post(hovedspringforbudtAjax.ajaxurl, data, function(response) {
					var $nav = $('section.fakta nav').clone();
					$('section.fakta').empty().append(response, $nav);
				});
				e.preventDefault();
			});
		}
		$(document).on('click', 'nav a.social', function(e) {
			var share_url = $(this).parent().siblings('.type-fakta').attr('data-permalink');
			var share_title = $(this).parent().siblings('h2').text();
			var share_content = $(this).parent().siblings('.type-fakta').find('p').text();
			var share_image = $('head link[rel=image_src]').attr('href');
			if ($(this).attr('id') == 'twitter') {
				if (share_content.length > 103) {
					share_content = share_content.substring(0, 103) + '...';
				}
				window.open('https://twitter.com/share?url=' + encodeURIComponent(share_url) + '&text=' + encodeURIComponent(share_title) + ': ' + encodeURIComponent(share_content), $(this).attr('class'), 'width=550,height=450');
			} else if ($(this).attr('id') == 'facebook') {
				window.open('http://www.facebook.com/sharer.php?s=100&p[url]=' + encodeURIComponent(share_url) + '&p[title]=' + encodeURIComponent(share_title) + '&p[summary]=' + encodeURIComponent(share_content) + '&p[images][0]=' + encodeURIComponent(share_image), $(this).attr('class'), 'width=550,height=450');
			} else if ($(this).attr('id') == 'google') {
				window.open('https://plus.google.com/share?url=' + encodeURIComponent(share_url) + '&title=' + encodeURIComponent(share_title) + '&content=' + encodeURIComponent(share_content), $(this).attr('class'), 'width=550,height=450');
			} else {
				window.location.href = share_url;
			}
			e.preventDefault();
		});
	});
	$(document).keyup(function(event){
		if (event.keyCode == 27) {
			document.location.href = '/wp-admin/';
		}
	});
})(jQuery);