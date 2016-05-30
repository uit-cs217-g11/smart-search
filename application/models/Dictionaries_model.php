<?php ob_start(); if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dictionaries_model extends CI_Model
{
	var $tbl_dictionaries	= 'dictionaries';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function InsertDictionaries($data)
	{
		$this->db->insert_batch($this->tbl_dictionaries, $data);
	}
	
	function DeleteWord($word)
	{
		$this->db->where('word', $word);
		$this->db->delete($this->tbl_dictionaries);
	}
}