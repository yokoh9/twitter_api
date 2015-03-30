$(function() {
	var $win = $(window),
				
			$section = $('.content'),
			contentH = 2200,
			speed = 20,
			
			//背景画像サイズ設定
			bgw = 1280,
			bgh = 1024,
			sw = $win.width(),
			sh = $win.height(),
			//アスペクト比
			bgRatio = bgw / bgh,
			sRatio = sw / sh;


	//sectionの高さを設定
	$section.css('height', contentH);

	//アスペクト比で background-size設定を切替え
	// if(sRatio < bgRatio){
	if(sRatio < 1.34){
		$section.css('backgroundSize', 'auto 108%');
	} else {
		$section.css('backgroundSize', 'cover');
	}
	// if(sw > bgw){
	// 	$section.css('backgroundSize', 'cover');
	// } else {
	// 	$section.css('backgroundSize', 'auto 108%');
	// }


	$section.each(function(index) {
		var $self = $(this);

		$win.scroll(function() {
			var posY = -($win.scrollTop() / speed),
					dist = contentH / speed;

			//2つ目以降のsectionの background-position(Y)を設定
			posY += dist * index;
			var bgPos = '50% ' + posY + 'px';
			$self.css('backgroundPosition', bgPos);

			// タイトル文字
			$('.sprite', $self).each(function() {
				var $sprite = $(this);
				var posY = -($win.scrollTop() / $sprite.data('speed')) + $sprite.data('offsety');
				$sprite.css('position', 'fixed');
				$sprite.css('top', posY);
			});

			//tweetbox
			$('.tweetbox').each(function(){
				var offsetValue = $(this).offset();

				//画面内に入ったら表示
				if ((($win.scrollTop() + sh) > offsetValue.top) && ($win.scrollTop() < (offsetValue.top - 80))) {
					if(!$(this).is('show')){
						return $(this).addClass('show').animate({
							'opacity': 1
						},
						{
							duration: 800,
							queue: false
						});
					}
				} else if($(this).is('.show')){
					return $(this).removeClass('show').animate({
						'opacity': 0
					},
					{
						duration: 1000,
						queue: false
					});
				}
			}); //tweetbox

		}); //$win.scroll
	});

});