<?php ob_start(); if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles_model extends CI_Model
{
	var $tbl_articles 	= 'articles';
	
	function __construct()
	{
		parent::__construct();
	}

	function SelectArticleFriendlyURL($article_id)
	{
		$this->db->select('a.friendly_url as friendly_url');
		
		$this->db->from($this->tbl_articles . ' as a');
		
		$this->db->where("a.id", $article_id);
		$query = $this->db->get();
		if ($query->num_rows() == 1)
			return $query->row();
		return FALSE;
	}
}