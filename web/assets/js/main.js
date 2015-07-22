$(document).ready( function() {


	if ($(window).width() < 992) {
		$('.header-list-item').click( function(e) {
			e.preventDefault();

			if (!$(this).hasClass('opened')) {
				$('.header-list-item').removeClass('opened');
				$(this).addClass('opened');
			} else {
				$(this).removeClass('opened');
			}
		});
	}

	$('.header-arrow').click( function(e) {
		e.preventDefault();
		$('body').animate({
			scrollTop: $('.concept').offset().top
		});
	});

	$('#header .apple').click( function(e) {
		$('.messageMicrosoft').hide();
		$('.messageApple').show();
		$('.microsoft').removeClass("current");
		$(this).addClass("current");
	});

	$('#header .microsoft').click( function(e) {
		$('.messageApple').hide();
		$('.messageMicrosoft').show();
		$('.apple').removeClass("current");
		$(this).addClass("current");
	});

});