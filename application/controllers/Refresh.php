<?php

class Refresh extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	
		$this->data['META_TITLE'] = 'Cập nhật :: ' . $this->data['META_TITLE'];
		
		$this->load->model("articles_model");
	}
	
	public function index()
	{
		return redirect(SMART_SEARCH_HOME);
	}
	
	public function articles()
	{
		$this->load->model("crawl_model");
		
		$this->articles_model->EmptyTableArticle();

		$current_page = 1;

		while(true)
		{
			$controlPageUrl = "http://www.stdio.vn/articles/index/0/all/".$current_page;
			$controlHtml = $this->crawl_model->getPage($controlPageUrl, "http", 30, "");
			
			$content = substr($controlHtml, strpos($controlHtml, 'BÀI VIẾT MỚI NHẤT'));

			while(true)
			{
				$url = "http://www.stdio.vn".$this->crawl_model->getBetween($content, '<a href="', '">');
				
				if(strpos($url, "read") == FALSE)
					break;

				$article_id = $this->crawl_model->getBetween($url, 'http://www.stdio.vn/articles/read/', '/');
				$articleHtml = $this->crawl_model->getPage($url, "http", 30, "");
				$article_info = $this->crawl_model->getArticle($articleHtml);
				
				$article_brief = $this->crawl_model->getBetween($content, '<div class="article_brief">', '</div>');
				$article_brief = trim($article_brief);
										
				$this->articles_model->insertArticle($article_id, 
														$article_info["category_id"], 
														$article_info["title"], 
														$article_brief, 
														$article_info["author_id"], 
														$article_info["content"], 
														$article_info["tags"], 
														$article_info["friendly_url"]);
				
				$content = substr($content, strpos($content, '<div class="article_brief">', strlen('<div class="article_brief">')));
			}
			
			if(strpos($controlHtml, '<i class="fa fa-angle-right fa-lg"></i></div><div class="button_disable">') != FALSE)
				break;
				
			$current_page++;
		}
		
		return redirect(SMART_SEARCH_HOME);
	}
	
	public function load_articles()
	{
		$this->load->helper("file");
		$articles = $this->articles_model->SelectAllArticles();
		
		foreach($articles as $item)
		{
			$data = $item->article_id.PHP_EOL.$item->friendly_url.PHP_EOL.$item->title.PHP_EOL.$item->tags.PHP_EOL.strip_tags($item->content);
			
			if (!write_file('raw_data/'.$item->article_id.'-'.$item->friendly_url.'.raw', $data, 'w'))
			{
				echo 'FALSE';
			}
			else
			{
				echo 'TRUE';
			}
		}
		
		return redirect(SMART_SEARCH_HOME);
	}
}