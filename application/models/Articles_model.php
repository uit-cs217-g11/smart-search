<?php ob_start(); if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles_model extends CI_Model
{
	var $tbl_articles 	= 'articles';
	var $tbl_keywords	= 'keywords';
	var $tbl_categories	= 'categories';
	
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
	
	function SelectArticlesBriefByKeywords($keywords = NULL, $offset = 0, $limit = 0)
	{
		if($keywords == NULL)
			return FALSE;
			
		$this->db->select(' b.article_id as article_id,
							b.title as title,
							b.description as description,
							b.author_id as author_id,
							b.tags as tags,
							b.friendly_url as friendly_url,
							
							c.id as category_id,
							c.name as category_name,
							c.friendly_url as category_friendly_url');
		
		$this->db->select_sum('a.weight');
		$this->db->from($this->tbl_keywords . ' as a');
		$this->db->join($this->tbl_articles. ' as b', 'a.article_id = b.article_id');
		$this->db->join($this->tbl_categories . ' as c', 'b.category_id = c.id');
		
		$this->db->like('a.word', array_values($keywords)[0]);
		array_shift($keywords);
		
		foreach($keywords as $item)
		{
			$this->db->or_like('a.word', $item);
		}
		
		$this->db->group_by('article_id');
		$this->db->order_by('weight', 'desc');
		
		if ($limit > 0)
		{
			$this->db->limit($limit, $offset);
		}
		
		$query = $this->db->get();
		return $query->result();
	}
	
	function SelectArticlesByArticleId($article_id)
	{
		if($article_id == NULL)
			return FALSE;
			
		$this->db->select(' b.article_id as article_id,
							b.category_id as category_id,
							b.title as title,
							b.description as description,
							b.author_id as author_id,
							b.content as content,
							b.tags as tags,
							b.friendly_url as friendly_url');
		
		$this->db->from($this->tbl_articles. ' as b');
		$this->db->where_in('article_id', $article_id);

		$query = $this->db->get();
		return $query->result();
	}
	
	function EmptyTableArticle()
	{
		$this->db->truncate($this->tbl_articles);
	}
	
	function InsertArticle($article_id, $category_id, $title, $description, $author_id, $content, $tags, $friendly_url)
	{
		$data = array(
			"article_id" =>$article_id,
			"category_id" => $category_id,
			"description" => $description,
			"title" => $title,
			"author_id" => $author_id,
			"content" => $content,
			"tags" => $tags,
			"friendly_url" => $friendly_url
		);
		
		$this->db->insert($this->tbl_articles, $data);
			
		return $this->db->insert_id();
	}
	
	function CountAllArticles()
	{
		$this->db->from($this->tbl_articles);
		return $this->db->count_all_results();
	}
	
	function SelectAllArticles()
	{
		$this->db->select(' b.article_id as article_id,
							b.category_id as category_id,
							b.title as title,
							b.description as description,
							b.author_id as author_id,
							b.content as content,
							b.tags as tags,
							b.friendly_url as friendly_url');
							
		$this->db->from($this->tbl_articles . ' as b');
		
		$query = $this->db->get();
		return $query->result();
	}
	
	function CountArticleByKeywords($keywords = NULL)
	{
		if ($keywords == NULL)
		{
			return 0;
		}
		
		$this->db->from($this->tbl_keywords . ' as a');
		$this->db->like('a.word', array_values($keywords)[0]);
		array_shift($keywords);
		
		foreach($keywords as $item)
		{
			$this->db->or_like('a.word', $item);
		}
		
		$this->db->group_by('article_id');
		
		$query = $this->db->get();
        return $query->num_rows();
	}
}