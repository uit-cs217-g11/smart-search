<?php

class Refresh extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	
		$this->data['META_TITLE'] = 'Cập nhật :: ' . $this->data['META_TITLE'];
	}
	
	public function index()
	{
		return redirect(SMART_SEARCH_HOME);
	}
	
	public function articles($limited = 0, $offset = 0)
	{
		if(DEBUG_MODE == false)
			return;		// LOCK
		
		$this->load->model("articles_model");
		$this->load->model("crawl_model");
		
		$this->articles_model->EmptyTableArticle();
		
		$current_page = 1;
		if($limited != 0)
		{
			$current_page = $offset;
		}
		
		$controlHtmls = array();

		while(true)
		{
			$controlPageUrl = "http://www.stdio.vn/articles/index/0/all/".$current_page;
			$html = $this->crawl_model->getPage($controlPageUrl, "http", 30, "");
			$controlHtmls[] = $html;

			if(strpos($html, '<i class="fa fa-angle-right fa-lg"></i></div><div class="button_disable">') != FALSE)
				break;
	
			$current_page++;
			
			if($limited != 0)
			{
				if($current_page >= $limited + $offset)
					break;
			}
		}
		
		foreach($controlHtmls as $item)
		{
			$content = substr($item, strpos($item, 'BÀI VIẾT MỚI NHẤT'));

			while(true)
			{
				$url = "http://www.stdio.vn".$this->crawl_model->getBetween($content, '<a href="', '">');
				
				if(strpos($url, 'read/') === FALSE)
					break;

				$article_id = $this->crawl_model->getBetween($url, 'http://www.stdio.vn/articles/read/', '/');			
				$articleHtml = $this->crawl_model->getPage($url, "http", 30, "");
				
				$content = substr($content, strpos($content, '<div class="article_brief">', strlen('<div class="article_brief">')));
				$article_brief = $this->crawl_model->getBetween($content, '<div class="article_brief">', '</div>');
				$article_brief = trim($article_brief);
				
				$article_info = $this->crawl_model->getArticle($articleHtml);				
				
				$this->articles_model->InsertArticle($article_id, 
														$article_info["category_id"], 
														$article_info["title"], 
														$article_brief, 
														$article_info["author_id"], 
														$article_info["content"], 
														$article_info["tags"], 
														$article_info["friendly_url"],
														$url);
			}
		}
		
		return redirect(SMART_SEARCH_HOME);
	}
	
	public function load_articles()
	{
		if(DEBUG_MODE == false)
			return;		// LOCK
		
		$this->load->model("articles_model");
		$this->load->helper("file");
		$articles = $this->articles_model->SelectAllArticles();
		
		foreach($articles as $item)
		{
			$data = $item->article_id.PHP_EOL.$item->friendly_url.PHP_EOL.$item->title.PHP_EOL.$item->tags.PHP_EOL.strip_tags($item->content);
			
			if (write_file('raw_data/'.$item->article_id.'-'.$item->friendly_url.'.raw', $data, 'w'))
			{
				echo 'TRUE';
			}
			else
			{
				echo 'FALSE';
			}
		}
		
		return redirect(SMART_SEARCH_HOME);
	}
	
	public function keywords()
	{
		if(DEBUG_MODE == false)
			return;		// LOCK

		$this->load->helper('file');
		$this->load->model('keywords_model');
		
		$this->keywords_model->EmptyTableKeywords();

		$indexed_directory = "indexed/";
		$separator = DIRECTORY_SEPARATOR;
		$paths = 'relative';
		
		$indexed_articles = array();
    	$cdir = scandir($indexed_directory);
		
		foreach ($cdir as $key => $value)
		{
			if (!in_array($value, array(".", "..")))
			{
				if (is_dir($indexed_directory . $separator . $value))
				{
					$indexed_articles[$value] = $this->dir_to_array($indexed_directory . $separator . $value, $separator, $paths);
				}
				else
				{
					if ($paths == 'relative')
					{
						$indexed_articles[] = $indexed_directory . '/' . $value;                    
					}
					elseif ($paths == 'absolute')
					{
						$indexed_articles[] = base_url() . $indexed_directory . '/' . $value;
					}
				}
			}
		}
		
		foreach($indexed_articles as $item)
		{
			$content = read_file($item);

			$article_id = strtok($content, PHP_EOL);
			$article_id = intval(preg_replace('/[^0-9]/s', '', $article_id));

			$content = preg_replace("/^(.*\n){4}/", "", $content);

			$keywords_map = explode(PHP_EOL, $content);
			array_pop($keywords_map);
			
			$keywords = array();
			
			foreach($keywords_map as $keyword)
			{
				$word_info = explode('|', $keyword);
				$word = $word_info[0];
				
				$tf = $word_info[1];
				$idf = 1;
				$weight = $tf * $idf;
				
				$data = array(
						"word"			=> $word,
						"weight"		=> $weight,
						"tf"			=> $tf,
						"idf"			=> $idf,
						"article_id"	=> $article_id
				);

				array_push($keywords, $data);
			}

			$this->keywords_model->InsertKeywords($keywords);
		}
		
		return redirect(SMART_SEARCH_HOME);
	}
	
	public function keywords_weight()
	{
		if(DEBUG_MODE == false)
			return;		// LOCK
		
		$this->load->model('keywords_model');
		
		$keywords_count = $this->keywords_model->CountAllKeywords();
		$distinct_keywords = $this->keywords_model->SelectDistinctKeywords();

		foreach($distinct_keywords as $item)
		{
			$keywords = $this->keywords_model->SelectKeywords($item->word);
			$idf = log10($keywords_count / count($keywords));

			$this->keywords_model->UpdateWeightTfAndIdfByWord($item->word, $item->tf * $idf, $idf);
		}

		return redirect(SMART_SEARCH_HOME);
	}
}