<?php if ($page_title != 'RSS') { ?>

<html>
	<head>
		<title><?=$page_title?> - <?=$blog_title?></title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta name="author" content="Stephen Ou" />
		<meta name="copyright" content="Copyright <?=date('Y')?> - Stephen Ou" />
		<meta name="viewport" content="width=device-width, user-scalable=no" />
		<link rel="icon" type="image/jpeg" href="<?=$blog_url?>/media/me.jpg" />
		<script type="text/javascript">
		
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-32871674-1']);
			_gaq.push(['_trackPageview']);
		
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		
		</script>
		<style type="text/css">
			html {
				-webkit-text-size-adjust: none;
			}
			body {
				font-family: sans-serif;
				width: 640px;
				margin: auto;
			}
			.container {
				margin: 30px 20px;
			}
			nav, header, footer {
				text-align: center;
			}
			h1 {
				font-size: 25px;
			}
			h2 {
				font-size: 19px;
			}
			h3 {
				font-size: 18px;
			}
			h4 {
				font-size: 17px;
			}
			h5 {
				font-size: 16px;
			}
			h6 {
				font-size: 14px;
				margin: 12px 0;
			}
			article {
				line-height: 24px;
			}
			article p, article ul, article h2, article h3, article h4, article h5 {
				margin: 24px 0;
			}
			a {
				color: inherit;
				text-decoration: none;
				border-bottom: dotted 1px black;
				padding-bottom: 2px;
				font-weight: bold;
			}
			a:hover {
				border-bottom: solid 1px black;
			}
			a:active {
				position: relative;
				top: 1px;
			}
			hr {
				display: block;
				margin: 40px 0;
			}
			aside p {
				font-size: 13px;
				text-align: center;
			}
			img {
				max-width: 600px;
				margin: 10px 0;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<nav>
					<h1>
						<a href="<?=$blog_url?>"><?=$blog_title?></a>
					</h1>
					<h6>I have developed 7 successful web apps & programmed for a Fortune 1000 Company.</h6>
					<h6>I came to the US with little English in 2008. This blog is where I get better in writing.</h6>
					<h6>Website: <a href="http://stephenou.com" target="_blank">http://stephenou.com</a> - Twitter: <a href="http://twitter.com/#!/stephenou" target="_blank">@stephenou</a> - <a href="<?=$blog_url?>/rss">Subscribe via RSS</a></h6>
				<hr />
			</nav>
<?php foreach ($articles_output as $slug => $article) { ?>
			<article>
					<header>
						<h1>
							<a href="<?=$blog_url?>/<?=$slug?>"><?=$article['title']?></a>
						</h1>
					</header>
<?=$article['content']?>
					<aside>
						<p>Share: <a href="https://www.facebook.com/sharer/sharer.php?u=<?=urlencode($blog_url.'/'.$slug)?>" target="_blank">Facebook</a> - <a href="https://twitter.com/intent/tweet?text=<?=$article['title']?>&url=<?=urlencode($blog_url.'/'.$slug)?>" target="_blank">Twitter</a> - <a href="https://plus.google.com/share?url=<?=urlencode($blog_url.'/'.$slug)?>" target="_blank">Google+</a> - <a href="mailto:me@stephenou.com?subject=Comment on <?=$article['title']?>">Comment</a></p>
					</aside>
					<hr />
			</article>
<?php } ?>
			<footer>
					<h6>Copyright <?=date('Y')?>. Powered by <a href="http://stephenou.com/blog/about-infinitesimal">Infinitesimal</a>.</h6>
			</footer>
		</div>
	</body>
</html>

<?php } else {

$dom = new DOMDocument('1.0', 'UTF-8');
$base = $dom->createElement('rss');
$base->setAttribute('version', '2.0');
$channel = $dom->createElement('channel');

$title = $dom->createElement('title');
$title->appendChild($dom->createTextNode($blog_title));
$channel->appendChild($title);

$link = $dom->createElement('link');
$link->appendChild($dom->createTextNode($blog_url));
$channel->appendChild($link);

$description = $dom->createElement('description');
$description->appendChild($dom->createTextNode('The blog of Stephen Ou (http://stephenou.com).'));
$channel->appendChild($description);

foreach ($articles_output as $slug => $article) {

$item = $dom->createElement('item');

$title = $dom->createElement('title');
$title->appendChild($dom->createTextNode($article['title']));
$item->appendChild($title);

$link = $dom->createElement('link');
$link->appendChild($dom->createTextNode($blog_url.'/'.$slug));
$item->appendChild($link);

$description = $dom->createElement('description');
$description->appendChild($dom->createTextNode($article['content']));
$item->appendChild($description);

$pubDate = $dom->createElement('pubDate');
$pubDate->appendChild($dom->createTextNode(date(DateTime::RSS, $article['timestamp'])));
$item->appendChild($pubDate);

$channel->appendChild($item);

}

$base->appendChild($channel);
$dom->appendChild($base);
echo $dom->saveXML();

} ?>