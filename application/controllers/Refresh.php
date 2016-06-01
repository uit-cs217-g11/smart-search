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
	
	public function get_article_urls()
	{
		$this->load->model("crawl_model");
		$this->load->helper("file");
		
		$controlHtmls = array();
		$articles_info = array();
		
		$current_page = 1;
		
		while(true)
		{
			$controlPageUrl = "http://www.stdio.vn/articles/index/0/all/".$current_page;
			$html = $this->crawl_model->getPage($controlPageUrl, "http", 30, "");
			array_push($controlHtmls, $html);

			if(strpos($html, '<i class="fa fa-angle-right fa-lg"></i></div><div class="button_disable">') != FALSE)
				break;
	
			$current_page++;
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
				$friendly_url = substr($url, strlen('http://www.stdio.vn/articles/read/') + strlen($article_id) + 1);

				$content = substr($content, strpos($content, '<div class="article_brief">', strlen('<div class="article_brief">')));
				$article_brief = $this->crawl_model->getBetween($content, '<div class="article_brief">', '</div>');
				$article_brief = trim($article_brief);
				
				$article = array(
					'a_id'				=> $article_id,
					'a_brief'			=> $article_brief,
					'a_friendly_url'	=> $friendly_url
				);
				
				array_push($articles_info, $article);
			}
		}
		
		if (!is_dir('data/')) {
			mkdir('data/', 0777, true);
		}

		if (write_file('data/articles_info.dat', serialize($articles_info), 'w'))
		{
			echo 'TRUE';
		}
		else
		{
			echo 'FALSE';
		}
	}
	
	public function articles($limit = 0, $offset = 0)
	{
		if(DEBUG_MODE == FALSE)
			return;		// LOCK
		
		$this->load->model("articles_model");
		$this->load->model("crawl_model");
		$this->load->helper('file');
		
		$content = read_file('data/articles_info.dat');

		if($content == '')
			return;

		$articles_info = unserialize($content);
		
		if($limit != 0)
			$articles_info = array_slice($articles_info, $offset, $limit);

		foreach($articles_info as $item)
		{
			$url = 'http://www.stdio.vn/articles/read/'.$item['a_id'].'/'.$item['a_friendly_url'];
			$articleHtml = $this->crawl_model->getPage($url, "http", 30, "");
			
			$article_info = $this->crawl_model->getArticle($articleHtml);

			// echo $item['a_id'].' - '.$article_info["title"].'<br/>';
			// print_r(implode('|', unserialize($article_info["keywords"])));
			// echo '<br/><br/>';
			
			$a_id = $this->articles_model->InsertArticle(	$item['a_id'], 
													$article_info["category_id"], 
													$article_info["title"], 
													$item['a_brief'], 
													$article_info["author_id"], 
													$article_info["content"], 
													$article_info["keywords"], 
													$item['a_friendly_url'],
													$url);
										
			echo $item['a_id'].(($a_id > 0)?': SUCCESS':': FAILED').'<br/>';
		}

		//return redirect(SMART_SEARCH_HOME);
	}
	
	public function save_articles_to_file()
	{
		if(DEBUG_MODE == false)
			return;		// LOCK
		
		$this->load->model("articles_model");
		$this->load->helper("file");
		$articles = $this->articles_model->SelectAllArticles();
		
		if (!is_dir('data/raw_data/')) {
			mkdir('data/raw_data/', 0777, true);
		}
		
		foreach($articles as $item)
		{
			$data 	= $item->article_id.PHP_EOL;
			$data  .= $item->friendly_url.PHP_EOL;
			$data  .= $item->title.PHP_EOL;
			$data  .= implode('|', unserialize($item->tags)).PHP_EOL;
			$data  .= strip_tags($item->content);
			
			if (write_file('data/raw_data/'.$item->article_id.'-'.$item->friendly_url.'.raw', $data))
			{
				echo $item->id.': TRUE<br/>';
			}
			else
			{
				echo $item->id.': FALSE<br/>';
			}
		}
		
		//return redirect(SMART_SEARCH_HOME);
	}
	
	public function keywords()
	{
		if(DEBUG_MODE == false)
			return;		// LOCK

		$this->load->helper('file');
		$this->load->model('keywords_model');
		
		$this->keywords_model->EmptyTableKeywords();

		$indexed_directory = "data/indexed_data/";
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
		
		//return redirect(SMART_SEARCH_HOME);
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

		//return redirect(SMART_SEARCH_HOME);
	}
	
	public function refresh_authors()
	{
		$this->load->model('crawl_model');
		$this->load->model('accounts_model');
		
		$url = "http://www.stdio.vn/about";
		$html = $this->crawl_model->getPage($url, "http", 30, "");
		
		$content = substr($html, strpos($html, '<ul class="about_author">'));
		
		while(true)
		{
			$a_id = $this->crawl_model->getBetween($content, '<a href="/users/index/', '/');
			$friendly_url = $this->crawl_model->getBetween($content, '<a href="/users/index/'.$a_id.'/', '">');
			$a_name = trim($this->crawl_model->getBetween($content, '<div class="info">', '<i class="fa fa-long-arrow-right fa-fw"></i>'));
			
			if($a_id == '')
			{
				echo 'DONE';
				break;
			}
			$content = substr($content, strpos($content, '<i class="fa fa-long-arrow-right fa-fw"></i>', strlen('<i class="fa fa-long-arrow-right fa-fw"></i>')));
			
			echo $a_id.' - '.$friendly_url.' - '.$a_name.'<br/>';
			$this->accounts_model->InsertAccount($a_id, $a_name, $friendly_url);
		}
	}
	
	public function load_dictionaries($path = '')
	{
		if($path == '')
		{
			echo 'FAILED';
			return FALSE;
		}
		
		$this->load->helper("file");
		$this->load->model('dictionaries_model');
		$words = file($path);
		
		if($words == '')
			return FALSE;

		$dicts = array();
		
		foreach($words as $word)
		{
			array_push($dicts, array('word' => $word));
		}
		
		$this->dictionaries_model->InsertDictionaries($dicts);
	}
	
	public function load_stopwords($path = '')
	{
		return FALSE;
		// if($path == '')
		// {
		// 	echo 'FAILED';
		// 	return FALSE;
		// }
		
		// $this->load->helper("file");
		// $this->load->model('dictionaries_model');
		// $words = file($path);
		
		// if($words == '')
		// 	return FALSE;
			
		// foreach($words as $word)
		// {
		// 	echo $word;
		// 	break;
		// }
	}
}