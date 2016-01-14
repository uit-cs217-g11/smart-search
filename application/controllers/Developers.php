<?php

class Developers extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	
		$this->data['META_TITLE'] = 'Nhóm phát triển :: ' . $this->data['META_TITLE'];
		
		$this->load->model('developers_model');
	}

	public function index()
	{
		$this->data['developers'] = $this->developers_model->SelectAllDevelopers();
		
		$this->load->view($this->data['PATH_VIEW'].'/include/header', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/developers/index', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/include/footer', $this->data);
	}
}