<?php
    
function InitLibrary(&$instance)
{
	$instance->load->library('session');
	
	$instance->load->helper('smart_search_helper');
	$instance->load->helper('url_helper');
	$instance->load->helper('text_helper');
	$instance->load->helper('date_helper');
	
	$instance->load->model('X_model');
	
	$instance->load->library(array(	'smart_search'
							));
}

class My_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		InitLibrary($this);
		InitMobileDetect($this);
		InitPageNavigation($this);
		
		$this->data['META_SUBPAGE']		= NULL;
		$this->data['META_URL']			= URL_HOME;
		$this->data['META_IMG']			= '';

		$this->data['META_DESC'] = 'Smart search.';
		$this->data['META_KEYWORD'] = 'smart-search';

	}
	
	public $data;
}
?>