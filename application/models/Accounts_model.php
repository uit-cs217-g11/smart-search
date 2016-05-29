<?php ob_start(); if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_model extends CI_Model
{
	var $tbl_accounts	= 'accounts';
	
	function __construct()
	{
		parent::__construct();
	}
	
    function InsertAccount($a_id, $a_name, $a_friendly_url)
    {
        $data = array(
			"account_id" =>$a_id,
			"name" => $a_name,
			"friendly_url" => $a_friendly_url,
		);
		
		$this->db->insert($this->tbl_accounts, $data);
			
		return $this->db->insert_id();
    }
}