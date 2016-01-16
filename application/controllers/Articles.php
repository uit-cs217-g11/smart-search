<?php

class Articles extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	
		$this->data['META_TITLE'] = 'Bài viết :: ' . $this->data['META_TITLE'];
		
		$this->load->model('articles_model');
	}

	public function index()
	{	
		$this->load->view($this->data['PATH_VIEW'].'/include/header', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/articles/index', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/include/footer', $this->data);
	}
	
	public function read($id = CHAR_EMPTY)
	{
		if ($id == CHAR_EMPTY)
		{
			return redirect('/articles', 'refresh');
		}
		
		$id = explode('-', $id)[0];
		
		$this->data['Article'] = $this->articles_model->SelectArticlesByArticleId($id);
		
		/*if ($this->data['Article'])
		{
			$this->data['META_TITLE'] = $this->data['Article']->title . ' :: ' . $this->data['META_TITLE'];
			$this->data['META_DESC'] = $this->data['Article']->description;
			$this->data['META_URL'] = SMART_SEARCH_HOME.'/articles/read/'.$this->data['Article']->id.'/'.$this->data['Article']->friendly_url;
		
		}
		else
		{
			return redirect('/articles', 'refresh');
		}*/

		$this->load->view($this->data['PATH_VIEW'].'/include/header', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/articles/read', $this->data);
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
			//$url_temp = $this->Articles_model->SelectArticleFriendlyURL($id_temp[1]);
			
			//if ($url_temp != FALSE)
			//{
				return redirect('http://www.stdio.vn'.'/articles/read/'.$id_temp[1], 'refresh');
				//return redirect(SMART_SEARCH_HOME.'/articles/read/'.$id_temp[1].'/'.$url_temp->friendly_url, 'refresh');
			//}
		}
		
		// PERFORM REDIRECT TO #ID AUTHOR
		$id_temp = NULL;
		preg_match('/^&(\d+)/', $search_str, $id_temp);
		if ($id_temp != NULL)
		{
			$id_temp[1] = intval($id_temp[1]);
			return redirect('http://www.stdio.vn'.'/users/index/'.$id_temp[1], 'refresh');
		}

		$keywords = explode('+', $search_str);
		
		$PAGE_NUM = $page;
		$PAGE_LIMIT = 20;
		$PAGE_OFFSET = $PAGE_LIMIT * ($PAGE_NUM - 1);
		$PAGE_COUNT = -1;
		
		$PAGE_COUNT = $this->articles_model->CountArticleByKeywords($keywords);

		$this->data['keywords'] = $search_str;
		$this->data['articles_brief'] = $this->articles_model->SelectArticlesBriefByKeywords($keywords, $PAGE_OFFSET, $PAGE_LIMIT);
		
		$this->data['PAGINATION_STR'] = GetPaging($PAGE_NUM, $PAGE_COUNT, $PAGE_LIMIT, 'articles', 'search', -1, $search_str);
		
		// TODO
		// Add Paging

		$this->load->view($this->data['PATH_VIEW'].'/include/header', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/articles/search', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/include/footer', $this->data);
	}
}