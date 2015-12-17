<?php

class Home extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	
		$this->data['META_TITLE'] = 'Trang chủ :: ' . $this->data['META_TITLE'];
	}

	public function index()
	{	
		$this->load->view($this->data['PATH_VIEW'].'/include/header', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/home/index', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/include/footer', $this->data);
	}
}