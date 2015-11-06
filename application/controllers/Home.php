<?php
	class Home extends CI_Controller
	{
		public function index()
		{
			$this->load->helper('file');
			
			for($i = 1; $i < 5; $i++)
			{
				$url = DEFAULT_CRAWL_URL.$i;
							
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);				
				$html = curl_exec($curl);
				curl_close ($curl);
				
				write_file(SAVE_PATH.$i.'.html', $html);
			}
						
			$this->load->view('pc/index');
		}
	}
?>