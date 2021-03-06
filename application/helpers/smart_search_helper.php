<?php

function InitMobileDetect(&$that)
{
	$that->load->library('Mobile_Detect');
	$detect = new Mobile_Detect;
	
	$that->data['PROFILE_DEVICE'] = DEVICE_UNKNOWN;
	$that->data['PATH_VIEW'] = 'pc';

	if ($detect->isMobile() && !$detect->isTablet())
	{
		$that->data['PROFILE_DEVICE'] = DEVICE_PHONE;
		$that->data['PATH_VIEW'] = 'phone';
	}
	else if ($detect->isTablet())
	{
		$that->data['PROFILE_DEVICE'] = DEVICE_TABLET;
		$that->data['PATH_VIEW'] = 'pc';
	}
	else
	{
		$that->data['PROFILE_DEVICE'] = DEVICE_PC;
		$that->data['PATH_VIEW'] = 'pc';
	}
}

function InitPageNavigation(&$that)
{
	$that->data['SEGMENT_1']	= $that->uri->segment(1);
	$that->data['SEGMENT_2']	= $that->uri->segment(2);
	$that->data['PARAM_1']		= '';
	$that->data['PARAM_2']		= '';
	$that->data['PAGE_NAVIGATION']	= '<a href="/"><i class="fa fa-home fa-lg fa-fw"></i></a>';
	$that->data['META_TITLE']		= 'SMART-SEARCH';
	$that->data['META_SITENAME']	= 'SMART-SEARCH';
}

function Title2FrienlyUrl($title)
{
	$friendly_url = trim(Unicode2ASCII($title));
	return url_title(convert_accented_characters($friendly_url), '-', TRUE);
}

function Unicode2ASCII($str)
{
	if(!$str)
		return CHAR_EMPTY;
	
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
		$arr = explode("|", $vi);
		$str = str_replace($arr, $en, $str);
	}
	return $str;
}

function GetPaging($page_num, $page_count, $page_limit, $page_controller, $page_method, $type_id = -1, $friendly_url = CHAR_EMPTY)
{
	$type_id = (int)$type_id;
	
	$STR_PAGING = CHAR_EMPTY;
	$STR_OPTIONAL_INFO = '/';

	if ((gettype($type_id) == "integer" && $type_id >= 0) || (gettype($type_id) == "string" && !empty($type_id)))
	{
		$STR_OPTIONAL_INFO .= $type_id . '/';
	}
	
	if (!empty($friendly_url))
	{		
		$STR_OPTIONAL_INFO .= $friendly_url . '/';
	}
	
	
	$totalPage = ceil($page_count / $page_limit);
	
	if ($page_num > 1)
	{
		$link1 = URL_HOME."/$page_controller/$page_method" . $STR_OPTIONAL_INFO . "1";
		$link2 = URL_HOME."/$page_controller/$page_method" . $STR_OPTIONAL_INFO . ($page_num-1);
		
		$STR_PAGING .= '<a class="button" href="'.$link1.'"><i class="fa fa-angle-double-left fa-lg"></i></a>';
		$STR_PAGING .= '<a class="button" href="'.$link2.'"><i class="fa fa-angle-left fa-lg"></i></a>';
	}
	else
	{
		$STR_PAGING .= '<div class="button_disable"><i class="fa fa-angle-double-left fa-lg"></i></div>';
		$STR_PAGING .= '<div class="button_disable"><i class="fa fa-angle-left fa-lg"></i></div>';
	}
	
	$STR_PAGING .= '<div class="button_disable">'.$page_num.'</div>';
	
	if ($page_num < $totalPage)
	{
		$link1 = URL_HOME."/$page_controller/$page_method" . $STR_OPTIONAL_INFO . ($page_num + 1);
		$link2 = URL_HOME."/$page_controller/$page_method" . $STR_OPTIONAL_INFO . $totalPage;
				
		$STR_PAGING .= '<a class="button" href="'.$link1.'"><i class="fa fa-angle-right fa-lg"></i></a>';
		$STR_PAGING .= '<a class="button" href="'.$link2.'"><i class="fa fa-angle-double-right fa-lg"></i></a>';
	}
	else
	{
		$STR_PAGING .= '<div class="button_disable"><i class="fa fa-angle-right fa-lg"></i></div>';
		$STR_PAGING .= '<div class="button_disable"><i class="fa fa-angle-double-right fa-lg"></i></div>';
	}
	
	return $STR_PAGING;
}

?>