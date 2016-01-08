<?php ob_start(); if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crawl_model extends CI_Model
{
	var $tbl_articles 	= 'articles';
	
	
	function __construct()
	{
		parent::__construct();
	}

	function getPage($url, $referer, $timeout, $header)
	{
		if(!isset($timeout))
			$timeout=30;
		$curl = curl_init();
		if(strstr($referer,"://")){
			curl_setopt ($curl, CURLOPT_REFERER, $referer);
		}
		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt ($curl, CURLOPT_TIMEOUT, $timeout);
		curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
		//curl_setopt ($curl, CURLOPT_HEADER, (int)$header);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$html = curl_exec ($curl);
		curl_close ($curl);
		return $html;
	}
	
	function getBetween($content, $start, $end)
	{
		$r = explode($start, $content);
		if (isset($r[1])){
			$r = explode($end, $r[1]);
			return $r[0];
		}
		return '';
	}
	
	function getArticle($articleHtml)
	{
		$category_id = $this->getBetween($articleHtml, '<a href="/articles/category/', '/');
		$title = $this->getBetween($articleHtml, '<h1 itemprop="name">', '</h1>');
		$author_id = $this->getBetween($articleHtml, '<a href="/users/index/', '/');
		$content = $this->getBetween($articleHtml, '<article class="article_content" itemprop="articleBody">', '</article>');
		$content = trim($content);
			
		$tags = null;
		$tagInfo = substr($articleHtml, strpos($articleHtml, '<div class="ele_tag">'));

		preg_match_all('/<div class=\"ele_tag\">(.*?)<\/div>/s',$tagInfo, $tags);
		array_shift($tags);
		array_splice($tags[0], 0, 1);
		
		$tagsStr = implode("|", $tags[0]);
		
		$friendly_url = Title2FrienlyUrl($title);
		
		$article = array(
			"category_id" => $category_id,
			"title" => $title,
			"author_id" => $author_id,
			"content" => $content,
			"tags" => $tagsStr,
			"friendly_url" => $friendly_url
		);
		
		return $article;
	}
}