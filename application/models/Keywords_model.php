<?php ob_start(); if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Keywords_model extends CI_Model
{
	var $tbl_keywords	= 'keywords';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function InsertKeyword($word, $weight, $tf, $article_id)
	{
		$data = array(
				"word"			=> $word,
				"weight"		=> $weight,
				"tf"			=> $tf,
				"idf"			=> 0,
				"article_id"	=> $article_id
		);
		
		$this->db->insert($this->tbl_keywords, $data);
		
		return $this->db->insert_id();
	}
	
	function InsertKeywords($data)
	{
		$this->db->insert_batch($this->tbl_keywords, $data);
	}
	
	function EmptyTableKeywords()
	{
		$this->db->truncate($this->tbl_keywords);
	}
}