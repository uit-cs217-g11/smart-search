<?php

class Refresh extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	
		$this->data['META_TITLE'] = 'Cập nhật :: ' . $this->data['META_TITLE'];
		
		$this->load->model("Articles_model");
	}
	
	public function index()
	{
		return redirect(SMART_SEARCH_HOME);
	}
	
	public function articles()
	{
		
		
		return redirect(SMART_SEARCH_HOME);
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
}