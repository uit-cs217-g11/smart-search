<?php

class Articles extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	
		$this->data['META_TITLE'] = 'Bài viết :: ' . $this->data['META_TITLE'];
		
		$this->load->model('articles_model');
	}

	public function index($category_id = 0, $friendly_url = 'all', $page = 1)
	{	
		$PAGE_NUM = $page;
		$PAGE_LIMIT = 20;
		$PAGE_OFFSET = $PAGE_LIMIT * ($PAGE_NUM - 1);
		$PAGE_COUNT = $this->articles_model->CountAllArticles($category_id);
		
		$this->data['PAGINATION_STR'] = GetPaging($PAGE_NUM, $PAGE_COUNT, $PAGE_LIMIT, 'articles', 'index', (int) $category_id, $friendly_url);
		
		$this->data['promote_categories'] = $this->articles_model->SelectPromoteCategories();
		$this->data['current_category'] = $category_id;
		
		$this->data['brief_articles'] = $this->articles_model->SelectArticlesBriefByCategoryId($category_id, $PAGE_OFFSET, $PAGE_LIMIT);
		
		
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

		$article = $this->articles_model->SelectArticlesByArticleId($id);
		$article->tags = unserialize($article->tags);

		if ($article != FALSE)
		{
			$this->data['META_TITLE'] = $article->title . ' :: ' . $this->data['META_TITLE'];
			$this->data['META_DESC'] = $article->description;
			$this->data['META_URL'] = SMART_SEARCH_HOME.'/articles/read/'.$article->article_id.'/'.$article->friendly_url;
		}
		else
		{
			//return redirect('/articles', 'refresh');
		}
		
		$this->data['article'] = $article;

		$this->load->view($this->data['PATH_VIEW'].'/include/header', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/articles/read', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/include/footer', $this->data);
	}
	
	public function categories()
	{
		$this->data['META_TITLE'] = 'Chủ đề :: ' . $this->data['META_TITLE'];
		$this->data['META_DESC'] = 'Các chủ đề lập trình và công nghệ thông tin của STDIO.VN';
		
		$this->data['categories'] = $this->articles_model->SelectAllCategories();
		
		$this->load->view($this->data['PATH_VIEW'].'/include/header', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/articles/categories', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/include/footer', $this->data);
	}
	
	public function search($search_str_encode = CHAR_EMPTY, $page = 1)
	{
		$this->data['META_TITLE'] = 'Tìm kiếm :: ' . $this->data['META_TITLE'];
		$this->data['META_DESC'] = 'Tìm kiếm về lập trình và công nghệ thông tin của STDIO.VN';
		
		// VALIDATE
		$search_str = urldecode($search_str_encode);
		
		// PERFORM REDIRECT TO #ID ARTICLE
		$id_temp = NULL;
		preg_match('/^#(\d+)/', $search_str, $id_temp);
		if ($id_temp != NULL)
		{
			$url_temp = $this->articles_model->SelectArticleFriendlyURL(intval($id_temp[1]));

			if ($url_temp != FALSE)
			{
				return redirect(SMART_SEARCH_HOME.'/articles/read/'.$id_temp[1].'/'.$url_temp->friendly_url, 'refresh');
			}
		}
		
		// PERFORM REDIRECT TO @ID AUTHOR
		$id_temp = NULL;
		preg_match('/^@(\d+)/', $search_str, $id_temp);
		if ($id_temp != NULL)
		{
			return redirect('http://www.stdio.vn'.'/users/index/'.intval($id_temp[1]), 'refresh');
		}

		$keywords = explode('+', $search_str);
		
		$PAGE_NUM = $page;
		$PAGE_LIMIT = 20;
		$PAGE_OFFSET = $PAGE_LIMIT * ($PAGE_NUM - 1);
		$PAGE_COUNT = -1;
		
		$PAGE_COUNT = $this->articles_model->CountArticleByKeywords($keywords);

		$this->data['keywords'] = $search_str;
		$this->data['articles_brief'] = $this->articles_model->SelectArticlesBriefByKeywords($keywords, $PAGE_OFFSET, $PAGE_LIMIT);
		
		$this->data['PAGINATION_STR'] = GetPaging($PAGE_NUM, $PAGE_COUNT, $PAGE_LIMIT, 'articles', 'search', -1, $search_str_encode);

		$this->load->view($this->data['PATH_VIEW'].'/include/header', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/articles/search', $this->data);
		$this->load->view($this->data['PATH_VIEW'].'/include/footer', $this->data);
	}
}