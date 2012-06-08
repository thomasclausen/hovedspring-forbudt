(function($) {
	$(document).ready(function(){
		$('html').removeClass('no-js');
		if(!$.browser.msie) {
			$('nav a#update').live('click', function() {
				var data = { action: 'fakta_update', security: hovedspringforbudtAjax.nonce };
				$.post(hovedspringforbudtAjax.ajaxurl, data, function(response) {
					var $nav = $('section.post nav').clone();
					$('section.post').empty().append(response, $nav);
				});
				return false;
			});
		}
		$('nav a.social').live('click', function() {
			var fact_ID = $(this).parent().siblings('.post').attr('id');
			var share_url = 'http://xn--lr-at-svmme-98a5v.nu/fakta/' + (parseInt(fact_ID.replace('post-', '')) - 1) + '/';
			var share_title = $(this).parent().siblings('h2').text();
			var share_content = $(this).parent().siblings('.post').find('p').text();
			var share_image = $('head link[rel=image_src]').attr('href');
			if ($(this).attr('id') == 'twitter') {
				if (share_content.length > 105) {
					share_content = share_content.substring(0, 105) + '...';
				}
				window.open('https://twitter.com/share?url=' + encodeURIComponent(share_url) + '&text=' + encodeURIComponent(share_title) + ': ' + encodeURIComponent(share_content), $(this).attr('class'), 'width=550,height=450');
			} else if ($(this).attr('id') == 'facebook') {
				window.open('http://www.facebook.com/sharer.php?s=100&p[url]=' + encodeURIComponent(share_url) + '&p[title]=' + encodeURIComponent(share_title) + '&p[summary]=' + encodeURIComponent(share_content) + '&p[images][0]=' + encodeURIComponent(share_image), $(this).attr('class'), 'width=550,height=450');
			} else if ($(this).attr('id') == 'google') {
				// window.open('https://m.google.com/app/plus/x/?v=compose&content=' + encodeURIComponent(share_title) + ': ' + encodeURIComponent(share_content) + ' - ' + encodeURIComponent(share_url) + '&hideloc=1', $(this).attr('class'), 'width=550,height=450'); // Mobile version
				window.open('https://plusone.google.com/_/+1/confirm?hl=da&url=' + encodeURIComponent(share_url) + '&title=' + encodeURIComponent(share_title), $(this).attr('class'), 'width=550,height=450'); // Desktop version

				// http://blog.ineedhits.com/tips-advice/how-to-optimize-your-business-google-plus-page-for-ranking-and-results-165410428.html
				// http://randyjensenonline.com/thoughts/destination-guatemala/
			} else {
				window.location.href = share_url;
			}
			return false;
		});
	});
	$(document).keyup(function(event){
		if (event.keyCode == 27) {
			document.location.href = '/wp-admin/';
		}
	});
})(jQuery);