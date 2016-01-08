<?php ob_start(); if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles_model extends CI_Model
{
	var $tbl_articles 	= 'articles';
	var $tbl_keywords	= 'keywords';
	
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
	
	function SelectArticlesBriefByKeywords($keywords = NULL)
	{
		if($keywords == NULL)
			return FALSE;
			
		$this->db->select(' b.id as id,
							b.category_id as category_id,
							b.title as title,
							b.description as description,
							b.author_id as author_id,
							b.content as content,
							b.tag as tag,
							b.friendly_url as friendly_url');
		
		$this->db->select_sum('a.weight');
		$this->db->from($this->tbl_keywords . ' as a');
		$this->db->join($this->tbl_articles. ' as b', 'a.article_id = b.id');
		
		$this->db->where_in('a.word', $keywords);
		$this->db->group_by('article_id');
		$this->db->order_by('weight', 'desc');
		
		$query = $this->db->get();
		return $query->result();
	}
	
	function EmptyTableArticle()
	{
		
	}
	
	function InsertArticle($category_id, $title, $description, $author_id, $content, $tag, $friendly_url)
	{
		
	}
}