<?php

class Articles extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	
		$this->data['META_TITLE'] = 'Bài viết :: ' . $this->data['META_TITLE'];
		
		$this->load->model('Articles_model');
	}

	public function index()
	{	
		$this->load->view($this->data['PATH_VIEW'].'/include/header', $this->data);
		//$this->load->view($this->data['PATH_VIEW'].'/articles/index', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/include/footer', $this->data);
	}
	
	public function read()
	{
		$this->load->view($this->data['PATH_VIEW'].'/include/header', $this->data);
		//$this->load->view($this->data['PATH_VIEW'].'/articles/index', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/include/footer', $this->data);
	}
	
	public function category()
	{
		$this->load->view($this->data['PATH_VIEW'].'/include/header', $this->data);
		//$this->load->view($this->data['PATH_VIEW'].'/articles/index', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/include/footer', $this->data);
	}
	
	public function categories()
	{
		$this->load->view($this->data['PATH_VIEW'].'/include/header', $this->data);
		//$this->load->view($this->data['PATH_VIEW'].'/articles/index', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/include/footer', $this->data);
	}
	
	public function search($search_str = CHAR_EMPTY, $page = 1)
	{
		// VALIDATE
		$search_str = urldecode($search_str);

		// PERFORM REDIRECT TO #ID ARTICLE
		$id_temp = NULL;
		preg_match('/^#(\d+)/', $search_str, $id_temp);
		if ($id_temp != NULL)
		{
			$id_temp[1] = intval($id_temp[1]);
			$url_temp = $this->Articles_model->SelectArticleFriendlyURL($id_temp[1]);
			
			if ($url_temp != FALSE)
			{
				return redirect('http://www.stdio.vn'.'/articles/read/'.$id_temp[1].'/'.$url_temp->friendly_url, 'refresh');
				//return redirect(SMART_SEARCH_HOME.'/articles/read/'.$id_temp[1].'/'.$url_temp->friendly_url, 'refresh');
			}
		}
		
		// PERFORM REDIRECT TO #ID AUTHOR
		$id_temp = NULL;
		preg_match('/^&(\d+)/', $search_str, $id_temp);
		if ($id_temp != NULL)
		{
			$id_temp[1] = intval($id_temp[1]);
			return redirect('http://www.stdio.vn'.'/users/index/'.$id_temp[1], 'refresh');
		}
		
		$keywords = explode('|', $search_str);

		$this->load->view($this->data['PATH_VIEW'].'/include/header', $this->data);
		//$this->load->view($this->data['PATH_VIEW'].'/articles/index', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/include/footer', $this->data);
	}
}