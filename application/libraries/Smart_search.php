<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Smart_search {
	
	private $CI;

	public $_CONTROLLER;
	public $_METHOD;
	
	public $_PARAM;		// $_PARAM[0] / $_PARAM[1] / ...
	public $_URL;		// $_URL['STATICS']

	public function __construct()
	{
		$this->CI = &get_instance();

		$this->_SEGMENT	= array();
		$this->_PARAM	= array();
		$this->_URL		= array();

		$this->_CONTROLLER	= 	$this->CI->uri->segment(1)=='index'?
								CONTROLLER_INDEX:$this->CI->uri->segment(1);
		$this->_METHOD		= 	$this->CI->uri->segment(2)=='index'?
								CONTROLLER_INDEX:$this->CI->uri->segment(2);

		$this->CI->load->model('dictionaries_model');
	}

	//==================================
	//========== UNICODE FUNCTION ======
	//==================================
	function Autolink($str, $attributes=array())
	{
		$attrs = CHAR_EMPTY;
		foreach ($attributes as $attribute => $value)
		{
			$attrs .= " {$attribute}=\"{$value}\"";
		}
		
		$str = CHAR_SPACE . $str;
		$str = preg_replace('`([^"=\'>])((http|https|ftp)://[^\s<]+[^\s<\.,)])`i',
							'$1<a href="$2"'.$attrs.'>$2</a>',
							$str);
		$str = substr($str, 1);
	 
		return $str;
	}

	function U2A($str)
	{
		if(!$str) return CHAR_EMPTY;
		
		$unicode = array(
			'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
			'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
			'd'=>'đ',
			'D'=>'Đ',
			'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
			'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
			'i'=>'í|ì|ỉ|ĩ|ị',
			'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
			'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
			'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
			'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
			'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
			'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
			'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
			);
			
		foreach($unicode as $en=>$vi){
			$arr = explode('|', $vi);
			$str = str_replace($arr, $en, $str);
		}
		return $str;
	}

	function GenerateRandomCode($factor, $length)
	{
		return substr(md5($factor.time()), 0, $length);
	}

	//	Use for URL
	function GetURLText($text)
	{
        $new_url = str_replace('_', '-', $text);
		return url_title(convert_accented_characters(trim($this->U2A($new_url))), '-', TRUE);
	}

	function BuildElement($content, $class, $tag = 'div', $title = CHAR_EMPTY, $id = CHAR_EMPTY)
	{
		return '<'.$tag.' class="'.$class.'"'.($id==CHAR_EMPTY?' id="'.$id.'"':CHAR_EMPTY).' '.($title==CHAR_EMPTY?' title="'.$title.'"':CHAR_EMPTY).'>'.$content.'</'.$tag.'>';
	}

	function SecureTrimText($content, $length = STRING_BRIEF_LENGTH)
	{
		return htmlspecialchars(trim(mb_substr($content, 0, $length)), ENT_COMPAT, 'UTF-8');
	}
	
	function tokenizing($str)
	{
		$word_segments = explode(' ', $str);
		$tokens = array();
		
		while(count($word_segments) > 0)
		{
			for($i = 4; $i >= 1; $i--)
			{
				$word = implode(' ', array_slice($word_segments, 0, $i));
				//echo $word.' - '.$i.'<br/>';
				
				if($this->CI->dictionaries_model->IsWordExist($word))
				{
					array_push($tokens, $word);
					$word_segments = array_slice($word_segments, (count($word_segments) < $i ? count($word_segments) : $i));
					break;
				}
				else if($i == 1)
				{
					$word_segments = array_slice($word_segments, 1);
				}
			}
		}
		
		return $tokens;
	}
}