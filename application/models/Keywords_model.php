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
	
	function SelectDistinctKeywords()
	{
		$this->db->distinct();
		$this->db->from($this->tbl_keywords);

		$query = $this->db->get();
		return $query->result();
	}
	
	function SelectKeywords($word)
	{
		$this->db->select(' a.id as id,
							a.word as word,
							a.tf as tf');
							
		$this->db->from($this->tbl_keywords . ' as a');
		$this->db->where('a.word', $word);
		
		$query = $this->db->get();
		return $query->result();
	}
	
	function UpdateWeightTfAndIdfByWord($word, $weight, $idf)
	{
		$data = array(
			"word"			=> $word,
			"weight"		=> $weight,
			"idf"			=> $idf,
		);
		
		$this->db->where("word", $word);
		$this->db->update($this->tbl_keywords, $data);

		if($this->db->affected_rows() > 0)
			return TRUE;
		return FALSE;
	}
	
	function CountAllKeywords()
	{
		$this->db->from($this->tbl_keywords);
		return $this->db->count_all_results();
	}
}