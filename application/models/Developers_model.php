<?php ob_start(); if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Developers_model extends CI_Model
{
	var $tbl_developers	= 'developers';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function SelectAllDevelopers()
	{
		$this->db->select(' a.id as id,
							a.first_name as first_name,
							a.last_name as last_name,
							a.description as description,
							a.avatar as avatar,
							a.url as url');
		$this->db->from($this->tbl_developers . ' as a');
		
		$query = $this->db->get();
		return $query->result();
	}
}