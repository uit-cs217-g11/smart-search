<?php ob_start(); if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class X_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function SelectAllX($table, $limit = 0, $offset = 0)
	{
		$this->db->select('*');
		$this->db->from($table);
        
		if ($limit > 0)
			$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		return $query->result();
	}

	public function SelectXById($table, $id_name, $id_value)
	{
		$this->db->select('*');

		$this->db->from($table);
		
		$this->db->where($id_name, $id_value);
		
		$query = $this->db->get();
		if ($query->num_rows() == 1)
			return $query->row();
		return NULL;
	}

	public function UpdateXById($table, $id_name, $id_value, $name, $value)
	{
		$data = array($name => $value);
		
		$this->db->where($id_name, $id_value);
		$this->db->update($table, $data);
		
		return ($this->db->affected_rows() > 0);
	}
}