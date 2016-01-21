<?php ob_start(); if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles_model extends CI_Model
{
	var $tbl_articles 	= 'articles';
	var $tbl_keywords	= 'keywords';
	var $tbl_categories	= 'categories';
	var $tbl_accounts	= 'accounts';
	
	function __construct()
	{
		parent::__construct();
	}

	function SelectArticleFriendlyURL($article_id)
	{
		$this->db->select('a.friendly_url as friendly_url');
		
		$this->db->from($this->tbl_articles . ' as a');
		$this->db->where("a.article_id", $article_id);
		
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
							b.tags as tags,
							b.friendly_url as friendly_url,

							c.id as category_id,
							c.name as category_name,
							c.friendly_url as category_friendly_url,
							
							d.id as author_id,
							d.first_name as first_name,
							d.last_name as last_name,
							d.friendly_url as author_friendly_url');
		
		$this->db->select_sum('a.weight', 'sum_weight');
		$this->db->from($this->tbl_keywords . ' as a');
		$this->db->join($this->tbl_articles. ' as b', 'a.article_id = b.article_id');
		$this->db->join($this->tbl_categories . ' as c', 'b.category_id = c.id');
		$this->db->join($this->tbl_accounts . ' as d', 'b.author_id = d.id');
		
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
							b.title as title,
							b.description as description,
							b.content as content,
							b.tags as tags,
							b.friendly_url as friendly_url,
							b.base_url as base_url,
							
							c.id as category_id,
							c.name as category_name,
							c.friendly_url as category_friendly_url,
							
							d.id as author_id,
							d.first_name as first_name,
							d.last_name as last_name,
							d.friendly_url as author_friendly_url');
		
		$this->db->from($this->tbl_articles. ' as b');
		$this->db->join($this->tbl_categories . ' as c', 'b.category_id = c.id');
		$this->db->join($this->tbl_accounts . ' as d', 'b.author_id = d.id');
		$this->db->where('article_id', $article_id);

		$query = $this->db->get();
		return $query->row();
	}
	
	function EmptyTableArticle()
	{
		$this->db->truncate($this->tbl_articles);
	}
	
	function InsertArticle($article_id, $category_id, $title, $description, $author_id, $content, $tags, $friendly_url, $base_url)
	{
		$data = array(
			"article_id" =>$article_id,
			"category_id" => $category_id,
			"description" => $description,
			"title" => $title,
			"author_id" => $author_id,
			"content" => $content,
			"tags" => $tags,
			"friendly_url" => $friendly_url,
			"base_url" => $base_url
		);
		
		$this->db->insert($this->tbl_articles, $data);
			
		return $this->db->insert_id();
	}
	
	function CountAllArticles($category_id = 0)
	{
		$this->db->from($this->tbl_articles . ' as a');
		if($category_id != 0)
			$this->db->where('a.category_id', $category_id);
		
		return $this->db->count_all_results();
	}
	
	function SelectAllArticles()
	{
		$this->db->select(' b.article_id as article_id,
							b.category_id as category_id,
							b.title as title,
							b.description as description,
							b.content as content,
							b.tags as tags,
							b.friendly_url as friendly_url,
							b.base_url as base_url');
							
		$this->db->from($this->tbl_articles . ' as b');

		$query = $this->db->get();
		return $query->result();
	}
	
	function SelectArticlesBriefByCategoryId($category_id, $offset = 0, $limit = 0)
	{
		$this->db->select(' b.article_id as article_id,
							b.title as title,
							b.description as description,
							b.tags as tags,
							b.friendly_url as friendly_url,

							c.id as category_id,
							c.name as category_name,
							c.friendly_url as category_friendly_url,
							
							d.id as author_id,
							d.first_name as first_name,
							d.last_name as last_name,
							d.friendly_url as author_friendly_url');
							
		$this->db->from($this->tbl_articles . ' as b');
		$this->db->join($this->tbl_categories . ' as c', 'b.category_id = c.id');
		$this->db->join($this->tbl_accounts . ' as d', 'd.id = b.author_id');
		
		if($category_id != 0)
		{
			$this->db->where('category_id', $category_id);
		}
		
		if ($limit > 0)
		{
			$this->db->limit($limit, $offset);
		}
		
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
	
	function SelectAllCategories()
	{
		$this->db->select( 'a.id as id,
							a.name as category_name,
							a.parent_id as parent_id,
							a.friendly_url as friendly_url');
		$this->db->from($this->tbl_categories . ' as a');

		$query = $this->db->get();
		return $query->result();
	}
	
	function SelectPromoteCategories()
	{
		$this->db->select( 'a.id as id,
							a.name as category_name,
							a.parent_id as parent_id,
							a.friendly_url as friendly_url');
		$this->db->from($this->tbl_categories . ' as a');
		$this->db->where('a.promote', 1);

		$query = $this->db->get();
		return $query->result();
	}
}