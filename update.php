<?php

define('MARKDOWN_SUFFIX', '.markdown');
define('HTML_SUFFIX', '.html');
define('RSS_SUFFIX', '.xml');
define('POSTS_PATH', 'posts');
define('MEDIA_PATH', 'media');
define('CACHE_PATH', 'cache');
define('TEMPLATE_PATH', 'template.php');
define('HOMEPAGE_SLUG', 'home');
define('RSS_SLUG', 'rss');
define('DATAFILE_NAME', 'datafile.json');
define('BLOG_URL', 'http://stephenou.com/blog');
define('BLOG_TITLE', 'Stephen Ou\'s Blog');

include('markdown.php');

$articles = array();
$copies = array();

$posts = scandir(POSTS_PATH);
$json = json_decode(file_get_contents(CACHE_PATH.'/'.DATAFILE_NAME), true);

foreach ($posts as $post) {
	if (substr($post, strlen(MARKDOWN_SUFFIX) * -1) == MARKDOWN_SUFFIX) {
		$content = @file_get_contents(POSTS_PATH.'/'.$post);
		if ($content) {
			$title = remove_markdown_suffix($post);
			$slug = title_to_slug($title);
			$articles[$slug]['title'] = $title;
			$articles[$slug]['content'] = markdown($content);
			$articles[$slug]['timestamp'] = $json[$slug];
		}
	}
}
uasort($articles, 'sort_by_timestamp');

$caches = scandir(CACHE_PATH);

foreach ($caches as $cache) {
	if (substr($cache, strlen(HTML_SUFFIX) * -1) == HTML_SUFFIX) {
		$slug = remove_html_suffix($cache);
		if ($slug != HOMEPAGE_SLUG && $slug != RSS_SLUG && !array_key_exists($slug, $articles)) {
			unlink(CACHE_PATH.'/'.$slug.HTML_SUFFIX);
			echo 'Removed: '.$slug.'<br />';
		} else {
			$copies[$slug] = file_get_contents(CACHE_PATH.'/'.$slug.HTML_SUFFIX);
		}
	}
}

$blog_url = BLOG_URL;
$blog_title = BLOG_TITLE;

foreach ($articles as $filename => $article) {
	unset($articles_output);
	$articles_output[$filename] = $article;
	$page_title = $article['title'];
	ob_start();
	include(TEMPLATE_PATH);
	$html = ob_get_contents();
	ob_end_clean();
	if (isset($copies[$filename])) {
		if ($copies[$filename] != $html) {
			file_put_contents(CACHE_PATH.'/'.$filename.HTML_SUFFIX, $html);
			echo 'Edited: <a href="'.BLOG_URL.'/'.$filename.'">'.$filename.'</a><br />';
		} else {
			echo 'Unchanged: <a href="'.BLOG_URL.'/'.$filename.'">'.$filename.'</a><br />';
		}
	} else {
		file_put_contents(CACHE_PATH.'/'.$filename.HTML_SUFFIX, $html);
		$json = json_decode(file_get_contents(CACHE_PATH.'/'.DATAFILE_NAME), true);
		if (!isset($json[$filename])) $json[$filename] = time();
		file_put_contents(CACHE_PATH.'/'.DATAFILE_NAME, json_encode($json));
		echo 'Created: <a href="'.BLOG_URL.'/'.$filename.'">'.$filename.'</a><br />';
		
	}
}

$posts = scandir(POSTS_PATH);
$json = json_decode(file_get_contents(CACHE_PATH.'/'.DATAFILE_NAME), true);

foreach ($posts as $post) {
	if (substr($post, strlen(MARKDOWN_SUFFIX) * -1) == MARKDOWN_SUFFIX) {
		$content = @file_get_contents(POSTS_PATH.'/'.$post);
		if ($content) {
			$title = remove_markdown_suffix($post);
			$slug = title_to_slug($title);
			$articles[$slug]['title'] = $title;
			$articles[$slug]['content'] = markdown($content);
			$articles[$slug]['timestamp'] = $json[$slug];
		}
	}
}
uasort($articles, 'sort_by_timestamp');

$filename = HOMEPAGE_SLUG;
$articles_output = $articles;
$page_title = 'Home';
ob_start();
include(TEMPLATE_PATH);
$html = ob_get_contents();
ob_end_clean();
file_put_contents(CACHE_PATH.'/'.$filename.HTML_SUFFIX, $html);
echo 'Edited: <a href="'.BLOG_URL.'">'.$filename.'</a><br />';

$filename = RSS_SLUG;
$articles_output = $articles;
$page_title = 'RSS';
ob_start();
include(TEMPLATE_PATH);
$html = ob_get_contents();
ob_end_clean();
file_put_contents(CACHE_PATH.'/'.$filename.RSS_SUFFIX, $html);
echo 'Edited: <a href="'.BLOG_URL.'/'.$filename.'">'.$filename.'</a><br />';

function remove_markdown_suffix($title) {
	return substr($title, 0, strlen(MARKDOWN_SUFFIX) * -1);
}

function remove_html_suffix($title) {
	return substr($title, 0, strlen(HTML_SUFFIX) * -1);
}

function title_to_slug($title) {
	return trim(preg_replace('/[^a-z0-9-]+/ms', '-', strtolower($title)), '-');
}

function sort_by_timestamp($a, $b) {
	return $b['timestamp'] - $a['timestamp'];
}

?>