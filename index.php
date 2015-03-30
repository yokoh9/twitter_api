<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Twitter API</title>
<link rel="stylesheet" href="https://raw.github.com/necolas/normalize.css/master/normalize.css">
<link rel="stylesheet" href="css/style.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>
</head>
<body>

<?php
	require 'lib/TwistOAuth.phar';

	// OAuth認証
	$consumer_key = 'k8JU8euWmVwtakbUAhEVTUFSW';
	$consumer_secret = 'zDLTmKiS7Uw983NPCm440IkQZhshwdsZAkQM2pZ6Xy3pe7Avft';
	$access_token = '106014863-lDb9tSSODscul6cE9FgvTzVne6xtJdvRUf220LyQ';
	$access_token_secret = 'AXc6dXlBFqeW2DPu52scBR9GSef0U74PcLP0eeQlkPwqR';

	// 認証
	$connection = new TwistOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);

	// tweetの表示
	function disp_tweet($value, $text){
		$icon_url = $value->user->profile_image_url;
		$screen_name = $value->user->screen_name;
		$updated = date('Y/m/d H:i', strtotime($value->created_at));
		$tweet_id = $value->id_str;
		$url = 'https://twitter.com/' . $screen_name . '/status/' . $tweet_id;

		echo '<div class="tweetbox">' . PHP_EOL;
		echo '<div class="thumb">' . '<img alt="" src="' . $icon_url . '">' . '</div>' . PHP_EOL;
		echo '<div class="meta"><a target="_blank" href="' . $url . '">' . $updated . '</a>' . '<br>@' . $screen_name .'</div>' . PHP_EOL;
		echo '<div class="tweet">' . $text . '</div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
	}
?>


<div id="container">

	<section id="section_ttl" class="content">
		<h1>
			<span class="ttl01 sprite" data-speed="1.4" data-offsety="300">T</span>
			<span class="ttl02 sprite" data-speed="1.6" data-offsety="300">w</span>
			<span class="ttl03 sprite" data-speed="2.0" data-offsety="300">i</span>
			<span class="ttl04 sprite" data-speed="2.4" data-offsety="300">t</span>
			<span class="ttl05 sprite" data-speed="2.8" data-offsety="300">t</span>
			<span class="ttl06 sprite" data-speed="3.2" data-offsety="300">e</span>
			<span class="ttl07 sprite" data-speed="3.6" data-offsety="300">r</span>
			<span class="ttl08 sprite" data-speed="4.0" data-offsety="300">A</span>
			<span class="ttl09 sprite" data-speed="4.4" data-offsety="300">P</span>
			<span class="ttl10 sprite" data-speed="4.8" data-offsety="300">I</span>
		</h1>
		<div class="text_box sprite" data-speed="4.0" data-offsety="450">
			<ul>
				<li><a href="https://dev.twitter.com/" target="_blank">Developers</a> &gt; <a href="https://dev.twitter.com/overview/documentation" target="_blank">Documentation</a> &gt; <a href="https://dev.twitter.com/overview/documentation" target="_blank">REST APIs</a></li>
				<li><a href="https://dev.twitter.com/rest/tools/console" target="_blank">Exploring the Twitter API</a> *required twitter sign in</li>
				<li><a href="http://qiita.com/drafts/760e432ebd39040d5a0f" target="_blank">Qiita : Twitter APIでつぶやきを取得する</a></li>
			</ul>
		</div>
	</section>


	<section id="section1" class="content">
		<div class="title_area">
			<h2>検索キーワードを含むツイート</h2>
			<p>⇒　<a href="https://dev.twitter.com/rest/reference/get/search/tweets" target="_blank">GET search/tweets</a> / Parameters : q</p>
		</div>

		<div class="tweet_area">
			<?php
				$tweets_params = ['q' => '夜景,きれい OR キレイ OR 綺麗 OR 奇麗' ,'count' => '11'];
				$tweets = $connection->get('search/tweets', $tweets_params)->statuses;

				foreach ($tweets as $value) {
					$text = htmlspecialchars($value->text, ENT_QUOTES, 'UTF-8', false);
					$keywords = preg_split('/,|\sOR\s/', $tweets_params['q']); //配列化

					foreach ($keywords as $key) {
						// str_ireplace: 大文字小文字を区別しない（ ⇔ str_replace）
						$text = str_ireplace($key, '<span class="keyword">'.$key.'</span>', $text);
					}
					disp_tweet($value, $text);
				}
			?>
		</div><!-- /.tweet_area -->
	</section>


	<section id="section2" class="content">
		<div class="tweet_area">
			<?php
				$tweets_params = ['q' => 'さくら OR 桜 OR 花見,咲,開花' ,'count' => '11', 'lang'=>'ja'];
				$tweets = $connection->get('search/tweets', $tweets_params)->statuses;

				foreach ($tweets as $value) {
					$text = htmlspecialchars($value->text, ENT_QUOTES, 'UTF-8', false);
					$keywords = preg_split('/,|\sOR\s/', $tweets_params['q']); //配列化

					foreach ($keywords as $key) {
						$text = str_ireplace($key, '<span class="keyword">'.$key.'</span>', $text);
					}
					disp_tweet($value, $text);
				}
			?>
		</div><!-- /.tweet_area -->
	</section>


	<section id="section3" class="content">
		<div class="tweet_area">
			<?php
				$tweets_params = ['q' => 'ありがと OR サンキュ OR 感謝 OR "Thank you" OR "THANK YOU" OR Thanks' ,'count' => '11', 'lang'=>'ja'];
				$tweets = $connection->get('search/tweets', $tweets_params)->statuses;

				foreach ($tweets as $value) {
					$text = htmlspecialchars($value->text, ENT_QUOTES, 'UTF-8', false);
					$keywords = preg_split('/\sOR\s/', $tweets_params['q']); //配列化

					foreach ($keywords as $key) {
						$text = str_ireplace($key, '<span class="keyword">'.$key.'</span>', $text);
					}
					disp_tweet($value, $text);
				}
			?>
		</div><!-- /.tweet_area -->
	</section>


	<section id="section4" class="content">
		<div class="title_area">
			<h2>指定したハッシュタグを含むツイートを表示</h2>
			<p>⇒　<a href="https://dev.twitter.com/rest/reference/get/search/tweets" target="_blank">GET search/tweets</a> / Parameters : q</p>
		</div>

		<div class="tweet_area">
			<?php
				$hash_params = ['q' => '#html5,#css3' ,'count' => '11', 'lang'=>'ja'];
				$hash = $connection->get('search/tweets', $hash_params)->statuses;

				foreach ($hash as $value) {
					$text = htmlspecialchars($value->text, ENT_QUOTES, 'UTF-8', false);
					$hashes = explode(',', $hash_params['q']); //配列化

					foreach ($hashes as $hash) {
						$text = str_ireplace($hash, '<span class="keyword">'.$hash.'</span>', $text);
					}

					disp_tweet($value, $text);
				}
			?>
		</div><!-- /.tweet_area -->
	</section>


	<section id="section5" class="content">
		<div class="title_area">
			<h2>指定位置から投稿されたツイートを表示</h2>
			<p>⇒　<a href="https://dev.twitter.com/rest/reference/get/search/tweets" target="_blank">GET search/tweets</a> / Parameters : geocode</p>
		</div>

		<div class="tweet_area">
			<?php
				$geo_params = ['geocode' => '35.710063,139.8107,0.2km' ,'count' => '11'];
				$geo = $connection->get('search/tweets', $geo_params)->statuses;

				$link_zoom = "18";	//リンク先のGoogle Mapsのズーム値
				$static_width = "240";	//Static Mapsの画像サイズ横幅(指定した2倍になる)
				$static_height = "120";	//Static Mapsの画像サイズ縦幅(指定した2倍になる)
				$static_zoom = "16";	//Static Mapsのズーム値

				foreach ($geo as $value) {
					$text = htmlspecialchars($value->text, ENT_QUOTES, 'UTF-8', false);
					$point = $value->geo->coordinates[0] . ',' . $value->geo->coordinates[1];

					$icon_url = $value->user->profile_image_url;
					$screen_name = $value->user->screen_name;
					$updated = date('Y/m/d H:i', strtotime($value->created_at));
					$tweet_id = $value->id_str;
					$url = 'https://twitter.com/' . $screen_name . '/status/' . $tweet_id;

					//Google Mapsへのリンクを生成
					$map_link = '<a href="https://www.google.co.jp/maps/@'.$point.','.$link_zoom.'z" target="_blank">地図</a>';
					//Google Static Mapsの画像を生成
					$static_map = '<a href="https://www.google.co.jp/maps/@'.$point.','.$link_zoom.'z" target="_blank"><img src="http://maps.googleapis.com/maps/api/staticmap?center='.$point.'&zoom='.$static_zoom.'&size='.$static_width.'x'.$static_height.'&scale=2&markers=color:red%7C'.$point.'&sensor=false" width="'.$static_width.'" height="'.$static_height.'" alt=""></a>';

					echo '<div class="tweetbox">' . PHP_EOL;
					echo '<div class="thumb">' . '<img alt="" src="' . $icon_url . '">' . '</div>' . PHP_EOL;
					echo '<div class="meta"><a target="_blank" href="' . $url . '">' . $updated . '</a>' . '<br>@' . $screen_name .'</div>' . PHP_EOL;
					echo '<div class="tweet">' . $text . '</div>' . PHP_EOL;
					// echo '<div class="map">' . $map_link . '</div>' . PHP_EOL;
					echo '<div class="map">' . $static_map . '</div>' . PHP_EOL;
					echo '</div>' . PHP_EOL;
				}

				//座標の処理
				if(isset($geo->coordinates) && !empty($geo->coordinates) && count($geo->coordinates)>1){
					//座標
					$point = "{$geo->coordinates[0]},{$geo->coordinates[1]}";
					//Google Mapsへのリンクを生成
					$link = '<a href="https://www.google.co.jp/maps/@'.$point.','.$link_zoom.'z" target="_blank">地図</a>';
					//Google Static Mapsの画像を生成
					$static = '<img src="http://maps.googleapis.com/maps/api/staticmap?center='.$point.'&zoom='.$static_zoom.'&size='.$static_width.'x'.$static_height.'&scale=2&markers=color:red%7C'.$point.'&sensor=false" alt="">';
				}
			?>
		</div><!-- /.tweet_area -->
	</section>


	<section id="section6" class="content">
		<div class="title_area">
			<h2>アカウントのタイムラインを表示</h2>
			<p>⇒　<a href="https://dev.twitter.com/rest/reference/get/statuses/home_timeline" target="_blank">GET statuses/home_timeline</a></p>
		</div>

		<div class="tweet_area">
			<?php
				$home_params = ['count' => '11'];
				$home = $connection->get('statuses/home_timeline', $home_params);

				foreach ($home as $value) {
					$text = htmlspecialchars($value->text, ENT_QUOTES, 'UTF-8', false);
					disp_tweet($value, $text);
				}
			?>
		</div><!-- /.tweet_area -->
	</section>


	<section id="section7" class="content">
		<div class="title_area">
			<h2>アカウントのツイートを表示</h2>
			<p>⇒　<a href="https://dev.twitter.com/rest/reference/get/statuses/user_timeline" target="_blank">GET statuses/user_timeline</a></p>
		</div>

		<div class="tweet_area">
			<?php
				$user_params = ['count' => '11'];
				$user = $connection->get('statuses/user_timeline', $user_params);

				foreach ($user as $value) {
					$text = htmlspecialchars($value->text, ENT_QUOTES, 'UTF-8', false);
					disp_tweet($value, $text);
				}
			?>
		</div><!-- /.tweet_area -->
	</section>


</div><!-- /#container -->

</body>
</html>